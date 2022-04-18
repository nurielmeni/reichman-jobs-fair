const _ = require("lodash");
const theme = require("./theme.json");
const tailpress = require("@jeffreyvr/tailwindcss-tailpress");

module.exports = {
  mode: "jit",
  important: false,
  content: [
    "./*/*.php",
    "./**/*.php",
    "../../plugins/NlsHunter/*/*.php",
    "../../plugins/NlsHunter/**/*.php",
    "../../plugins/NlsHunter/public/js/jobSearch.js",
    "./resources/css/*.css",
    "./resources/js/*.js",
    "./safelist.txt",
  ],
  theme: {
    container: {
      padding: {
        //DEFAULT: '1rem',
        // sm: '2rem',
        // lg: '0rem'
        DEFAULT: "0rem",
      },
      margin: {
        DEFAULT: "0.5rem 0",
      },
    },
    extend: {
      colors: tailpress.colorMapper(
        tailpress.theme("settings.color.palette", theme)
      ),
      width: {
        '1/31': '31%',
      },
      maxWidth: {
        'slider': '380px',
        'mslider': 'calc(100vw - 40px)',
        'cardAvatar': '30px',
        'logo': '100px',
        'mlogo': '40px',
        'lw': '144px',
        'mlw': '56px'
      },
      minWidth: {
        'slider': '380px',
        'mslider': 'calc(100vw - 40px)',
        'cardAvatar': '30px',
        'lw': '144px',
        'mlw': '56px'
      },
      maxHeight: {
        'slider': '266px',
        'mslider': '184px',
        'lw': '144px',
        'mlw': '56px'
      },
      minHeight: {
        'slider': '266px',
        'mslider': '184px',
        'lw': '144px',
        'mlw': '56px'
      },
      rotate: {
        '270': '270deg',
      },
      animation: {
        spin: 'spin 1s linear infinite',
        expand: 'expand-middle 0.6s -0.3s ease-out',
        slide: 'slide-left 1s -0.3s ease-out',
        'slide-down': 'slide-down 0.6s -0.3s ease-out'
      },
      keyframes: {
        'spin': {
          from: {
            transform: 'rotate(0deg)'
          },
          to: {
            transform: 'rotate(360deg)'
          }
        },
        'expand-middle': {
          from: {
            transform: 'scale(0)',
            opacity: '0.3'
          },
          to: {
            transform: 'scale(100%)',
            opacity: '1'
          }
        },
        'slide-left': {
          from: {
            transform: 'scaleX(0)',
            opacity: '0.3'
          },
          to: {
            transform: 'scaleX(1)',
            opacity: '1'
          }
        },
        'slide-down': {
          from: {
            transform: 'scaleY(0)',
            opacity: '0.3'
          },
          to: {
            transform: 'scaleY(1)',
            opacity: '1'
          }
        }
      },
      gridTemplateColumns: {
        'autofit-160': 'repeat( auto-fit, minmax(160px, 1fr) )',
        'autofit-114': 'repeat( auto-fit, minmax(114px, 1fr) )'
      }
    },
    screens: {
      sm: "640px",
      md: "768px",
      lg: "1280px",
      xl: tailpress.theme("settings.layout.wideSize", theme),
    },
  },
  plugins: [tailpress.tailwind],
};
