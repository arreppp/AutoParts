import { ref } from 'vue'
import api from '../lib/api'

// Kept as a plain composable (no Pinia store needed) —
// components fetch directly and categories are loaded once.

export const categories = ['All', 'Engine', 'Brakes', 'Suspension', 'Electrical', 'Body', 'Filters', 'Tyres']

export async function fetchProducts(params = {}) {
  const { data } = await api.get('/products', { params })
  return data
}

export async function fetchProduct(id) {
  const { data } = await api.get(`/products/${id}`)
  return data
}

export async function fetchCategories() {
  const { data } = await api.get('/categories')
  return data
}
