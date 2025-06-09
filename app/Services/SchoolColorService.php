<?php

namespace App\Services;

class SchoolColorService
{
    private static array $colorMap = [
        1 => [
            'text' => 'text-blue-700',
            'border' => 'border-blue-500',
            'bg' => 'bg-blue-50',
            'border-light' => 'border-blue-300',
            'bg-light' => 'bg-blue-50/60',
            'text-subtle' => 'text-blue-600',
            'text-points' => 'text-blue-800',
            'text-hover' => 'hover:text-blue-900',
            'border-hover' => 'hover:border-blue-700'
        ],
        2 => [
            'text' => 'text-green-700',
            'border' => 'border-green-500',
            'bg' => 'bg-green-50',
            'border-light' => 'border-green-300',
            'bg-light' => 'bg-green-50/60',
            'text-subtle' => 'text-green-600',
            'text-points' => 'text-green-800',
            'text-hover' => 'hover:text-green-900',
            'border-hover' => 'hover:border-green-700'
        ],
        3 => [
            'text' => 'text-purple-700',
            'border' => 'border-purple-500',
            'bg' => 'bg-purple-50',
            'border-light' => 'border-purple-300',
            'bg-light' => 'bg-purple-50/60',
            'text-subtle' => 'text-purple-600',
            'text-points' => 'text-purple-800',
            'text-hover' => 'hover:text-purple-900',
            'border-hover' => 'hover:border-purple-700'
        ],
        4 => [
            'text' => 'text-amber-700',
            'border' => 'border-amber-500',
            'bg' => 'bg-amber-50',
            'border-light' => 'border-amber-300',
            'bg-light' => 'bg-amber-50/60',
            'text-subtle' => 'text-amber-600',
            'text-points' => 'text-amber-800',
            'text-hover' => 'hover:text-amber-900',
            'border-hover' => 'hover:border-amber-700'
        ],
        5 => [
            'text' => 'text-rose-700',
            'border' => 'border-rose-500',
            'bg' => 'bg-rose-50',
            'border-light' => 'border-rose-300',
            'bg-light' => 'bg-rose-50/60',
            'text-subtle' => 'text-rose-600',
            'text-points' => 'text-rose-800',
            'text-hover' => 'hover:text-rose-900',
            'border-hover' => 'hover:border-rose-700'
        ],
    ];

    private static array $defaultColors = [
        'text' => 'text-gray-700',
        'border' => 'border-gray-500',
        'bg' => 'bg-gray-50',
        'border-light' => 'border-gray-300',
        'bg-light' => 'bg-gray-50/60',
        'text-subtle' => 'text-gray-600',
        'text-points' => 'text-gray-800',
        'text-hover' => 'hover:text-gray-900',
        'border-hover' => 'hover:border-gray-700'
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
