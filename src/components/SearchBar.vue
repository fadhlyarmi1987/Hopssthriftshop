<template>
  <div class="search-container text-center mt-5">
    <form @submit.prevent="$emit('search', query)">
      <input v-model="query" type="text" class="form-control search-input" placeholder="Cari produk..." />
      <button type="submit" class="btn btn-primary mt-1">Cari</button>
    </form>
    <p v-if="!hasResults">Tidak ada produk yang ditemukan.</p>
  </div>
</template>

<script>
export default {
  props: ['hasResults'],
  data() {
    return {
      query: '',
    };
  },
};
</script>
