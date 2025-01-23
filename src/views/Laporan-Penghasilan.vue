<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penghasilan</title>
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
        }

        .badge {
            padding: 0.5rem 1rem;
            font-size: 1rem;
            text-align: center;
            border-radius: 0.375rem;
            background-color: rgb(17, 206, 0);
        }

        .total-row {
            font-weight: bold;
            font-size: 1.2rem;
        }
    </style>
</head>

<body>
    <div id="app">
        <div class="container mt-5">
            <div class="card p-4">
                <h1 class="text-center mb-4">Laporan Penghasilan</h1>
                <div class="d-flex justify-content-end position-relative">
                    <a href="/dashboard" class="btn btn-back btn-sm position-absolute" style="top: 0; right: 0;">
                        Kembali ke Dashboard
                    </a>
                </div>
                <!-- Tabel Penghasilan -->
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>Alamat</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Total Harga</th>
                                <th>Tanggal Pemesanan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(order, index) in orders" :key="order.id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ order.name }}</td>
                                <td>{{ order.address }}</td>
                                <td>{{ order.quantity }}</td>
                                <td>Rp {{ formatCurrency(order.price) }}</td>
                                <td>Rp {{ formatCurrency(order.total_price) }}</td>
                                <td>{{ formatDate(order.created_at) }}</td>
                                <td>
                                    <span class="badge">{{ order.status }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Baris Total Penghasilan -->
                <div class="row mt-4">
                    <div class="col-12 text-end">
                        <span class="total-row">Total Penghasilan: Rp {{ formatCurrency(totalPenghasilan) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vue.js dan Axios -->
    <script src="https://unpkg.com/vue@3"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        const app = Vue.createApp({
            data() {
                return {
                    orders: [], // Data pesanan
                    totalPenghasilan: 0, // Total penghasilan
                };
            },
            methods: {
                // Ambil data dari API
                async fetchOrders() {
                    try {
                        const response = await axios.get("/api/orders");
                        this.orders = response.data.orders;
                        this.totalPenghasilan = response.data.totalPenghasilan;
                    } catch (error) {
                        console.error("Error fetching data:", error);
                    }
                },
                // Format angka menjadi format rupiah
                formatCurrency(value) {
                    return new Intl.NumberFormat("id-ID", {
                        style: "currency",
                        currency: "IDR",
                    }).format(value);
                },
                // Format tanggal
                formatDate(dateString) {
                    const options = { day: "2-digit", month: "2-digit", year: "numeric", hour: "2-digit", minute: "2-digit" };
                    return new Date(dateString).toLocaleDateString("id-ID", options);
                },
            },
            mounted() {
                this.fetchOrders(); // Ambil data saat komponen dimuat
            },
        });

        app.mount("#app");
    </script>
</body>

</html>
