/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./app/Livewire/**/*.php",
    ],
    theme: {
        extend: {
            colors: {
                brand: {
                    50: 'var(--color-brand-50, #eef2ff)',
                    100: 'var(--color-brand-100, #e0e7ff)',
                    200: 'var(--color-brand-200, #c7d2fe)',
                    300: 'var(--color-brand-300, #a5b4fc)',
                    400: 'var(--color-brand-400, #818cf8)',
                    500: 'var(--color-brand-500, #6366f1)',
                    600: 'var(--color-brand-600, #4f46e5)',
                    700: 'var(--color-brand-700, #4338ca)',
                    800: 'var(--color-brand-800, #3730a3)',
                    900: 'var(--color-brand-900, #312e81)',
                    950: 'var(--color-brand-950, #1e1b4b)',
                },
                page: 'var(--color-page-bg, #ffffff)',
                card: 'var(--color-card-bg, #f5f7fa)',
                txmain: 'var(--color-text-main, #4a4a4a)',
                heading: '#1f2937',
                darkbox: '#ff8c00',
                unpaid: {
                    text: '#ff8c00',
                    bg: '#ff8c001a',
                }
            }
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}
