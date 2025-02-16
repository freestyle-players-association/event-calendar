import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import colors from 'tailwindcss/colors';

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
                sans: ['work-sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    '50': '#f0f8ff',
                    '100': '#dff0ff',
                    '200': '#b8e3ff',
                    '300': '#7accff',
                    '400': '#33b2fd',
                    '500': '#0999ee',
                    '600': '#0079cc',
                    '700': '#0060a5',
                    '800': '#04548c',
                    '900': '#0a4570',
                    '950': '#062b4b',
                },
                secondary: colors.fuchsia
            },
        },
    },

    plugins: [forms],
};
