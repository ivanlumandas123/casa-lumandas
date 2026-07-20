import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['"Work Sans"', ...defaultTheme.fontFamily.sans],
                display: ['"Fraunces"', ...defaultTheme.fontFamily.serif],
                mono: ['"IBM Plex Mono"', ...defaultTheme.fontFamily.mono],
            },
            colors: {
                ink: {
                    DEFAULT: '#14203A',
                    50: '#EEF0F5',
                    100: '#D7DCE8',
                    200: '#A8B2CB',
                    300: '#7A88AE',
                    400: '#4C5E91',
                    500: '#2C3B65',
                    600: '#1E2C4E',
                    700: '#14203A',
                    800: '#0D162A',
                    900: '#080D1A',
                },
                paper: {
                    DEFAULT: '#F1F0EA',
                    dark: '#E6E4DA',
                },
                brass: {
                    DEFAULT: '#B98A2E',
                    light: '#D9AE5D',
                    dark: '#8C6620',
                },
                confirmed: '#1F8A6B',
                pending: '#D98A3D',
                cancelled: '#B44B3D',
            },
        },
    },

    plugins: [forms],
};