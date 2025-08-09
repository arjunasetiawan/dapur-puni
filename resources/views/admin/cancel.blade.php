<!DOCTYPE html>
<html>
<head> 
  @include('admin.css')
  <style>
    table {
      border: 2px solid white;
      text-align: center;
      width: 100%;
    }

    th {
      background-color: white;
      padding: 10px;
      font-size: 18px;
      font-weight: bold;
      color: black;
    }

    td {
      color: white;
      padding: 10px;
      border: 1px solid white;
    }

    .table_center {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 20px;
    }

    .div_deg {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 40px;
    }

    .search-form {
      display: flex;
      justify-content: center;
      margin: 30px 0;
    }

    input[type='search'] {
      width: 500px;
      height: 50px;
      margin-left: 10px;
    }

    .btn {
      border-radius: 20px;
      padding: 8px 16px;
      font-size: 14px;
    }

    .btn-secondary {
      background-color: #6c757d;
      border: none;
      color: white;
    }

    .badge {
      padding: 5px 10px;
      border-radius: 10px;
      font-size: 13px;
    }

    .bg-danger {
      background-color: #dc3545;
    }
  </style>
</head>

<body>
  @include('admin.header')
  @include('admin.sidebar')

  <div class="page-content">
    <div class="page-header">
      <div class="container-fluid">   

        <div style="padding: 20px;">
          <a href="{{ url()->previous() }}" class="btn btn-secondary">&larr; Back</a>
        </div>

        <div class="search-form">
          <form action="{{ url('order_search') }}" method="get">
            @csrf
            <input type="search" name="search" placeholder="Cari order...">
            <input type="submit" class="btn btn-secondary" value="Search">
          </form>
        </div>

        <div class="table_center">
          <table>
            <tr>
              <th>Customer Name</th>
              <th>Address</th>
              <th>Phone</th>
              <th>Product Title</th>
              <th>Price</th>
              <th>Image</th>
              <th>Status</th>
              <th>Cancel Reason</th>
            </tr>

            @foreach($data as $order)
              @if(strtolower($order->status) === 'canceled')
              <tr>
                <td>{{ $order->name }}</td>
                <td>{{ $order->rec_address }}</td>
                <td>{{ $order->phone }}</td>
                <td>{{ $order->product->title }}</td>
                <td>Rp.{{ number_format($order->product->price, 0, ',', '.') }}</td>
                <td>
                  <img width="150" src="/products/{{ $order->product->image }}">
                </td>
                <td><span class="badge bg-danger">Canceled</span></td>
                <td>{{ $order->cancel_reason ?? '-' }}</td>
              </tr>
              @endif
            @endforeach
          </table>
        </div>

        <div class="div_deg">
          {{ $data->onEachSide(1)->links() }}
        </div>

      </div>
    </div>
  </div>

  @include('admin.js')
</body>
</html>
