<div wire:poll.60s="refreshLogs">

    {{-- Header --}}
    <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
        {{-- Left: title + count + countdown --}}
        <div class="flex flex-wrap items-center gap-2">
            <span class="inline-block w-2.5 h-2.5 rounded-full bg-green-500 animate-pulse flex-shrink-0"></span>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 transition-colors duration-300">
                Aktivitätsprotokoll
            </h3>
            @if($total > 0)
                <span class="text-xs text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded-full transition-colors duration-300">
                    {{ $total }} {{ $total === 1 ? 'Eintrag' : 'Einträge' }}
                </span>
            @endif

            {{-- Countdown timer (Alpine, wire:ignore so Livewire doesn't reset it) --}}
            <div wire:ignore
                 x-data="{ countdown: 60, timer: null }"
                 x-init="timer = setInterval(() => countdown > 0 ? countdown-- : countdown = 60, 1000)"
                 @activity-refreshed.window="countdown = 60"
                 class="flex items-center gap-1 text-xs text-gray-400 dark:text-gray-500 transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <span x-text="countdown + 's'"></span>
            </div>
        </div>

        {{-- Right: Klasse filter + clear button --}}
        <div class="flex items-center gap-2">
            @if($klasseOptions->isNotEmpty())
                <select
                    wire:model.live="selectedKlasse"
                    class="text-sm border border-gray-300 dark:border-gray-600 rounded-lg px-2 py-1.5 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200"
                >
                    <option value="all">Alle Klassen</option>
                    @foreach($klasseOptions as $klasse)
                        <option value="{{ $klasse }}">{{ $klasse }}</option>
                    @endforeach
                </select>
            @endif

            @if($total > 0)
                <button
                    wire:click="clearHistory"
                    wire:confirm="Wirklich die gesamte Aktivitätshistory löschen? Diese Aktion kann nicht rückgängig gemacht werden."
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm text-red-600 dark:text-red-400 border border-red-300 dark:border-red-600 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/30 transition-colors duration-200"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    History löschen
                </button>
            @endif
        </div>
    </div>

    {{-- Legend + Severity Filter --}}
    <div class="flex flex-wrap gap-2 mb-3 text-xs text-gray-500 dark:text-gray-400 transition-colors duration-300">
        <span class="flex items-center gap-1.5">
            <span class="w-2.5 h-2.5 rounded-full bg-gray-300 dark:bg-gray-600 flex-shrink-0"></span>Normal
        </span>

        <button
            wire:click="toggleSeverity('warning')"
            class="flex items-center gap-1.5 px-2 py-0.5 rounded-full border transition-colors duration-200
                {{ $severityFilter === 'warning'
                    ? 'bg-yellow-100 dark:bg-yellow-900/40 border-yellow-400 text-yellow-700 dark:text-yellow-300 font-semibold'
                    : 'border-transparent text-gray-500 dark:text-gray-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 hover:text-yellow-700 dark:hover:text-yellow-300' }}"
        >
            <span class="w-2.5 h-2.5 rounded-full bg-yellow-400 flex-shrink-0"></span>
            Verdächtig
            @if($severityFilter === 'warning')
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            @endif
        </button>

        <button
            wire:click="toggleSeverity('danger')"
            class="flex items-center gap-1.5 px-2 py-0.5 rounded-full border transition-colors duration-200
                {{ $severityFilter === 'danger'
                    ? 'bg-red-100 dark:bg-red-900/40 border-red-400 text-red-700 dark:text-red-300 font-semibold'
                    : 'border-transparent text-gray-500 dark:text-gray-400 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-700 dark:hover:text-red-300' }}"
        >
            <span class="w-2.5 h-2.5 rounded-full bg-red-500 flex-shrink-0"></span>
            Kritisch
            @if($severityFilter === 'danger')
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            @endif
        </button>
    </div>

    {{-- Log List --}}
    @if($total === 0)
        <div class="text-center py-12 text-gray-400 dark:text-gray-500 transition-colors duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mx-auto mb-3 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <p class="text-sm"> Noch keine Aktivitäten vorhanden. Die Aktivitäten tracken die Werte eingaben aller Nutzer außer dem Admin, <br>
                zusätzlich wird anhand der Änderung und der Dauer zwischen erst Eintrag bestimmt ob die Änderung verdächtig ist. </p>
        </div>
    @else
        <div class="space-y-2">
            @foreach($logs as $log)
                @php
                    $bgClass = match($log->severity) {
                        'warning' => 'bg-yellow-50 dark:bg-yellow-900/20 border-yellow-300 dark:border-yellow-600',
                        'danger'  => 'bg-red-50   dark:bg-red-900/20   border-red-300   dark:border-red-600',
                        default   => 'bg-white     dark:bg-gray-700     border-gray-200  dark:border-gray-600',
                    };
                    $dotClass = match($log->severity) {
                        'warning' => 'bg-yellow-400',
                        'danger'  => 'bg-red-500',
                        default   => 'bg-gray-300 dark:bg-gray-500',
                    };
                    $textClass = match($log->severity) {
                        'warning' => 'text-yellow-800 dark:text-yellow-200',
                        'danger'  => 'text-red-800   dark:text-red-200',
                        default   => 'text-gray-700  dark:text-gray-200',
                    };
                    $timeClass = match($log->severity) {
                        'warning' => 'text-yellow-600 dark:text-yellow-400',
                        'danger'  => 'text-red-500   dark:text-red-400',
                        default   => 'text-gray-400  dark:text-gray-500',
                    };
                @endphp

                <div class="flex items-start gap-3 px-3 py-2.5 rounded-lg border {{ $bgClass }} transition-colors duration-200">
                    <span class="mt-1.5 w-2 h-2 rounded-full flex-shrink-0 {{ $dotClass }}"></span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm {{ $textClass }} transition-colors duration-300 break-words">
                            {{ $log->message }}
                        </p>
                    </div>
                    <span class="flex-shrink-0 text-xs {{ $timeClass }} transition-colors duration-300 whitespace-nowrap">
                        {{ $log->created_at->diffForHumans() }}
                    </span>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($totalPages > 1)
            @php
                $window  = 2; // pages shown around current
                $pages   = [];
                $prev    = null;
                for ($i = 1; $i <= $totalPages; $i++) {
                    if ($i === 1 || $i === $totalPages
                        || ($i >= $page - $window && $i <= $page + $window)) {
                        if ($prev !== null && $i - $prev > 1) {
                            $pages[] = '...';
                        }
                        $pages[] = $i;
                        $prev = $i;
                    }
                }
            @endphp

            <div class="flex items-center justify-center flex-wrap gap-1 mt-5">
                {{-- Previous --}}
                <button
                    wire:click="previousPage"
                    @disabled($page <= 1)
                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 disabled:opacity-40 disabled:cursor-not-allowed transition-colors duration-200"
                    aria-label="Vorherige Seite"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>

                @foreach($pages as $p)
                    @if($p === '...')
                        <span class="w-8 h-8 flex items-center justify-center text-gray-400 dark:text-gray-500 text-sm select-none">…</span>
                    @else
                        <button
                            wire:click="goToPage({{ $p }})"
                            class="w-8 h-8 rounded-lg border text-sm font-medium transition-colors duration-200
                                {{ $p === $page
                                    ? 'border-blue-500 bg-blue-500 text-white dark:bg-blue-600 dark:border-blue-600'
                                    : 'border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                        >
                            {{ $p }}
                        </button>
                    @endif
                @endforeach

                {{-- Next --}}
                <button
                    wire:click="nextPage"
                    @disabled($page >= $totalPages)
                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 disabled:opacity-40 disabled:cursor-not-allowed transition-colors duration-200"
                    aria-label="Nächste Seite"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        @endif
    @endif

</div>
