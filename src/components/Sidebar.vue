<template>
  <div class="sidebar d-flex flex-column">
    <h3>Kategori Baju</h3>
    <a href="#dashboard" :class="{ active: currentRoute === 'dashboard' }" @click="navigate('dashboard')">Dashboard</a>
    <a href="#kaos" :class="{ active: currentRoute === 'kaos' }" @click="navigate('kaos')">Kaos</a>
    <a href="#kemeja" :class="{ active: currentRoute === 'kemeja' }" @click="navigate('kemeja')">Kemeja</a>
    <a href="#jaket" :class="{ active: currentRoute === 'jaket' }" @click="navigate('jaket')">Jaket</a>
    <div class="mt-auto">
      <button v-if="isAuthenticated" class="btn btn-secondary btn-sm mt-3" @click="$emit('laporan-penghasilan')">Laporan Penghasilan</button>
      <button v-if="isAuthenticated" class="btn btn-danger btn-sm mt-3" @click="logout">Logout</button>
      <button v-else class="btn btn-primary btn-sm mt-3" @click="$emit('login')">Login</button>
    </div>
  </div>
</template>

<script>
export default {
  props: ['isAuthenticated', 'currentRoute'],
  methods: {
    navigate(route) {
      this.$emit('navigate', route);
    },
    logout() {
      this.$emit('logout');
    },
  },
};
</script>

<style>
/* Tambahkan gaya CSS sesuai kebutuhan */
</style>
