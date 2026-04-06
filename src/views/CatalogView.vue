<template>
  <div>
    <div class="catalog-banner">
      <div class="container">
        <h1>PARTS CATALOG</h1>
        <p>Find the right part for your vehicle</p>
      </div>
    </div>

    <div class="catalog-page container">
      <div class="catalog-layout">
        <!-- Sidebar -->
        <aside class="sidebar">
          <div class="sidebar-section">
            <h4>FILTER BY CATEGORY</h4>
            <button v-for="cat in categories" :key="cat" class="cat-btn" :class="{ active: selectedCat === cat }" @click="selectedCat = cat">
              {{ cat }} <span v-if="selectedCat === cat">✓</span>
            </button>
          </div>
          <div class="sidebar-section">
            <h4>SORT BY</h4>
            <select v-model="sort" class="sidebar-select">
              <option value="default">Featured</option>
              <option value="price-asc">Price: Low to High</option>
              <option value="price-desc">Price: High to Low</option>
              <option value="rating">Top Rated</option>
            </select>
          </div>
          <div class="sidebar-section">
            <h4>MAX PRICE: <span style="color:var(--red)">RM {{ maxPrice }}</span></h4>
            <input type="range" v-model.number="maxPrice" min="18" max="700" step="10" class="range" />
          </div>
        </aside>

        <!-- Main -->
        <div class="catalog-main">
          <div class="catalog-topbar">
            <div class="search-box">
              <span>🔍</span>
              <input v-model="query" placeholder="Search parts, brands, OEM number..." />
            </div>
            <span class="result-count">{{ filtered.length }} products found</span>
          </div>

          <div v-if="filtered.length" class="products-grid">
            <div class="product-card" v-for="p in filtered" :key="p.id">
              <div class="product-img">
                <span class="p-emoji">{{ p.emoji }}</span>
                <span class="p-cat-tag">{{ p.category }}</span>
              </div>
              <div class="product-body">
                <div class="p-brand">{{ p.brand }}</div>
                <h3 class="p-name">{{ p.name }}</h3>
                <div class="p-sku">SKU: {{ p.sku }}</div>
                <div class="p-stars">
                  <span class="stars">★★★★★</span>
                  <span class="p-rating">{{ p.rating }} ({{ p.reviews }})</span>
                </div>
                <div class="p-stock" :class="p.stock > 20 ? 'in' : p.stock > 0 ? 'low' : 'out'">
                  {{ p.stock > 20 ? '✓ In Stock' : p.stock > 0 ? `⚠ Only ${p.stock} left` : '✗ Out of Stock' }}
                </div>
                <div class="p-footer">
                  <span class="p-price">RM {{ p.price.toFixed(2) }}</span>
                  <button class="add-cart-btn" @click="addToCart(p)" :disabled="p.stock === 0">
                    🛒 ADD TO CART
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div v-else class="no-results">
            <span>🔍</span>
            <p>No parts found matching your search.</p>
            <button class="btn-primary" @click="selectedCat='All'; query=''; maxPrice=700">Reset Filters</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { categories, products } from '../stores/products'
import { useCartStore } from '../stores/cart'

const cart = useCartStore()
const selectedCat = ref('All')
const query = ref('')
const sort = ref('default')
const maxPrice = ref(700)
const added = ref(null)

function addToCart(p) { cart.add(p); added.value = p.id; setTimeout(() => added.value = null, 1200) }

const filtered = computed(() => {
  let list = products
  if (selectedCat.value !== 'All') list = list.filter(p => p.category === selectedCat.value)
  if (query.value) list = list.filter(p =>
    p.name.toLowerCase().includes(query.value.toLowerCase()) ||
    p.brand.toLowerCase().includes(query.value.toLowerCase()) ||
    p.sku.toLowerCase().includes(query.value.toLowerCase())
  )
  list = list.filter(p => p.price <= maxPrice.value)
  if (sort.value === 'price-asc') list = [...list].sort((a,b) => a.price - b.price)
  if (sort.value === 'price-desc') list = [...list].sort((a,b) => b.price - a.price)
  if (sort.value === 'rating') list = [...list].sort((a,b) => b.rating - a.rating)
  return list
})
</script>

<style scoped>
.catalog-banner { background: linear-gradient(to right, var(--navy), #2a3560); color: #fff; padding: 32px 0; }
.catalog-banner h1 { font-family: 'Barlow', sans-serif; font-weight: 900; font-size: 1.8rem; text-transform: uppercase; }
.catalog-banner p { color: #aab4cc; font-size: 0.9rem; margin-top: 4px; }

.catalog-page { padding: 28px 20px 60px; }
.catalog-layout { display: grid; grid-template-columns: 220px 1fr; gap: 24px; align-items: start; }

.sidebar { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; position: sticky; top: 120px; }
.sidebar-section { padding: 18px; border-bottom: 1px solid var(--border); }
.sidebar-section:last-child { border-bottom: none; }
.sidebar-section h4 { font-family: 'Barlow', sans-serif; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-muted); margin-bottom: 12px; }
.cat-btn { display: flex; justify-content: space-between; width: 100%; text-align: left; background: transparent; border: none; color: var(--text-muted); padding: 7px 10px; border-radius: var(--radius); cursor: pointer; font-size: 0.87rem; transition: all 0.15s; margin-bottom: 2px; }
.cat-btn:hover { background: var(--bg); color: var(--text); }
.cat-btn.active { background: var(--red-light); color: var(--red); font-weight: 700; }
.sidebar-select { width: 100%; background: var(--bg); border: 1px solid var(--border); color: var(--text); padding: 8px 12px; border-radius: var(--radius); font-size: 0.87rem; }
.range { width: 100%; accent-color: var(--red); margin-top: 8px; }

.catalog-topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; gap: 16px; }
.search-box { flex: 1; display: flex; align-items: center; gap: 10px; background: var(--white); border: 1px solid var(--border); border-radius: var(--radius); padding: 10px 16px; }
.search-box input { flex: 1; background: transparent; border: none; color: var(--text); font-size: 0.9rem; }
.search-box input::placeholder { color: #bbb; }
.result-count { font-size: 0.82rem; color: var(--text-muted); white-space: nowrap; font-weight: 600; }

.products-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
.product-card { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; transition: all 0.2s; }
.product-card:hover { border-color: var(--red); box-shadow: var(--shadow-md); transform: translateY(-2px); }
.product-img { background: var(--bg); height: 140px; display: flex; align-items: center; justify-content: center; position: relative; }
.p-emoji { font-size: 3.5rem; }
.p-cat-tag { position: absolute; top: 8px; left: 8px; background: var(--navy); color: #fff; font-size: 0.7rem; font-weight: 700; padding: 2px 10px; border-radius: 20px; font-family: 'Barlow', sans-serif; text-transform: uppercase; letter-spacing: 0.04em; }
.product-body { padding: 14px; }
.p-brand { font-size: 0.72rem; font-weight: 800; color: var(--red); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 3px; }
.p-name { font-family: 'Barlow', sans-serif; font-size: 0.95rem; font-weight: 700; line-height: 1.3; margin-bottom: 4px; }
.p-sku { font-size: 0.72rem; color: var(--text-light); margin-bottom: 6px; }
.p-stars { display: flex; align-items: center; gap: 6px; margin-bottom: 6px; font-size: 0.8rem; }
.stars { color: #f59e0b; }
.p-rating { color: var(--text-muted); }
.p-stock { font-size: 0.75rem; font-weight: 700; margin-bottom: 10px; }
.p-stock.in { color: var(--success); }
.p-stock.low { color: #d97706; }
.p-stock.out { color: #dc2626; }
.p-footer { display: flex; align-items: center; justify-content: space-between; gap: 8px; }
.p-price { font-family: 'Barlow', sans-serif; font-weight: 900; font-size: 1.1rem; color: var(--navy); }
.add-cart-btn { background: var(--red); color: #fff; border: none; padding: 7px 12px; border-radius: var(--radius); font-weight: 700; font-family: 'Barlow', sans-serif; font-size: 0.73rem; cursor: pointer; letter-spacing: 0.04em; transition: background 0.2s; white-space: nowrap; }
.add-cart-btn:hover { background: var(--red-dark); }
.add-cart-btn:disabled { opacity: 0.4; cursor: not-allowed; }

.no-results { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 60px; text-align: center; }
.no-results span { font-size: 3rem; display: block; margin-bottom: 12px; }
.no-results p { color: var(--text-muted); margin-bottom: 20px; }
</style>
