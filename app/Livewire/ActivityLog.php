<?php

namespace App\Livewire;

use App\Models\ActivityLog as ActivityLogModel;
use Livewire\Attributes\On;
use Livewire\Component;

class ActivityLog extends Component
{
    public int     $page            = 1;
    public int     $perPage         = 15;
    public string  $selectedKlasse  = 'all';
    public ?string $severityFilter  = null;

    public function updatedSelectedKlasse(): void
    {
        $this->page = 1;
    }

    public function updatedSeverityFilter(): void
    {
        $this->page = 1;
    }

    public function toggleSeverity(string $severity): void
    {
        $this->severityFilter = $this->severityFilter === $severity ? null : $severity;
        $this->page = 1;
    }

    /** Called by wire:poll (60s fallback) AND Reverb when a new entry is created */
    #[On('echo:activity-log,.activity.log.updated')]
    public function refreshLogs(): void
    {
        $this->dispatch('activity-refreshed');
    }

    public function goToPage(int $page): void
    {
        $this->page = max(1, $page);
    }

    public function previousPage(): void
    {
        if ($this->page > 1) {
            $this->page--;
        }
    }

    public function nextPage(): void
    {
        $this->page++;
    }

    public function clearHistory(): void
    {
        ActivityLogModel::truncate();
        $this->page           = 1;
        $this->selectedKlasse = 'all';
        $this->dispatch('activity-refreshed');
    }

    public function render()
    {
        $query = ActivityLogModel::orderByDesc('created_at');

        if ($this->selectedKlasse !== 'all') {
            $query->where('klasse_name', $this->selectedKlasse);
        }

        if ($this->severityFilter !== null) {
            $query->where('severity', $this->severityFilter);
        }

        $total      = $query->count();
        $totalPages = max(1, (int) ceil($total / $this->perPage));

        if ($this->page > $totalPages) {
            $this->page = $totalPages;
        }

        $logs = (clone $query)
            ->offset(($this->page - 1) * $this->perPage)
            ->limit($this->perPage)
            ->get();

        // Only klasses that have score-related entries (not logins)
        $klasseOptions = ActivityLogModel::whereNotNull('klasse_name')
            ->where('klasse_name', '!=', '')
            ->distinct()
            ->orderBy('klasse_name')
            ->pluck('klasse_name');

        return view('livewire.activity-log', [
            'logs'          => $logs,
            'total'         => $total,
            'totalPages'    => $totalPages,
            'klasseOptions' => $klasseOptions,
        ]);
    }
}
