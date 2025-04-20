<x-layout>
    <x-slot:heading>
        Campus Olympiade
    </x-slot:heading>
    <section class="relative isolate overflow-hidden bg-white px-6 py-24 sm:py-32 lg:px-8">
        <div class="absolute inset-0 -z-10 bg-[radial-gradient(45rem_50rem_at_top,var(--color-indigo-100),white)] opacity-20"></div>
        <div class="absolute inset-y-0 right-1/2 -z-10 mr-16 w-[200%] origin-bottom-left skew-x-[-30deg] bg-white ring-1 shadow-xl shadow-indigo-600/10 ring-indigo-50 sm:mr-28 lg:mr-0 xl:mr-16 xl:origin-center"></div>
        <div class="mx-auto max-w-2xl lg:max-w-4xl mb-24">
            <img class="mx-auto h-12" src="{{asset('storage/Clipped.png')}}" alt="">
            <figure class="mt-10">
                <blockquote class="text-center text-xl/8 font-semibold text-gray-900 sm:text-2xl/9">
                    <p>“Willkommen bei der diesjährigen Olympiade.”</p>
                    <p>“Wir wünschen euch viel Spaß und ein fairen Kampf.”</p>
                    <p>“Auf Leben und Tot ;)”</p>
                </blockquote>
                <figcaption class="mt-10">
                    <img class="mx-auto size-10 rounded-full" src="{{asset('storage/profile.png')}}" alt="">
                    <div class="mt-4 flex items-center justify-center space-x-3 text-base">
                        <div class="font-semibold text-gray-900">Bernd Jürgen</div>
                        <svg viewBox="0 0 2 2" width="3" height="3" aria-hidden="true" class="fill-gray-900">
                            <circle cx="1" cy="1" r="1" />
                        </svg>
                        <div class="text-gray-600">CEO of nothing</div>
                    </div>
                </figcaption>
            </figure>
        </div>
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <dl class="grid grid-cols-1 gap-x-8 gap-y-16 text-center lg:grid-cols-3">
                <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                    <dt class="text-base/7 text-gray-600">_</dt>
                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl"><p>{{ $schoolCount }}</p> beteiligte Schulen</dd>
                </div>
                <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                    <dt class="text-base/7 text-gray-600">_</dt>
                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl"><p>{{ $klasseCount }}</p> teilnehmende Klassen</dd>
                </div>
                <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                    <dt class="text-base/7 text-gray-600">_</dt>
                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl"><p>{{ $teamCount }}</p> versuchende Teams</dd>
                </div>
            </dl>
        </div>
    </section>

    <section class="mx-auto max-w-4xl px-6 py-12">
        <h2 class="text-2xl font-bold text-center mb-6">Kommentare</h2>

        <!-- Anzeige vorhandener Kommentare -->
        @forelse($comments as $comment)
            <div class="bg-gray-100 rounded-md p-4 mb-4 shadow-sm">
                <p class="text-sm text-gray-600 mb-2">
                    IP-Adresse: {{ $comment->ip_address }}
                </p>
                <p class="text-gray-800">{{ $comment->message }}</p>
            </div>
        @empty
            <p class="text-gray-500 text-center mb-6">Noch keine Kommentare.</p>
        @endforelse

        <!-- Formular zum Speichern eines neuen Kommentars -->
        <form action="{{ route('comments.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="message" class="block text-gray-700 font-semibold mb-2">Kommentar schreiben:</label>
                <textarea
                    id="message"
                    name="message"
                    rows="4"
                    class="block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-indigo-500"
                    placeholder="Deine Nachricht"
                    required
                ></textarea>
            </div>
            <button
                type="submit"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent
                       rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none
                       focus:border-indigo-700 focus:ring ring-indigo-300"
            >
                Abschicken
            </button>
        </form>
    </section>
</x-layout>

