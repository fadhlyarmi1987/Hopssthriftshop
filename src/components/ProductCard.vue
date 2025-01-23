<template>
  <div class="col-md-4 mb-4">
    <div class="card h-100">
      <img :src="`/storage/${product.image}`" class="card-img-top" :alt="product.name" />
      <div class="card-body d-flex flex-column">
        <h5 class="card-title">{{ product.name }}</h5>
        <p class="card-text"><strong>Kategori:</strong> {{ product.category }}</p>
        <p class="card-text"><strong>Ukuran Tersedia:</strong> {{ product.size }}</p>
        <p class="card-text"><strong>Harga:</strong> Rp {{ formatPrice(product.price) }}</p>
        <p class="card-text">{{ product.description }}</p>
        <div class="mt-auto">
          <button v-if="isAuthenticated" class="btn btn-warning btn-sm" @click="$emit('edit', product)">Edit</button>
          <button v-if="isAuthenticated" class="btn btn-danger btn-sm" @click="$emit('delete', product)">Hapus</button>
          <button v-else class="btn btn-success btn-sm" @click="$emit('order', product)">Order Sekarang</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['product', 'isAuthenticated'],
  methods: {
    formatPrice(price) {
      return new Intl.NumberFormat('id-ID').format(price);
    },
  },
};
</script>
