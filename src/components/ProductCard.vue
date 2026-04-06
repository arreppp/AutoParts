<template>
  <div class="card" @click="$router.push('/catalog')">
    <div class="card-img">
      <span class="emoji">{{ product.emoji }}</span>
      <span class="category-tag">{{ product.category }}</span>
    </div>
    <div class="card-body">
      <div class="brand">{{ product.brand }}</div>
      <h3 class="name">{{ product.name }}</h3>
      <div class="meta">
        <span class="stars">{{ '★'.repeat(Math.round(product.rating)) }}</span>
        <span class="rating">{{ product.rating }}</span>
        <span class="reviews">({{ product.reviews }})</span>
      </div>
      <div class="footer">
        <span class="price">RM {{ product.price.toFixed(2) }}</span>
        <button class="add-btn" @click.stop="addToCart">
          <span>+</span> Add
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useCartStore } from '../stores/cart'
const cart = useCartStore()
const props = defineProps({ product: Object })

function addToCart() {
  cart.add(props.product)
}
</script>

<style scoped>
.card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  overflow: hidden;
  cursor: pointer;
  transition: border-color 0.2s, transform 0.2s;
}
.card:hover { border-color: var(--accent); transform: translateY(-4px); }
.card-img {
  background: var(--surface2);
  height: 160px;
  display: flex; align-items: center; justify-content: center;
  position: relative;
}
.emoji { font-size: 4rem; }
.category-tag {
  position: absolute; top: 12px; left: 12px;
  background: var(--border); color: var(--text-muted);
  padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;
}
.card-body { padding: 16px; }
.brand { font-size: 0.78rem; font-weight: 600; color: var(--accent); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 4px; }
.name { font-size: 0.95rem; font-weight: 700; line-height: 1.3; margin-bottom: 8px; font-family: 'Syne', sans-serif; }
.meta { display: flex; align-items: center; gap: 6px; margin-bottom: 14px; font-size: 0.82rem; }
.stars { color: #f59e0b; letter-spacing: 1px; }
.rating { font-weight: 700; }
.reviews { color: var(--text-muted); }
.footer { display: flex; align-items: center; justify-content: space-between; }
.price { font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1.1rem; }
.add-btn {
  background: var(--accent); color: #0e0e11; border: none; cursor: pointer;
  padding: 8px 16px; border-radius: 8px; font-weight: 700; font-family: 'Syne', sans-serif;
  font-size: 0.85rem; transition: all 0.2s; display: flex; align-items: center; gap: 4px;
}
.add-btn:hover { background: #d4eb30; }
</style>
