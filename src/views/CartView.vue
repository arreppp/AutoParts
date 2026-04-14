<template>
  <div>
    <div class="page-banner"><div class="container"><h1>MY CART</h1></div></div>
    <div class="cart-page container">
      <div v-if="loading" class="empty-cart">
        <span>⏳</span>
        <h3>Loading cart...</h3>
      </div>

      <div v-else-if="cart.items.length === 0" class="empty-cart">
        <span>🛒</span>
        <h3>Your cart is empty</h3>
        <p>Browse our catalog and add parts to your cart.</p>
        <router-link to="/catalog" class="btn-primary">BROWSE PARTS</router-link>
      </div>

      <div v-else class="cart-layout">
        <div class="cart-items">
          <div class="cart-table-header">
            <span>PRODUCT</span><span>PRICE</span><span>QTY</span><span>SUBTOTAL</span><span></span>
          </div>
          <div class="cart-row" v-for="item in cart.items" :key="item.id">
            <div class="item-product">
              <div class="item-emoji">{{ item.emoji }}</div>
              <div>
                <div class="item-brand">{{ item.brand }}</div>
                <div class="item-name">{{ item.name }}</div>
              </div>
            </div>
            <div class="item-cell">RM {{ item.price.toFixed(2) }}</div>
            <div class="item-cell">
              <div class="qty-ctrl">
                <button @click="updateQty(item.id, item.qty - 1)">−</button>
                <span>{{ item.qty }}</span>
                <button @click="updateQty(item.id, item.qty + 1)">+</button>
              </div>
            </div>
            <div class="item-cell bold">RM {{ item.subtotal.toFixed(2) }}</div>
            <button class="remove-btn" @click="removeItem(item.id)">✕</button>
          </div>
        </div>

        <div class="cart-summary">
          <h3>ORDER SUMMARY</h3>
          <div class="sum-row"><span>Subtotal</span><span>RM {{ cart.subtotal.toFixed(2) }}</span></div>
          <div class="sum-row">
            <span>Shipping</span>
            <span class="free-label" v-if="cart.shipping === 0">FREE</span>
            <span v-else>RM {{ cart.shipping.toFixed(2) }}</span>
          </div>
          <div class="sum-row"><span>SST (8%)</span><span>RM {{ cart.tax.toFixed(2) }}</span></div>
          <div class="sum-divider"></div>
          <div class="sum-row total"><span>TOTAL</span><span>RM {{ cart.total.toFixed(2) }}</span></div>
          <div class="free-ship-banner" v-if="cart.subtotal < 200">
            🚚 Add RM {{ (200 - cart.subtotal).toFixed(2) }} more for <strong>FREE shipping</strong>!
          </div>
          <router-link to="/checkout" class="btn-primary checkout-btn">PROCEED TO CHECKOUT →</router-link>
          <router-link to="/catalog" class="btn-secondary continue-btn">← CONTINUE SHOPPING</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useCartStore } from '../stores/cart'

const cart = useCartStore()
const loading = ref(true)

onMounted(async () => {
  try {
    await cart.fetchCart()
  } finally {
    loading.value = false
  }
})

async function removeItem(cartItemId) {
  await cart.remove(cartItemId)
}

async function updateQty(cartItemId, qty) {
  await cart.updateQty(cartItemId, qty)
}
</script>

<style scoped>
.page-banner { background: linear-gradient(to right, var(--navy), #2a3560); color: #fff; padding: 32px 0; }
.page-banner h1 { font-family: 'Barlow', sans-serif; font-weight: 900; font-size: 1.8rem; text-transform: uppercase; }
.cart-page { padding: 32px 20px 60px; }
.empty-cart { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 80px; text-align: center; }
.empty-cart span { font-size: 4rem; display: block; margin-bottom: 16px; }
.empty-cart h3 { font-family: 'Barlow', sans-serif; font-size: 1.4rem; margin-bottom: 8px; }
.empty-cart p { color: var(--text-muted); margin-bottom: 24px; }
.cart-layout { display: grid; grid-template-columns: 1fr 320px; gap: 24px; align-items: start; }
.cart-table-header { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 40px; gap: 12px; padding: 10px 16px; background: var(--navy); color: #fff; border-radius: var(--radius); font-family: 'Barlow', sans-serif; font-size: 0.75rem; font-weight: 800; letter-spacing: 0.06em; margin-bottom: 8px; }
.cart-row { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius); padding: 14px 16px; display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 40px; gap: 12px; align-items: center; margin-bottom: 8px; }
.item-product { display: flex; align-items: center; gap: 12px; }
.item-emoji { font-size: 2rem; background: var(--bg); width: 52px; height: 52px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius); flex-shrink: 0; border: 1px solid var(--border); }
.item-brand { font-size: 0.7rem; font-weight: 800; color: var(--red); text-transform: uppercase; }
.item-name { font-weight: 700; font-size: 0.88rem; }
.item-cell { font-size: 0.9rem; color: var(--text); }
.item-cell.bold { font-weight: 700; font-family: 'Barlow', sans-serif; }
.qty-ctrl { display: flex; align-items: center; border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; width: fit-content; }
.qty-ctrl button { background: var(--bg); border: none; width: 28px; height: 28px; cursor: pointer; font-size: 1rem; transition: background 0.15s; }
.qty-ctrl button:hover { background: var(--border); }
.qty-ctrl span { width: 32px; text-align: center; font-weight: 700; font-size: 0.88rem; }
.remove-btn { background: transparent; border: none; color: #ccc; font-size: 1rem; cursor: pointer; transition: color 0.2s; }
.remove-btn:hover { color: var(--red); }
.cart-summary { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 24px; position: sticky; top: 120px; }
.cart-summary h3 { font-family: 'Barlow', sans-serif; font-size: 0.9rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 18px; padding-bottom: 12px; border-bottom: 2px solid var(--red); color: var(--navy); }
.sum-row { display: flex; justify-content: space-between; padding: 7px 0; font-size: 0.88rem; color: var(--text-muted); }
.sum-row.total { font-weight: 800; font-family: 'Barlow', sans-serif; font-size: 1rem; color: var(--navy); }
.free-label { color: var(--success); font-weight: 700; }
.sum-divider { height: 1px; background: var(--border); margin: 6px 0; }
.free-ship-banner { background: #fff8e1; border: 1px solid #ffe082; color: #7a5700; font-size: 0.8rem; padding: 8px 12px; border-radius: var(--radius); margin: 12px 0; }
.checkout-btn { display: flex; justify-content: center; width: 100%; margin-top: 16px; }
.continue-btn { display: flex; justify-content: center; width: 100%; margin-top: 10px; }
</style>
