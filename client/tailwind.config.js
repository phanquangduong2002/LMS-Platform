/** @type {import('tailwindcss').Config} */
export default {
  content: ['./index.html', './src/**/*.{js,ts,jsx,tsx,vue}'],
  theme: {
    extend: {
      colors: {
        primary: '#2f57ef',
        secondary: '#b966e7',
        gray: 'rgb(107, 115, 133)',
        heading: '#192335',
        body: '#6b7385'
      },
      backgroundColor: {
        'white-opacity': '#ffffff21',
        'gray-light': '#f6f6f6'
      },
      backgroundImage: {
        primary: '#2f57ef',
        gradient: 'linear-gradient(to right, #2f57ef, #b966e7)',
        banner: 'linear-gradient(270deg,#b966e7 0%,#2f57ef 100%)',
        blur: 'linear-gradient(#fff,hsla(0,0%,100%,.1))'
      },
      borderColor: {
        primary: '#2f57ef',
        secondary: '#b966e7',
        seperate: '#e6e3f1'
      },
      ringColor: {
        primaryOpacity: '#2f57ef21'
      }
    },
    daisyui: {}
  },
  plugins: [require('daisyui')]
}
