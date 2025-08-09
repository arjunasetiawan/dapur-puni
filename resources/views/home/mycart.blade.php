<!DOCTYPE html>
<html>
<head>
  @include('home.css')
  <style type="text/css">
    .div_deg {
      display: flex;
      justify-content: center;
      align-items: flex-start;
      gap: 40px;
      margin: 60px;
      flex-wrap: wrap;
    }

    table {
      flex: 1;
      min-width: 300px;
      border: 2px solid black;
      text-align: center;
      width: 100%;
    }

    th {
      border: 2px solid black;
      text-align: center;
      color: white;
      font: 20px;
      font-weight: bold;
      background-color: black;
    }

    td {
      border: 1px solid black;
    }

    .cart_value {
      text-align: center;
      margin-bottom: 70px;
      padding: 18px;
    }

    .order_deg {
      flex: 1;
      min-width: 300px;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }

    label {
      display: inline-block;
      width: 150px;
    }

    .div_gap {
      padding: 20px;
    }
  </style>
</head>

<body>
  <div class="hero_area">
    @include('home.header')
  </div>

  <div class="div_deg">
    <div class="order_deg">
      <form id="order-form">
        @csrf

        <div class="div_gap">
          <label>Name</label>
          <input type="text" name="name" id="name" required value="{{ Auth::user()->name }}">
        </div>

        <div class="div_gap">
          <label>Address</label>
          <textarea name="address" id="address" required>{{ Auth::user()->address }}</textarea>
        </div>

        <div class="div_gap">
          <label>Phone</label>
          <input type="text" name="phone" id="phone" required value="{{ Auth::user()->phone }}">
        </div>

        <div class="div_gap">
          <button type="submit" formaction="{{ url('confirm_order') }}" formmethod="POST" class="btn btn-primary">Cash On Delivered</button>
          <button type="button" class="btn btn-success" id="pay-button">Payment</button>
        </div>
      </form>
    </div>

    <table>
      <tr>
        <th>Product Title</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Image</th>
        <th>Remove</th>
      </tr>

      <?php $value = 0; ?>

      @foreach($cart as $cartItem)
      <tr>
        <td>{{ $cartItem->product->title }}</td>
        <td>Rp{{ number_format($cartItem->product->price, 0, ',', '.') }}</td>
        <td>{{ $cartItem->quantity }}</td>
        <td>
          <img width="150px" src="/products/{{ $cartItem->product->image }}">
        </td>
        <td>
          <a class="btn btn-danger" href="{{ url('delete_cart', $cartItem->id) }}">Remove</a>
        </td>
      </tr>

      <?php $value += $cartItem->product->price * $cartItem->quantity; ?>
      @endforeach
    </table>
  </div>

  <div class="cart_value">
    <h3>Total Value of Cart is: Rp. {{ number_format($value, 0, ',', '.') }}</h3>
  </div>

  <div style="padding: 20px; display: flex; gap: 10px; margin-left:30px;">
    <a href="{{ url('/') }}" class="btn btn-secondary">&larr; Back</a>
  </div>

  @include('home.footer')

  <!-- MIDTRANS SCRIPT -->
  <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

  <script>
    document.getElementById('pay-button').addEventListener('click', function () {
      const name = document.getElementById('name').value;
      const address = document.getElementById('address').value;
      const phone = document.getElementById('phone').value;
      const total = "{{ (int)$value }}";

      fetch("{{ url('/pay') }}", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": "{{ csrf_token() }}",
        },
        body: JSON.stringify({
          name: name,
          address: address,
          phone: phone,
          total: total
        })
      })
      .then(response => response.json())
      .then(data => {
        snap.pay(data.token, {
          onSuccess: function (result) {
            // Kirim data ke backend setelah pembayaran sukses
            fetch("{{ url('/payment/success') }}", {
              method: "POST",
              headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
              },
              body: JSON.stringify({
                name: name,
                address: address,
                phone: phone
              })
            }).then(() => {
              window.location.href = "/payment/success";
            });
          },
          onPending: function (result) {
            alert("Pembayaran menunggu konfirmasi.");
          },
          onError: function (result) {
            alert("Pembayaran gagal.");
          },
          onClose: function () {
            alert("Kamu menutup popup tanpa menyelesaikan pembayaran.");
          }
        });
      });
    });
  </script>
</body>
</html>
