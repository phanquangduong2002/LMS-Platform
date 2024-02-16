/** @type {import('tailwindcss').Config} */
export default {
  content: ['./index.html', './src/**/*.{js,ts,jsx,tsx,vue}'],
  theme: {
    extend: {
      colors: {
        primary: '#2f57ef',
        secondary: '#b966e7',
        gray: 'rgb(107, 115, 133)'
      },

      backgroundImage: {
        primary: '#2f57ef',
        gradient: 'linear-gradient(to right, #2f57ef, #b966e7)'
      },
      borderColor: {
        primary: '#2f57ef',
        secondary: '#b966e7',
        seperate: '#e6e3f1'
      }
    },
    daisyui: {}
  },
  plugins: [require('daisyui')]
}
