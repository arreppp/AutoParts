<template>
  <div class="navbar-wrapper">
    <!-- Top bar -->
    <div class="topbar">
      <div class="container topbar-inner">
        <span class="topbar-text">📞 +60 3-XXXX XXXX &nbsp;|&nbsp; ✉ info@autopartsmy.com</span>
        <div class="topbar-right">
          <template v-if="auth.isLoggedIn">
            <span>👤 {{ auth.user.name }}</span>
            <span class="sep">|</span>
            <a href="#" @click.prevent="auth.logout(); $router.push('/')">Logout</a>
          </template>
          <template v-else>
            <router-link to="/login">Login</router-link>
            <span class="sep">|</span>
            <router-link to="/register">Register</router-link>
          </template>
        </div>
      </div>
    </div>

    <!-- Main nav -->
    <nav class="mainnav">
      <div class="container mainnav-inner">
        <router-link to="/" class="logo">
          <span class="logo-gear">⚙</span>
          <div class="logo-text">
            <span class="logo-main">AutoParts</span>
            <span class="logo-sub">MY</span>
          </div>
        </router-link>

        <div class="search-wrap">
          <input class="nav-search" placeholder="Search by part name, brand, OEM number..." v-model="searchQ" @keyup.enter="doSearch" />
          <button class="search-btn" @click="doSearch">SEARCH</button>
        </div>

        <router-link to="/cart" class="cart-wrap">
          <div class="cart-icon-wrap">
            <span class="cart-icon">🛒</span>
            <span v-if="cart.count > 0" class="badge">{{ cart.count }}</span>
          </div>
          <div class="cart-info">
            <span class="cart-label">My Cart</span>
            <span class="cart-total">RM {{ cart.total.toFixed(2) }}</span>
          </div>
        </router-link>
      </div>
    </nav>

    <!-- Nav menu -->
    <div class="navmenu">
      <div class="container navmenu-inner">
        <router-link to="/">HOME</router-link>
        <router-link to="/catalog">PARTS CATALOG</router-link>
        <router-link to="/catalog">SHOP</router-link>
        <router-link to="/orders" v-if="auth.isLoggedIn">MY ORDERS</router-link>
        <a href="#">FIND A WORKSHOP</a>
        <a href="#">ABOUT US</a>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useCartStore } from '../stores/cart'
import { useAuthStore } from '../stores/auth'
const cart = useCartStore()
const auth = useAuthStore()
const router = useRouter()
const searchQ = ref('')
function doSearch() { if (searchQ.value.trim()) { router.push('/catalog') } }
</script>

<style scoped>
.navbar-wrapper { position: sticky; top: 0; z-index: 100; box-shadow: 0 2px 8px rgba(0,0,0,0.12); }
.topbar { background: var(--navy); color: #ccc; font-size: 0.78rem; padding: 6px 0; }
.topbar-inner { display: flex; justify-content: space-between; align-items: center; }
.topbar-right { display: flex; align-items: center; gap: 8px; }
.topbar-right a { color: #ccc; transition: color 0.2s; }
.topbar-right a:hover { color: #fff; }
.sep { color: #555; }

.mainnav { background: var(--white); padding: 14px 0; border-bottom: 1px solid var(--border); }
.mainnav-inner { display: flex; align-items: center; gap: 24px; }
.logo { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
.logo-gear { font-size: 2rem; color: var(--red); }
.logo-text { display: flex; flex-direction: column; line-height: 1; }
.logo-main { font-family: 'Barlow', sans-serif; font-weight: 900; font-size: 1.3rem; color: var(--navy); text-transform: uppercase; }
.logo-sub { font-family: 'Barlow', sans-serif; font-weight: 700; font-size: 0.75rem; color: var(--red); letter-spacing: 0.2em; }
.search-wrap { flex: 1; display: flex; border: 2px solid var(--red); border-radius: var(--radius); overflow: hidden; }
.nav-search { flex: 1; padding: 10px 16px; border: none; background: #fff; color: var(--text); font-size: 0.9rem; }
.nav-search::placeholder { color: #aaa; }
.search-btn { background: var(--red); color: #fff; font-weight: 700; font-family: 'Barlow', sans-serif; padding: 0 22px; font-size: 0.85rem; letter-spacing: 0.06em; border: none; cursor: pointer; transition: background 0.2s; }
.search-btn:hover { background: var(--red-dark); }
.cart-wrap { display: flex; align-items: center; gap: 10px; color: var(--text); flex-shrink: 0; }
.cart-icon-wrap { position: relative; }
.cart-icon { font-size: 1.8rem; }
.cart-info { display: flex; flex-direction: column; line-height: 1.3; }
.cart-label { font-size: 0.75rem; color: var(--text-muted); }
.cart-total { font-weight: 700; font-family: 'Barlow', sans-serif; font-size: 0.95rem; color: var(--red); }

.navmenu { background: var(--red); }
.navmenu-inner { display: flex; gap: 0; }
.navmenu-inner a { color: #fff; font-weight: 700; font-family: 'Barlow', sans-serif; font-size: 0.82rem; letter-spacing: 0.06em; padding: 12px 18px; display: block; transition: background 0.2s; }
.navmenu-inner a:hover, .navmenu-inner a.router-link-active { background: rgba(0,0,0,0.2); }
</style>
