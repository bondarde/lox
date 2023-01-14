module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/jetstream/**/*.blade.php',
        './vendor/bondarde/**/*.php',
        './app/**/*.php',
    ],
    theme: {
        container: {
            padding: {
                DEFAULT: '0.5rem',
                default: '0.5rem',
                sm: '2rem',
            },
            center: true,
        },
        extend: {
            screens: {
                'print': {
                    'raw': 'print',
                },
            }
        },
    },
    plugins: [
        // require('./resources/tailwind/burger-menu'),
    ],
}
