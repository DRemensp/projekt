<?php

namespace App\Services;

class SchoolColorService
{
    private static array $colorMap = [
        1 => [
            'text' => 'text-blue-700',
            'border' => 'border-blue-500',
            'bg' => 'bg-blue-100',
            'border-light' => 'border-blue-300',
            'bg-light' => 'bg-blue-100',
            'text-subtle' => 'text-blue-600',
            'text-points' => 'text-blue-800',
            'text-hover' => 'hover:text-blue-900',
            'border-hover' => 'hover:border-blue-700',
            'gradient' => 'from-blue-50 to-blue-300'
        ],
        2 => [
            'text' => 'text-green-700',
            'border' => 'border-green-500',
            'bg' => 'bg-green-100',
            'border-light' => 'border-green-300',
            'bg-light' => 'bg-green-100',
            'text-subtle' => 'text-green-600',
            'text-points' => 'text-green-800',
            'text-hover' => 'hover:text-green-900',
            'border-hover' => 'hover:border-green-700',
            'gradient' => 'from-green-50 to-green-300'
        ],
        3 => [
            'text' => 'text-purple-700',
            'border' => 'border-purple-500',
            'bg' => 'bg-purple-100',
            'border-light' => 'border-purple-300',
            'bg-light' => 'bg-purple-100',
            'text-subtle' => 'text-purple-600',
            'text-points' => 'text-purple-800',
            'text-hover' => 'hover:text-purple-900',
            'border-hover' => 'hover:border-purple-700',
            'gradient' => 'from-purple-50 to-purple-300'
        ],
        4 => [
            'text' => 'text-orange-700',
            'border' => 'border-orange-400',
            'bg' => 'bg-orange-100',
            'border-light' => 'border-orange-300',
            'bg-light' => 'bg-orange-100',
            'text-subtle' => 'text-orange-600',
            'text-points' => 'text-orange-800',
            'text-hover' => 'hover:text-orange-900',
            'border-hover' => 'hover:border-orange-700',
            'gradient' => 'from-orange-50 to-orange-300'
        ],
        5 => [
            'text' => 'text-yellow-700',
            'border' => 'border-yellow-400',
            'bg' => 'bg-yellow-100',
            'border-light' => 'border-yellow-300',
            'bg-light' => 'bg-yellow-100',
            'text-subtle' => 'text-yellow-600',
            'text-points' => 'text-yellow-800',
            'text-hover' => 'hover:text-yellow-900',
            'border-hover' => 'hover:border-yellow-700',
            'gradient' => 'from-yellow-50 to-yellow-300'
        ],
    ];

    private static array $defaultColors = [
        'text' => 'text-gray-700',
        'border' => 'border-gray-500',
        'bg' => 'bg-gray-100',
        'border-light' => 'border-gray-300',
        'bg-light' => 'bg-gray-50',
        'text-subtle' => 'text-gray-600',
        'text-points' => 'text-gray-800',
        'text-hover' => 'hover:text-gray-900',
        'border-hover' => 'hover:border-gray-700',
        'gradient' => 'from-gray-50 to-gray-100'
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
