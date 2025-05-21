module.exports = {
  content: [
    "./html/**/*.php",
    "./html/**/*.html",
    "./html/**/*.js",
    "./admin/**/*.php",
    "./admin/**/*.html",
    "./admin/**/*.js",
    "./*.php",
    "./*.html",
    "./assets/**/*.js",
    "./assets/**/*.html"
  ],
  safelist: [
    "prose", "prose-invert", "prose-lg", "prose-xl", "max-w-none", { pattern: /^prose/ },
    "bg-red-500", "text-white", "text-2xl", "p-6", "mb-6", "rounded", "shadow", "m-6", "bg-gray-100"
  ],
  theme: { extend: {} },
  plugins: [require('@tailwindcss/typography')],
  darkMode: 'class',
}

