<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi</title>

    <!-- Link ke CDN Bootstrap untuk styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-image: url('../assets/IMAGE/bgdashboard.jpg');
            background-size: cover;
            background-position: center;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: rgba(255, 255, 255, 0.5);
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            border-radius: 5px;
            vertical-align: middle;
        }

        .btn-info {
            background-color: rgb(104, 243, 45);
            border-color: rgb(104, 243, 45);
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-info:hover,
        .btn-danger:hover {
            background-color: #138496;
            border-color: #117a8b;
        }

        .badge {
            padding: 0.5rem 1rem;
            font-size: 1rem;
            text-align: center;
            border-radius: 0.375rem;
        }

        .badge-warning {
            background-color: #ffc107;
        }

        .price {
            font-weight: bold;
        }

        .btn-back {
            background-color: rgb(228, 228, 228);
            border-color: rgb(228, 228, 228);
        }

        .btn-back:hover {
            background-color: rgb(134, 134, 134);
            border-color: rgb(134, 134, 134);
        }

        .img-thumbnail {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }

        .table {
            border-radius: 10px;
            border-left: none;
            border-right: none;
            border-top: 1px solid #ddd;
            overflow: hidden;
        }

        .table th,
        .table td {
            height: 120px;
            border-left: none;
            border-right: none;
            vertical-align: middle;
        }

        .d-flex {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .mt-4 {
            margin-top: 2rem;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <div class="card p-4">
            <h1 class="text-center mb-4">Riwayat Transaksi</h1>
            <div class="d-flex justify-content-end position-relative">
                <a href="{{ route('products.index') }}" class="btn btn-back btn-sm position-absolute" style="top: 0; right: 0;">
                    Kembali ke Dashboard
                </a>
            </div>
            <!-- Tabel Pesanan -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Phone</th>
                            <th>Gambar</th>
                            <th>Harga</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->name }}</td>
                            <td>{{ $order->address }}</td>
                            <td>{{ $order->product->name }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>{{ $order->phone }}</td>
                            <td>
                                @if ($order->image)
                                <img src="{{ asset('storage/' . $order->image) }}" alt="Image" class="img-thumbnail">
                                @else
                                No image
                                @endif
                            </td>
                            <td class="price">{{ $order->total_price }}</td> <!-- Menambahkan kelas price -->
                            <td>
                                <span class="badge bg-warning">{{ $order->status }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Link ke CDN JS untuk Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script untuk memformat harga ke format Rupiah -->
    <script>
        // Fungsi untuk format ke Rupiah
        function formatRupiah(angka) {
            let reverse = angka.toString().split('').reverse().join(''),
                ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');
            return 'Rp ' + ribuan;
        }

        // Menambahkan format Rupiah ke elemen yang memiliki kelas "price"
        document.querySelectorAll('.price').forEach(function(element) {
            let price = element.textContent;
            element.textContent = formatRupiah(price);
        });
    </script>

</body>

</html>
