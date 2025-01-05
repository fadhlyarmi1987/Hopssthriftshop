<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi</title>

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
            background-color: rgba(214, 214, 214, 0.64);
            border-color: rgba(214, 214, 214, 0.64);
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

        /* Styling untuk format harga Rupiah */
        .price {
            font-weight: bold;
        }

        /* Styling untuk tombol kembali */
        .btn-back {
            background-color: rgb(228, 228, 228);
            border-color: rgb(228, 228, 228);
        }

        .btn-back:hover {
            background-color: rgb(134, 134, 134);
            border-color: rgb(134, 134, 134);
        }

        /* Styling untuk gambar produk */
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

        /* Margin tambahan untuk elemen */
        .mt-4 {
            margin-top: 2rem;
        }

        .checkmark-wrapper svg {
            animation: checkmark-draw 1s ease-out forwards;
        }

        @keyframes checkmark-draw {
            0% {
                stroke-dasharray: 0, 100;
                stroke-dashoffset: 100;
            }

            100% {
                stroke-dasharray: 100, 0;
                stroke-dashoffset: 0;
            }
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <div class="card p-4">
            <h1 class="text-center mb-4">Detail Transaksi</h1>
            <div class="d-flex justify-content-end position-relative">
                <a href="{{ route('products.index') }}" class="btn btn-back btn-sm position-absolute" style="top: 0; right: 0;">
                    Kembali ke Daftar Produk
                </a>
            </div>
            <!-- Tabel Pesanan dengan status 'waiting' -->
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
                            <th>Aksi</th>
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
                            <td class="d-flex justify-content-start align-items-center">
                                <!-- Tombol Proses -->
                                @if($order->status == 'waiting')
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#confirmProcessModal{{ $order->id }}">Proses</button>
                                <!-- Tombol Cancel -->
                                @endif
                                <button class="btn btn-danger btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#confirmCancelModal{{ $order->id }}">Batalkan</button>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Proses -->
    @foreach ($orders as $order)
    <div class="modal fade" id="confirmProcessModal{{ $order->id }}" tabindex="-1" aria-labelledby="confirmProcessModalLabel{{ $order->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmProcessModalLabel{{ $order->id }}">Konfirmasi Proses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin memproses pesanan <strong>{{ $order->product->name }}</strong> <span>dari</span> <strong>{{ $order->name }}</strong>?
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('orders.process', $order->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-info">Proses</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Batalkan -->
    <div class="modal fade" id="confirmCancelModal{{ $order->id }}" tabindex="-1" aria-labelledby="confirmCancelModalLabel{{ $order->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmCancelModalLabel{{ $order->id }}">Konfirmasi Batalkan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin membatalkan pesanan <strong>{{ $order->product->name }}</strong> <span>dari</span> <strong>{{ $order->name }}</strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Batalkan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Modal Berhasil Proses -->
    <div class="modal fade" id="seksesproses" tabindex="-1" aria-labelledby="seksesproses" aria-hidden="true">
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
                        <h5 class="modal-title" id="seksesproses">Pesanan Berhasil Diproses</h5>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Link ke CDN JS untuk Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

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

    @if(session('successproses'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tampilkan modal ketika halaman dimuat
            var successModal = new bootstrap.Modal(document.getElementById('seksesproses'));
            successModal.show();
        });
    </script>
    @endif

</body>

</html>