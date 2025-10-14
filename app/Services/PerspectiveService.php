<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PerspectiveService
{
    private string $apiKey;
    private array $attributes;
    private array $languageHints;
    private float $blockThreshold;
    private float $moderateThreshold;
    private int $timeout;

    public function __construct()
    {
        $this->apiKey = config('services.perspective.api_key');
        $this->attributes = config('services.perspective.attributes', []);
        $this->languageHints = config('services.perspective.language_hints', ['de', 'en']);
        $this->blockThreshold = config('services.perspective.block_threshold', 0.75);
        $this->moderateThreshold = config('services.perspective.moderate_threshold', 0.60);
        $this->timeout = config('services.perspective.timeout', 4);
    }

    /**
     * Analysiert Text mit der Perspective API
     */
    public function analyzeText(string $text): array
    {
        if (empty($this->apiKey)) {
            Log::warning('Perspective API key not configured');
            return ['action' => 'allow', 'scores' => [], 'error' => 'API key not configured'];
        }

        // Erstelle Request für Perspective API
        $requestedAttributes = new \stdClass();

        // Füge Attribute hinzu - als leere Objekte für JSON-Konvertierung
        foreach ($this->attributes as $attribute) {
            $requestedAttributes->$attribute = new \stdClass();
        }

        $requestData = [
            'comment' => ['text' => $text],
            'requestedAttributes' => $requestedAttributes,
            'languages' => $this->languageHints,
            'doNotStore' => true, // Kommentare nicht speichern
        ];

        try {
            $response = Http::timeout($this->timeout)
                ->withOptions([
                    'verify' => config('app.env') === 'production', // SSL verification nur in Production
                ])
                ->post("https://commentanalyzer.googleapis.com/v1alpha1/comments:analyze?key={$this->apiKey}", $requestData);

            if (!$response->successful()) {
                $errorBody = $response->json();
                Log::error('Perspective API error', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                    'error_message' => $errorBody['error']['message'] ?? 'Unknown error',
                    'error_code' => $errorBody['error']['code'] ?? null,
                    'request_data' => $requestData
                ]);
                return [
                    'action' => 'allow',
                    'scores' => [],
                    'error' => 'API request failed: ' . ($errorBody['error']['message'] ?? $response->body())
                ];
            }

            $data = $response->json();
            $scores = [];
            $maxScore = 0;
            $triggeredAttributes = [];

            // Verarbeite die Scores
            if (isset($data['attributeScores'])) {
                foreach ($data['attributeScores'] as $attribute => $scoreData) {
                    $score = $scoreData['summaryScore']['value'] ?? 0;
                    $scores[$attribute] = $score;

                    if ($score > $maxScore) {
                        $maxScore = $score;
                    }

                    if ($score >= $this->moderateThreshold) {
                        $triggeredAttributes[] = $attribute;
                    }
                }
            }

            // Entscheide über die Aktion
            $action = $this->determineAction($maxScore, $triggeredAttributes);

            return [
                'action' => $action,
                'scores' => $scores,
                'maxScore' => $maxScore,
                'triggeredAttributes' => $triggeredAttributes,
                'error' => null
            ];

        } catch (\Exception $e) {
            Log::error('Perspective API exception', ['error' => $e->getMessage()]);
            return ['action' => 'allow', 'scores' => [], 'error' => $e->getMessage()];
        }
    }

    /**
     * Bestimmt die Aktion basierend auf den Scores
     */
    private function determineAction(float $maxScore, array $triggeredAttributes): string
    {
        if ($maxScore >= $this->blockThreshold) {
            return 'block';
        } elseif ($maxScore >= $this->moderateThreshold) {
            return 'moderate';
        } else {
            return 'allow';
        }
    }

    /**
     * Erstellt eine benutzerfreundliche Begründung
     */
    public function getReasonText(array $analysis): string
    {
        if ($analysis['action'] === 'allow') {
            return '';
        }

        $reasons = [];
        $attributeTranslations = [
            'TOXICITY' => 'toxischen Inhalts',
            'SEVERE_TOXICITY' => 'extrem toxischen Inhalts',
            'IDENTITY_ATTACK' => 'Identitätsangriffs',
            'INSULT' => 'beleidigender Sprache',
            'PROFANITY' => 'vulgärer Sprache',
            'THREAT' => 'Bedrohungen',
            'SEXUALLY_EXPLICIT' => 'sexueller Inhalte',
            'SPAM' => 'Spam-Inhalts',
        ];

        foreach ($analysis['triggeredAttributes'] as $attribute) {
            if (isset($attributeTranslations[$attribute])) {
                $reasons[] = $attributeTranslations[$attribute];
            }
        }

        if (empty($reasons)) {
            return 'unangemessener Inhalte';
        }

        return implode(', ', $reasons);
    }
}
