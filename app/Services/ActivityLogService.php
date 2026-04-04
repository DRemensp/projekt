<?php

namespace App\Services;

use App\Events\ActivityLogUpdated;
use App\Models\ActivityLog;
use App\Models\Discipline;
use App\Models\Team;
use Illuminate\Contracts\Auth\Authenticatable;

class ActivityLogService
{
    /**
     * Thresholds for sus detection (in minutes).
     * < WARN_MINUTES  → warning (yellow)
     * >= WARN_MINUTES → danger  (red)
     */
    private const WARN_MINUTES = 5;

    /**
     * Log score changes after a storeOrUpdate on discipline_team.
     *
     * @param  Authenticatable  $user       The user performing the action
     * @param  Discipline        $discipline
     * @param  Team              $team
     * @param  float|null        $oldScore1  Value in DB before save (null if row was new)
     * @param  float|null        $oldScore2
     * @param  float|null        $newScore1  Value sent in the request
     * @param  float|null        $newScore2
     * @param  bool              $wasNew     True when the pivot row did not exist before
     */
    public function logScoreChanges(
        Authenticatable $user,
        Discipline $discipline,
        Team $team,
        ?float $oldScore1,
        ?float $oldScore2,
        ?float $newScore1,
        ?float $newScore2,
        bool $wasNew
    ): void {
        $klasseName = $discipline->klasse?->name ?? '–';

        if ($wasNew) {
            // Fresh row: log every non-null value as a normal addition
            if ($newScore1 !== null) {
                $this->write($user, $discipline, $team, $klasseName, 'score_1', null, $newScore1, 'score_added', 'normal');
            }
            if ($newScore2 !== null) {
                $this->write($user, $discipline, $team, $klasseName, 'score_2', null, $newScore2, 'score_added', 'normal');
            }
            return;
        }

        // Existing row: compare each field independently
        $this->checkField($user, $discipline, $team, $klasseName, 'score_1', $oldScore1, $newScore1);
        $this->checkField($user, $discipline, $team, $klasseName, 'score_2', $oldScore2, $newScore2);
    }

    /**
     * Log a login event (teachers and admins only).
     */
    public function logLogin(Authenticatable $user): void
    {
        ActivityLog::create([
            'user_id'   => $user->id,
            'user_name' => $user->name,
            'action'    => 'login',
            'severity'  => 'normal',
            'created_at' => now(),
        ]);
    }

    // -------------------------------------------------------------------------

    private function checkField(
        Authenticatable $user,
        Discipline $discipline,
        Team $team,
        string $klasseName,
        string $field,
        ?float $oldVal,
        ?float $newVal
    ): void {
        // Treat 0.0 submitted as null (empty field submitted as 0)
        $oldVal = ($oldVal === 0.0) ? null : $oldVal;
        $newVal = ($newVal === 0.0) ? null : $newVal;

        // No change at all
        if ($oldVal === $newVal) {
            return;
        }

        // null → value: first entry for this field (normal)
        if ($oldVal === null && $newVal !== null) {
            $this->write($user, $discipline, $team, $klasseName, $field, null, $newVal, 'score_added', 'normal');
            return;
        }

        // value → null: deliberately cleared (always danger)
        if ($oldVal !== null && $newVal === null) {
            ['seconds' => $seconds] = $this->analyzeChange($discipline->id, $team->id, $field);
            $this->write($user, $discipline, $team, $klasseName, $field, $oldVal, null, 'score_cleared', 'danger', $seconds);
            return;
        }

        // value → different value: late correction
        ['severity' => $severity, 'seconds' => $seconds] = $this->analyzeChange($discipline->id, $team->id, $field);
        $this->write($user, $discipline, $team, $klasseName, $field, $oldVal, $newVal, 'score_updated', $severity, $seconds);
    }

    /**
     * Returns severity and seconds-since-last-entry for a changed field.
     *
     * @return array{severity: string, seconds: int}
     */
    private function analyzeChange(int $disciplineId, int $teamId, string $field): array
    {
        $lastEntry = ActivityLog::where('discipline_id', $disciplineId)
            ->where('team_id', $teamId)
            ->where('field', $field)
            ->whereIn('action', ['score_added', 'score_updated'])
            ->latest('created_at')
            ->first();

        if ($lastEntry === null) {
            return ['severity' => 'danger', 'seconds' => 0];
        }

        $seconds  = (int) $lastEntry->created_at->diffInSeconds(now());
        $severity = $seconds < (self::WARN_MINUTES * 60) ? 'warning' : 'danger';

        return ['severity' => $severity, 'seconds' => $seconds];
    }

    private function write(
        Authenticatable $user,
        Discipline $discipline,
        Team $team,
        string $klasseName,
        string $field,
        ?float $oldVal,
        ?float $newVal,
        string $action,
        string $severity,
        ?int $secondsSinceLast = null
    ): void {
        ActivityLog::create([
            'user_id'             => $user->id,
            'user_name'           => $user->name,
            'action'              => $action,
            'discipline_id'       => $discipline->id,
            'discipline_name'     => $discipline->name,
            'team_id'             => $team->id,
            'team_name'           => $team->name,
            'klasse_name'         => $klasseName,
            'field'               => $field,
            'old_value'           => $oldVal,
            'new_value'           => $newVal,
            'severity'            => $severity,
            'seconds_since_last'  => $secondsSinceLast,
            'created_at'          => now(),
        ]);

        event(new ActivityLogUpdated());
    }
}
