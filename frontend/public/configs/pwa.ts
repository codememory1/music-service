export default {
  manifest: {
    name: process.env.SITE_NAME,
    short_name: process.env.SITE_NAME,
    description: '',
    start_url: '/',
    display: 'fullscreen',
    background_color: '#0E1723',
    theme_color: '#070E17',
    lang: process.env.DEFAULT_LANG,
    orientation: 'landscape-primary'
  },

  icon: {
    fileName: 'favicon/icon.png',
    sizes: [64, 120, 144, 152, 192, 328, 512],
    purpose: 'any'
  },

  workbox: {
    // debug: true,
    // dev: true
  }
};
