const colors = require('tailwindcss/colors');
const forms = require('@tailwindcss/forms');
const typography = require('@tailwindcss/typography');

module.exports = {
    content: [
        './resources/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                danger: colors.rose,
                primary: colors.green,
                success: colors.blue,
                warning: colors.yellow,
            },
        },
    },
    plugins: [
        forms,
        typography,
    ],
};
