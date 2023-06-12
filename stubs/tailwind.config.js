const defaultTheme = require('tailwindcss/defaultTheme')
const plugin = require('tailwindcss/plugin');

module.exports = {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './vendor/hotwired/hotstream/**/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },

      animation: {
        'appear-then-fade-out': 'appear-then-fade-out 3s both',
      },

      keyframes: () => ({
        ['appear-then-fade-out']: {
          '0%, 100%': { opacity: 0 },
          '10%, 80%': { opacity: 1 },
        },
      }),
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/aspect-ratio'),
    require('@tailwindcss/typography'),
    plugin(function ({ addVariant }) {
      return addVariant('native', ['&.native', '.native &']);
    }),
    plugin(function ({ addVariant }) {
      return addVariant('not-native', ['&:not(.native)', ':not(.native) &']);
    }),
    plugin(function ({ addVariant }) {
      return addVariant('is-selected', ['&.is-selected', '.is-selected &']);
    }),
    plugin(function ({ addVariant }) {
      return addVariant('in-frame', ['&.in-frame', '.in-frame &']);
    }),
  ]
}
