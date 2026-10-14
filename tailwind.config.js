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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                display: ['Inter', ...defaultTheme.fontFamily.sans],
            },

            colors: {
                brand: {
                    50: '#fff4f1',
                    100: '#ffe6df',
                    200: '#ffcab8',
                    300: '#ffa286',
                    400: '#ff7450',
                    500: '#f4572d',
                    600: '#c9370f',
                    700: '#a82a0c',
                    800: '#8a230d',
                    900: '#6f1d0b',
                },
                ink: {
                    50: '#fafaf9',
                    100: '#f5f5f4',
                    200: '#e7e5e4',
                    300: '#d6d3d1',
                    400: '#a8a29e',
                    500: '#78716c',
                    600: '#57534e',
                    700: '#44403c',
                    800: '#292524',
                    900: '#1c1917',
                },
            },

            boxShadow: {
                card: '0 1px 2px 0 rgb(28 25 23 / 0.04), 0 8px 24px -12px rgb(28 25 23 / 0.12)',
                'card-hover': '0 1px 2px 0 rgb(28 25 23 / 0.05), 0 18px 40px -16px rgb(28 25 23 / 0.20)',
                nav: '0 1px 2px 0 rgb(28 25 23 / 0.04)',
            },

            maxWidth: {
                wide: '1200px',
            },

            animation: {
                'fade-up': 'fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both',
                'pulse-soft': 'pulseSoft 2.4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            },

            keyframes: {
                fadeUp: {
                    '0%': { opacity: '0', transform: 'translateY(12px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                pulseSoft: {
                    '0%, 100%': { opacity: '1', transform: 'scale(1)' },
                    '50%': { opacity: '0.5', transform: 'scale(0.8)' },
                },
            },
        },
    },

    plugins: [forms],
};
