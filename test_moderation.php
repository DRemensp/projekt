<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Services\PerspectiveService;

echo "=== Testing Comment Moderation System ===\n\n";

$moderationService = new PerspectiveService();

// Test messages with different toxicity levels
$testMessages = [
    'clean' => 'Das ist ein sehr hilfreicher und informativer Beitrag. Vielen Dank!',
    'moderate' => 'Das ist wirklich dumm und macht keinen Sinn.',
    'offensive' => 'Du bist ein kompletter Idiot und solltest dich schämen!'
];

foreach ($testMessages as $type => $message) {
    echo "Testing {$type} message: '{$message}'\n";
    echo str_repeat('-', 50) . "\n";

    $analysis = $moderationService->analyzeText($message);

    echo "Action: " . $analysis['action'] . "\n";
    echo "Max Score: " . ($analysis['maxScore'] ?? 'N/A') . "\n";
    echo "Error: " . ($analysis['error'] ?? 'None') . "\n";

    if (!empty($analysis['scores'])) {
        echo "Detailed Scores:\n";
        foreach ($analysis['scores'] as $attribute => $score) {
            echo "  {$attribute}: " . round($score, 3) . "\n";
        }
    }

    if (!empty($analysis['triggeredAttributes'])) {
        echo "Triggered Attributes: " . implode(', ', $analysis['triggeredAttributes']) . "\n";
        echo "Reason: " . $moderationService->getReasonText($analysis) . "\n";
    }

    echo "\n";
}

echo "=== Test Complete ===\n";
