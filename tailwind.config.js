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
                'riak': {
                    // Warna Emas Utama (Honey Quartz)
                    'honey': '#F7B720',

                    // Warna Alam/Daun (Riak Khaki)
                    'khaki': '#6D7636',

                    // Warna Kontras/Mewah (Royal Army)
                    'army': '#2E3317',

                    // Warna Aksen Hangat (Sunset Persimmon)
                    'persimmon': '#E67E22',

                    // Warna Background Utama (Spring Cream)
                    'cream': '#FEFAE0',
                },
            },
            fontFamily: {
                sans: ['Inter', 'serif'], // Nuansa organik 
            },
        },
    },

    plugins: [forms],
};
