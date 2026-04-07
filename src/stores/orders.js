import { defineStore } from 'pinia'
import { ref } from 'vue'
import api from '../lib/api'

export const useOrdersStore = defineStore('orders', () => {
  const orders = ref([])

  async function fetchOrders() {
    const { data } = await api.get('/orders')
    orders.value = data.data ?? data
  }

  async function placeOrder(details) {
    const { data } = await api.post('/orders', details)
    orders.value.unshift(data.order)
    return data.order
  }

  async function fetchOrder(id) {
    const { data } = await api.get(`/orders/${id}`)
    return data
  }

  return { orders, fetchOrders, placeOrder, fetchOrder }
})
