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
            colors: {
                'shutter-copper': '#BC6C25', // Primary Action/Brand
                'porsche': '#DDA15E',        // Secondary/Accent
                'rocket-fuel': '#FEFAE0',    // Main Background
                'ceylanite': '#283618',      // Header/Footer/Dark Text
                'cedar-green': '#606C38',    // Deep accents
            },
            fontFamily: {
                sans: ['Inter', 'serif'], // Nuansa organik 
            },
        },
    },

    plugins: [forms],
};
