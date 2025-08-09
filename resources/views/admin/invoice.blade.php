<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Resi Pengiriman - Dapur Puni</title>
  <style>
    body { font-family: sans-serif; color: #333; }
    .header { text-align: center; margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 8px; border: 1px solid #ccc; }
    .section-title { font-weight: bold; margin-top: 20px; }
    .product-img {
      display: block;
      margin: 10px auto;
      max-width: 300px;
      height: auto;
    }
  </style>
</head>
<body>
  <div class="header">
    <h2>Resi Pengiriman</h2>
    <p><strong>Dapur Puni</strong> | www.dapurpuni.com</p>
    <p>Jl. Harapan 2 Rt004/Rw 010 | 0822-6813-6904</p>
    <hr>
  </div>

  <p><strong>Nomor Resi:</strong> DPN-{{ $data->id }}</p>
  <p><strong>Tanggal Pengiriman:</strong> {{ date('d-m-Y') }}</p>

  <p class="section-title">Informasi Penerima</p>
  <table>
    <tr><td>Nama</td><td>{{ $data->name }}</td></tr>
    <tr><td>Alamat</td><td>{{ $data->rec_address }}</td></tr>
    <tr><td>No. Telepon</td><td>{{ $data->phone }}</td></tr>
  </table>

  <p class="section-title">Detail Produk</p>
  <table>
    <thead>
      <tr>
        <th>Nama Produk</th>
        <th>Harga</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>{{ $data->product->title }}</td>
        <td>Rp{{ number_format($data->product->price, 0, ',', '.') }}</td>
        <td>{{ ucfirst($data->status) }}</td>
      </tr>
    </tbody>
  </table>
  
  <p class="section-title">Info Pengiriman</p>
  <p>Kurir: JNE Reguler</p>
  <p>Estimasi Tiba: 2–4 Hari Kerja</p>

  <br><br>
  <p>Terima kasih telah berbelanja di <strong>Dapur Puni</strong>.</p>
</body>
</html>
