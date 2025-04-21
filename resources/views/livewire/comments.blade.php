<div wire:poll.10s class="max-w-2xl mx-auto my-8">
    <!-- Eingabefeld -->
    <div class="mb-6">
        <form wire:submit.prevent="store">
            <textarea
                wire:model.defer="message"
                class="w-full p-2 border rounded resize-none overflow-hidden"
                placeholder="Schreibe einen Kommentar... (max 200 Zeichen)"
                required
                maxlength="200"
                style="min-height: 38px;"
                x-data="{
                    resize() {
                        $el.style.height = '38px';
                        $el.style.height = $el.scrollHeight + 'px';
                    }
                }"
                x-init="resize()"
                @input="resize()"
                @keydown.enter.prevent="$wire.store()"
            ></textarea>
            <div class="flex justify-between items-center mt-1">
                <span class="text-xs text-gray-500" x-data x-text="$wire.message ? $wire.message.length + '/200' : '0/200'" x-on:input.window="$el.textContent = $wire.message ? $wire.message.length + '/200' : '0/200'"></span>
                <button
                    type="submit"
                    class="px-4 py-1 bg-blue-500 text-white rounded"
                >
                    Senden
                </button>
            </div>
        </form>
    </div>

    <!-- Kommentare -->
    @if(isset($comments) && $comments->count() > 0)
        <div class="{{ $comments->count() > 10 ? 'max-h-[500px] overflow-y-auto pr-1' : '' }} space-y-3">
            @php
                $visibleComments = $this->showAllComments ? $comments : $comments->take(5);
            @endphp

            @foreach($visibleComments as $comment)
                <div class="relative bg-gray-50 p-3">
                    <span class="text-xs text-gray-500 absolute top-2 right-2">
                        {{ $comment->created_at->format('d.m.Y H:i') }}
                    </span>
                    <p class="text-sm text-gray-600">IP: {{ $comment->ip_address }}</p>
                    <p class="mt-1 break-words whitespace-pre-wrap">{{ $comment->message }}</p>
                </div>
            @endforeach

            @if($comments->count() > 5)
                <button
                    wire:click="toggleShowAll"
                    class="text-blue-500 text-sm"
                >
                    {{ $this->showAllComments ? 'Weniger anzeigen' : 'Mehr anzeigen' }}
                </button>
            @endif
        </div>
    @else
        <p>Keine Kommentare vorhanden.</p>
    @endif
</div>
