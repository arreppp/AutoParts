<template>
  <div>
    <div class="page-banner"><div class="container"><h1>LOGIN</h1></div></div>
    <div class="auth-page container">
      <div class="auth-card">
        <div class="auth-header">
          <h2>SIGN IN TO YOUR ACCOUNT</h2>
          <p>Access your orders, saved parts and more.</p>
        </div>
        <form @submit.prevent="handleLogin" class="auth-form">
          <div class="field">
            <label>EMAIL ADDRESS</label>
            <input v-model="email" type="email" placeholder="you@example.com" required />
          </div>
          <div class="field">
            <label>PASSWORD</label>
            <input v-model="password" type="password" placeholder="••••••••" required />
          </div>
          <div v-if="error" class="error-msg">⚠ {{ error }}</div>
          <button type="submit" class="btn-primary submit-btn" :disabled="loading">
            {{ loading ? 'SIGNING IN...' : 'SIGN IN →' }}
          </button>
        </form>
        <div class="auth-footer">
          Don't have an account? <router-link to="/register">Register here →</router-link>
        </div>
        <div class="demo-box">💡 <strong>Demo:</strong> Register an account first, then log in with those credentials.</div>
      </div>
      <div class="auth-side">
        <div class="side-content">
          <div class="side-icon">🔧</div>
          <h3>MALAYSIA'S TRUSTED<br>AUTO PARTS PLATFORM</h3>
          <ul>
            <li>✓ 25,000+ genuine parts</li>
            <li>✓ OEM-guaranteed fitment</li>
            <li>✓ Fast nationwide delivery</li>
            <li>✓ 14-day easy returns</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useAuthStore } from '../stores/auth'
const auth = useAuthStore(); const router = useRouter(); const route = useRoute()
const email = ref(''); const password = ref(''); const error = ref(''); const loading = ref(false)
async function handleLogin() {
  error.value = ''; loading.value = true
  try { await auth.login(email.value, password.value); router.push(route.query.redirect || '/') }
  catch (e) { error.value = e.response?.data?.errors?.email?.[0] ?? e.response?.data?.message ?? e.message }
  finally { loading.value = false }
}
</script>

<style scoped>
.page-banner { background: linear-gradient(to right, var(--navy), #2a3560); color: #fff; padding: 32px 0; }
.page-banner h1 { font-family: 'Barlow', sans-serif; font-weight: 900; font-size: 1.8rem; }
.auth-page { padding: 48px 20px 80px; display: grid; grid-template-columns: 1fr 1fr; gap: 48px; max-width: 900px; }
.auth-card { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 36px; }
.auth-header { margin-bottom: 28px; padding-bottom: 20px; border-bottom: 2px solid var(--red); }
.auth-header h2 { font-family: 'Barlow', sans-serif; font-weight: 900; font-size: 1.1rem; color: var(--navy); }
.auth-header p { color: var(--text-muted); font-size: 0.87rem; margin-top: 4px; }
.auth-form { display: flex; flex-direction: column; gap: 16px; margin-bottom: 20px; }
.field { display: flex; flex-direction: column; gap: 6px; }
.field label { font-size: 0.73rem; font-weight: 800; font-family: 'Barlow', sans-serif; color: var(--text-muted); letter-spacing: 0.08em; }
.field input { background: var(--bg); border: 1px solid var(--border); color: var(--text); padding: 11px 14px; border-radius: var(--radius); font-size: 0.9rem; transition: border-color 0.2s; }
.field input:focus { border-color: var(--red); background: #fff; }
.error-msg { background: #fff0f0; border: 1px solid #ffcdd2; color: var(--red); padding: 10px 14px; border-radius: var(--radius); font-size: 0.85rem; }
.submit-btn { width: 100%; justify-content: center; padding: 13px; font-size: 0.9rem; }
.submit-btn:disabled { opacity: 0.5; cursor: not-allowed; }
.auth-footer { text-align: center; font-size: 0.87rem; color: var(--text-muted); }
.auth-footer a { color: var(--red); font-weight: 700; }
.demo-box { margin-top: 16px; background: #f8f9fa; border: 1px solid var(--border); border-radius: var(--radius); padding: 12px; font-size: 0.8rem; color: var(--text-muted); text-align: center; }
.auth-side { background: linear-gradient(135deg, var(--navy) 0%, #2a3560 100%); border-radius: var(--radius-lg); padding: 40px; color: #fff; display: flex; align-items: center; }
.side-icon { font-size: 4rem; margin-bottom: 20px; }
.side-content h3 { font-family: 'Barlow', sans-serif; font-weight: 900; font-size: 1.2rem; margin-bottom: 20px; line-height: 1.3; }
.side-content ul { list-style: none; display: flex; flex-direction: column; gap: 10px; }
.side-content li { font-size: 0.9rem; color: #aab4cc; }
@media(max-width:768px) { .auth-page { grid-template-columns:1fr; } .auth-side { display:none; } }
</style>
