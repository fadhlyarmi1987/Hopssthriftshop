<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('CSS/dashboard.css') }}">
</head>

<body>

    <div class="container-fluid">
        <!-- Sidebar -->
        <div class="container-fluid">
            <!-- Sidebar -->
            <div class="sidebar d-flex flex-column">
                <h3>Kategori Baju</h3>
                <a href="{{ url('/dashboard') }}" class="{{ Request::is('dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ url('/kaos') }}" class="{{ Request::is('kaos') ? 'active' : '' }}">Kaos</a>
                <a href="{{ url('/kemeja') }}" class="{{ Request::is('kemeja') ? 'active' : '' }}">Kemeja</a>
                <a href="{{ url('/jaket') }}" class="{{ Request::is('jaket') ? 'active' : '' }}">Jaket</a>

                <div class="mt-auto">
                    @auth
                    <!-- Tombol Logout hanya tampil jika pengguna sudah login -->
                    <a href="{{ url('/logout') }}" class="btn btn-danger btn-sm mt-3">Logout</a>
                    @endauth

                    @guest
                    <!-- Jika pengguna belum login, tampilkan tombol untuk login -->
                    <a href="{{ route('login') }}" class="btn btn-primary btn-sm mt-3">Login</a>
                    @endguest
                </div>
            </div>
        </div>

        <!-- Konten Utama -->
        <div class="content">
            <h2 class="text-center text-utama">Kemeja</h2>

            <!-- Tombol Tambah Produk -->
            @auth
            <div class="d-flex justify-content-end mb-3">
                <button class="btn btn-sm tombol-tambah-produk" data-bs-toggle="modal" data-bs-target="#productModal">
                    Tambah Produk
                </button>
                <!-- Tombol Detail Transaksi -->
                <a href="{{ route('transaksi') }}" class="btn btn-sm tombol-detail-transaksi ms-2">
                    Detail Transaksi
                </a>
                <!-- Tombol Riwayat Transaksi -->
                <a href="{{ route('riwayat.transaksi') }}" class="btn btn-sm tombol-riwayat-transaksi ms-2">
                    Riwayat Transaksi
                </a>
            </div>
            @endauth

            <!-- Kartu Produk -->
            <div class="row">
                @foreach ($kemeja as $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text"><strong>Kategori:</strong> {{ $product->category }}</p>
                            <p class="card-text"><strong>Ukuran Tersedia:</strong> {{ $product->size }}</p>
                            <p class="card-text"><strong>Harga:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <p class="card-text">{{ $product->description }}</p>

                            <div class="button-container mt-auto justify-content-center">
                                @auth
                                <button class="btn-edit-produk btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editProductModal{{ $product->id }}">Edit</button>
                                <button class="btn-hapus-produk btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteProductModal{{ $product->id }}">
                                    Hapus
                                </button>
                                @else
                                <!-- Tombol Order Sekarang untuk pengguna yang belum login -->
                                <button class="btn-order-sekarang btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#orderModal{{ $product->id }}">Order Sekarang</button>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        @foreach ($kemeja as $product)
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
                    <!-- Modal Konfirmasi Hapus Produk -->
                    <div class="modal-footer">
                        <button type="button" class="btn-batal-modal" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-hapus-modal">Hapus</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        @endforeach

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
                            <button type="submit" class="btn-simpan">Kirim Order</button>
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




        <!-- Modal Edit Produk -->
        @foreach ($kemeja as $product)
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
                                <label for="size" class="form-label">Size</label>
                                <input type="text" class="form-control" id="size" name="size" value="{{ $product->size }}" required>
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

                            <button type="submit" class="btn-simpan">Simpan Perubahan</button>
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
                                <label for="size" class="form-label">Ukuran</label>
                                <input type="text" class="form-control" placeholder="contoh: S, M, L ,dst" id="size" name="size" required>
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

                            <button type="submit" class="btn-simpan">Tambah Produk</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>