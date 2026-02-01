<x-layout>
    <div class="bg-gradient-to-br from-blue-100 to-green-100 mx-auto px-4 py-8 transition-colors duration-200 dark:bg-none">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 flex items-center gap-3 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-700 dark:text-gray-300 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Kommentar-Moderation
                </h1>
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 dark:bg-gray-700 text-white rounded-lg hover:bg-gray-700 dark:hover:bg-gray-600 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Zurück
                </a>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 dark:bg-green-900/30 border border-green-300 dark:border-green-700 text-green-700 dark:text-green-300 rounded-lg flex items-center gap-2 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Toggle-Button für Kommentare -->
            <div class="mb-6">
                <form action="{{ route('moderation.toggle') }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 rounded-lg font-semibold transition-all shadow-md hover:shadow-lg {{ $commentsEnabled ? 'bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white' : 'bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800 text-white' }}">
                        @if($commentsEnabled)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                            Kommentare deaktivieren
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Kommentare aktivieren
                        @endif
                    </button>
                    <div class="ml-3 text-sm text-gray-600 dark:text-gray-300 transition-colors duration-200">
                        Status: <strong class="{{ $commentsEnabled ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">{{ $commentsEnabled ? 'Aktiviert' : 'Deaktiviert' }}</strong>
                    </div>
                </form>
            </div>

            <!-- Statistiken -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm transition-colors duration-200">
                    <div class="text-3xl font-bold mb-1 text-gray-800 dark:text-gray-100 transition-colors duration-200">{{ $stats['total'] }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-300 transition-colors duration-200">Gesamt</div>
                </div>
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm transition-colors duration-200">
                    <div class="text-3xl font-bold mb-1 text-gray-800 dark:text-gray-100 transition-colors duration-200">{{ $stats['approved'] }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-300 transition-colors duration-200">Freigegeben</div>
                </div>
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm transition-colors duration-200">
                    <div class="text-3xl font-bold mb-1 text-gray-800 dark:text-gray-100 transition-colors duration-200">{{ $stats['pending'] }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-300 transition-colors duration-200">Ausstehend</div>
                </div>
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm transition-colors duration-200">
                    <div class="text-3xl font-bold mb-1 text-gray-800 dark:text-gray-100 transition-colors duration-200">{{ $stats['blocked'] }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-300 transition-colors duration-200">Blockiert</div>
                </div>
            </div>
        </div>

        <!-- Kommentare Tabelle -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transition-colors duration-200">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600 transition-colors duration-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider transition-colors duration-200">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider transition-colors duration-200">Autor</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider transition-colors duration-200">Nachricht</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider transition-colors duration-200">IP-Adresse</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider transition-colors duration-200">AI-Scores</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider transition-colors duration-200">Grund</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider transition-colors duration-200">Datum</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider transition-colors duration-200">Aktionen</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700 transition-colors duration-200">
                        @forelse($comments as $comment)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                <!-- Status Badge -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($comment->moderation_status === 'approved')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 transition-colors duration-200">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            Freigegeben
                                        </span>
                                    @elseif($comment->moderation_status === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 transition-colors duration-200">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                            </svg>
                                            Ausstehend
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 transition-colors duration-200">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"/>
                                            </svg>
                                            Blockiert
                                        </span>
                                    @endif
                                </td>

                                <!-- Autor -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 dark:from-blue-600 dark:to-indigo-700 rounded-full flex items-center justify-center text-white text-xs font-medium">
                                            {{ strtoupper(substr($comment->author_name ?? 'A', 0, 1)) }}
                                        </div>
                                        <span class="text-sm font-medium text-gray-900 dark:text-gray-100 transition-colors duration-200">{{ $comment->author_name ?? 'Anonym' }}</span>
                                    </div>
                                </td>

                                <!-- Nachricht -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 dark:text-gray-100 max-w-md break-words transition-colors duration-200">{{ $comment->message }}</div>
                                </td>

                                <!-- IP-Adresse -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <code class="text-xs bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded font-mono text-gray-700 dark:text-gray-300 transition-colors duration-200">{{ $comment->ip_address ?? 'N/A' }}</code>
                                </td>

                                <!-- AI-Scores -->
                                <td class="px-6 py-4">
                                    @if($comment->moderation_scores && is_array($comment->moderation_scores))
                                        <div class="space-y-1">
                                            @foreach($comment->moderation_scores as $attribute => $score)
                                                <div class="flex items-center gap-2 text-xs">
                                                    <span class="font-medium text-gray-600 dark:text-gray-300 w-32 truncate transition-colors duration-200" title="{{ $attribute }}">{{ $attribute }}</span>
                                                    <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2 max-w-24 transition-colors duration-200">
                                                        <div class="h-2 rounded-full {{ $score > 0.75 ? 'bg-red-500' : ($score > 0.6 ? 'bg-yellow-500' : 'bg-green-500') }}"
                                                             style="width: {{ $score * 100 }}%"></div>
                                                    </div>
                                                    <span class="font-mono text-gray-700 dark:text-gray-300 w-12 text-right transition-colors duration-200">{{ number_format($score * 100, 1) }}%</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400 dark:text-gray-500 transition-colors duration-200">Keine Daten</span>
                                    @endif
                                </td>

                                <!-- Grund -->
                                <td class="px-6 py-4">
                                    @if($comment->moderation_reason)
                                        <div class="text-xs text-gray-600 dark:text-gray-300 max-w-xs transition-colors duration-200">{{ $comment->moderation_reason }}</div>
                                    @else
                                        <span class="text-xs text-gray-400 dark:text-gray-500 transition-colors duration-200">-</span>
                                    @endif
                                </td>

                                <!-- Datum -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 transition-colors duration-200">
                                    {{ $comment->created_at->format('d.m.Y H:i') }}
                                </td>

                                <!-- Aktionen -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        @if($comment->moderation_status !== 'approved')
                                            <form action="{{ route('moderation.approve', $comment) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 p-1 hover:bg-green-50 dark:hover:bg-green-900/30 rounded transition-colors duration-200" title="Freigeben">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif

                                        @if($comment->moderation_status !== 'blocked')
                                            <form action="{{ route('moderation.block', $comment) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-700 dark:hover:text-yellow-300 p-1 hover:bg-yellow-50 dark:hover:bg-yellow-900/30 rounded transition-colors duration-200" title="Blockieren">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('moderation.destroy', $comment) }}" method="POST" onsubmit="return confirm('Kommentar wirklich löschen?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 p-1 hover:bg-red-50 dark:hover:bg-red-900/30 rounded transition-colors duration-200" title="Löschen">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 dark:text-gray-500 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 font-medium transition-colors duration-200">Noch keine Kommentare vorhanden</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($comments->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 transition-colors duration-200">
                    {{ $comments->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layout>
