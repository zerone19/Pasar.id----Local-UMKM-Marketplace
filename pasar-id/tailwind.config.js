import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.blade.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['"Be Vietnam Pro"', ...defaultTheme.fontFamily.sans],
                label: ['"Work Sans"', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Pasar.ID design system — "Tactile Minimalism"
                surface: {
                    DEFAULT: '#fbf9f4',
                    dim: '#dbdad5',
                    bright: '#fbf9f4',
                    lowest: '#ffffff',
                    low: '#f5f3ee',
                    mid: '#f0eee9',
                    high: '#eae8e3',
                    highest: '#e4e2dd',
                },
                brand: {
                    DEFAULT: '#154212',      // primary forest green
                    on: '#ffffff',
                    container: '#2d5a27',
                    onContainer: '#9dd090',
                    soft: '#bcf0ae',         // primary-fixed
                    softDim: '#a1d494',     // primary-fixed-dim
                },
                leaf: {
                    DEFAULT: '#456800',      // secondary
                    on: '#ffffff',
                    container: '#bfef73',
                    onContainer: '#496d00',
                },
                burlap: {
                    DEFAULT: '#52330f',      // tertiary
                    on: '#ffffff',
                    container: '#6c4924',
                    onContainer: '#ebba8b',
                },
                ink: {
                    DEFAULT: '#1b1c19',      // on-surface
                    variant: '#42493e',      // on-surface-variant
                },
                outline: {
                    DEFAULT: '#72796e',
                    variant: '#c2c9bb',
                },
                error: {
                    DEFAULT: '#ba1a1a',
                    on: '#ffffff',
                    container: '#ffdad6',
                    onContainer: '#93000a',
                },
            },
            borderRadius: {
                DEFAULT: '0.5rem',
                lg: '1rem',
            },
            boxShadow: {
                leaf: '0 6px 20px -8px rgba(45, 90, 39, 0.18)',
                'leaf-sm': '0 2px 8px -4px rgba(45, 90, 39, 0.12)',
            },
            maxWidth: {
                content: '1280px',
            },
        },
    },

    plugins: [forms],
};
