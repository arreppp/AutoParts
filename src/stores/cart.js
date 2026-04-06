import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

export const useCartStore = defineStore('cart', () => {
  const items = ref(JSON.parse(localStorage.getItem('ap_cart') || '[]'))

  const count = computed(() => items.value.reduce((s, i) => s + i.qty, 0))
  const total = computed(() => items.value.reduce((s, i) => s + i.price * i.qty, 0))

  function save() { localStorage.setItem('ap_cart', JSON.stringify(items.value)) }

  function add(product) {
    const existing = items.value.find(i => i.id === product.id)
    if (existing) existing.qty++
    else items.value.push({ ...product, qty: 1 })
    save()
  }

  function remove(id) {
    items.value = items.value.filter(i => i.id !== id)
    save()
  }

  function updateQty(id, qty) {
    const item = items.value.find(i => i.id === id)
    if (item) { item.qty = qty; if (item.qty <= 0) remove(id) }
    save()
  }

  function clear() { items.value = []; save() }

  return { items, count, total, add, remove, updateQty, clear }
})
