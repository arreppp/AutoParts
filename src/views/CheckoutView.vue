<template>
  <div>
    <div class="page-banner"><div class="container"><h1>CHECKOUT</h1></div></div>
    <div class="checkout-page container">

      <!-- Steps -->
      <div class="steps-bar">
        <div v-for="(s,i) in steps" :key="i" class="step-item" :class="{ active: step===i, done: step>i }">
          <div class="step-num">{{ step > i ? '✓' : i+1 }}</div>
          <span>{{ s }}</span>
          <div class="step-connector" v-if="i < steps.length - 1"></div>
        </div>
      </div>

      <!-- Step 1: Shipping -->
      <div v-if="step===0" class="checkout-grid">
        <div class="form-card">
          <h3>SHIPPING INFORMATION</h3>
          <div class="form-grid">
            <div class="field"><label>FULL NAME</label><input v-model="shipping.name" placeholder="Ahmad bin Abdullah" /></div>
            <div class="field"><label>PHONE NUMBER</label><input v-model="shipping.phone" placeholder="01X-XXXXXXX" /></div>
            <div class="field full"><label>ADDRESS LINE 1</label><input v-model="shipping.address1" placeholder="No. 12, Jalan Bunga Raya" /></div>
            <div class="field full"><label>ADDRESS LINE 2 (OPTIONAL)</label><input v-model="shipping.address2" placeholder="Taman Maju" /></div>
            <div class="field"><label>CITY</label><input v-model="shipping.city" placeholder="Petaling Jaya" /></div>
            <div class="field"><label>POSTCODE</label><input v-model="shipping.postcode" placeholder="47500" /></div>
            <div class="field full"><label>STATE</label>
              <select v-model="shipping.state" class="form-select">
                <option value="">Select state</option>
                <option v-for="s in states" :key="s">{{ s }}</option>
              </select>
            </div>
            <div class="field full"><label>DELIVERY NOTES</label><textarea v-model="shipping.notes" rows="2" placeholder="Leave at guardhouse, call before delivery..."></textarea></div>
          </div>
          <div class="form-actions">
            <router-link to="/cart" class="btn-secondary">← BACK TO CART</router-link>
            <button class="btn-primary" @click="step++" :disabled="!shippingValid">CONTINUE TO PAYMENT →</button>
          </div>
        </div>
        <OrderSideBar :cart="cart" :shipping="shippingCost" :tax="tax" :total="grandTotal" />
      </div>

      <!-- Step 2: Payment -->
      <div v-if="step===1" class="checkout-grid">
        <div class="form-card">
          <h3>PAYMENT METHOD</h3>
          <div class="pay-options">
            <label v-for="m in paymentMethods" :key="m.id" class="pay-opt" :class="{ selected: payment.method===m.id }">
              <input type="radio" v-model="payment.method" :value="m.id" hidden />
              <span class="pay-icon">{{ m.icon }}</span>
              <div><strong>{{ m.name }}</strong><p>{{ m.desc }}</p></div>
              <span class="pay-check" v-if="payment.method===m.id">✓</span>
            </label>
          </div>
          <div v-if="payment.method==='card'" class="card-fields">
            <div class="field full"><label>CARD NUMBER</label><input v-model="payment.cardNumber" placeholder="1234 5678 9012 3456" maxlength="19" /></div>
            <div class="field"><label>EXPIRY (MM/YY)</label><input v-model="payment.expiry" placeholder="MM/YY" maxlength="5" /></div>
            <div class="field"><label>CVV</label><input v-model="payment.cvv" placeholder="123" maxlength="3" type="password" /></div>
            <div class="field full"><label>NAME ON CARD</label><input v-model="payment.cardName" placeholder="AHMAD ABDULLAH" /></div>
          </div>
          <div class="form-actions">
            <button class="btn-secondary" @click="step--">← BACK</button>
            <button class="btn-primary" @click="step++" :disabled="!paymentValid">REVIEW ORDER →</button>
          </div>
        </div>
        <OrderSideBar :cart="cart" :shipping="shippingCost" :tax="tax" :total="grandTotal" />
      </div>

      <!-- Step 3: Confirm -->
      <div v-if="step===2" class="checkout-grid">
        <div class="form-card">
          <h3>REVIEW YOUR ORDER</h3>
          <div class="confirm-blocks">
            <div class="confirm-block">
              <h4>📦 SHIP TO</h4>
              <p><strong>{{ shipping.name }}</strong> &nbsp;|&nbsp; {{ shipping.phone }}</p>
              <p>{{ shipping.address1 }}<span v-if="shipping.address2">, {{ shipping.address2 }}</span></p>
              <p>{{ shipping.city }}, {{ shipping.postcode }}, {{ shipping.state }}</p>
            </div>
            <div class="confirm-block">
              <h4>💳 PAYMENT</h4>
              <p><strong>{{ paymentMethods.find(m=>m.id===payment.method)?.name }}</strong></p>
              <p v-if="payment.method==='card'" class="muted">Card ending in {{ payment.cardNumber.slice(-4) }}</p>
            </div>
          </div>
          <div class="confirm-items">
            <h4>🛒 ORDER ITEMS</h4>
            <div class="confirm-row" v-for="item in cart.items" :key="item.id">
              <span class="ci-emoji">{{ item.emoji }}</span>
              <span class="ci-name">{{ item.name }}</span>
              <span class="ci-qty">× {{ item.qty }}</span>
              <span class="ci-price">RM {{ (item.price * item.qty).toFixed(2) }}</span>
            </div>
          </div>
          <div class="form-actions">
            <button class="btn-secondary" @click="step--">← BACK</button>
            <button class="btn-primary place-btn" @click="placeOrder">✓ PLACE ORDER NOW</button>
          </div>
        </div>
        <OrderSideBar :cart="cart" :shipping="shippingCost" :tax="tax" :total="grandTotal" />
      </div>

      <!-- Success -->
      <div v-if="step===3" class="success-card">
        <div class="success-check">✓</div>
        <h2>ORDER PLACED SUCCESSFULLY!</h2>
        <p class="order-ref">Order Reference: <strong>{{ placedOrder?.id }}</strong></p>
        <p>Thank you for your purchase! Your parts will be processed and dispatched within 1 working day. You will receive a confirmation email shortly.</p>
        <div class="success-actions">
          <router-link to="/orders" class="btn-primary">VIEW MY ORDERS</router-link>
          <router-link to="/catalog" class="btn-secondary">CONTINUE SHOPPING</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, defineComponent, h } from 'vue'
import { useCartStore } from '../stores/cart'
import { useOrdersStore } from '../stores/orders'

const cart = useCartStore()
const ordersStore = useOrdersStore()
const step = ref(0)
const steps = ['Shipping', 'Payment', 'Confirm']
const placedOrder = ref(null)
const states = ['Johor','Kedah','Kelantan','Melaka','Negeri Sembilan','Pahang','Perak','Perlis','Pulau Pinang','Sabah','Sarawak','Selangor','Terengganu','Kuala Lumpur','Labuan','Putrajaya']
const shipping = ref({ name:'',phone:'',address1:'',address2:'',city:'',postcode:'',state:'',notes:'' })
const payment = ref({ method:'fpx',cardNumber:'',expiry:'',cvv:'',cardName:'' })
const paymentMethods = [
  { id:'fpx', icon:'🏦', name:'Online Banking (FPX)', desc:'Maybank2u, CIMB Clicks, RHB, Hong Leong and more' },
  { id:'card', icon:'💳', name:'Credit / Debit Card', desc:'Visa, Mastercard, American Express' },
  { id:'ewallet', icon:'📱', name:'e-Wallet', desc:"Touch 'n Go eWallet, GrabPay, Boost" },
  { id:'cod', icon:'💵', name:'Cash on Delivery', desc:'Pay when parts arrive (Klang Valley only)' },
]
const shippingCost = computed(() => cart.total >= 200 ? 0 : 15)
const tax = computed(() => cart.total * 0.08)
const grandTotal = computed(() => (cart.total + shippingCost.value + tax.value).toFixed(2))
const shippingValid = computed(() => shipping.value.name && shipping.value.phone && shipping.value.address1 && shipping.value.city && shipping.value.postcode && shipping.value.state)
const paymentValid = computed(() => {
  if (!payment.value.method) return false
  if (payment.value.method === 'card') return payment.value.cardNumber.length >= 16 && payment.value.expiry && payment.value.cvv && payment.value.cardName
  return true
})
function placeOrder() {
  placedOrder.value = ordersStore.placeOrder(cart.items, { shipping: shipping.value, payment: { method: payment.value.method }, total: grandTotal.value })
  cart.clear(); step.value = 3
}

const OrderSideBar = defineComponent({
  props: ['cart','shipping','tax','total'],
  setup(props) {
    return () => h('div', { class: 'order-sidebar' }, [
      h('h3', 'ORDER SUMMARY'),
      ...props.cart.items.map(item => h('div', { class: 'os-row' }, [
        h('span', item.name + ' ×' + item.qty),
        h('span', 'RM ' + (item.price * item.qty).toFixed(2))
      ])),
      h('div', { class: 'os-divider' }),
      h('div', { class: 'os-row' }, [h('span', 'Subtotal'), h('span', 'RM ' + props.cart.total.toFixed(2))]),
      h('div', { class: 'os-row' }, [h('span', 'Shipping'), h('span', props.shipping === 0 ? 'FREE' : 'RM ' + props.shipping.toFixed(2))]),
      h('div', { class: 'os-row' }, [h('span', 'SST (8%)'), h('span', 'RM ' + props.tax.toFixed(2))]),
      h('div', { class: 'os-divider' }),
      h('div', { class: 'os-row os-total' }, [h('span', 'TOTAL'), h('span', 'RM ' + props.total)])
    ])
  }
})
</script>

<style scoped>
.page-banner { background: linear-gradient(to right, var(--navy), #2a3560); color: #fff; padding: 32px 0; }
.page-banner h1 { font-family: 'Barlow', sans-serif; font-weight: 900; font-size: 1.8rem; }
.checkout-page { padding: 32px 20px 80px; max-width: 1000px; }

.steps-bar { display: flex; align-items: center; margin-bottom: 32px; }
.step-item { display: flex; align-items: center; gap: 10px; }
.step-num { width: 32px; height: 32px; border-radius: 50%; border: 2px solid var(--border); background: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-family: 'Barlow', sans-serif; font-size: 0.85rem; color: var(--text-muted); flex-shrink: 0; transition: all 0.3s; }
.step-item.active .step-num { border-color: var(--red); color: var(--red); }
.step-item.done .step-num { background: var(--red); border-color: var(--red); color: #fff; }
.step-item span { font-family: 'Barlow', sans-serif; font-weight: 700; font-size: 0.82rem; text-transform: uppercase; color: var(--text-muted); }
.step-item.active span { color: var(--navy); }
.step-connector { height: 2px; width: 60px; background: var(--border); margin: 0 12px; }

.checkout-grid { display: grid; grid-template-columns: 1fr 300px; gap: 20px; align-items: start; }
.form-card { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 28px; }
.form-card h3 { font-family: 'Barlow', sans-serif; font-size: 0.9rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.06em; color: var(--navy); margin-bottom: 20px; padding-bottom: 12px; border-bottom: 2px solid var(--red); }
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 24px; }
.field { display: flex; flex-direction: column; gap: 5px; }
.field.full { grid-column: span 2; }
.field label { font-size: 0.7rem; font-weight: 800; font-family: 'Barlow', sans-serif; color: var(--text-muted); letter-spacing: 0.08em; }
.field input, .field textarea { background: var(--bg); border: 1px solid var(--border); color: var(--text); padding: 10px 13px; border-radius: var(--radius); font-size: 0.9rem; resize: none; transition: border-color 0.2s; }
.field input:focus, .field textarea:focus { border-color: var(--red); background: #fff; }
.form-select { background: var(--bg); border: 1px solid var(--border); color: var(--text); padding: 10px 13px; border-radius: var(--radius); font-size: 0.9rem; width: 100%; }
.form-actions { display: flex; justify-content: space-between; align-items: center; margin-top: 8px; }
.btn-primary:disabled, .btn-secondary:disabled { opacity: 0.4; cursor: not-allowed; }

.pay-options { display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px; }
.pay-opt { display: flex; align-items: center; gap: 14px; border: 1.5px solid var(--border); border-radius: var(--radius); padding: 14px; cursor: pointer; transition: all 0.2s; background: var(--bg); }
.pay-opt.selected { border-color: var(--red); background: #fff0f0; }
.pay-icon { font-size: 1.6rem; flex-shrink: 0; }
.pay-opt div { flex: 1; }
.pay-opt strong { display: block; font-size: 0.9rem; }
.pay-opt p { color: var(--text-muted); font-size: 0.8rem; margin: 0; }
.pay-check { color: var(--red); font-weight: 900; font-size: 1.1rem; }
.card-fields { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 20px; }

.confirm-blocks { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 16px; }
.confirm-block { background: var(--bg); border: 1px solid var(--border); border-radius: var(--radius); padding: 14px; }
.confirm-block h4 { font-family: 'Barlow', sans-serif; font-size: 0.78rem; font-weight: 800; text-transform: uppercase; color: var(--text-muted); margin-bottom: 8px; }
.confirm-block p { font-size: 0.87rem; margin-bottom: 3px; }
.confirm-block .muted { color: var(--text-muted); font-size: 0.82rem; }
.confirm-items { background: var(--bg); border: 1px solid var(--border); border-radius: var(--radius); padding: 14px; margin-bottom: 20px; }
.confirm-items h4 { font-family: 'Barlow', sans-serif; font-size: 0.78rem; font-weight: 800; text-transform: uppercase; color: var(--text-muted); margin-bottom: 10px; }
.confirm-row { display: flex; align-items: center; gap: 10px; padding: 7px 0; border-bottom: 1px solid var(--border); font-size: 0.87rem; }
.confirm-row:last-child { border-bottom: none; }
.ci-emoji { font-size: 1.2rem; }
.ci-name { flex: 1; }
.ci-qty { color: var(--text-muted); }
.ci-price { font-weight: 700; }
.place-btn { min-width: 200px; justify-content: center; }

/* Order sidebar */
:deep(.order-sidebar) { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 22px; position: sticky; top: 120px; }
:deep(.order-sidebar h3) { font-family: 'Barlow', sans-serif; font-size: 0.85rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.06em; color: var(--navy); margin-bottom: 16px; padding-bottom: 10px; border-bottom: 2px solid var(--red); }
:deep(.os-row) { display: flex; justify-content: space-between; font-size: 0.83rem; color: var(--text-muted); padding: 5px 0; }
:deep(.os-divider) { height: 1px; background: var(--border); margin: 8px 0; }
:deep(.os-total) { font-weight: 900; font-family: 'Barlow', sans-serif; color: var(--navy); font-size: 0.95rem; }

.success-card { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 64px 40px; text-align: center; max-width: 600px; margin: 0 auto; }
.success-check { width: 72px; height: 72px; background: var(--red); color: #fff; font-size: 2rem; font-weight: 900; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; }
.success-card h2 { font-family: 'Barlow', sans-serif; font-weight: 900; font-size: 1.4rem; color: var(--navy); text-transform: uppercase; margin-bottom: 12px; }
.order-ref { color: var(--text-muted); margin-bottom: 12px; }
.order-ref strong { color: var(--red); font-family: 'Barlow', sans-serif; }
.success-card p { color: var(--text-muted); font-size: 0.9rem; line-height: 1.7; margin-bottom: 28px; }
.success-actions { display: flex; gap: 12px; justify-content: center; }
</style>
