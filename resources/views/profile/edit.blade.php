<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profil</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  @include('home.css') <!-- Jika kamu ada tambahan custom CSS -->
</head>

<body>
  <div class="hero_area">
    @include('home.header')
  </div>

  <div class="container mt-5 mb-5">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="card shadow rounded">
          <div class="card-body">
            <h3 class="card-title mb-4 text-center">Edit Profil</h3>

            @if(session('success'))
              <div class="alert alert-success">
                {{ session('success') }}
              </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')

              <!-- Nama -->
              <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" name="name" value="{{ old('name', Auth::user()->name) }}" required>
              </div>

              <!-- Email -->
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="{{ old('email', Auth::user()->email) }}" required>
              </div>

              <!-- Foto Profil -->
              <div class="mb-3">
                <label for="profile_photo" class="form-label">Foto Profil</label>
                <input type="file" class="form-control" name="profile_photo">
                @if(Auth::user()->profile_photo)
                  <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" width="100" class="img-thumbnail mt-2">
                @endif
              </div>

              <div class="d-grid">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
              </div>
            </form>
          </div>
        </div>
        <div class="text-center mt-3">
          <a href="{{ url('/dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
        </div>
      </div>
    </div>
  </div>

  @include('home.footer')

  <!-- Bootstrap JS (Optional for interaction) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
