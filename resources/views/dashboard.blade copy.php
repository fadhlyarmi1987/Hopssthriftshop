<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="{{ asset('CSS/dashboard.css') }}">
</head>

<body>

    <div class="container-fluid">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column">
            <h3>Kategori Baju</h3>
            <a href="{{ url('/dashboard') }}">Dashboard</a>
            <a href="{{ url('/kaos') }}">Kaos</a>
            <a href="{{ url('/kemeja') }}">Kemeja</a>
            <a href="{{ url('/jaket') }}">Jaket</a>

            <div class="mt-auto">

                @auth
                <!-- Tombol Laporan Penghasilan -->
                <a href="{{ url('/laporan-penghasilan') }}" class="btn btn-secondary btn-sm mt-3">Laporan Penghasilan</a>

                <!-- Tombol Logout hanya tampil jika pengguna sudah login -->
                <a href="{{ url('/logout') }}" class="btn btn-danger btn-sm mt-3">Logout</a>

                @endauth

                @guest
                <!-- Jika pengguna belum login, tampilkan link untuk login -->
                <a href="{{ route('login') }}" class="btn btn-primary btn-sm mt-3">Login</a>

                @endguest
            </div>
        </div>
    </div>



    <!-- Konten Utama -->
    <div class="content">
        <h2 class="text-center mb-4">Produk</h2>

        <!-- Tombol Tambah Produk -->
        @auth
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-sm btn-add" data-bs-toggle="modal" data-bs-target="#productModal">
                Tambah Produk
            </button>
            <!-- Tombol Detail Transaksi -->
            <a href="{{ route('transaksi') }}" class="btn btn-info btn-sm ms-2">
                Detail Transaksi
            </a>
            <!-- Tombol Riwayat Transaksi -->
            <a href="{{ route('riwayat.transaksi') }}" class="btn btn-secondary btn-sm ms-2">
                Riwayat Transaksi
            </a>
        </div>
        @endauth





        <!-- Kartu Produk -->
        <div class="row">
            @foreach ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text"><strong>Kategori:</strong> {{ $product->category }}</p>
                        <p class="card-text"><strong>Harga:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="card-text">{{ $product->description }}</p>

                        @auth
                        <!-- Tombol Edit Produk -->
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editProductModal{{ $product->id }}">Edit</button>

                        <!-- Tombol Hapus Produk -->
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteProductModal{{ $product->id }}">
                            Hapus
                        </button>

                        <!-- Modal Konfirmasi Hapus Produk -->
                        <div class="modal fade" id="deleteProductModal{{ $product->id }}" tabindex="-1" aria-labelledby="deleteProductModalLabel{{ $product->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteProductModalLabel{{ $product->id }}">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menghapus produk <strong>{{ $product->name }}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <!-- Tombol Order Sekarang untuk pengguna yang belum login -->
                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#orderModal{{ $product->id }}">Order Sekarang</button>
                        @endauth
                    </div>
                </div>
            </div>
            @endforeach
        </div>
s

        <!-- Modal Order Sekarang -->
        <div class="modal fade" id="orderModal{{ $product->id }}" tabindex="-1" aria-labelledby="orderModalLabel{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderModalLabel{{ $product->id }}">Order Produk: {{ $product->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('orders.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="address" name="address" required>
                            </div>
                            <div class="mb-3">
                                <label for="size" class="form-label">Ukuran</label>
                                <input type="text" class="form-control" id="size" name="size" required>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" id="quantity{{ $product->id }}" name="quantity" value="1" required min="1">
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="mb-3">
                                <label for="notes" class="form-label">Catatan</label>
                                <textarea class="form-control" id="notes" name="notes"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Harga (per item)</label>
                                <input type="text" class="form-control" id="price{{ $product->id }}" value="{{ number_format($product->price, 0, ',', '.') }}" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="total_price" class="form-label">Total Harga</label>
                                <input type="text" class="form-control" id="total_price{{ $product->id }}" name="total_price" value="{{ number_format($product->price, 0, ',', '.') }}" disabled>
                            </div>
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="product_image" value="{{ $product->image }}">
                            <input type="hidden" name="price" id="hidden_price{{ $product->id }}" value="{{ $product->price }}">
                            <input type="hidden" name="total_price" id="hidden_total_price{{ $product->id }}" value="{{ $product->price }}">
                            <button type="submit" class="btn btn-primary">Kirim Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Fungsi untuk format angka ke format Rupiah
            function formatRupiah(number) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(number).replace('Rp', '').trim();
            }

            // Kalkulasi harga total ketika jumlah diubah
            document.getElementById('quantity{{ $product->id }}').addEventListener('input', function() {
                var quantity = parseInt(this.value);
                var price = parseFloat(document.getElementById('price{{ $product->id }}').value.replace(/\./g, '').replace(',', '.'));
                var totalPrice = quantity * price;

                // Format harga dalam Rupiah
                document.getElementById('total_price{{ $product->id }}').value = formatRupiah(totalPrice);
                document.getElementById('hidden_total_price{{ $product->id }}').value = totalPrice;
            });
        </script>
        @endforeach




        <!-- Modal Edit Produk -->
        @foreach ($products as $product)
        <div class="modal fade" id="editProductModal{{ $product->id }}" tabindex="-1" aria-labelledby="editProductModalLabel{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductModalLabel{{ $product->id }}">Edit Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">Kategori</label>
                                <input type="text" class="form-control" id="category" name="category" value="{{ $product->category }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Harga</label>
                                <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}" step="0.01" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="description" name="description">{{ $product->description }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Gambar Produk</label>
                                <input type="file" class="form-control" id="image" name="image">
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Modal untuk Tambah Produk -->
        <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productModalLabel">Tambah Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">Kategori</label>
                                <input type="text" class="form-control" id="category" name="category" required>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Harga</label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="description" name="description"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Gambar Produk</label>
                                <input type="file" class="form-control" id="image" name="image">
                            </div>

                            <button type="submit" class="btn btn-primary">Tambah Produk</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Order Berhasil -->
    <div class="modal fade" id="orderSuccessModal" tabindex="-1" aria-labelledby="orderSuccessModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-body">
                    <div class="d-flex justify-content-center align-items-center flex-column">
                        <!-- Ikon Centang Hijau -->
                        <div class="checkmark-wrapper mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="none" viewBox="0 0 24 24" stroke="green">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <!-- Pesan Berhasil -->
                        <h5 class="modal-title" id="orderSuccessModalLabel">Pesanan Berhasil Dibuat!</h5>
                        <p>Terima kasih telah memesan. Kami akan segera memproses pesanan Anda, mohon periksa WhatsApp anda</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Update Berhasil -->
    <div class="modal fade" id="updatesuccessModal" tabindex="-1" aria-labelledby="orderSuccessModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-body">
                    <div class="d-flex justify-content-center align-items-center flex-column">
                        <!-- Ikon Centang Hijau -->
                        <div class="checkmark-wrapper mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="none" viewBox="0 0 24 24" stroke="green">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <!-- Pesan Berhasil -->
                        <h5 class="modal-title" id="orderSuccessModalLabel">Barang Berhasil Terupdate</h5>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Produk Berhasil -->
    <div class="modal fade" id="uploadsuccessModal" tabindex="-1" aria-labelledby="orderSuccessModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-body">
                    <div class="d-flex justify-content-center align-items-center flex-column">
                        <!-- Ikon Centang Hijau -->
                        <div class="checkmark-wrapper mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="none" viewBox="0 0 24 24" stroke="green">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <!-- Pesan Berhasil -->
                        <h5 class="modal-title" id="orderSuccessModalLabel">Barang Berhasil Ditambahkan</h5>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Untuk Pilihan Hapus -->
    <div class="modal fade" id="deleteProductModal{{ $product->id }}" tabindex="-1" aria-labelledby="deleteProductLabel{{ $product->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteProductLabel{{ $product->id }}">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus produk <strong>{{ $product->name }}</strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @if(session('successorder'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tampilkan modal ketika halaman dimuat
            var successModal = new bootstrap.Modal(document.getElementById('orderSuccessModal'));
            successModal.show();
        });
    </script>
    @endif

    @if(session('successupdate'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tampilkan modal ketika halaman dimuat
            var successModal = new bootstrap.Modal(document.getElementById('updatesuccessModal'));
            successModal.show();
        });
    </script>
    @endif

    @if(session('successadd'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tampilkan modal ketika halaman dimuat
            var successModal = new bootstrap.Modal(document.getElementById('uploadsuccessModal'));
            successModal.show();
        });
    </script>
    @endif

</body>



</html>