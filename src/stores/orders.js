import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useOrdersStore = defineStore('orders', () => {
  const orders = ref(JSON.parse(localStorage.getItem('ap_orders') || '[]'))

  function save() { localStorage.setItem('ap_orders', JSON.stringify(orders.value)) }

  function placeOrder(cart, details) {
    const order = {
      id: 'ORD-' + Date.now(),
      date: new Date().toISOString(),
      items: [...cart],
      details,
      status: 'Processing',
      total: cart.reduce((s, i) => s + i.price * i.qty, 0)
    }
    orders.value.unshift(order)
    save()
    return order
  }

  return { orders, placeOrder }
})
