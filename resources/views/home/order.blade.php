<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @include('home.css')

  <style>
    .div_center {
      margin: 40px auto;
      width: 90%;
      max-width: 1000px;
    }

    table {
      border: 1px solid #ccc;
      text-align: center;
      width: 100%;
    }

    th {
      background: #f5f5f5;
      font-weight: bold;
    }

    th, td {
      padding: 10px;
      border: 1px solid #ccc;
    }

    .cart_value {
      text-align: center;
      margin-bottom: 50px;
    }

    .nav-tabs {
      display: flex;
      gap: 15px;
      margin: 20px 0;
      padding-left: 0;
      border-bottom: 2px solid #ddd;
    }

    .nav-tabs a {
      padding: 10px 15px;
      text-decoration: none;
      border: 1px solid #ddd;
      border-bottom: none;
      background: #f9f9f9;
      color: #333;
      border-radius: 5px 5px 0 0;
    }

    .nav-tabs a.active {
      background: #f53d2d;
      color: white;
      border-color: #f53d2d #f53d2d white;
    }

    /* FIX: Navbar & Modal */
    .navbar {
      z-index: 1000 !important;
      position: relative;
    }

    .modal {
      z-index: 2000 !important;
    }

    .modal-backdrop {
      z-index: 1999 !important;
    }

    body.modal-open {
      overflow: hidden;
    }

    .modal-dialog {
      margin-top: 100px !important;
    }
  </style>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function toggleOtherReason(selectElement, orderId) {
      const input = document.getElementById('other_reason_' + orderId);
      if (selectElement.value === 'Lainnya') {
        input.style.display = 'block';
        input.setAttribute('required', true);
      } else {
        input.style.display = 'none';
        input.removeAttribute('required');
      }
    }
  </script>
</head>
<body>
<div>
  @include('home.header')

  <div class="div_center">
    <div class="nav-tabs">
      <a href="{{ url('/myorders?type=all') }}" class="{{ request('type') == 'all' || !request('type') ? 'active' : '' }}">Semua</a>
      <a href="{{ url('/myorders?type=in progress') }}" class="{{ request('type') == 'in progress' ? 'active' : '' }}">Diproses</a>
      <a href="{{ url('/myorders?type=on the way') }}" class="{{ request('type') == 'on the way' ? 'active' : '' }}">Dikirim</a>
      <a href="{{ url('/myorders?type=delivered') }}" class="{{ request('type') == 'delivered' ? 'active' : '' }}">Selesai</a>
      <a href="{{ url('/myorders?type=canceled') }}" class="{{ request('type') == 'canceled' ? 'active' : '' }}">Dibatalkan</a>
    </div>

    @if($order->isEmpty())
      <p class="text-center text-muted mt-4">Belum ada pesanan pada kategori ini.</p>
    @else
      <table>
        <tr>
          <th>Product Name</th>
          <th>Price</th>
          <th>Delivery Status</th>
          <th>Image</th>
          <th>Cancel</th>
        </tr>

        @php $value = 0; @endphp

        @foreach($order as $item)
          <tr>
            <td>{{ $item->product->title }}</td>
            <td>Rp.{{ number_format($item->product->price, 0, ',', '.') }}</td>
            <td>
              @php
                $badgeClass = match(strtolower($item->status)) {
                  'on the way' => 'bg-info',
                  'delivered' => 'bg-success',
                  'in progress' => 'bg-warning text-dark',
                  'canceled' => 'bg-danger',
                  default => 'bg-secondary',
                };
              @endphp
              <span class="badge {{ $badgeClass }}">{{ ucfirst($item->status) }}</span>
            </td>
            <td>
              <img height="100" src="{{ asset('products/' . $item->product->image) }}">
            </td>
            <td>
              @if(strtolower($item->payment_status) !== 'cancel' && !in_array(strtolower($item->status), ['delivered', 'canceled']))
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#cancelModal-{{ $item->id }}">
                  Cancel
                </button>

                <!-- Modal -->
                <div class="modal fade" id="cancelModal-{{ $item->id }}" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <form method="POST" action="{{ route('user.order.cancel', $item->id) }}">
                      @csrf
                      @method('PUT')
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Pilih Alasan Pembatalan</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <div class="mb-3">
                            <label for="cancel_reason_{{ $item->id }}" class="form-label">Alasan pembatalan:</label>
                            <select class="form-control" name="cancel_reason" id="cancel_reason_{{ $item->id }}" onchange="toggleOtherReason(this, '{{ $item->id }}')" required>
                              <option value="" disabled selected>-- Pilih alasan --</option>
                              <option value="Salah pilih produk">Salah pilih produk</option>
                              <option value="Menemukan harga lebih murah">Menemukan harga lebih murah</option>
                              <option value="Ingin mengubah pesanan">Ingin mengubah pesanan</option>
                              <option value="Alasan pribadi">Alasan pribadi</option>
                              <option value="Lainnya">Lainnya</option>
                            </select>
                          </div>
                          <div class="mb-3" id="other_reason_{{ $item->id }}" style="display:none;">
                            <label class="form-label">Masukkan alasan lainnya:</label>
                            <input type="text" class="form-control" name="other_reason">
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                          <button type="submit" class="btn btn-danger">Kirim Pembatalan</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              @else
                <span class="text-muted">-</span>
              @endif
            </td>
          </tr>
          @php
            $value += (int) str_replace('.', '', $item->product->price);
          @endphp
        @endforeach
      </table>

      <div class="cart_value mt-4">
        <h3>Total Pesanan: Rp. {{ number_format($value, 0, ',', '.') }}</h3>
      </div>
    @endif

    <div style="padding: 20px; display: flex; gap: 10px; margin-left: 10px;">
      <a href="{{ url('/') }}" class="btn btn-secondary">&larr; Kembali</a>
    </div>
  </div>

  @include('home.footer')
</div>
</body>
</html>
