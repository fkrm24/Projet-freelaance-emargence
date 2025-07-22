import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    safelist: [
        'text-yellow-400',
        'text-gray-300',
        'text-red-500',
    ],
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
        colors: {
            primary: '#152C54',
            secondary: '#D0D3D5',
            accent1: '#2748E9',
            accent2: '#018FFD',
            white: '#FFFFFF',
            black: '#000000',
        },
    },

    plugins: [forms],
};
