<?php

namespace App\Services;

class SchoolColorService
{
    private static array $colorMap = [
        1 => [
            'text' => 'text-blue-700 dark:text-blue-300',
            'border' => 'border-blue-500 dark:border-blue-400/70',
            'bg' => 'bg-blue-100 dark:from-blue-500/30 dark:to-blue-400/10 dark:bg-blue-500/10',
            'border-light' => 'border-blue-300 dark:border-blue-400/40',
            'bg-light' => 'bg-blue-100 dark:bg-blue-500/10',
            'text-subtle' => 'text-blue-600 dark:text-blue-300',
            'text-points' => 'text-blue-800 dark:text-blue-200',
            'text-hover' => 'hover:text-blue-900 dark:hover:text-blue-200',
            'border-hover' => 'hover:border-blue-700 dark:hover:border-blue-300',
            'gradient' => 'from-blue-50 to-blue-300 dark:from-blue-500/20 dark:to-blue-400/5'
        ],
        2 => [
            'text' => 'text-orange-700 dark:text-orange-300',
            'border' => 'border-orange-400 dark:border-orange-300/70',
            'bg' => 'bg-orange-100 dark:from-orange-500/30 dark:to-orange-400/10 dark:bg-orange-500/10',
            'border-light' => 'border-orange-300 dark:border-orange-400/40',
            'bg-light' => 'bg-orange-100 dark:bg-orange-500/10',
            'text-subtle' => 'text-orange-600 dark:text-orange-300',
            'text-points' => 'text-orange-800 dark:text-orange-200',
            'text-hover' => 'hover:text-orange-900 dark:hover:text-orange-200',
            'border-hover' => 'hover:border-orange-700 dark:hover:border-orange-300',
            'gradient' => 'from-orange-50 to-orange-300 dark:from-orange-500/20 dark:to-orange-400/5'
        ],
        3 => [
            'text' => 'text-green-700 dark:text-green-300',
            'border' => 'border-green-500 dark:border-green-400/70',
            'bg' => 'bg-green-100 dark:from-green-500/30 dark:to-green-400/10 dark:bg-green-500/10',
            'border-light' => 'border-green-300 dark:border-green-400/40',
            'bg-light' => 'bg-green-100 dark:bg-green-500/10',
            'text-subtle' => 'text-green-600 dark:text-green-300',
            'text-points' => 'text-green-800 dark:text-green-200',
            'text-hover' => 'hover:text-green-900 dark:hover:text-green-200',
            'border-hover' => 'hover:border-green-700 dark:hover:border-green-300',
            'gradient' => 'from-green-50 to-green-300 dark:from-green-500/20 dark:to-green-400/5'
        ],
        4 => [
            'text' => 'text-purple-700 dark:text-purple-300',
            'border' => 'border-purple-500 dark:border-purple-400/70',
            'bg' => 'bg-purple-100 dark:from-purple-500/30 dark:to-purple-400/10 dark:bg-purple-500/10',
            'border-light' => 'border-purple-300 dark:border-purple-400/40',
            'bg-light' => 'bg-purple-100 dark:bg-purple-500/10',
            'text-subtle' => 'text-purple-600 dark:text-purple-300',
            'text-points' => 'text-purple-800 dark:text-purple-200',
            'text-hover' => 'hover:text-purple-900 dark:hover:text-purple-200',
            'border-hover' => 'hover:border-purple-700 dark:hover:border-purple-300',
            'gradient' => 'from-purple-50 to-purple-300 dark:from-purple-500/20 dark:to-purple-400/5'
        ],
        5 => [
            'text' => 'text-yellow-700 dark:text-yellow-300',
            'border' => 'border-yellow-400 dark:border-yellow-300/70',
            'bg' => 'bg-yellow-100 dark:from-amber-400/30 dark:to-yellow-300/10 dark:bg-amber-400/10',
            'border-light' => 'border-yellow-300 dark:border-yellow-300/40',
            'bg-light' => 'bg-yellow-100 dark:bg-amber-400/10',
            'text-subtle' => 'text-yellow-600 dark:text-yellow-300',
            'text-points' => 'text-yellow-800 dark:text-yellow-200',
            'text-hover' => 'hover:text-yellow-900 dark:hover:text-yellow-200',
            'border-hover' => 'hover:border-yellow-700 dark:hover:border-yellow-300',
            'gradient' => 'from-yellow-50 to-yellow-300 dark:from-amber-400/20 dark:to-yellow-300/5'
        ],
    ];

    private static array $defaultColors = [
        'text' => 'text-gray-700 dark:text-slate-300',
        'border' => 'border-gray-500 dark:border-slate-500/70',
        'bg' => 'bg-gray-100 dark:from-slate-500/20 dark:to-slate-400/5 dark:bg-slate-500/10',
        'border-light' => 'border-gray-300 dark:border-slate-500/40',
        'bg-light' => 'bg-gray-50 dark:bg-slate-500/10',
        'text-subtle' => 'text-gray-600 dark:text-slate-300',
        'text-points' => 'text-gray-800 dark:text-slate-200',
        'text-hover' => 'hover:text-gray-900 dark:hover:text-slate-200',
        'border-hover' => 'hover:border-gray-700 dark:hover:border-slate-400',
        'gradient' => 'from-gray-50 to-gray-100 dark:from-slate-500/15 dark:to-slate-400/5'
    ];

    public static function getColorClasses(int|null $schoolId): array
    {
        return self::$colorMap[$schoolId] ?? self::$defaultColors;
    }

    public static function getAllColorsForJs(): array
    {
        $result = ['default' => self::$defaultColors];

        foreach (self::$colorMap as $schoolId => $colors) {
            $result[$schoolId] = $colors;
        }

        return $result;
    }
}
