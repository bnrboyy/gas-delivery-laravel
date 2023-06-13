/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            display: ['group-focus']
        },
    },
    variants: {
        extends: {
            display: ['group-focus']
        },
    },
    plugins: [],
};
