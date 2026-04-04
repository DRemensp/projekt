import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './app/**/*.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],

    // Safelist für dynamische Klassen
    safelist: [
        // Alle Farbvarianten die dynamisch verwendet werden
        {
            pattern: /bg-(blue|yellow|green|orange|purple|gray)-(50|100|200|300|500|700|800)/,
            variants: ['hover'],
        },
        {
            pattern: /text-(blue|yellow|green|orange|purple|gray)-(600|700|800)/,
        },
        {
            pattern: /border-(blue|yellow|green|orange|purple|gray)-(200|300|400|500)/,
        },
        {
            pattern: /from-(blue|yellow|green|orange|purple|gray)-(50)/,
        },
        {
            pattern: /to-(blue|yellow|green|orange|purple|gray)-(100|300)/,
        },

        // Spezifische Klassen
        'bg-blue-50',
        'bg-yellow-50',
        'bg-green-50',
        'bg-orange-50',
        'bg-purple-50',
        'bg-gray-50',
    ]
};
