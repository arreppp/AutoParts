<template>
  <div>
    <div class="page-banner"><div class="container"><h1>REGISTER</h1></div></div>
    <div class="auth-page container">
      <div class="auth-card">
        <div class="auth-header">
          <h2>CREATE YOUR ACCOUNT</h2>
          <p>Join thousands of Malaysian car owners on AutoParts MY.</p>
        </div>
        <form @submit.prevent="handleRegister" class="auth-form">
          <div class="field">
            <label>FULL NAME</label>
            <input v-model="name" type="text" placeholder="Ahmad bin Abdullah" required />
          </div>
          <div class="field">
            <label>EMAIL ADDRESS</label>
            <input v-model="email" type="email" placeholder="you@example.com" required />
          </div>
          <div class="field">
            <label>PASSWORD</label>
            <input v-model="password" type="password" placeholder="Min. 6 characters" required minlength="6" />
          </div>
          <div class="field">
            <label>CONFIRM PASSWORD</label>
            <input v-model="confirm" type="password" placeholder="Repeat your password" required />
          </div>
          <div v-if="error" class="error-msg">⚠ {{ error }}</div>
          <button type="submit" class="btn-primary submit-btn" :disabled="loading">
            {{ loading ? 'CREATING ACCOUNT...' : 'CREATE ACCOUNT →' }}
          </button>
        </form>
        <div class="auth-footer">Already have an account? <router-link to="/login">Sign in →</router-link></div>
      </div>
      <div class="auth-side">
        <div class="side-icon">🏎️</div>
        <h3>WHY JOIN AUTOPARTS MY?</h3>
        <ul>
          <li>✓ Access 25,000+ parts instantly</li>
          <li>✓ OEM-verified fitment guarantee</li>
          <li>✓ Track all your orders in one place</li>
          <li>✓ Exclusive member discounts</li>
          <li>✓ Priority customer support</li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'
const auth = useAuthStore(); const router = useRouter()
const name = ref(''); const email = ref(''); const password = ref(''); const confirm = ref(''); const error = ref(''); const loading = ref(false)
async function handleRegister() {
  error.value = ''
  if (password.value !== confirm.value) { error.value = 'Passwords do not match.'; return }
  if (password.value.length < 6) { error.value = 'Password must be at least 6 characters.'; return }
  loading.value = true
  try { auth.register(name.value, email.value, password.value); router.push('/') }
  catch (e) { error.value = e.message }
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
.submit-btn { width: 100%; justify-content: center; padding: 13px; }
.submit-btn:disabled { opacity: 0.5; cursor: not-allowed; }
.auth-footer { text-align: center; font-size: 0.87rem; color: var(--text-muted); }
.auth-footer a { color: var(--red); font-weight: 700; }
.auth-side { background: linear-gradient(135deg, var(--navy) 0%, #2a3560 100%); border-radius: var(--radius-lg); padding: 40px; color: #fff; display: flex; flex-direction: column; justify-content: center; }
.side-icon { font-size: 4rem; margin-bottom: 20px; }
.auth-side h3 { font-family: 'Barlow', sans-serif; font-weight: 900; font-size: 1.1rem; margin-bottom: 20px; }
.auth-side ul { list-style: none; display: flex; flex-direction: column; gap: 12px; }
.auth-side li { font-size: 0.9rem; color: #aab4cc; }
@media(max-width:768px) { .auth-page { grid-template-columns:1fr; } .auth-side { display:none; } }
</style>
