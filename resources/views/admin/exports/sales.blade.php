<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Nomor Telepon</th>
            <th>Produk</th>
            <th>Harga</th>
            <th>Status</th>
            <th>Status Pembayaran</th>
            <th>Tanggal Order</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
        <tr>
            <td>{{ $order->name }}</td>
            <td>{{ $order->rec_address }}</td>
            <td>{{ $order->phone }}</td>
            <td>{{ $order->product->title }}</td>
            <td>{{ number_format($order->product->price, 0, ',', '.') }}</td>
            <td>{{ ucfirst($order->status) }}</td>
            <td>{{ ucfirst($order->payment_status) }}</td>
            <td>{{ $order->created_at->format('d-m-Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
ssss