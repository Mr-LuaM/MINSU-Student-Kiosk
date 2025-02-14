import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                primary: '#007C3D', // Slightly softened MinSU Green for a modern look
                secondary: '#FFC72C', // Warmer Gold for better contrast
                accent: '#004D1A', // Darker Green for hover effects and emphasis
                background: '#F8F9FA', // Light Grayish White for a clean look
                modal: '#FFFBEA', // Soft Gold-White for modals
                text: {
                    DEFAULT: '#2E2E2E', // Dark Gray for better readability
                    contrast: '#FFFFFF', // Pure White for Highlights
                },
                card: '#FFFFFF', // Fully White Cards for better separation
                border: '#D1D5DB', // Softer Gray for Borders
            },
    
        
            fontSize: {
                sm: ['1.125rem', { lineHeight: '1.75rem' }], // ~18px
                base: ['1.5rem', { lineHeight: '2rem' }], // ~24px
                lg: ['2rem', { lineHeight: '2.5rem' }], // ~32px
                xl: ['2.5rem', { lineHeight: '3rem' }], // ~40px
                '2xl': ['3rem', { lineHeight: '3.5rem' }], // ~48px
                '3.5xl': ['3.5rem', { lineHeight: '4rem' }], // ~56px
                '4xl': ['4rem', { lineHeight: '4.5rem' }], // ~64px
                '5xl': ['5rem', { lineHeight: '5.5rem' }], // ~80px
                '6xl': ['6rem', { lineHeight: '6.5rem' }], // ~96px
            },
            

            fontFamily: {
                sans: ['Inter', 'Poppins', 'Nunito', ...defaultTheme.fontFamily.sans],
            },

            screens: {
                sm: '640px', // Phones
                md: '768px', // Tablets
                lg: '1024px', // Laptops / Small Kiosks
                xl: '1280px', // Large Screens
                xxl: '1440px', // Extra Large Kiosk Displays
            },

            spacing: {
                18: '4.5rem', // Adjusted button spacing
                22: '5.5rem', // Better padding for kiosks
                button: '6rem', // Large buttons for touchscreen kiosks
            },

            borderRadius: {
                kiosk: '1rem', // Softer rounded edges for kiosk UI
            },

            cursor: {
                pointer: 'pointer', // Ensures touch-friendly buttons
            },

            boxShadow: {
                kiosk: '0px 4px 10px rgba(0, 0, 0, 0.3)', // Soft shadow for kiosk buttons
            },

            maxWidth: {
                kiosk: '80%', // Prevents text from stretching too wide on large screens
            },

            transitionTimingFunction: {
                smooth: 'cubic-bezier(0.4, 0, 0.2, 1)', // Smooth UI transitions
            },
        },
    },

    plugins: [forms],
};
