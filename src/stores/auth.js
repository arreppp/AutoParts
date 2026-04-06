import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(JSON.parse(localStorage.getItem('ap_user') || 'null'))

  const isLoggedIn = computed(() => !!user.value)

  function login(email, password) {
    const users = JSON.parse(localStorage.getItem('ap_users') || '[]')
    const found = users.find(u => u.email === email && u.password === password)
    if (!found) throw new Error('Invalid email or password.')
    user.value = { name: found.name, email: found.email }
    localStorage.setItem('ap_user', JSON.stringify(user.value))
  }

  function register(name, email, password) {
    const users = JSON.parse(localStorage.getItem('ap_users') || '[]')
    if (users.find(u => u.email === email)) throw new Error('Email already registered.')
    users.push({ name, email, password })
    localStorage.setItem('ap_users', JSON.stringify(users))
    user.value = { name, email }
    localStorage.setItem('ap_user', JSON.stringify(user.value))
  }

  function logout() {
    user.value = null
    localStorage.removeItem('ap_user')
  }

  return { user, isLoggedIn, login, register, logout }
})
