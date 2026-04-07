<template>
  <div class="home">

    <!-- HERO -->
    <section class="hero">
      <div class="container hero-inner">
        <div class="hero-text">
          <div class="hero-eyebrow">MALAYSIA'S #1 AUTO PARTS PLATFORM</div>
          <h1>WHERE THE RIGHT<br><span>PARTS FIT</span></h1>
          <p>Find genuine and aftermarket car parts faster, smarter, and more reliably for your Proton, Perodua, Toyota, Honda, and more.</p>
          <div class="hero-search">
            <select class="hero-select">
              <option>SELECT MAKE</option>
              <option>Perodua</option><option>Proton</option><option>Toyota</option>
              <option>Honda</option><option>Mazda</option><option>Mitsubishi</option>
            </select>
            <select class="hero-select">
              <option>SELECT MODEL</option>
              <option>Myvi</option><option>Axia</option><option>Viva</option><option>Alza</option>
            </select>
            <select class="hero-select">
              <option>SELECT YEAR</option>
              <option v-for="y in years" :key="y">{{ y }}</option>
            </select>
            <router-link to="/catalog" class="btn-primary">SEARCH PARTS</router-link>
          </div>
        </div>
        <div class="hero-img">
          <div class="hero-gear-graphic">
            <div class="gear-ring outer"></div>
            <div class="gear-ring mid"></div>
            <div class="gear-ring inner"></div>
            <div class="gear-center">⚙</div>
            <div class="floating-part p1">🔧</div>
            <div class="floating-part p2">⚡</div>
            <div class="floating-part p3">🛑</div>
            <div class="floating-part p4">🔩</div>
          </div>
        </div>
      </div>
    </section>

    <!-- BRANDS -->
    <section class="section-wrap white">
      <div class="container">
        <p class="section-title">MULTI BRANDS <span>VEHICLE</span></p>
        <div class="section-divider"></div>
        <div class="brands-row">
          <div v-for="b in brands" :key="b.name" class="brand-logo">
            <span class="brand-emoji">{{ b.icon }}</span>
            <span>{{ b.name }}</span>
          </div>
        </div>
      </div>
    </section>

    <!-- INFO STRIP -->
    <section class="info-strip">
      <div class="container info-strip-inner">
        <div class="info-col">
          <div class="info-icon">🔍</div>
          <div>
            <h4>VEHICLE IDENTIFICATION NUMBER (VIN)</h4>
            <p>Enter your vehicle's VIN number to find the exact parts that match your specific vehicle. No guesswork, no parts mismatch.</p>
          </div>
        </div>
        <div class="info-logo-center">
          <div class="center-logo">⚙ AutoParts<span>MY</span></div>
          <div class="oem-badge">✔ OEM PART FITMENT</div>
          <p class="oem-text">100% guaranteed to fit your car for parts guaranteed to fit. 10 years warranty on OEM parts.</p>
        </div>
        <div class="info-col right">
          <div class="info-icon">🏷</div>
          <div>
            <h4>OEM PART FITMENT</h4>
            <p>Every OEM part carries the exact fitment data that indicates it fits 100% guaranteed to fit for 10-year car.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- CAR MODELS -->
    <section class="section-wrap gray">
      <div class="container">
        <p class="section-title">MULTI BRANDS AND <span>CAR MODELS</span></p>
        <div class="section-divider"></div>
        <p class="section-sub">Over 500+ directly-tracked and continuously-updated models for the most accurate results. repair. no guesswork. no costly mistakes.</p>
        <div class="models-grid">
          <div v-for="m in carModels" :key="m" class="model-card">
            <span class="model-icon">🚗</span>
            <span class="model-name">{{ m }}</span>
          </div>
        </div>
      </div>
    </section>

    <!-- PARTS COMPATIBILITY SEARCH -->
    <section class="section-wrap white">
      <div class="container">
        <p class="section-title">MAINTENANCE PARTS <span>COMPATIBILITY SEARCH</span></p>
        <div class="section-divider"></div>
        <p class="section-sub">Not sure if a maintenance part fits your car? Simply search parts for its part numbers and our smart catalog system in seconds.</p>
        <div class="parts-cat-grid">
          <router-link v-for="p in partCategories" :key="p.name" to="/catalog" class="parts-cat-card">
            <div class="parts-cat-icon">{{ p.icon }}</div>
            <span>{{ p.name }}</span>
          </router-link>
        </div>
      </div>
    </section>

    <!-- STATS -->
    <section class="stats-section">
      <div class="container stats-inner">
        <div class="stat-item" v-for="s in stats" :key="s.label">
          <div class="stat-num">{{ s.num }}</div>
          <div class="stat-label">{{ s.label }}</div>
        </div>
      </div>
    </section>

    <!-- HOW TO SEARCH -->
    <section class="section-wrap gray">
      <div class="container how-inner">
        <p class="section-title">HOW TO <span>SEARCH YOUR PARTS</span></p>
        <div class="section-divider"></div>
        <div class="how-steps">
          <div class="how-step" v-for="(s,i) in howSteps" :key="i">
            <div class="how-num">{{ i+1 }}</div>
            <div class="how-icon">{{ s.icon }}</div>
            <h4>{{ s.title }}</h4>
            <p>{{ s.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- REVIEWS -->
    <section class="section-wrap white">
      <div class="container">
        <p class="section-title">RECENT REVIEW <span>& RATING</span></p>
        <div class="section-divider"></div>
        <div class="reviews-grid">
          <div v-for="r in reviews" :key="r.name" class="review-card">
            <div class="review-top">
              <div class="reviewer-avatar">{{ r.initials }}</div>
              <div>
                <div class="reviewer-name">{{ r.name }}</div>
                <div class="review-stars">★★★★★</div>
              </div>
              <div class="review-badge">{{ r.badge }}</div>
            </div>
            <h4>{{ r.title }}</h4>
            <p>{{ r.text }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- CONTACT -->
    <section class="section-wrap gray contact-section">
      <div class="container contact-inner">
        <div class="contact-form-col">
          <p class="section-title" style="text-align:left">YOUR FEEDBACK IS IMPORTANT,<br>PLEASE TELL US <span>HOW TO IMPROVE</span></p>
          <div class="section-divider" style="margin-left:0"></div>
          <div class="contact-form">
            <div class="form-row">
              <div class="field"><label>NAME</label><input placeholder="Your Full Name" /></div>
              <div class="field"><label>EMAIL</label><input placeholder="Your Email Address" /></div>
            </div>
            <div class="field"><label>YOUR CONTACT NO.</label><input placeholder="01X-XXXXXXX" /></div>
            <div class="field"><label>YOUR MESSAGE</label><textarea rows="4" placeholder="Your message here..."></textarea></div>
            <button class="btn-primary">SEND MESSAGE</button>
          </div>
        </div>
        <div class="contact-img-col">
          <div class="contact-gear">⚙️</div>
        </div>
      </div>
    </section>

  </div>
</template>

<script setup>
const years = Array.from({length: 30}, (_,i) => 2024 - i)

const brands = [
  { name: 'Ford', icon: '🚙' }, { name: 'Hyundai', icon: '🚗' }, { name: 'Kia', icon: '🚗' },
  { name: 'Mazda', icon: '🚗' }, { name: 'Mitsubishi', icon: '🚙' }, { name: 'Alfa Romeo', icon: '🏎' }
]

const carModels = [
  'Myvi', 'Axia', 'Hilux', 'Triton', 'Tucson', 'Mazda 3',
  'Teana', 'Corolla E', 'Livina RS', 'BRV', 'Mazda 5', 'Lancer GS',
  'Wira', 'Iriz S', 'Ford Ranger'
]

const partCategories = [
  { name: 'Oil Filter', icon: '🔩' }, { name: 'Air Filter', icon: '💨' },
  { name: 'Cabin Filter', icon: '🌀' }, { name: 'Fuel Filter', icon: '⛽' },
  { name: 'Radiator by VIN', icon: '🌡' }, { name: 'Brake Pads', icon: '🛑' },
  { name: 'Brake Disc', icon: '⭕' }, { name: 'Brake Drum & Shoes', icon: '🔧' },
  { name: 'Spark Plug', icon: '⚡' }, { name: 'Ignition Coil', icon: '🔌' },
]

const stats = [
  { num: '25,345+', label: 'Live Products' },
  { num: '100,345+', label: 'Auto Service / Car Models' },
  { num: '10,115+', label: 'Car Service Models' },
]

const howSteps = [
  { icon: '🚗', title: 'Select Your Vehicle', desc: 'Choose your car make, model and year from our comprehensive database.' },
  { icon: '🔍', title: 'Search the Part', desc: 'Search by part name, OEM number, or browse by category.' },
  { icon: '🛒', title: 'Add to Cart', desc: 'Compare parts, check compatibility and add to your cart.' },
  { icon: '🚀', title: 'Fast Delivery', desc: 'Checkout securely and receive your parts within 1–3 working days.' },
]

const reviews = [
  { initials: 'RH', name: 'Razif H.', badge: '✔ Verified', title: 'Reliable OEM Parts Source', text: 'Good quality OEM parts. Arrived 2 days after ordering and fitment was perfect for my Myvi. Will definitely order again.' },
  { initials: 'LW', name: 'Lee W.', badge: '✔ Verified', title: 'Saved Me From Wrong Purchases', text: 'The VIN compatibility search is brilliant. I was about to order the wrong brake pads but the system flagged it and suggested the correct ones.' },
  { initials: 'AM', name: 'Ahmad M.', badge: '✔ Verified', title: 'Best Auto Parts Marketplace', text: 'Found a replacement alternator for my old Proton Saga here. Parts were genuine and price was much better than local shops. Fast shipping too.' },
]
</script>

<style scoped>
/* HERO */
.hero { background: linear-gradient(135deg, var(--navy) 0%, #2a3560 100%); color: #fff; padding: 56px 0; overflow: hidden; }
.hero-inner { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center; }
.hero-eyebrow { font-family: 'Barlow', sans-serif; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.15em; color: var(--red); background: rgba(204,0,0,0.15); display: inline-block; padding: 4px 14px; border-radius: 20px; margin-bottom: 16px; border: 1px solid rgba(204,0,0,0.4); }
.hero-text h1 { font-family: 'Barlow', sans-serif; font-size: clamp(2rem, 4vw, 3rem); font-weight: 900; line-height: 1.1; margin-bottom: 16px; text-transform: uppercase; }
.hero-text h1 span { color: var(--red); }
.hero-text p { color: #aab4cc; font-size: 0.95rem; margin-bottom: 28px; max-width: 480px; line-height: 1.7; }
.hero-search { display: flex; gap: 10px; flex-wrap: wrap; }
.hero-select { background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; padding: 10px 14px; border-radius: var(--radius); font-size: 0.82rem; font-family: 'Barlow', sans-serif; font-weight: 600; cursor: pointer; }
.hero-select option { background: var(--navy); color: #fff; }

.hero-img { display: flex; align-items: center; justify-content: center; }
.hero-gear-graphic { position: relative; width: 320px; height: 320px; display: flex; align-items: center; justify-content: center; }
.gear-ring { position: absolute; border-radius: 50%; border: 2px solid rgba(204,0,0,0.3); }
.gear-ring.outer { width: 300px; height: 300px; border-style: dashed; animation: spin 20s linear infinite; }
.gear-ring.mid { width: 220px; height: 220px; border-color: rgba(255,255,255,0.1); animation: spin 15s linear infinite reverse; }
.gear-ring.inner { width: 140px; height: 140px; border-color: rgba(204,0,0,0.4); }
.gear-center { font-size: 4rem; z-index: 1; animation: spin 8s linear infinite; }
.floating-part { position: absolute; font-size: 1.8rem; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); border-radius: 50%; width: 56px; height: 56px; display: flex; align-items: center; justify-content: center; }
.p1 { top: 10px; right: 60px; animation: float 3s ease-in-out infinite; }
.p2 { top: 60px; left: 10px; animation: float 3.5s ease-in-out infinite 0.5s; }
.p3 { bottom: 30px; right: 40px; animation: float 4s ease-in-out infinite 1s; }
.p4 { bottom: 60px; left: 30px; animation: float 3.2s ease-in-out infinite 1.5s; }
@keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
@keyframes spin { from{transform:rotate(0deg)} to{transform:rotate(360deg)} }

/* BRANDS */
.brands-row { display: flex; justify-content: center; gap: 40px; flex-wrap: wrap; align-items: center; }
.brand-logo { display: flex; flex-direction: column; align-items: center; gap: 6px; padding: 16px 24px; border: 1px solid var(--border); border-radius: var(--radius); min-width: 100px; transition: all 0.2s; cursor: pointer; background: #fff; }
.brand-logo:hover { border-color: var(--red); box-shadow: var(--shadow); }
.brand-emoji { font-size: 2rem; }
.brand-logo span:last-child { font-weight: 700; font-size: 0.85rem; font-family: 'Barlow', sans-serif; color: var(--text-muted); text-transform: uppercase; }

/* INFO STRIP */
.info-strip { background: var(--white); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); padding: 40px 0; }
.info-strip-inner { display: grid; grid-template-columns: 1fr auto 1fr; gap: 40px; align-items: center; }
.info-col { display: flex; gap: 16px; align-items: flex-start; }
.info-col.right { flex-direction: row-reverse; text-align: right; }
.info-icon { font-size: 2rem; flex-shrink: 0; }
.info-col h4 { font-family: 'Barlow', sans-serif; font-size: 0.9rem; font-weight: 800; text-transform: uppercase; margin-bottom: 6px; }
.info-col p { font-size: 0.83rem; color: var(--text-muted); line-height: 1.6; }
.info-logo-center { text-align: center; }
.center-logo { font-family: 'Barlow', sans-serif; font-weight: 900; font-size: 1.2rem; color: var(--navy); margin-bottom: 8px; }
.center-logo span { color: var(--red); }
.oem-badge { background: var(--red); color: #fff; font-weight: 700; font-size: 0.75rem; padding: 4px 14px; border-radius: 20px; display: inline-block; margin-bottom: 8px; font-family: 'Barlow', sans-serif; letter-spacing: 0.06em; }
.oem-text { font-size: 0.78rem; color: var(--text-muted); max-width: 180px; }

/* MODELS */
.models-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px; }
.model-card { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius); padding: 14px; display: flex; align-items: center; gap: 10px; transition: all 0.2s; cursor: pointer; }
.model-card:hover { border-color: var(--red); box-shadow: var(--shadow); }
.model-icon { font-size: 1.4rem; }
.model-name { font-weight: 700; font-family: 'Barlow', sans-serif; font-size: 0.88rem; text-transform: uppercase; }

/* PARTS CATEGORIES */
.parts-cat-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px; }
.parts-cat-card { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 20px 12px; display: flex; flex-direction: column; align-items: center; gap: 10px; text-align: center; transition: all 0.2s; }
.parts-cat-card:hover { border-color: var(--red); transform: translateY(-3px); box-shadow: var(--shadow); }
.parts-cat-icon { font-size: 2.2rem; background: var(--red-light); width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 50%; border: 2px solid rgba(204,0,0,0.15); }
.parts-cat-card span:last-child { font-size: 0.8rem; font-weight: 700; font-family: 'Barlow', sans-serif; text-transform: uppercase; color: var(--text); line-height: 1.3; }

/* STATS */
.stats-section { background: var(--red); padding: 48px 0; }
.stats-inner { display: flex; justify-content: space-around; align-items: center; }
.stat-item { text-align: center; color: #fff; }
.stat-num { font-family: 'Barlow', sans-serif; font-size: 2.8rem; font-weight: 900; line-height: 1; }
.stat-label { font-size: 0.85rem; opacity: 0.85; margin-top: 4px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }

/* HOW TO */
.how-steps { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; }
.how-step { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 28px 20px; text-align: center; position: relative; }
.how-num { position: absolute; top: -14px; left: 50%; transform: translateX(-50%); background: var(--red); color: #fff; font-family: 'Barlow', sans-serif; font-weight: 900; font-size: 0.85rem; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
.how-icon { font-size: 2.5rem; margin-bottom: 12px; }
.how-step h4 { font-family: 'Barlow', sans-serif; font-size: 0.9rem; font-weight: 800; text-transform: uppercase; margin-bottom: 8px; }
.how-step p { font-size: 0.82rem; color: var(--text-muted); line-height: 1.6; }

/* REVIEWS */
.reviews-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
.review-card { background: var(--bg); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 22px; }
.review-top { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; }
.reviewer-avatar { width: 42px; height: 42px; background: var(--navy); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-family: 'Barlow', sans-serif; flex-shrink: 0; }
.reviewer-name { font-weight: 700; font-size: 0.9rem; }
.review-stars { color: #f59e0b; font-size: 0.85rem; }
.review-badge { margin-left: auto; background: rgba(46,125,50,0.1); color: var(--success); font-size: 0.72rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; border: 1px solid rgba(46,125,50,0.2); white-space: nowrap; }
.review-card h4 { font-family: 'Barlow', sans-serif; font-size: 0.88rem; font-weight: 800; text-transform: uppercase; margin-bottom: 8px; color: var(--red); }
.review-card p { font-size: 0.83rem; color: var(--text-muted); line-height: 1.6; }

/* CONTACT */
.contact-inner { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; }
.contact-form { display: flex; flex-direction: column; gap: 14px; margin-top: 8px; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.field { display: flex; flex-direction: column; gap: 5px; }
.field label { font-size: 0.75rem; font-weight: 800; font-family: 'Barlow', sans-serif; color: var(--text-muted); letter-spacing: 0.06em; }
.field input, .field textarea { background: #fff; border: 1px solid var(--border); color: var(--text); padding: 10px 14px; border-radius: var(--radius); font-size: 0.9rem; resize: none; transition: border-color 0.2s; }
.field input:focus, .field textarea:focus { border-color: var(--red); }
.contact-img-col { display: flex; align-items: center; justify-content: center; }
.contact-gear { font-size: 12rem; opacity: 0.15; animation: spin 20s linear infinite; }

@media(max-width: 900px) {
  .hero-inner { grid-template-columns: 1fr; }
  .hero-img { display: none; }
  .models-grid { grid-template-columns: repeat(3,1fr); }
  .parts-cat-grid { grid-template-columns: repeat(3,1fr); }
  .how-steps { grid-template-columns: repeat(2,1fr); }
  .reviews-grid { grid-template-columns: 1fr; }
  .contact-inner { grid-template-columns: 1fr; }
  .contact-img-col { display: none; }
  .info-strip-inner { grid-template-columns: 1fr; }
}
</style>
