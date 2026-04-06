<template>
  <footer class="footer">
    <div class="footer-main">
      <div class="container footer-grid">
        <div class="footer-brand">
          <div class="footer-logo">⚙ AutoParts<span>MY</span></div>
          <p>Malaysia's trusted platform for genuine OEM and quality aftermarket car parts. Fast delivery, guaranteed fitment.</p>
        </div>
        <div class="footer-col">
          <h5>ABOUT US</h5>
          <a href="#">About AutoParts MY</a>
          <a href="#">Our Story</a>
          <a href="#">Careers</a>
          <a href="#">Press</a>
        </div>
        <div class="footer-col">
          <h5>PLATFORM & FEATURES</h5>
          <router-link to="/catalog">Parts Catalog</router-link>
          <a href="#">Compatibility Search</a>
          <a href="#">VIN Lookup</a>
          <a href="#">Find a Workshop</a>
        </div>
        <div class="footer-col">
          <h5>PARTNER WITH US</h5>
          <a href="#">Sell on AutoParts MY</a>
          <a href="#">Become an Auto Parts Retailer</a>
          <a href="#">Affiliate Program</a>
        </div>
        <div class="footer-col">
          <h5>SUPPORT</h5>
          <a href="#">Help Center</a>
          <a href="#">Shipping Policy</a>
          <a href="#">Return & Refund</a>
          <a href="#">Privacy Policy</a>
          <a href="#">Terms of Service</a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <div class="container footer-bottom-inner">
        <span>© 2025 AutoParts MY. All rights reserved.</span>
        <span>Built with Vue 3 + Vite + Pinia</span>
      </div>
    </div>
  </footer>
</template>

<style scoped>
.footer { background: var(--navy); color: #aab4cc; margin-top: 0; }
.footer-main { padding: 52px 0 40px; }
.footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; gap: 40px; }
.footer-logo { font-family: 'Barlow', sans-serif; font-weight: 900; font-size: 1.3rem; color: #fff; margin-bottom: 12px; }
.footer-logo span { color: var(--red); }
.footer-brand p { font-size: 0.83rem; line-height: 1.7; max-width: 220px; }
.footer-col { display: flex; flex-direction: column; gap: 10px; }
.footer-col h5 { font-family: 'Barlow', sans-serif; font-weight: 800; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; color: #fff; margin-bottom: 4px; }
.footer-col a { font-size: 0.83rem; color: #aab4cc; transition: color 0.2s; }
.footer-col a:hover { color: var(--red); }
.footer-bottom { border-top: 1px solid rgba(255,255,255,0.08); padding: 16px 0; }
.footer-bottom-inner { display: flex; justify-content: space-between; font-size: 0.8rem; color: #667; }
</style>
