import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import api from '../lib/api'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(JSON.parse(localStorage.getItem('ap_user') || 'null'))

  const isLoggedIn = computed(() => !!user.value)

  async function login(email, password) {
    const { data } = await api.post('/login', { email, password })
    localStorage.setItem('ap_token', data.token)
    localStorage.setItem('ap_user', JSON.stringify(data.user))
    user.value = data.user
  }

  async function register(name, email, password, passwordConfirmation) {
    const { data } = await api.post('/register', {
      name,
      email,
      password,
      password_confirmation: passwordConfirmation ?? password,
    })
    localStorage.setItem('ap_token', data.token)
    localStorage.setItem('ap_user', JSON.stringify(data.user))
    user.value = data.user
  }

  async function logout() {
    try {
      await api.post('/logout')
    } catch (_) {
      // ignore network errors on logout
    }
    user.value = null
    localStorage.removeItem('ap_token')
    localStorage.removeItem('ap_user')
  }

  return { user, isLoggedIn, login, register, logout }
})
