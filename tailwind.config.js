import colors from 'tailwindcss/colors'
import preset from './vendor/filament/support/tailwind.config.preset'

/** @type {import('tailwindcss').Config} */
export default {
    presets: [preset],
    darkMode: 'media',
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './vendor/**/*.blade.php',
        './app/**/*.php',
    ],
    theme: {
        container: {
            center: true,
            padding: {
                DEFAULT: '0.5rem',
                default: '0.5rem',
                sm: '2rem',
            },
        },
        extend: {
            colors: {
                'nav-highlight': '#4572c5',
                gray: colors.stone,
            },
            screens: {
                xs: '370px',
                print: {
                    raw: 'print',
                },
            }
        },
    },
    plugins: [
        // require('./resources/tailwind/burger-menu'),
    ],
}
