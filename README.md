# <span style="color:#2563eb">Campus</span><span style="color:#14b8a6">Olympiade</span>

<p align="center">
  <img alt="Laravel 12" src="https://img.shields.io/badge/Laravel-12-ff2d20?style=flat-square">
  <img alt="Livewire 3" src="https://img.shields.io/badge/Livewire-3-8b5cf6?style=flat-square">
  <img alt="Tailwind CSS" src="https://img.shields.io/badge/Tailwind-3-38bdf8?style=flat-square">
  <img alt="Vite" src="https://img.shields.io/badge/Vite-6-facc15?style=flat-square">
</p>

CampusOlympiade ist eine Laravel 12 Anwendung für Schulwettbewerbe. Teams treten in Disziplinen an, Ergebnisse werden zentral erfasst und automatisch gerankt. Die Plattform bietet Live-Rankings, Team-Laufzettel, Archiv-Snapshots und ein moderiertes Community-Board.

## 🟦 Tech-Stack
- Laravel 12, PHP 8.2
- Livewire 3
- Tailwind CSS + Vite
- Spatie Permission (Rollen)
- Spatie Cookie Consent
- MySQL oder MariaDB
- Optional: Redis für Cache/Session/Queue
- Optional: Google Perspective API für Kommentar-Moderation

## 🎨 Farbwelt (UI)
- Farbige Akzente pro Schule (SchoolColorService), dadurch klare visuelle Zuordnung in Rankings.
- Eigene Light- und Dark-Mode-Varianten mit unterschiedlichen Layouts und Hintergründen.
- UI-Highlights nutzen konsistente Farben für Karten, Badges und Tabellen.

## 🟩 Funktionen im Detail
Die Punkte unten spiegeln die Logik aus Migrations, Models, Controllern und JS wider.

### 🟩 Wettbewerb und Stammdaten
- Schulen anlegen, listen und löschen. Beim Löschen werden Klassen und Teams per Cascade entfernt; die zugehörigen Klassen-User werden zusätzlich gelöscht.
- Klassen anlegen: Jede Klasse gehört zu einer Schule. Beim Erstellen wird automatisch ein Klassen-Account erstellt (User) und ein lesbares Passwort generiert. Das Klartext-Passwort wird in der Klasse gespeichert, damit es weitergegeben werden kann.
- Disziplinen anlegen: Pro Klasse genau eine Disziplin (unique klasse_id). Enthalten sind Name, Beschreibung und die Regel, ob höher oder niedriger besser ist.
- Teams anlegen: Teams gehören zu einer Klasse. Mitglieder werden als Liste (JSON) gespeichert und können per Zeilenumbruch eingegeben werden.
- Bonus-Status pro Team (boolean), zusätzliche Punkte über das Scoresystem.

### 🟧 Scores und Eingabe
- Zwei Versuche pro Team und Disziplin (score_1, score_2 in discipline_team).
- Teacher Dashboard: globale Score-Eingabe für alle Teams/Disziplinen mit Anzeige der aktuell gespeicherten Werte.
- Klassen-Dashboard: Klassen-Accounts dürfen Scores für die eigene Disziplin eintragen.
- Speicherung erfolgt in der Pivot-Tabelle discipline_team (updateExistingPivot oder attach).
- Nach jedem Speichern wird die Gesamtrechnung automatisch angestoßen.

### 🟨 Punkteberechnung und Rankings
- Live Ranking mit Tabs für Schulen, Klassen, Teams und Disziplinen.
- Podium für Top 3 und darunter eine vollständige Rangliste.
- Team-Suche mit Live-Filter in der Team-Rangliste.
- Disziplinen-Ansicht: bestes Team pro Disziplin; Klick öffnet ein Modal mit vollständiger Disziplin-Rangliste.
- Manuelles Recalculate-Endpunkt: /ranking/recalculate (POST, auth).

### 🟦 Laufzettel (Team-Ansicht)
- Team-Suche auf /laufzettel; Detailansicht auf /laufzettel/{team}.
- Zeigt Gesamtpunkte, Gesamtplatzierung, Disziplin-Position, beste Leistung und Highscore je Disziplin.
- Mitglieder-Modal und Bonus-Modal für bessere Lesbarkeit.
- Admins können den Bonus-Status per Button togglen (AJAX), inklusive automatischer Neuberechnung.

### 🟪 Administration
- Admin-Ansicht mit Formularen für Schulen, Klassen, Disziplinen, Teams und Scoresystem.
- Scoresystem steuert die Punktevergabe und Bonuspunkte.
- Archiv-Funktion: Snapshots erstellen und löschen.
- Admin-Broadcast: Admin kann Live-Benachrichtigungen an Zielgruppen senden (Gäste, Teacher, Klassen/Schüler), inkl. Popup-Anzeige im Frontend.

### 🟩 Archive
- Ein Archiv speichert einen kompletten Snapshot (Rankings, Disziplinen, Teams, Farben, Statistiken) als JSON.
- Archiv-Liste mit Kennzahlen und Detailansicht mit Tabs für Schulen, Klassen, Teams und Disziplinen.

### 🟦 Community und Moderation
- Livewire-Kommentare mit Status: approved, pending, blocked.
- AI-Moderation über Google Perspective API (Schwellenwerte konfigurierbar).
- Moderation-Panel für Admin und Teacher: freigeben, blockieren, löschen.
- Kommentar-Feature global aktivierbar/deaktivierbar (Setting + Cache für 1h).
- IP-Adressen werden nur in der Datenbank gespeichert (Moderationszweck).
- Erstnutzungs-Hinweis bei Kommentaren mit verpflichtender Bestätigung vor dem ersten Senden (pro Browser).
- Kommentarnutzung nur mit Moderation-Cookies; ohne Einwilligung bleibt das Kommentarformular gesperrt.

### 🟨 Design und UX
- Light und Dark Mode, Toggle im Footer, Speicherung in localStorage.
- Alternative Designs für Light und Dark auf der Startseite.
- Farbzuordnung je Schule für konsistente Highlights.
- Mobile Navbar mit Animation und Admin Carousel mit Touch-Swipe.
- Footer mit rechtlichen Seiten (Datenschutz, Cookie-Richtlinie, Nutzungsbedingungen, Impressum) und Button zum Öffnen der Cookie-Präferenzen.

### 🟧 Statistik
- VisitCounter zählt Besuche der Startseite.
- Gesamtzahlen für Schulen, Klassen, Teams und Schätzung der Schüler (Teams ohne Mitglieder zählen als 3).

## 🟦 Datenmodell und Relationen
Kurzübersicht der wichtigsten Beziehungen:

- School 1--* Klasse 1--* Team
- Klasse 1--1 Discipline
- Team *--* Discipline (Pivot discipline_team mit score_1, score_2)
- User 1--1 Klasse (Klassen-Account wird über User.name == Klasse.name zugeordnet)

Weitere Tabellen:
- scoresystems (aktive Punkte-Logik)
- comments (inkl. Moderationsdaten)
- settings (comments_enabled)
- archives (JSON-Snapshots)
- visit_counters
- spatie permission tables (roles, role_user, etc.)

## 🟨 Punkteberechnung (recalculateAllScores)
1. Team-, Klassen- und Schul-Scores werden auf 0 gesetzt.
2. Pro Disziplin wird das beste Ergebnis pro Team ermittelt (Best of 2).
3. Die Teams werden je nach Regel sortiert (höher oder niedriger besser).
4. Punktevergabe über Scoresystem:
   - Platz 1, 2, 3: feste Werte (first_place, second_place, third_place)
   - Ab Platz 4: max_score - (platz - 4) * score_step, minimum 0
5. Bonuspunkte werden zu Teams mit bonus = true addiert.
6. Klassen-Score = Durchschnitt der Team-Scores der Klasse.
7. Schul-Score = Durchschnitt aller Team-Scores über alle Klassen.

## 🟩 Rollen und Berechtigungen
- Admin: volle Verwaltung, Scoresystem, Archive, Bonus-Status, Moderation.
- Teacher: Score-Eingabe und Moderation.
- Klassen-Account: Score-Eingabe für die eigene Disziplin.
- Public: Ranking, Laufzettel, Kommentare (sofern aktiviert).

## 🟦 Seiten und Workflows
- /            Startseite mit Statistiken und Kommentar-Board
- /ranking     Live-Ranking mit Tabs, Suche und Disziplin-Modal
- /laufzettel  Team-Suche und Team-Detailansicht
- /teacher     Teacher Dashboard (Score-Eingabe)
- /admin       Admin Dashboard
- /moderation  Kommentar-Moderation
- /archive     Archiv-Liste und Detailansichten
- /dashboard   Klassen-Dashboard (nach Login)
- /profile     Standard Breeze Profilseite
- /datenschutz, /cookies, /nutzungsbedingungen, /impressum  Rechtliche Seiten

## 🟩 Lokales Setup
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed --class=DatabaseSeeder
npm install
npm run dev
php artisan serve
```

Seeded Default Accounts (bitte sofort ändern):
- admin@localhost / admin123
- teacher@localhost / teacher123

## 🟧 Produktionsserver Setup (Ubuntu + Nginx + MySQL)
Beispiel für einen klassischen Linux-Server ohne Forge. Passe Pfade und Versionen an.

1) System-Pakete installieren
```bash
sudo apt update
sudo apt install -y nginx mysql-server git unzip
sudo apt install -y php8.2-fpm php8.2-cli php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip php8.2-bcmath
```

2) Projekt ausrollen
```bash
git clone <repo-url> /var/www/campus-olympiade
cd /var/www/campus-olympiade
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
```

3) Datenbank erstellen
```sql
CREATE DATABASE campus_olympiade;
CREATE USER 'campus'@'localhost' IDENTIFIED BY 'strong_password';
GRANT ALL PRIVILEGES ON campus_olympiade.* TO 'campus'@'localhost';
FLUSH PRIVILEGES;
```

4) .env konfigurieren (Auszug)
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://example.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=campus_olympiade
DB_USERNAME=campus
DB_PASSWORD=strong_password
```

5) Migrate + Seed
```bash
php artisan migrate --force
php artisan db:seed --class=DatabaseSeeder --force
```

6) Assets bauen
```bash
npm install
npm run build
```

7) Rechte setzen
```bash
sudo chown -R www-data:www-data /var/www/campus-olympiade
sudo chmod -R 775 storage bootstrap/cache
```

8) Nginx Site (Beispiel)
```nginx
server {
    server_name example.com;
    root /var/www/campus-olympiade/public;

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

9) Cache und Optimierung
```bash
php artisan optimize
```

Optional (Cron für Scheduler):
```bash
* * * * * cd /var/www/campus-olympiade && php artisan schedule:run >> /dev/null 2>&1
```

## 🟨 Konfiguration (.env) - wichtige Keys
Minimal:
- APP_ENV, APP_KEY, APP_URL
- DB_CONNECTION, DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD

Optional, aber empfohlen:
- CACHE_STORE, SESSION_DRIVER, QUEUE_CONNECTION, REDIS_HOST, REDIS_PASSWORD, REDIS_PORT
- MAIL_* für Mailversand
- PERSPECTIVE_API_KEY (Kommentar-Moderation)
- PERSPECTIVE_ATTRIBUTES (z.B. TOXICITY,INSULT,SPAM)
- PERSPECTIVE_LANGUAGE_HINTS (z.B. de,en)
- PERSPECTIVE_BLOCK_THRESHOLD, PERSPECTIVE_MODERATE_THRESHOLD, PERSPECTIVE_TIMEOUT
- BROADCAST_CONNECTION, REVERB_APP_KEY, REVERB_APP_SECRET, REVERB_APP_ID, REVERB_HOST, REVERB_PORT, REVERB_SCHEME
- VITE_REVERB_APP_KEY, VITE_REVERB_HOST, VITE_REVERB_PORT, VITE_REVERB_SCHEME

Ohne PERSPECTIVE_API_KEY werden Kommentare automatisch erlaubt (Fallback) oder als pending markiert.

## 🟩 Betrieb und Wartung
- Nach Deploy: php artisan optimize:clear
- Bei Schema-Änderungen: php artisan migrate --force
- Bei geänderten Assets: npm run build
- Default-User nach dem ersten Login ändern

## 🟥 Sicherheitshinweise
- In Produktion keine Standard-Accounts nutzen.
- APP_DEBUG=false setzen.
- Wenn versehentlich .env versioniert wurde: Zugangsdaten rotieren.
