<!-- ======== Statistik Section ======== -->
<section class="no-padding-top no-padding-bottom">
  <div class="container-fluid">
    <div class="row">
      <!-- Total Clients -->
      <div class="col-md-3 col-sm-6">
        <div class="statistic-block block">
          <div class="progress-details d-flex align-items-end justify-content-between">
            <div class="title"><div class="icon"><i class="icon-user-1"></i></div><strong>Total Clients</strong></div>
            <div class="number dashtext-1">{{ $user }}</div>
          </div>
          <div class="progress progress-template"><div role="progressbar" style="width: 30%" class="progress-bar progress-bar-template dashbg-1"></div></div>
        </div>
      </div>

      <!-- Total Products -->
      <div class="col-md-3 col-sm-6">
        <div class="statistic-block block">
          <div class="progress-details d-flex align-items-end justify-content-between">
            <div class="title"><div class="icon"><i class="icon-contract"></i></div><strong>Total Products</strong></div>
            <div class="number dashtext-2">{{ $product }}</div>
          </div>
          <div class="progress progress-template"><div role="progressbar" style="width: 70%" class="progress-bar progress-bar-template dashbg-2"></div></div>
        </div>
      </div>

      <!-- Total Order -->
      <div class="col-md-3 col-sm-6">
        <div class="statistic-block block">
          <div class="progress-details d-flex align-items-end justify-content-between">
            <div class="title"><div class="icon"><i class="icon-paper-and-pencil"></i></div><strong>Total Order</strong></div>
            <div class="number dashtext-3">{{ $order }}</div>
          </div>
          <div class="progress progress-template"><div role="progressbar" style="width: 55%" class="progress-bar progress-bar-template dashbg-3"></div></div>
        </div>
      </div>

      <!-- Total Delivered -->
      <div class="col-md-3 col-sm-6">
        <div class="statistic-block block">
          <div class="progress-details d-flex align-items-end justify-content-between">
            <div class="title"><div class="icon"><i class="icon-writing-whiteboard"></i></div><strong>Total Delivered</strong></div>
            <div class="number dashtext-4">{{ $delivered }}</div>
          </div>
          <div class="progress progress-template"><div role="progressbar" style="width: 35%" class="progress-bar progress-bar-template dashbg-4"></div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Tombol Aksi -->
<div class="d-flex flex-wrap justify-content-end align-items-center gap-2 me-4 mt-3">
  <button class="btn btn-sm btn-outline-primary" onclick="toggleView('chart')">Tampilkan Chart</button>
  <button class="btn btn-sm btn-outline-success" onclick="toggleView('history')">Tampilkan Histori Order</button>
  <button class="btn btn-sm btn-outline-warning text-yellow" onclick="toggleView('profit')">Hitung Keuntungan</button>
</div>

<!-- Form Keuntungan (Hidden by default) -->
<section id="profitSection" style="display: none;">
  <div class="container-fluid mt-3">
    <form action="{{ route('admin.calculateProfit') }}" method="POST" class="d-flex flex-wrap align-items-center gap-2">
      @csrf
      <input type="number" name="total_income" class="form-control form-control-sm" placeholder="Pendapatan (Rp)" required>
      <input type="number" name="total_expense" class="form-control form-control-sm" placeholder="Pengeluaran (Rp)" required>
      <button type="submit" class="btn btn-sm btn-warning text-dark">Hitung</button>
    </form>

    @if(session('profit'))
    <div class="alert alert-info mt-3">
      <strong>Keuntungan Bersih:</strong> Rp {{ number_format(session('profit'), 0, ',', '.') }}
    </div>
    @endif
  </div>
</section>

<!-- Chart Section -->
<section class="mt-4" id="chartSection">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Order per Bulan ({{ date('Y') }})</h4>
        <canvas id="orderChart" height="100"></canvas>
        <hr class="my-4">
        <h5>Unduh Laporan Penjualan</h5>
        <form action="{{ url('/admin/export-sales') }}" method="GET" class="row g-3 align-items-end">
          <div class="col-md-3">
            <label for="range" class="form-label">Pilih Range:</label>
            <select name="range" id="range" class="form-control" required>
              <option value="harian">Harian</option>
              <option value="mingguan">Mingguan</option>
              <option value="bulanan">Bulanan</option>
            </select>
          </div>
          <div class="col-md-3">
            <label for="tanggal_mulai" class="form-label">Tanggal Mulai:</label>
            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" required>
          </div>
          <div class="col-md-3">
            <label for="tanggal_selesai" class="form-label">Tanggal Selesai:</label>
            <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" required>
          </div>
          <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">Download Data</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- Histori Order Section -->
<section id="historySection" class="table_center" style="display: none;">
  <div class="container-fluid">
    <h4 class="card-title mt-4 mb-4" style="font-size: 24px; font-weight: bold; color: white;">Histori Orderan</h4>
    <div class="table-responsive-custom">
      <table class="table table-bordered table-striped text-white">
        <thead>
          <tr>
            <th>Customer Name</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Product Title</th>
            <th>Price</th>
            <th>Image</th>
            <th>Status</th>
            <th>Status Pembayaran</th>
          </tr>
        </thead>
        <tbody>
          @foreach($data as $order)
          <tr>
            <td>{{ $order->name }}</td>
            <td>{{ $order->rec_address }}</td>
            <td>{{ $order->phone }}</td>
            <td>{{ $order->product->title }}</td>
            <td>Rp.{{ number_format($order->product->price, 0, ',', '.') }}</td>
            <td><img width="150" src="/products/{{ $order->product->image }}"></td>
            <td><span class="badge {{ match(strtolower($order->status)) {
              'on the way' => 'bg-info',
              'delivered' => 'bg-success',
              'in progress' => 'bg-warning text-dark',
              'canceled' => 'bg-danger',
              default => 'bg-secondary'
            } }}">{{ ucfirst($order->status) }}</span></td>
            <td><span class="badge {{ match(strtolower($order->payment_status)) {
              'cash on delivery' => 'bg-info',
              'pembayaran berhasil' => 'bg-success',
              'cancel' => 'bg-danger',
              default => 'bg-secondary'
            } }}">{{ ucfirst($order->payment_status) }}</span></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="div_deg mt-3">{{ $data->appends(['view' => 'history'])->onEachSide(1)->links() }}</div>
  </div>
</section>

<!-- Footer -->
<footer class="footer">
  <div class="footer__block block no-margin-bottom">
    <div class="container-fluid text-center">
      <p class="no-margin-bottom">2018 &copy; Your company. Download From 
        <a target="_blank" href="https://templateshub.net">Templates Hub</a>.
      </p>
    </div>
  </div>
</footer>

<!-- Chart.js and Toggle Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  function toggleView(view) {
    const chart = document.getElementById('chartSection');
    const history = document.getElementById('historySection');
    const profit = document.getElementById('profitSection');
    chart.style.display = 'none';
    history.style.display = 'none';
    profit.style.display = 'none';
    if (view === 'chart') chart.style.display = 'block';
    else if (view === 'history') history.style.display = 'block';
    else if (view === 'profit') profit.style.display = 'block';
  }
  const ctx = document.getElementById('orderChart').getContext('2d');
  const monthLabels = ['January', 'February', 'March', 'April', 'May', 'June',
                      'July', 'August', 'September', 'October', 'November', 'December'];
  const orderData = JSON.parse(`{!! json_encode($monthlyOrders) !!}`);
  const dataA = orderData.productA;
  const dataB = orderData.productB;
  const dataC = orderData.productC;
  const currentMonthIndex = parseInt('{{ $startMonthIndex ?? 5 }}');
  function rotateArray(arr, index) {
    return arr.slice(index).concat(arr.slice(0, index));
  }
  const rotatedLabels = rotateArray(monthLabels, currentMonthIndex);
  const rotatedDataA = rotateArray(dataA, currentMonthIndex);
  const rotatedDataB = rotateArray(dataB, currentMonthIndex);
  const rotatedDataC = rotateArray(dataC, currentMonthIndex);
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: rotatedLabels,
      datasets: [
        {
          label: 'Total Order',
          data: rotatedDataA,
          borderColor: 'rgba(54, 162, 235, 1)',
          backgroundColor: 'rgba(54, 162, 235, 0.2)',
          fill: true,
          tension: 0.4
        },
        {
          label: 'Delivered',
          data: rotatedDataB,
          borderColor: 'rgb(3, 192, 60)',
          backgroundColor: 'rgba(3, 207, 37, 0.2)',
          fill: true,
          tension: 0.4
        },
        {
          label: 'Total Cancel',
          data: rotatedDataC,
          borderColor: 'rgb(235, 54, 54)',
          backgroundColor: 'rgba(235, 54, 54, 0.2)',
          fill: true,
          tension: 0.4
        }
      ]
    },
    options: {
      responsive: true,
      plugins: {
        title: {
          display: true,
          text: 'Tren Penjualan Produk per Bulan'
        }
      }
    }
  });
</script>
<style>
  /* Tambahan untuk border table */
  .table-responsive-custom table {
    width: 100%;
    border-collapse: collapse;
    color: white;
  }

  .table-responsive-custom th,
  .table-responsive-custom td {
    border: 1px solid #dee2e6;
    padding: 0.75rem;
    text-align: left;
    vertical-align: middle;
  }

  .table-responsive-custom th {
    background-color: #343a40;
  }

  .table-responsive-custom img {
    max-width: 100px;
    height: auto;
  }
</style>
