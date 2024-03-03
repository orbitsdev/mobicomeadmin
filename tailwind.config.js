import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
import preset from './vendor/filament/support/tailwind.config.preset'
const colors = require('tailwindcss/colors')

/** @type {import('tailwindcss').Config} */
export default {
    presets: [preset],
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {

                gray: colors.neutral,
                system: {
                    '50': '#f0fdf5',
                    '100': '#dcfce8',
                    '200': '#bbf7d1',
                    '300': '#86efad',
                    '400': '#4ade81',
                    '500': '#22c55e',
                    '600': '#22c55e',
                    '700': '#15803c',
                    '800': '#166533',
                    '900': '#14532b',
                    '950': '#052e14'
                }
                // system: colors.system 
                
              }
        },
    },

    plugins: [forms, typography],
};
