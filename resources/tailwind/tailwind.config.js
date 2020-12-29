module.exports = {
    purge: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    darkMode: 'media',
    theme: {
        container: {
            padding: {
                DEFAULT: '0.5rem',
                default: '0.5rem',
                sm: '2rem',
            },
            center: true,
        },
        fontSize: {
            xs: ['0.5em', {lineHeight: '1.5em'}],
            sm: ['0.75em', {lineHeight: '1.5em'}],
            md: ['0.85em', {lineHeight: '1.5em'}],
            base: ['1rem', {lineHeight: '1.5rem'}],
            lg: ['1.125rem', {lineHeight: '1.75rem'}],
            xl: ['1.25rem', {lineHeight: '1.75rem'}],
            '2xl': ['1.5rem', {lineHeight: '2rem'}],
            '3xl': ['1.875rem', {lineHeight: '2.25rem'}],
            '4xl': ['2.25rem', {lineHeight: '2.5rem'}],
            '5xl': ['3rem', {lineHeight: '1'}],
            '6xl': ['4rem', {lineHeight: '1'}],
        },
        extend: {
            screens: {
                'print': {
                    'raw': 'print',
                },
            }
        },
    },
    variants: {
        backgroundColor: [
            'responsive',
            'dark',
            'hover',
            'focus',
            'active',
            'focus-within',
        ],
        borderColor: [
            'dark',
            'hover',
            'focus',
            'focus-within',
        ],
        opacity: [
            'dark',
            'responsive',
            'hover',
            'focus',
            'disabled',
        ],
        outline: [
            'dark',
            'focus',
            'active',
            'focus-within',
        ],
        boxShadow: [
            'dark',
            'responsive',
            'focus',
            'active',
            'focus-within',
        ],
        extend: {},
    },
    plugins: [
        // require('./resources/tailwind/burger-menu'),
    ],
}
