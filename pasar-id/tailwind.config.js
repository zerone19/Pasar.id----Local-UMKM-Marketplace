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
                // Material Design Tokens tambahan (dari Stitch pt2)
                'primary': '#154212',
                'on-primary': '#ffffff',
                'primary-container': '#2d5a27',
                'on-primary-container': '#9dd090',
                'secondary': '#456800',
                'on-secondary': '#ffffff',
                'secondary-container': '#bfef73',
                'on-secondary-container': '#496d00',
                'tertiary': '#52330f',
                'on-tertiary': '#ffffff',
                'tertiary-container': '#6c4924',
                'on-tertiary-container': '#ebba8b',
                'background': '#fbf9f4',
                'on-background': '#1b1c19',
                'surface': '#fbf9f4',
                'on-surface': '#1b1c19',
                'surface-variant': '#e4e2dd',
                'on-surface-variant': '#42493e',
                'outline-variant': '#c2c9bb',
                'inverse-primary': '#a1d494',
                'surface-container': '#f0eee9',
                'surface-container-low': '#f5f3ee',
                'surface-container-high': '#eae8e3',
                'surface-container-lowest': '#ffffff',
                'surface-container-highest': '#e4e2dd',
                'surface-bright': '#fbf9f4',
                'surface-dim': '#dbdad5',
                'inverse-surface': '#30312e',
                'inverse-on-surface': '#f2f1ec',
                'on-tertiary-fixed': '#ffffff',
                'tertiary-fixed': '#ffdcbd',
                'on-tertiary-fixed-variant': '#61401b',
                'tertiary-fixed-dim': '#eebd8e',
                'tertiary-fixed-variant': '#61401b',
                'on-tertiary-fixed': '#ffffff',
                'secondary-fixed': '#c2f276',
                'on-secondary-fixed': '#121f00',
                'secondary-fixed-dim': '#a7d55d',
                'on-secondary-fixed-variant': '#334f00',
                'primary-fixed': '#bcf0ae',
                'on-primary-fixed': '#002201',
                'primary-fixed-dim': '#a1d494',
                'on-primary-fixed-variant': '#23501e',
                'outline': '#72796e',
                'on-tertiary': '#ffffff',
            },
            borderRadius: {
                DEFAULT: '0.25rem',
                sm: '0.125rem',
                md: '0.375rem',
                lg: '0.5rem',
                xl: '0.75rem',
                full: '9999px',
            },
            spacing: {
                base: '8px',
                xs: '4px',
                sm: '12px',
                md: '24px',
                lg: '40px',
                xl: '64px',
                gutter: '16px',
                'margin-mobile': '20px',
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

    plugins: [
        forms,
        // Tambahkan utility class untuk Material Design & typography
        function({ addUtilities }) {
            const newUtilities = {
                '.font-headline': { 
                    'font-family': '"Be Vietnam Pro", sans-serif', 
                    'font-weight': '700' 
                },
                '.font-body': { 
                    'font-family': '"Be Vietnam Pro", sans-serif', 
                    'font-weight': '400' 
                },
                '.font-label': { 
                    'font-family': '"Work Sans", sans-serif', 
                    'font-weight': '500' 
                },
                
                // Material symbols sizing utilities
                '.material-symbols-outlined': {
                    'font-family': 'Material Symbols Outlined',
                    'font-weight': 'normal',
                    'font-style': 'normal',
                    'font-size': '24px',
                    'line-height': '1',
                    'text-transform': 'none',
                    'letter-spacing': 'normal',
                    'word-wrap': 'nowrap',
                    'white-space': 'nowrap',
                    'display': 'inline-block',
                },
            }
            addUtilities(newUtilities, ['responsive'])
        }
    ],
};
