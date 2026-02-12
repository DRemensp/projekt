<!DOCTYPE html>
<html lang="de">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Urkunde</title>

    @php
        // Farben basierend auf dem Rang
        $themeColor = '#000000';
        if ($rank == 1) $themeColor = '#c5a059';      // Gold
        elseif ($rank == 2) $themeColor = '#7f8c8d';  // Silber
        elseif ($rank == 3) $themeColor = '#a0522d';  // Bronze
    @endphp

    <style>
        @page { margin: 0; size: A4 portrait; }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0; padding: 0;
            background: none;
            color: #1a1a1a;
            line-height: 1.5;
        }

        /* ---------------- RAHMEN ---------------- */
        .page-border {
            position: absolute;
            top: 20px; left: 20px; right: 20px; bottom: 20px;
            border: 2px solid {{ $themeColor }};
            z-index: 50;
            pointer-events: none;
        }

        .inner-border {
            position: absolute;
            top: 35px; left: 35px; right: 35px; bottom: 35px;
            border: 1px solid {{ $themeColor }};
            opacity: 0.5;
            z-index: 50;
            pointer-events: none;
        }

        /* ---------------- ZENTRALER HINTERGRUND (LORBEERKRANZ) ---------------- */
        .central-bg-container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%); /* Exakte Zentrierung */
            z-index: -1000;
            width: 80%;
            text-align: center;
        }

        .central-bg-img {
            width: 100%;
            opacity: 0.15; /* Dezent im Hintergrund */
        }

        /* ---------------- INHALT ---------------- */
        .content {
            position: relative;
            padding: 100px 80px 0 80px;
            text-align: center;
            z-index: 100;
        }

        .top-decoration {
            width: 60px; height: 4px;
            background-color: {{ $themeColor }};
            margin: 0 auto 40px;
        }

        .event-name {
            font-size: 18px; text-transform: uppercase; letter-spacing: 6px;
            color: #7f8c8d; margin-bottom: 10px; font-weight: 400;
        }

        .main-title {
            font-size: 72px; font-family: 'Times New Roman', serif; font-weight: bold;
            color: #2c3e50; margin: 0 0 40px 0;
            text-transform: uppercase; letter-spacing: 2px;
        }

        .recognition-text {
            font-size: 16px; font-style: italic; color: #34495e; margin-bottom: 30px;
        }

        .recipient-name {
            font-size: 54px; font-weight: bold; color: #1a1a1a;
            border-bottom: 2px solid #eee; display: inline-block;
            padding-bottom: 10px; margin-bottom: 20px; min-width: 80%;
        }

        .sub-details {
            font-size: 18px; color: #7f8c8d; margin-bottom: 50px;
        }

        /* ---------------- ERGEBNIS KARTE ---------------- */
        .achievement-card {
            background-color: rgba(255, 255, 255, 0.85);
            border: 1px solid #e0e0e0;
            padding: 30px; width: 60%; margin: 0 auto;
            position: relative;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        }

        .rank-label {
            font-size: 48px; font-weight: 900; color: {{ $themeColor }}; margin-bottom: 5px;
        }

        .discipline-label {
            font-size: 14px; text-transform: uppercase; letter-spacing: 3px;
            color: #2c3e50; font-weight: bold;
        }

        .score-pill {
            display: inline-block; margin-top: 15px; padding: 5px 15px;
            background: #2c3e50; color: white; font-size: 12px;
            border-radius: 50px; text-transform: uppercase;
        }

        /* ---------------- FOOTER BEREICH ---------------- */
        .bottom-section {
            position: absolute;
            bottom: 60px;
            left: 40px;
            right: 40px;
            text-align: center;
        }

        .signature-line {
            width: 300px;
            height: 2px;
            background-color: {{ $themeColor }};
            margin: 0 auto 30px auto;
        }

        .logo-table {
            width: 100%;
            text-align: center;
        }

        .logo-table td {
            vertical-align: middle;
            text-align: center;
            width: 25%;
            padding: 0 10px;
        }

        .school-logo {
            max-width: 100%;
            height: auto;
            max-height: 50px;
            opacity: 0.8;
            filter: grayscale(100%);
        }

        /* Steinbeis etwas höher erlauben, damit es optisch passt */
        .logo-steinbeis {
            max-height: 70px;
        }

        .seal {
            position: absolute; bottom: 40px; right: 80px; width: 100px; height: 100px; opacity: 0.2;
        }
    </style>
</head>
<body>

<div class="page-border"></div>
<div class="inner-border"></div>

<div class="central-bg-container">
    <img class="central-bg-img" src="{{ public_path('pdf/Backgroundcentral.png') }}">
</div>

<div class="content">
    <div class="top-decoration"></div>
    <div class="event-name">CampusOlympiade {{ date('Y') }}</div>
    <h1 class="main-title">Urkunde</h1>

    <div class="recognition-text">
        @if($type === 'TEAM')
            In Anerkennung der herausragenden sportlichen Leistungen des Teams
        @elseif($type === 'KLASSE')
            In Anerkennung der gemeinschaftlichen Stärke der Klasse
        @else
            In Anerkennung der exzellenten Repräsentation der Schule
        @endif
    </div>

    <div class="recipient-name">{{ $name }}</div>

    <div class="sub-details">
        {{ $subtext }}
    </div>

    <div class="achievement-card">
        <div class="rank-label">{{ $rank }}. Platz</div>

        <div class="discipline-label">
            @if($type === 'TEAM')
                TEAMWERTUNG
            @elseif($type === 'KLASSE')
                KLASSENWERTUNG
            @else
                SCHULWERTUNG
            @endif
        </div>

        <div class="score-pill">{{ $score }} Gesamtpunkte</div>
    </div>
</div>

<div class="bottom-section">
    <div class="signature-line"></div>

    <table class="logo-table">
        <tr>
            <td>
                <img class="school-logo logo-steinbeis" src="{{ public_path('pdf/FredinantSteinbeisTransparent.png') }}">
            </td>
            <td>
                <img class="school-logo" src="{{ public_path('pdf/TheodorHeussTransparent.png') }}">
            </td>
            <td>
                <img class="school-logo" src="{{ public_path('pdf/LauraStradinTransparent.png') }}">
            </td>
            <td>
                <img class="school-logo" src="{{ public_path('pdf/KerstensteinerTransparent.png') }}">
            </td>
        </tr>
    </table>
</div>

<svg class="seal" viewBox="0 0 100 100">
    <circle cx="50" cy="50" r="45" fill="none" stroke="{{ $themeColor }}" stroke-width="2" />
    <circle cx="50" cy="50" r="38" fill="none" stroke="{{ $themeColor }}" stroke-width="1" />
    <path d="M30 50 L45 65 L70 35" fill="none" stroke="{{ $themeColor }}" stroke-width="5" />
</svg>

</body>
</html>
