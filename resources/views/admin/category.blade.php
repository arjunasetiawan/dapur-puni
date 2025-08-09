<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css')

    <style type="text/css">
      input[type='text']
      {
        width: 400px;
        height: 50px;
      }

      .div_deg
      {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 30px;
      }

    .table_deg
    {
      text-align: center;
      margin: auto;
      border: 3px solid #F0F8FF;
      margin-top: 50px;  
      width: 600px;
    }

    th
    {
      background-color: skyblue;
      padding: 15px;
      font-size: 20px;
      font-weight: bold;
      color: white;
    }

    td{
      color: white;
      padding: 10px;
      border: 1px solid skyblue;
    }
    </style>


  </head>
 <!-- tampilan add category-->
  <body>
    @include('admin.header')

    @include('admin.sidebar')  
      <!-- Sidebar Navigation end-->
      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">

          <h1 style="color:white;">Tambah Category</h1>

        <!-- Form kotak Category-->
         <div class="div_deg">

                  <form action="{{ url('/add_category') }}" method="POST">
              @csrf
              <div class="form-group">
                  <label for="category">Nama Kategori</label>
                  <input type="text" name="category" id="category" class="form-control" placeholder="Masukkan nama kategori">
                  
                  {{-- Tampilkan error jika input tidak diisi --}}
                  @error('category')
                      <div class="text-danger mt-1">{{ $message }}</div>
                  @enderror
              </div>

              <button type="submit" class="btn btn-primary">Tambah</button>
          </form>
         </div>

         <div>

            <table class="table_deg">

              <tr>
                <th>Category Name</th>

                <th>Edit</th>

                <th>Delete</th>
              </tr>

              @foreach($data as $data)

              <tr>
                <td>{{$data->category_name}}</td>

                <td>
                  <a class="btn btn-success" href="{{url('edit_category',$data->id)}}">Edit</a>
                </td>


                <td>
                  <a class="btn btn-danger" onclick="confirmation(event)"  href="{{url('delete_category',$data->id)}}">Delete</a>
                </td>
                
              </tr> 
              
              @endforeach

            </table>

         </div>
        </div>
      </div>
    </div>
    <!-- JavaScript files-->



    @include('admin.js')

  </body>
</html>