<header class="header_section">
  <style>
    .custom_nav-container {
      display: flex;
      flex-direction: column;
      background-color: white;
      border-bottom: 1px solid #ddd;
      padding: 0;
    }

    .custom_nav-container > .top-bar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 30px;
      width: 100%;
      gap: 30px;
      flex-wrap: wrap;
    }

    .navbar-brand {
      display: flex;
      align-items: center;
    }

    .search-bar {
      flex: 1;
      display: flex;
      justify-content: center;
    }

    .search-bar input {
      width: 100%;
      max-width: 600px;
      padding: 10px 15px;
      border: 1px solid #ccc;
      border-radius: 25px;
      background-color: #e0e0e0;
      font-size: 16px;
    }

    .user_option {
      display: flex !important;
      align-items: center !important;
      justify-content: flex-end;
      gap: 15px !important;
    }

    .cart-wrapper {
      position: relative;
    }

    .cart-icon {
      position: relative;
      cursor: pointer;
      color: #000;
      text-decoration: none;
    }

    .mini-cart {
      position: absolute;
      top: 100%;
      right: 0;
      width: 320px;
      background: white;
      border: 1px solid #ddd;
      border-radius: 6px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
      padding: 15px;
      z-index: 999;
      display: none;
    }

    .cart-wrapper:hover .mini-cart {
      display: block;
    }

    .mini-cart-item {
      display: flex;
      gap: 10px;
      margin-bottom: 10px;
    }

    .mini-cart-item img {
      width: 55px;
      height: 55px;
      border-radius: 4px;
      object-fit: cover;
    }

    .mini-cart-info {
      display: flex;
      flex-direction: column;
    }

    .product-name {
      font-size: 14px;
      font-weight: 600;
      margin: 0;
      color: #333;
    }

    .price {
      font-size: 14px;
      color: #ff5722;
    }

    .btn-view-cart {
      display: block;
      background-color: #ff5722;
      color: white;
      text-align: center;
      padding: 10px;
      border-radius: 4px;
      font-weight: 600;
      text-decoration: none;
      transition: background-color 0.3s;
    }

    .btn-view-cart:hover {
      background-color: #e64a19;
    }

    .collapse.navbar-collapse {
      display: flex !important;
      justify-content: center;
      align-items: center !important;
      width: 100% !important;
      border-top: 1px solid #eee;
      padding: 10px 0;
    }

    .navbar-nav {
      display: flex !important;
      gap: 30px;
      margin: 0;
    }

    .nav-link {
      color: #000;
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .user_option a {
      color: #000;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 5px;
      font-weight: 500;
    }

    @media (max-width: 768px) {
      .custom_nav-container > .top-bar {
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
      }

      .search-bar {
        padding: 0;
      }

      .collapse.navbar-collapse {
        flex-direction: column;
      }
    }
  </style>

  <nav class="navbar navbar-expand-lg custom_nav-container">
    <div class="top-bar">
      <!-- LOGO -->
      <a class="navbar-brand d-flex align-items-center" href="{{url('dashboard')}}">
        <img src="/images/Dapurpunii.png" alt="Logo" style="height: 80px; margin-right: 10px;">
      </a>

      <!-- SEARCH -->
      <div class="search-bar">
        <input type="text" placeholder="Search..." />
      </div>

      <!-- USER & CART -->
      <div class="user_option">
        @if (Route::has('login'))
          @auth
            <div class="cart-wrapper">
              <a href="{{ url('mycart') }}" class="cart-icon {{ request()->is('mycart') ? 'nav-active' : '' }}">
                <i class="fa fa-shopping-bag" aria-hidden="true"></i> {{$count}}
              </a>

              <div class="mini-cart">
                <p><strong>Baru Ditambahkan</strong></p>
                @if($cartItems->count() > 0)
                  @foreach($cartItems as $item)
                    <div class="mini-cart-item d-flex mb-2" style="gap: 10px;">
                      <img src="{{ asset('products/' . $item->product->image) }}" alt="{{ $item->product->title }}"
                        style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                      <div class="mini-cart-info">
                        <p class="product-name mb-1" style="font-size: 14px; font-weight: 500;">
                          {{ $item->product->title }}
                          @if($item->product->variant)
                            • {{ $item->product->variant }}
                          @endif
                        </p>
                        <span class="price" style="font-size: 13px; color: #f35;">
                          Rp{{ number_format($item->product->price, 0, ',', '.') }}
                        </span>
                      </div>
                    </div>
                    <br>
                  @endforeach
                  <div class="mini-cart-summary text-center mt-2" style="font-size: 15px; font-weight: 600;">
                    <span>Total:</span> Rp{{ number_format($totalValue, 0, ',', '.') }}
                  </div>
                @else
                  <p class="text-muted">Keranjang masih kosong.</p>
                @endif
                <a href="{{ url('mycart') }}" class="btn-view-cart">Check Out</a>
              </div>
            </div>

            <div class="dropdown">
              <a href="#" class="dropdown-toggle d-flex align-items-center" id="navbarDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('images/default-user.png') }}"
                  class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;" alt="User Photo">
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ url('myorders') }}">My Orders</a>
                <a class="dropdown-item" href="{{ route('profile.edit') }}">Akun Saya</a>
                <a class="dropdown-item" href="{{ route('logout') }}"
                  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  Log Out
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                </form>
              </div>
            </div>
          @else
            <a href="{{('/login')}}"><i class="fa fa-user" aria-hidden="true"></i> Login</a>
            <a href="{{('/register')}}"><i class="fa fa-vcard" aria-hidden="true"></i> Register</a>
          @endauth
        @endif
      </div>
    </div>

    <!-- MENU -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav">
        <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
          <a class="nav-link" href="{{url('/')}}">Home</a>
        </li>
        <li class="nav-item {{ request()->is('shop') ? 'active' : '' }}">
          <a class="nav-link" href="{{url('/shop')}}">Shop</a>
        </li>
        <li class="nav-item {{ request()->is('testimonial') ? 'active' : '' }}">
          <a class="nav-link" href="{{url('/testimonial')}}">Testimonial</a>
        </li>
        <li class="nav-item {{ request()->is('testimonial') ? 'active' : '' }}">
          <a class="nav-link" href="{{url('/aboutus')}}">About Us</a>
        </li>
      </ul>
    </div>
  </nav>
</header>
