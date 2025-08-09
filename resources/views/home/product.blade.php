<!DOCTYPE html>
<html lang="en">
<head>
  @include('home.css')
  <title>Shop - Dapur Puni</title>
  <style>
    .product-card {
      background-color: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 0 15px rgba(0,0,0,0.05);
      padding: 15px;
      transition: 0.3s ease;
    }

    .product-card:hover {
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .product-image img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 10px;
    }

    .product-title {
      font-size: 16px;
      font-weight: bold;
      margin: 10px 0 5px;
    }

    .product-price {
      color: #888;
      font-size: 14px;
      margin-bottom: 10px;
    }

    .quantity-controls {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px;
      margin-bottom: 10px;
    }

    .qty-btn {
      background-color: #eee;
      border: none;
      width: 32px;
      height: 32px;
      font-size: 18px;
      cursor: pointer;
      border-radius: 5px;
    }

    .qty-input {
      width: 50px;
      text-align: center;
      border: 1px solid #ccc;
      border-radius: 5px;
      height: 32px;
    }

    .d-flex {
      display: flex;
    }

    .justify-content-between {
      justify-content: space-between;
    }

    .gap-2 {
      gap: 10px;
    }

    .btn {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .sidebar a {
      display: block;
      color: #000;
      padding: 5px 0;
      text-decoration: none;
    }

    .sidebar a:hover {
      text-decoration: underline;
    }

    .sidebar {
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 15px;
    }
  </style>
</head>

<body>

  <!-- Header -->
 

  <section class="shop_section layout_padding">
    <div class="container">
      <div class="row">
        <!-- Sidebar Kategori -->
        <div class="col-md-3">
          <div class="sidebar">
            <h5>Kategori</h5>
            <a href="{{ url('/shop') }}">Semua Produk</a>
            @foreach($categories as $category)
              <a href="{{ url('/shop?category=' . $category->id) }}">
                {{ $category->category_name }}
              </a>
            @endforeach
            <hr>
            <p>Keranjang: {{ $count }} item</p>
          </div>
        </div>

        <!-- Produk -->
        <div class="col-md-9">
          <!-- <div class="heading_container heading_center mb-4">
            <h2>Coba Menu Pilihan Kami</h2>
          </div> -->

          <div class="row">
            @forelse($product as $products)
            <div class="col-sm-6 col-md-4 col-lg-4 mb-4">
              <div class="product-card">
                <div class="product-image">
                  <img src="{{ asset('products/' . $products->image) }}" alt="{{ $products->title }}">
                </div>
                <div class="product-info text-center">
                  <h6 class="product-title">{{ $products->title }}</h6>
                  <p class="product-price">Rp{{ number_format($products->price, 0, ',', '.') }}</p>

                  <form action="{{ url('add_cart', $products->id) }}" method="POST">
                    @csrf
                    <div class="quantity-controls">
                      <button type="button" class="qty-btn minus">-</button>
                      <input type="number" name="quantity" value="1" min="1" class="qty-input">
                      <button type="button" class="qty-btn plus">+</button>
                    </div>

                    <div class="d-flex justify-content-between gap-2">
                      <a href="{{ url('product_details', $products->id) }}" class="btn btn-outline-info btn-sm px-2 py-1">
                        Details
                      </a>
                      <button type="submit" class="btn btn-danger btn-sm">
                        Tambah ke keranjang
                      </button>
                    </div>
                  </form>

                </div>
              </div>
            </div>
            @empty
              <div class="col-12 text-center">
                <p>Produk tidak ditemukan untuk kategori ini.</p>
              </div>
            @endforelse
          </div>
        </div>
      </div>

      <div class="mt-4">
        <a href="{{ url('/') }}" class="btn btn-secondary">&larr; Kembali ke Beranda</a>
      </div>
    </div>
  </section>

  <!-- Footer -->
  

  <!-- JS untuk + / - qty -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('.product-card').forEach(card => {
        const minus = card.querySelector('.qty-btn.minus');
        const plus = card.querySelector('.qty-btn.plus');
        const input = card.querySelector('.qty-input');

        minus?.addEventListener('click', () => {
          let val = parseInt(input.value);
          if (val > 1) input.value = val - 1;
        });

        plus?.addEventListener('click', () => {
          let val = parseInt(input.value);
          input.value = val + 1;
        });
      });
    });
  </script>
</body>
</html>
