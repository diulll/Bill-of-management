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
                rausch: {
                    DEFAULT: '#ff385c',
                    active: '#e00b41',
                    disabled: '#ffd1da',
                    light: '#fff0f3',
                },
                ink: '#222222',
                body: '#3f3f3f',
                muted: {
                    DEFAULT: '#6a6a6a',
                    soft: '#929292',
                },
                hairline: {
                    DEFAULT: '#dddddd',
                    soft: '#ebebeb',
                },
                'border-strong': '#c1c1c1',
                canvas: '#ffffff',
                'surface-soft': '#f7f7f7',
                'surface-strong': '#f2f2f2',
                'error-text': '#c13515',
                'star-rating': '#222222',
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            fontSize: {
                'display-xl': ['28px', { lineHeight: '1.43', fontWeight: '700' }],
                'display-lg': ['22px', { lineHeight: '1.18', fontWeight: '500', letterSpacing: '-0.44px' }],
                'display-md': ['21px', { lineHeight: '1.43', fontWeight: '700' }],
                'display-sm': ['20px', { lineHeight: '1.20', fontWeight: '600', letterSpacing: '-0.18px' }],
                'title-md': ['16px', { lineHeight: '1.25', fontWeight: '600' }],
                'title-sm': ['16px', { lineHeight: '1.25', fontWeight: '500' }],
                'body-md': ['16px', { lineHeight: '1.5', fontWeight: '400' }],
                'body-sm': ['14px', { lineHeight: '1.43', fontWeight: '400' }],
                'caption': ['14px', { lineHeight: '1.29', fontWeight: '500' }],
                'caption-sm': ['13px', { lineHeight: '1.23', fontWeight: '400' }],
                'badge': ['11px', { lineHeight: '1.18', fontWeight: '600' }],
                'micro-label': ['12px', { lineHeight: '1.33', fontWeight: '700' }],
                'button-md': ['16px', { lineHeight: '1.25', fontWeight: '500' }],
                'button-sm': ['14px', { lineHeight: '1.29', fontWeight: '500' }],
                'nav-link': ['16px', { lineHeight: '1.25', fontWeight: '600' }],
            },
            borderRadius: {
                'airbnb-sm': '8px',
                'airbnb-md': '14px',
                'airbnb-lg': '20px',
                'airbnb-xl': '32px',
                'pill': '9999px',
            },
            boxShadow: {
                'airbnb': '0 0 0 1px rgba(0,0,0,0.02), 0 2px 6px rgba(0,0,0,0.04), 0 4px 8px rgba(0,0,0,0.1)',
                'airbnb-lg': '0 0 0 1px rgba(0,0,0,0.04), 0 8px 16px rgba(0,0,0,0.12)',
            },
            spacing: {
                '18': '4.5rem',
                '22': '5.5rem',
            },
            height: {
                'nav': '80px',
                'btn': '48px',
                'input': '56px',
                'search': '64px',
            },
        },
    },

    plugins: [forms],
};
