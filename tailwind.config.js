const defaultTheme = require('tailwindcss/defaultTheme');
const forms = require('@tailwindcss/forms');
const typography = require('@tailwindcss/typography');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.js",
        "./resources/js/**/*.css",
    ],
    theme: {
        extend: {
            colors: {
                primary: '#09B451',
                secondary: '#383D38',
                gunmetal: '#263238',
                rblack: '#232323',
                success: '#2E7D31',
                warning: '#FBC02D',
                error: '#E53835',
                ash: '#B1B1B1',
                fondo: '#EEEEEE',
                cultured: '#F2F4F7',
                greyblue: '#E6EFF5',
                silver: '#F5F7FA',
            },
            fontFamily: {
                poppins: ['Poppins', ...defaultTheme.fontFamily.sans],
                inter: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                soft: '0 2px 8px 0 rgba(0,0,0,0.08)',
                card: '0 4px 24px 0 rgba(0,0,0,0.08)',
            },
            borderRadius: {
                '2xl': '1rem',
                '3xl': '1.5rem',
            },
        },
    },
    plugins: [forms, typography],
};