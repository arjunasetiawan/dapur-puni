<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      font-family: DejaVu Sans;
      font-size: 12px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      border: 1px solid black;
      padding: 8px;
      text-align: center;
    }

    th {
      background-color: #f2f2f2;
    }

    img {
      width: 80px;
      height: auto;
    }
  </style>
</head>
<body>

  <h2 style="text-align: center;">All Orders</h2>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Customer Name</th>
        <th>Address</th>
        <th>Phone</th>
        <th>Product Title</th>
        <th>Price</th>
        <th>Image</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach($orders as $index => $order)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $order->name }}</td>
          <td>{{ $order->rec_address }}</td>
          <td>{{ $order->phone }}</td>
          <td>{{ $order->product->title ?? '-' }}</td>
          <td>{{ $order->product->price ?? '-' }}</td>
          <td>
            @if($order->product && $order->product->image)
              <img src="{{ public_path('products/' . $order->product->image) }}" alt="product">
            @else
              No Image
            @endif
          </td>
          <td>{{ ucfirst($order->status) }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

</body>
</html>
