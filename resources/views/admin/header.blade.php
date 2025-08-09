<header class="header"> 
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">  

  <nav class="navbar navbar-expand-lg">
    <!-- Search Panel -->
    <div class="search-panel">
      <div class="search-inner d-flex align-items-center justify-content-center">
        <div class="close-btn">Close <i class="fa fa-close"></i></div>
        <form id="searchForm" action="#">
          <div class="form-group">
            <input type="search" name="search" placeholder="What are you searching for...">
            <button type="submit" class="submit">Search</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Header Menu -->
    <div class="container-fluid d-flex align-items-center justify-content-between">
      
      <!-- Logo + Sidebar Toggle -->
      <div class="navbar-header">
        <a href="{{ route('dashboard') }}" class="navbar-brand">
          <div class="brand-text brand-big visible text-uppercase">
            <strong class="text-primary"></strong><strong>Admin</strong>
          </div>
          <div class="brand-text brand-sm">
            <strong class="text-primary">D</strong><strong>A</strong>
          </div>
        </a>
        <!-- Sidebar Toggle Btn -->
        <button class="sidebar-toggle"><i class="fa fa-long-arrow-left"></i></button>
      </div>

      <!-- Notifikasi -->
      <div class="dropdown">
        <a href="#" id="resetNotification" class="dropdown-toggle" data-toggle="dropdown">
          <i class="fa fa-bell"></i>
          @php
              $totalNotif = ($notifCanceled ?? 0) + ($notifAccepted ?? 0);
          @endphp
          @if($totalNotif > 0)
              <span class="badge badge-danger" id="notifCount">{{ $totalNotif }}</span>
          @endif
        </a>
        <div class="dropdown-menu">
          <!-- <a class="dropdown-item" href="#">
            {{ $notifCanceled ?? 0 }} pesanan dibatalkan
          </a> -->
          <a class="dropdown-item" href="#">
            {{ $notifAccepted ?? 0 }} pesanan diterima
          </a>
        </div>
      </div>

      <!-- Logout -->
      <div class="list-inline-item logout">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="bg-black text-red px-4 py-2 rounded shadow hover:bg-gray-800 transition duration-300 cursor-pointer">
            Logout
          </button>
        </form>
      </div>

    </div>
  </nav>

  <!-- Script AJAX Reset Notifikasi -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $('#resetNotification').on('click', function () {
      $.ajax({
        url: "{{ route('reset.notifikasi') }}",
        method: "GET",
        success: function () {
          $('#notifCount').text('0');
        }
      });
    });
  </script>
</header>
