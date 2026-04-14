import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import api from '../lib/api'

export const useCartStore = defineStore('cart', () => {
  const items    = ref([])
  const subtotal = ref(0)
  const shipping = ref(0)
  const tax      = ref(0)
  const total    = ref(0)

  const count = computed(() => items.value.reduce((s, i) => s + i.qty, 0))

  function applyResponse(data) {
    items.value    = data.items
    subtotal.value = data.subtotal
    shipping.value = data.shipping
    tax.value      = data.tax
    total.value    = data.total
  }

  async function fetchCart() {
    const { data } = await api.get('/cart')
    applyResponse(data)
  }

  async function add(product) {
    const { data } = await api.post('/cart/add', { product_id: product.id })
    applyResponse(data)
  }

  async function remove(cartItemId) {
    const { data } = await api.delete(`/cart/items/${cartItemId}`)
    applyResponse(data)
  }

  async function updateQty(cartItemId, qty) {
    const { data } = await api.put(`/cart/items/${cartItemId}`, { quantity: qty })
    applyResponse(data)
  }

  async function clear() {
    const { data } = await api.delete('/cart/clear')
    applyResponse(data)
  }

  return { items, count, subtotal, shipping, tax, total, fetchCart, add, remove, updateQty, clear }
})
