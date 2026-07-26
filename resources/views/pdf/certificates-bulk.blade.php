<!DOCTYPE html>
<html lang="de">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Urkunden</title>

    <style>
        @page { margin: 0; size: A4 portrait; }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0; padding: 0;
            background: none;
            color: #1a1a1a;
            line-height: 1.5;
        }

        /* Eine Urkunde = eine Seite. Alle Dekorationen liegen absolut in diesem Kasten. */
        .sheet {
            position: relative;
            width: 100%;
            height: 296mm;
            overflow: hidden;
        }

        .page-border {
            position: absolute;
            top: 20px; left: 20px; right: 20px; bottom: 20px;
            border: 2px solid #000;
            z-index: 50;
        }

        .inner-border {
            position: absolute;
            top: 35px; left: 35px; right: 35px; bottom: 35px;
            border: 1px solid #000;
            opacity: 0.5;
            z-index: 50;
        }

        /* Quadratisches Motiv, 80% der Seitenbreite (476pt) -> mittig auf A4 hoch (842pt),
           damit es genauso sitzt wie auf der Einzelurkunde. */
        .central-bg-container {
            position: absolute;
            top: 182.8pt;
            left: 10%;
            width: 80%;
            z-index: 0;
            text-align: center;
        }

        .central-bg-img {
            width: 100%;
            opacity: 0.15;
        }

        .content {
            position: relative;
            padding: 100px 80px 0 80px;
            text-align: center;
            z-index: 100;
        }

        .top-decoration {
            width: 60px; height: 4px;
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

        .achievement-card {
            background-color: rgba(255, 255, 255, 0.85);
            border: 1px solid #e0e0e0;
            padding: 30px; width: 60%; margin: 0 auto;
            position: relative;
        }

        .rank-label {
            font-size: 48px; font-weight: 900; margin-bottom: 5px;
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

        .bottom-section {
            position: absolute;
            bottom: 60px;
            left: 40px;
            right: 40px;
            text-align: center;
            z-index: 100;
        }

        .signature-line {
            width: 300px;
            height: 2px;
            margin: 0 auto 30px auto;
        }

        .logo-table {
            width: 100%;
            text-align: center;
        }

        .logo-table td {
            vertical-align: middle;
            text-align: center;
            padding: 0 10px;
        }

        .school-logo {
            max-width: 100%;
            height: auto;
            max-height: 50px;
            opacity: 0.8;
            filter: grayscale(100%);
        }

        .logo-steinbeis {
            max-height: 70px;
        }

        .seal {
            position: absolute; bottom: 40px; right: 80px; width: 100px; height: 100px; opacity: 0.2;
            z-index: 100;
        }
    </style>
</head>
<body>

@php
    $allLogos = [
        'steinbeis'       => ['file' => 'FredinantSteinbeisTransparent.png', 'extra' => 'logo-steinbeis'],
        'heuss'           => ['file' => 'TheodorHeussTransparent.png',        'extra' => ''],
        'stradin'         => ['file' => 'LauraStradinTransparent.png',         'extra' => ''],
        'kerschensteiner' => ['file' => 'KerstensteinerTransparent.png',       'extra' => ''],
    ];
    $active   = array_filter($allLogos, fn($k) => in_array($k, $logoKeys ?? array_keys($allLogos)), ARRAY_FILTER_USE_KEY);
    $colWidth = count($active) > 0 ? round(100 / count($active), 2) . '%' : '25%';
@endphp

@foreach($certificates as $cert)
    @php
        $themeColor = '#000000';
        if ($cert['rank'] == 1) $themeColor = '#c5a059';      // Gold
        elseif ($cert['rank'] == 2) $themeColor = '#7f8c8d';  // Silber
        elseif ($cert['rank'] == 3) $themeColor = '#a0522d';  // Bronze
    @endphp

    <div class="sheet" @if(! $loop->last) style="page-break-after: always;" @endif>
        <div class="page-border" style="border-color: {{ $themeColor }};"></div>
        <div class="inner-border" style="border-color: {{ $themeColor }};"></div>

        <div class="central-bg-container">
            <img class="central-bg-img" src="{{ public_path('pdf/Backgroundcentral.png') }}">
        </div>

        <div class="content">
            <div class="top-decoration" style="background-color: {{ $themeColor }};"></div>
            <div class="event-name">CampusOlympiade {{ date('Y') }}</div>
            <h1 class="main-title">Urkunde</h1>

            <div class="recognition-text">
                @if($cert['type'] === 'TEAM')
                    In Anerkennung der herausragenden sportlichen Leistungen des Teams
                @elseif($cert['type'] === 'KLASSE')
                    In Anerkennung der gemeinschaftlichen Stärke der Klasse
                @else
                    In Anerkennung der exzellenten Repräsentation der Schule
                @endif
            </div>

            <div class="recipient-name">{{ $cert['name'] }}</div>

            <div class="sub-details">{{ $cert['subtext'] }}</div>

            <div class="achievement-card">
                <div class="rank-label" style="color: {{ $themeColor }};">{{ $cert['rank'] }}. Platz</div>

                <div class="discipline-label">
                    @if($cert['type'] === 'TEAM')
                        TEAMWERTUNG
                    @elseif($cert['type'] === 'KLASSE')
                        KLASSENWERTUNG
                    @else
                        SCHULWERTUNG
                    @endif
                </div>

                <div class="score-pill">{{ $cert['score'] }} Gesamtpunkte</div>
            </div>
        </div>

        <div class="bottom-section">
            <div class="signature-line" style="background-color: {{ $themeColor }};"></div>

            @if(count($active) > 0)
                <table class="logo-table">
                    <tr>
                        @foreach($active as $logo)
                            <td style="width: {{ $colWidth }}">
                                <img class="school-logo {{ $logo['extra'] }}" src="{{ public_path('pdf/' . $logo['file']) }}">
                            </td>
                        @endforeach
                    </tr>
                </table>
            @endif
        </div>

        <svg class="seal" viewBox="0 0 100 100">
            <circle cx="50" cy="50" r="45" fill="none" stroke="{{ $themeColor }}" stroke-width="2" />
            <circle cx="50" cy="50" r="38" fill="none" stroke="{{ $themeColor }}" stroke-width="1" />
            <path d="M30 50 L45 65 L70 35" fill="none" stroke="{{ $themeColor }}" stroke-width="5" />
        </svg>
    </div>
@endforeach

</body>
</html>
