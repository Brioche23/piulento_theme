module.exports = {
  content: ["./static/*.js", "./templates/**/*.twig"],
  theme: {
    fontFamily: {
      sans: ["Inter", "sans-serif"],
      serif: ["Wremena", "serif"],
    },
    extend: {
      backgroundImage: {
        "arrow-up": "url('./static/src/arrow-up.svg')",
        "arrow-right": "url('./static/src/arrow-right.svg')",
      },
      aspectRatio: {
        "2/1": "2 / 1",
      },
    },
  },
  plugins: [],
};
