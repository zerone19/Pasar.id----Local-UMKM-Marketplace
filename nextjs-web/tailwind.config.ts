import type { Config } from 'tailwindcss';

export default {
  content: ['./src/**/*.{js,ts,jsx,tsx,mdx}'],
  theme: {
    extend: {
      colors: {
        primary: '#154212',
        secondary: '#456800',
        tertiary: '#52330f',
        background: '#fbf9f4',
        cream: '#fbf9f4',

        /* Design system surface colors */
        surface: '#f0eee9',
        'surface-container': '#edece7',
        'surface-container-low': '#f0eee9',
        'surface-container-high': '#e4e2dd',
        'surface-container-highest': '#d7d5ce',
        'surface-container-lowest': '#f7f5f0',

        /* Text colors */
        'on-surface': '#1b1c19',
        'on-surface-variant': '#60665a',
        'on-primary': '#ffffff',
        'on-secondary': '#ffffff',
        'on-tertiary': '#ffffff',

        /* Outline */
        outline: '#a8b0a0',
        'outline-variant': '#c2c9bb',

        /* Error */
        error: '#ba1a0a',
        'on-error': '#ffffff',
        'error-container': '#fde7e4',
      },
      fontFamily: {
        sans: ['Be Vietnam Pro', 'sans-serif'],
        body: ['Work Sans', 'sans-serif'],
        headline: ['Be Vietnam Pro', 'sans-serif'],
        label: ['Work Sans', 'sans-serif'],
        'headline-xl': ['Be Vietnam Pro', 'sans-serif'],
        'headline-md': ['Be Vietnam Pro', 'sans-serif'],
        'headline-lg': ['Be Vietnam Pro', 'sans-serif'],
        'body-sm': ['Work Sans', 'sans-serif'],
        'body-md': ['Work Sans', 'sans-serif'],
        'body-lg': ['Work Sans', 'sans-serif'],
        'label-sm': ['Work Sans', 'sans-serif'],
        'label-md': ['Work Sans', 'sans-serif'],
        'label-lg': ['Work Sans', 'sans-serif'],
      },
      boxShadow: {
        organic: '0 4px 12px rgba(0, 0, 0, 0.06), 0 1px 3px rgba(0, 0, 0, 0.04)',
      },
      borderRadius: {
        sm: '0.25rem',
        DEFAULT: '0.5rem',
        md: '0.75rem',
        lg: '1rem',
        xl: '1.5rem',
        full: '9999px',
      },
    },
  },
  plugins: [],
} satisfies Config;
