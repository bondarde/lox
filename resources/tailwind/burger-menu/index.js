module.exports = function ({addComponents, theme}) {
    const minScreen = 'md'

    const button = '.burger-menu__burger'
    const menu = '.burger-menu__menu'
    const toggle = '.burger-menu__toggle'

    const burger = {
        [`${button}`]: {
            '@apply cursor-pointer select-none relative': {},
            '&:before, &:after': {
                display: 'block',
                content: '""',

                position: 'absolute',
                top: '50%',
                left: '8px',

                width: '12px',
                height: '2px',

                transition: '211ms ease-in-out',

                background: theme('colors.indigo.400'),
            },
            '&:before': {
                transform: 'translate(0, -2px)',
            },
            '&:after': {
                transform: 'translate(0, 2px)',
            },
            [`@screen ${minScreen}`]: {
                '&': {
                    '@apply hidden': {},
                },
            },
        },

        [`${menu}`]: {
            '@apply hidden': {},
            'z-index': '1000',
            [`@screen ${minScreen}`]: {
                '&': {
                    '@apply block': {},
                },
            },
        },

        [`${toggle}`]: {
            '@apply hidden': {},
            '&:checked': {
                [`& ~ ${menu}`]: {
                    '@apply block': {},
                    animation: 'burger-menu-fade-in 211ms ease-in-out forwards',
                },
                [`& ~ ${button}`]: {
                    '&:before': {
                        transform: 'rotate(45deg)',
                    },
                    '&:after': {
                        transform: 'rotate(-45deg)',
                    },
                },
            },
        },

        '@keyframes burger-menu-fade-in': {
            '0%': {
                opacity: '0',
            },

            '100%': {
                opacity: '1',
            },
        },
    }

    addComponents(burger)
}
