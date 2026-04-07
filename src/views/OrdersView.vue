<template>
  <div>
    <div class="page-banner"><div class="container"><h1>MY ORDERS</h1></div></div>
    <div class="orders-page container">
      <div v-if="loading" class="empty">
        <span>⏳</span>
        <h3>Loading orders...</h3>
      </div>
      <div v-else-if="orders.orders.length === 0" class="empty">
        <span>📦</span>
        <h3>NO ORDERS YET</h3>
        <p>Place your first order and it will appear here.</p>
        <router-link to="/catalog" class="btn-primary">START SHOPPING</router-link>
      </div>
      <div v-else class="orders-list">
        <div v-for="order in orders.orders" :key="order.id" class="order-card">
          <div class="order-header">
            <div class="order-meta">
              <span class="order-id">{{ order.order_number }}</span>
              <span class="order-date">{{ formatDate(order.created_at) }}</span>
            </div>
            <span class="status-badge" :class="order.status.toLowerCase()">{{ order.status }}</span>
          </div>
          <div class="order-body">
            <div class="order-item" v-for="item in order.items" :key="item.id">
              <span class="oi-emoji">{{ item.product_emoji }}</span>
              <span class="oi-name">{{ item.product_name }}</span>
              <span class="oi-qty">× {{ item.quantity }}</span>
              <span class="oi-price">RM {{ item.subtotal.toFixed(2) }}</span>
            </div>
          </div>
          <div class="order-footer">
            <div class="order-info-tags">
              <span>📍 {{ order.shipping_city }}, {{ order.shipping_state }}</span>
              <span>💳 {{ payLabel(order.payment_method) }}</span>
            </div>
            <div class="order-total">Grand Total: <strong>RM {{ Number(order.total).toFixed(2) }}</strong></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useOrdersStore } from '../stores/orders'

const orders = useOrdersStore()
const loading = ref(true)

onMounted(async () => {
  try {
    await orders.fetchOrders()
  } finally {
    loading.value = false
  }
})

function formatDate(iso) {
  return new Date(iso).toLocaleDateString('en-MY', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' })
}
function payLabel(m) {
  return { fpx: 'Online Banking (FPX)', card: 'Credit/Debit Card', ewallet: 'e-Wallet', cod: 'Cash on Delivery' }[m] || m
}
</script>

<style scoped>
.page-banner { background: linear-gradient(to right, var(--navy), #2a3560); color: #fff; padding: 32px 0; }
.page-banner h1 { font-family: 'Barlow', sans-serif; font-weight: 900; font-size: 1.8rem; }
.orders-page { padding: 32px 20px 80px; max-width: 860px; }
.empty { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 80px; text-align: center; }
.empty span { font-size: 4rem; display: block; margin-bottom: 16px; }
.empty h3 { font-family: 'Barlow', sans-serif; font-size: 1.2rem; font-weight: 900; margin-bottom: 8px; }
.empty p { color: var(--text-muted); margin-bottom: 24px; }
.orders-list { display: flex; flex-direction: column; gap: 16px; }
.order-card { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; }
.order-header { display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 1px solid var(--border); background: var(--bg); }
.order-meta { display: flex; align-items: center; gap: 16px; }
.order-id { font-family: 'Barlow', sans-serif; font-weight: 900; font-size: 0.9rem; color: var(--navy); }
.order-date { font-size: 0.8rem; color: var(--text-muted); }
.status-badge { padding: 4px 14px; border-radius: 20px; font-size: 0.72rem; font-weight: 800; text-transform: uppercase; font-family: 'Barlow', sans-serif; letter-spacing: 0.05em; }
.status-badge.processing { background: #fff3e0; color: #e65100; border: 1px solid #ffcc80; }
.status-badge.confirmed { background: #e3f2fd; color: #1565c0; border: 1px solid #90caf9; }
.status-badge.shipped { background: #e8f5e9; color: var(--success); border: 1px solid #a5d6a7; }
.status-badge.delivered { background: #e8f5e9; color: var(--success); border: 1px solid #a5d6a7; }
.status-badge.cancelled { background: #fff0f0; color: var(--red); border: 1px solid #ffcdd2; }
.order-body { padding: 14px 20px; display: flex; flex-direction: column; gap: 8px; }
.order-item { display: flex; align-items: center; gap: 10px; font-size: 0.87rem; padding: 6px 0; border-bottom: 1px dashed var(--border); }
.order-item:last-child { border-bottom: none; }
.oi-emoji { font-size: 1.3rem; }
.oi-name { flex: 1; }
.oi-qty { color: var(--text-muted); }
.oi-price { font-weight: 700; font-family: 'Barlow', sans-serif; }
.order-footer { display: flex; justify-content: space-between; align-items: center; padding: 12px 20px; border-top: 1px solid var(--border); }
.order-info-tags { display: flex; gap: 16px; font-size: 0.8rem; color: var(--text-muted); }
.order-total { font-size: 0.88rem; color: var(--text-muted); }
.order-total strong { font-family: 'Barlow', sans-serif; font-weight: 900; font-size: 1rem; color: var(--navy); }
</style>
