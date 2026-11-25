import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            colors: {
                navy: {
                    DEFAULT: '#0E2B53',
                    deep: '#0A1F3D',
                    soft: '#1A3F6F',
                    muted: '#3D5A7A',
                },
                teal: {
                    DEFAULT: '#2E8982',
                    dark: '#1E5D56',
                    soft: '#76BFA9',
                    mist: '#D8EFEA',
                },
                gold: {
                    DEFAULT: '#C9A227',
                    bright: '#E0BD4A',
                    soft: '#EAD9AE',
                    muted: '#A8841A',
                },
                ivory: {
                    DEFAULT: '#F4F1EC',
                    warm: '#EBE6DC',
                    deep: '#D9D2C5',
                },
            },
            fontFamily: {
                display: ['"Cormorant Garamond"', ...defaultTheme.fontFamily.serif],
                sans: ['"Source Sans 3"', ...defaultTheme.fontFamily.sans],
            },
            backgroundImage: {
                'vertex-grid':
                    'linear-gradient(rgba(14,43,83,0.04) 1px, transparent 1px), linear-gradient(90deg, rgba(14,43,83,0.04) 1px, transparent 1px)',
                'vertex-radial':
                    'radial-gradient(ellipse at top, rgba(46,137,130,0.18), transparent 55%), radial-gradient(ellipse at bottom right, rgba(201,162,39,0.12), transparent 45%)',
            },
            backgroundSize: {
                grid: '48px 48px',
            },
            keyframes: {
                'rise': {
                    '0%': { transform: 'translateY(12px)' },
                    '100%': { transform: 'translateY(0)' },
                },
            },
            animation: {
                rise: 'rise 0.7s ease-out',
            },
        },
    },

    plugins: [forms],
};
