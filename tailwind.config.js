import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

export default {
    darkMode: 'class', // Ensures dark mode is optional & not automatic
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.js',
        './vendor/usernotnull/tall-toasts/config/**/*.php',
        './vendor/usernotnull/tall-toasts/resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                primary: '#007C3D', // MinSU Green - Modernized
                secondary: {
                    DEFAULT: '#FFC72C', // Gold for contrast
                    darken: '#E6A800', // Darker Gold for hover effects
                },                
                accent: '#004D1A', // Darker Green for hover effects
                background: '#F8F9FA', // Light Grayish White
                modal: '#FFFBEA', // Soft Gold-White for modals
                card: '#FFFFFF', // Pure white for separation
                border: '#D1D5DB', // Soft gray for subtle borders

                // **Text Colors for better UI Contrast**
                text: {
                    DEFAULT: '#2E2E2E', // Dark Gray for readability
                    contrast: '#FFFFFF', // White for highlights
                    muted: '#6B7280', // Softer Gray for secondary text
                    danger: '#D32F2F', // Red for errors & warnings
                    success: '#388E3C', // Green for success messages
                    info: '#1976D2', // Blue for informative messages
                },

                // **Button & Interaction Colors**
                button: {
                    primary: {
                        DEFAULT: '#007C3D',
                        hover: '#005A2C',
                        focus: '#004D1A',
                    },
                    secondary: {
                        DEFAULT: '#FFC72C',
                        hover: '#E6A800',
                        focus: '#CC9700',
                    },
                    danger: {
                        DEFAULT: '#D32F2F',
                        hover: '#B71C1C',
                        focus: '#9A0007',
                    },
                    muted: '#A5A5A5',
                },

                input: {
                    bg: '#FFFFFF', 
                    border: '#CBD5E1', 
                    focus: '#004D1A', // FIXED to match other focus colors
                    placeholder: '#94A3B8',
                },

                dropdown: {
                    bg: '#FFFFFF', 
                    text: '#2E2E2E', 
                    hover: '#F3F4F6', 
                    border: '#D1D5DB',
                },
            },

            fontSize: {
                sm: ['1rem', { lineHeight: '1.5rem' }],
                md: ['1.125rem', { lineHeight: '1.75rem' }],
                base: ['1.25rem', { lineHeight: '1.75rem' }],
                lg: ['1.75rem', { lineHeight: '2.25rem' }],
                xl: ['2.25rem', { lineHeight: '2.75rem' }],
                '2xl': ['3rem', { lineHeight: '3.5rem' }],
                '4xl': ['4rem', { lineHeight: '4.5rem' }],
                '5xl': ['5rem', { lineHeight: '5.5rem' }],
            },

            fontFamily: {
                sans: ['Inter', 'Poppins', 'Nunito', ...defaultTheme.fontFamily.sans],
            },

            screens: {
                sm: '640px', 
                md: '768px', 
                lg: '1024px',
                xl: '1280px', 
                xxl: '1440px',
            },

            spacing: {
                18: '4.5rem',
                22: '5.5rem',
                button: '6rem',
            },

            borderRadius: {
                kiosk: '1rem',
                sm: '6px',
                md: '10px',
                lg: '16px',
            },

            cursor: {
                pointer: 'pointer',
                disabled: 'not-allowed',
            },

            boxShadow: {
                kiosk: '0px 4px 10px rgba(0, 0, 0, 0.3)',
                card: '0px 2px 8px rgba(0, 0, 0, 0.15)',
                modal: '0px 6px 20px rgba(0, 0, 0, 0.25)',
            },

            maxWidth: {
                kiosk: '80%',
                form: '720px',
            },

            transitionTimingFunction: {
                smooth: 'cubic-bezier(0.4, 0, 0.2, 1)',
            },

            transitionDuration: {
                DEFAULT: '300ms',
                fast: '150ms',
                slow: '500ms',
            },

            opacity: {
                10: '0.1',
                20: '0.2',
                30: '0.3',
                40: '0.4',
                50: '0.5',
                60: '0.6',
                70: '0.7',
                80: '0.8',
                90: '0.9',
            },

            zIndex: {
                dropdown: '100',
                modal: '200',
                toast: '300',
            },

            borderColor: {
                focus: '#004D1A',
            },
        },
    },

    plugins: [forms],
};
