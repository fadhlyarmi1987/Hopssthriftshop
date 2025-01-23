<template>
  <div class="container-fluid">
    <Sidebar
      :isAuthenticated="isAuthenticated"
      :currentRoute="currentRoute"
      @navigate="navigate"
      @logout="logout"
      @login="login"
    />
    <div class="content">
      <h2 class="text-center text-utama">Selamat datang di Toko Baju Kami</h2>
      <SearchBar :hasResults="products.length > 0" @search="searchProducts" />
      <div class="d-flex justify-content-end mb-3" v-if="isAuthenticated">
        <button class="btn btn-sm tombol-tambah-produk" @click="showAddProductModal = true">Tambah Produk</button>
        <button class="btn btn-sm tombol-detail-transaksi ms-2" @click="showDetailTransaksi()">Detail Transaksi</button>
        <button class="btn btn-sm tombol-riwayat-transaksi ms-2" @click="showRiwayatTransaksi()">Riwayat Transaksi</button>
      </div>
      <div class="row">
        <ProductCard
          v-for="product in products"
          :key="product.id"
          :product="product"
          :isAuthenticated="isAuthenticated"
          @edit="editProduct"
          @delete="deleteProduct"
          @order="orderProduct"
        />
      </div>
      <AddProductModal v-if="showAddProductModal" @close="showAddProductModal = false" />
    </div>
  </div>
</template>

<script>
import Sidebar from '../components/Sidebar.vue';
import SearchBar from '../components/SearchBar.vue';
import ProductCard from '../components/ProductCard.vue';
import AddProductModal from '../components/AddProductModal.vue';

export default {
  data() {
    return {
      isAuthenticated: true,
      currentRoute: 'dashboard',
      products: [],
      showAddProductModal: false,
    };
  },
  methods: {
    navigate(route) {
      this.currentRoute = route;
    },
    logout() {
      console.log('Logout');
    },
    login() {
      console.log('Login');
    },
    searchProducts(query) {
      console.log('Search query:', query);
    },
    editProduct(product) {
      console.log('Edit product:', product);
    },
    deleteProduct(product) {
      console.log('Delete product:', product);
    },
    orderProduct(product) {
      console.log('Order product:', product);
    },
    showDetailTransaksi() {
      console.log('Show detail transaksi');
    },
    showRiwayatTransaksi() {
      console.log('Show riwayat transaksi');
    },
  },
};
</script>
