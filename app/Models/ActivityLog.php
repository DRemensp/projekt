<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'user_name',
        'action',
        'discipline_id',
        'discipline_name',
        'team_id',
        'team_name',
        'klasse_name',
        'field',
        'old_value',
        'new_value',
        'severity',
        'seconds_since_last',
        'created_at',
    ];

    protected $casts = [
        'old_value'  => 'float',
        'new_value'  => 'float',
        'created_at' => 'datetime',
    ];

    /**
     * Human-readable description of the activity.
     */
    public function getMessageAttribute(): string
    {
        $fieldLabel = $this->field === 'score_1' ? 'Versuch 1' : 'Versuch 2';
        $where      = trim(($this->klasse_name ?? '') . ' (' . ($this->discipline_name ?? '') . ')');
        $team       = $this->team_name ?? '–';

        $delay = $this->seconds_since_last !== null
            ? $this->formatDelay($this->seconds_since_last)
            : null;

        return match ($this->action) {
            'score_added' => sprintf(
                '%s hat %s mit %s für Team %s eingetragen [%s]',
                $this->user_name,
                $fieldLabel,
                $this->formatValue($this->new_value),
                $team,
                $where
            ),
            'score_updated' => sprintf(
                '%s hat %s für Team %s%s von %s auf %s geändert [%s]',
                $this->user_name,
                $fieldLabel,
                $team,
                $delay ? ' ' . $delay : ' nachträglich',
                $this->formatValue($this->old_value),
                $this->formatValue($this->new_value),
                $where
            ),
            'score_cleared' => sprintf(
                '%s hat %s für Team %s%s gelöscht (war %s) [%s]',
                $this->user_name,
                $fieldLabel,
                $team,
                $delay ? ' ' . $delay : ' nachträglich',
                $this->formatValue($this->old_value),
                $where
            ),
            'login' => sprintf('%s (Teacher) hat sich eingeloggt', $this->user_name),
            default => '–',
        };
    }

    private function formatDelay(int $seconds): string
    {
        if ($seconds < 60) {
            return $seconds . ' ' . ($seconds === 1 ? 'Sekunde' : 'Sekunden') . ' nach Eingabe';
        }

        $minutes = (int) round($seconds / 60);
        if ($minutes < 60) {
            return $minutes . ' ' . ($minutes === 1 ? 'Minute' : 'Minuten') . ' nach Eingabe';
        }

        $hours = (int) round($seconds / 3600);
        if ($hours < 24) {
            return $hours . ' ' . ($hours === 1 ? 'Stunde' : 'Stunden') . ' später';
        }

        $days = (int) round($seconds / 86400);
        return $days . ' ' . ($days === 1 ? 'Tag' : 'Tage') . ' später';
    }

    private function formatValue(?float $value): string
    {
        if ($value === null) return '–';
        // Remove trailing zeros: 14.500 → 14.5, 14.000 → 14
        return rtrim(rtrim(number_format($value, 3, '.', ''), '0'), '.');
    }
}
