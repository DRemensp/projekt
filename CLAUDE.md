# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**CampusOlympiade** – a Laravel 12 web app for school competitions. Teams compete in disciplines, scores are recorded centrally, and rankings are computed automatically. Key features: live rankings, team score sheets (Laufzettel), archive snapshots, and an AI-moderated community board.

## Commands

### Development (all-in-one)
```bash
composer dev
# Starts: php artisan serve, queue:listen, pail (log viewer), npm run dev
```

### Individual services
```bash
php artisan serve          # HTTP server
php artisan reverb:start   # WebSocket server (Laravel Reverb)
php artisan queue:listen   # Queue worker
npm run dev                # Vite asset compilation
npm run build              # Production assets
```

### Testing
```bash
php artisan test                             # Run all tests (uses Pest)
php artisan test --filter TestName           # Run a single test
php artisan test tests/Feature/ExampleTest.php  # Run a specific file
./vendor/bin/pest                            # Run Pest directly
```

Note: Tests use the real database (SQLite in-memory is commented out in `phpunit.xml.dist`). Configure `DB_CONNECTION` in `.env` for testing or uncomment the SQLite lines.

### Code style
```bash
./vendor/bin/pint          # Fix PHP code style (Laravel Pint)
./vendor/bin/pint --test   # Check without fixing
```

### Artisan shortcuts
```bash
php artisan optimize:clear       # Clear all caches (after deploy or config changes)
php artisan migrate              # Run migrations
php artisan db:seed --class=DatabaseSeeder  # Seed initial data (admin + teacher accounts)
php artisan tinker               # REPL
```

## Architecture

### Tech stack
- **Laravel 12 / PHP 8.2** – MVC backbone
- **Livewire 3** – reactive UI components (comments, forms)
- **Livewire Volt** – single-file Livewire components (used in `resources/views/livewire/`)
- **Tailwind CSS 3 + Vite 6** – styling and asset pipeline
- **Laravel Reverb** – self-hosted WebSocket server for real-time broadcasts
- **Spatie Permission** – role-based access control (roles: `admin`, `teacher`; Klassen-Accounts have no named role)
- **Spatie Cookie Consent** – GDPR cookie management
- **Google Perspective API** – AI comment moderation (`App\Services\PerspectiveService`)

### Data model
```
School 1──* Klasse 1──* Team
Klasse 1──1 Discipline
Team *──* Discipline  (pivot: discipline_team with score_1, score_2)
User 1──1 Klasse      (matched via User.name == Klasse.name, or Klasse.user_id)
```

Key tables: `schools`, `klasses`, `teams`, `disciplines`, `discipline_team` (pivot), `comments`, `settings` (singleton row), `archives`, `scoresystems`, `visit_counters`, and Spatie permission tables.

### Score calculation (`RankingController::recalculateAllScores`)
Triggered via `POST /ranking/recalculate`. Steps:
1. Reset all team/klasse/school scores to 0.
2. Per discipline: take best of 2 attempts per team (`score_1`, `score_2`).
3. Sort by `higher_is_better` flag.
4. Assign points from `Scoresystem`: fixed values for places 1–3, then `max_score - (rank - 4) * score_step` for the rest (min 0).
5. Add `bonus_score` to teams with `bonus = true`.
6. Klasse score = average of its teams' scores.
7. School score = average of all teams across all klasses.

### School color system (`App\Services\SchoolColorService`)
Maps school IDs (1–5) to Tailwind color classes for text, borders, backgrounds, and gradients (with dark-mode variants). ID > 5 falls back to gray/slate. Call `SchoolColorService::getColorClasses($schoolId)` to get a keyed array of class strings, or `getAllColorsForJs()` to pass the full map to Blade/JavaScript.

### Roles and access
- **Admin** – full access: school/klasse/team/discipline/scoresystem management, archive, broadcast, bonus toggle, comment moderation.
- **Teacher** – score entry for all teams/disciplines, comment moderation.
- **Klassen-Account** – authenticated user created automatically when a Klasse is created; can only enter scores for their own discipline (`/dashboard`).
- **Public** – ranking, laufzettel, comments (if enabled).

Role checks in routes use inline closures; in controllers the pattern is `auth()->user()->hasRole('admin')`.

### Comment system
- Livewire component: `App\Livewire\Comments` + `resources/views/livewire/comments.blade.php`
- Comments require: Spatie cookie consent with `moderation: true`, plus a `comment_notice_ack=1` cookie (first-use acknowledgement).
- Moderation pipeline: PerspectiveService → `allow` (auto-approved) / `moderate` (pending) / `block`.
- Without a `PERSPECTIVE_API_KEY`, all comments fall back to `pending`.
- `settings.comments_enabled` (cached 1h in `settings_comments_enabled` cache key) gates the entire feature.

### Real-time events (Laravel Reverb)
- `AdminBroadcastMessage` – admin sends messages to targets: `guests` (public channel), `teachers` / `klasses` (private channels).
- `ScoresRecalculated` – fired after score recalculation.
- Frontend listens via Laravel Echo + Pusher-compatible JS (`resources/js/`).

### Laufzettel (team score sheet)
`/laufzettel` – public search by team. `/laufzettel/{team}` – detailed view: total score, overall rank, discipline rank, best score, highscore per discipline. Admins can toggle bonus status here via AJAX (`POST /team/{team}/toggle-bonus`), which triggers recalculation.

### Archive
`ArchiveController::store` snapshots the full current state (rankings, disciplines, teams, colors, stats) as JSON into the `archives` table. Snapshots are read-only and can be deleted by admins.

### Key `.env` variables
| Variable | Purpose |
|---|---|
| `PERSPECTIVE_API_KEY` | Google Perspective API for comment moderation |
| `PERSPECTIVE_BLOCK_THRESHOLD` / `PERSPECTIVE_MODERATE_THRESHOLD` | Score thresholds (default 0.75 / 0.60) |
| `REVERB_*` / `VITE_REVERB_*` | WebSocket server config |
| `BROADCAST_CONNECTION=reverb` | Required for real-time features |
| `QUEUE_CONNECTION` | `database` (default) or `redis` |
