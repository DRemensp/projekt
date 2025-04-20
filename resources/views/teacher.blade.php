{{-- resources/views/teacher.blade.php --}}
<x-layout>
    <x-slot:heading>
        Lehrer Dashboard
    </x-slot:heading>

    <div class="py-6 px-8 bg-gray-100 min-h-screen">
        {{-- Überschrift --}}
        <div class="text-center mb-10">
            <h1 class="text-5xl font-bold mb-2 text-indigo-700">
                Aktuelles Ranking
            </h1>
            <p class="text-gray-500">
                (Beispielhafte Darstellung – Dummy-Daten)
            </p>
        </div>

        {{-- Auswahlfelder (Dropdowns) + Button --}}
        <div class="flex flex-col md:flex-row justify-center items-center gap-4 mb-10">
            {{-- 1. Auswahl: "Team", "Klasse", "Schule" --}}
            <div>
                <label for="rankingViewSelect" class="block mb-1 text-sm font-medium text-gray-700">
                    Ansicht auswählen
                </label>
                <select
                    id="rankingViewSelect"
                    class="block w-48 p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none"
                >
                    <option value="teams">Teams</option>
                    <option value="klasses">Klassen</option>
                    <option value="schools">Schulen</option>
                </select>
            </div>


            <div>
                <label for="disciplineSelect" class="block mb-1 text-sm font-medium text-gray-700">
                    Disziplin auswählen
                </label>
                <select
                    id="disciplineSelect"
                    class="block w-48 p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none"
                >
                    <option value="disziplinA">Disziplin A</option>
                    <option value="disziplinB">Disziplin B</option>
                    <option value="disziplinC">Disziplin C</option>
                </select>
            </div>

            {{-- Button zum Aktualisieren --}}
            <div>
                <button
                    class="mt-2 md:mt-8 px-4 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700"
                    onclick="updateRanking()"
                >
                    Ranking anzeigen
                </button>
            </div>
        </div>

        {{-- Dynamische Überschrift (per JavaScript gesetzt) --}}
        <div class="text-center mb-8">
            <h2 id="rankingTitle" class="text-3xl font-semibold text-gray-800"></h2>
        </div>

        {{-- Ranking-Liste --}}
        <div id="rankingList" class="mx-auto max-w-4xl space-y-6">
            {{-- Inhalte werden per JavaScript eingefügt --}}
        </div>
    </div>

    <script>
        // Beispielhafte Datensammlung, um das Ranking pro Ansicht & Disziplin zu simulieren:
        const mockData = {
            teams: {
                disziplinA: [
                    { place: 1, name: 'Team Alpha', extra: 'Klasse 12A / 100 Punkte', score: 100 },
                    { place: 2, name: 'Team Bravo', extra: 'Klasse 11B / 95 Punkte', score: 95 },
                    { place: 3, name: 'Team Charlie', extra: 'Klasse 10C / 90 Punkte', score: 90 },
                ],
                disziplinB: [
                    { place: 1, name: 'Team Bravo', extra: 'Klasse 11B / 88 Punkte', score: 88 },
                    { place: 2, name: 'Team Alpha', extra: 'Klasse 12A / 80 Punkte', score: 80 },
                ],
                disziplinC: [
                    { place: 1, name: 'Team Delta', extra: 'Klasse 9A / 70 Punkte', score: 70 },
                    { place: 2, name: 'Team Alpha', extra: 'Klasse 12A / 65 Punkte', score: 65 },
                    { place: 3, name: 'Team Bravo', extra: 'Klasse 11B / 60 Punkte', score: 60 },
                ],
            },
            klasses: {
                disziplinA: [
                    { place: 1, name: 'Klasse 12A', extra: 'Gesamtpunktzahl: 300', score: 300 },
                    { place: 2, name: 'Klasse 11B', extra: 'Gesamtpunktzahl: 280', score: 280 },
                ],
                disziplinB: [
                    { place: 1, name: 'Klasse 10C', extra: 'Gesamtpunktzahl: 250', score: 250 },
                    { place: 2, name: 'Klasse 12A', extra: 'Gesamtpunktzahl: 240', score: 240 },
                ],
                disziplinC: [
                    { place: 1, name: 'Klasse 9A', extra: 'Gesamtpunktzahl: 210', score: 210 },
                    { place: 2, name: 'Klasse 11B', extra: 'Gesamtpunktzahl: 200', score: 200 },
                ],
            },
            schools: {
                disziplinA: [
                    { place: 1, name: 'Schule A', extra: 'Diverse Klassen / 900 Punkte', score: 900 },
                    { place: 2, name: 'Schule B', extra: 'Diverse Klassen / 850 Punkte', score: 850 },
                ],
                disziplinB: [
                    { place: 1, name: 'Schule C', extra: 'Diverse Klassen / 780 Punkte', score: 780 },
                ],
                disziplinC: [
                    { place: 1, name: 'Schule A', extra: 'Diverse Klassen / 600 Punkte', score: 600 },
                    { place: 2, name: 'Schule B', extra: 'Diverse Klassen / 590 Punkte', score: 590 },
                ],
            },
        };

        function updateRanking() {
            const viewSelect = document.getElementById('rankingViewSelect');
            const disciplineSelect = document.getElementById('disciplineSelect');
            const rankingTitle = document.getElementById('rankingTitle');
            const rankingList = document.getElementById('rankingList');

            // Ausgewählte Filter holen
            const viewValue = viewSelect.value;
            const disciplineValue = disciplineSelect.value;

            // Anzeige am Titel:
            let viewText = '';
            switch (viewValue) {
                case 'teams':
                    viewText = 'Teams';
                    break;
                case 'klasses':
                    viewText = 'Klassen';
                    break;
                default:
                    viewText = 'Schulen';
            }

            let disciplineText = '';
            switch (disciplineValue) {
                case 'disziplinA':
                    disciplineText = 'Disziplin A';
                    break;
                case 'disziplinB':
                    disciplineText = 'Disziplin B';
                    break;
                default:
                    disciplineText = 'Disziplin C';
            }

            // Titel setzen
            rankingTitle.textContent = `${viewText} – ${disciplineText}`;

            // Ranking-Daten aus mockData ermitteln
            const data = mockData[viewValue][disciplineValue] || [];

            // Falls keine Daten vorhanden, Listing leeren und ggf. Meldung anzeigen
            if (!data.length) {
                rankingList.innerHTML = `
                    <div class="text-center p-6 text-gray-500">
                        Keine Daten verfügbar.
                    </div>
                `;
                return;
            }

            // Neue HTML-Blöcke für das Ranking erstellen
            let htmlOutput = '';
            data.forEach((item) => {
                htmlOutput += `
                    <div class="p-6 bg-white rounded-lg shadow-lg flex items-center justify-between">
                        <div class="flex items-center">
                            <div
                                class="bg-${item.place == 1 ? 'yellow' : (item.place == 2 ? 'gray' : (item.place == 3 ? 'orange' : 'indigo'))}-400
                                       text-white font-bold rounded-full h-12 w-12
                                       flex items-center justify-center mr-4 text-2xl">
                                ${item.place}
                            </div>
                            <div>
                                <p class="text-2xl font-semibold text-gray-800">${item.name}</p>
                                <p class="text-sm text-gray-500">${item.extra}</p>
                            </div>
                        </div>
                        <div class="text-4xl font-extrabold text-green-600">
                            ${item.score}
                        </div>
                    </div>
                `;
            });

            // HTML in das Element einfügen
            rankingList.innerHTML = htmlOutput;
        }
    </script>
</x-layout>
