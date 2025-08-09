<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css')
    <style>
        .dark-container {
            padding: 30px;
            border-radius: 10px;
            color: white;
        }

        .dark-table {
            background-color: #2a2a2a;
            color: white;
        }

        .dark-table th {
            background-color: #111;
            text-align: center;
            color: white;
        }

        .dark-table td {
            background-color: #2a2a2a;
            text-align: center;
            color: white;
        }

        .btn-danger {
            background-color: #e74c3c;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .btn-primary {
            background-color: #3498db;
            border: none;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }
    </style>
  </head>

  <body>
    @include('admin.header')
    @include('admin.sidebar')  

    <div class="page-content">
      <div class="page-header">
        <div class="container-fluid"> 

          <div class="container-fluid page-body-wrapper">
            <div class="container dark-container">

              <h2 class="text-white text-center mb-4">Daftar Pengguna</h2>

              <div class="table-responsive">
                <table class="table table-bordered dark-table">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Email</th>
                      <th>Telepon</th>
                      <th>Alamat</th>
                      <th>Foto</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($users as $key => $user)
                      <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->address }}</td>
                        <td>
                          @if($user->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" width="50" height="50" style="object-fit: cover; border-radius: 50%;">
                          @else
                            <span>Tidak ada foto</span>
                          @endif
                        </td>
                        
                        <td>
                          <a href="{{ url('edit_user', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>
                          <a href="{{ url('delete_user', $user->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Hapus pengguna ini?')">Hapus</a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>

            </div>
          </div>

        </div>
      </div>
    </div>

    @include('admin.js')
  </body>
</html>
