<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css')
    
    <style type="text/css">

      table
      {
        border: 2px solid white;
        text-align: center;
      }
      
      th
      {
        background-color: white;
        padding: 10px;
        font-size: 18px;
        font-weight: bold;
        text-align: center;
        color: black;
      }


      td
      {
        color: white;
        padding: 10px;
        border: 1px solid white;
      }
      .table_center
      {
        display: flex;
        justify-content: center;
        align-items: center;
      }


       .div_deg
        {
          display: flex;
          justify-content: center;
          align-items: center;
          margin-top: 60px;
        }

        .search-form {
            display: flex;
            justify-content: center;
            margin: 30px 0; /* Jarak atas & bawah */
          }

          input[type='search']
      {
        width: 500px;
        height: 60px;
        margin-left: 50px;
      }

      .btn {
        border-radius: 20px;
        padding: 8px 16px;
        font-size: 14px;
        font-weight: 500;
        text-transform: capitalize;
        transition: all 0.2s ease-in-out;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      }

    .btn:hover {
      transform: scale(1.05);
      opacity: 0.9;
    }

    .btn-primary {
      background-color: #0d6efd;
      border: none;
      color: white;
    }

    .btn-primary:hover {
      background-color: #0b5ed7;
    }

    .btn-success {
      background-color: #198754;
      border: none;
      color: white;
    }

    .btn-success:hover {
      background-color: #157347;
    }

    </style>

  </head>
<!-- tampilan admin-->
  <body>
  @include('admin.header')

  @include('admin.sidebar')

 

  <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">   
            
          {{-- ✅ Notifikasi Pesanan Dibatalkan --}}
  @if(isset($notifOrders) && $notifOrders->count() > 0)
    <div class="alert alert-warning d-flex justify-content-between align-items-center" style="margin: 20px;">
        <div>
            <strong>🔔 Notifikasi:</strong> Ada {{ $notifOrders->count() }} pesanan yang dibatalkan oleh customer.
        </div>
        <a href="{{ route('admin.markOrdersSeen') }}" class="btn btn-dark btn-sm">Tandai Sudah Dibaca</a>
    </div>
  @endif

           <div style="padding: 20px; display: flex; gap: 10px;">
                          <a href="{{ url()->previous() }}" class="btn btn-secondary">&larr; Back</a>
                      </div>


            <div class="search-form">
           <form class="" action="{{url('order_search')}}" method="get">
            @csrf
            <input type="search" name="search">
            <input type="submit" class="btn btn-secondary" value="Search">
          </form>
          </div>

          <div class="table_center">

           
          <table>
            <tr>
              <th>Costumer Name</th>

              <th>Address</th>

              <th>Phone</th>

              <th>Product Title</th>

              <th>Price</th>

              <th>Image</th>

              <th>Status</th>

              <th>Change Status</th>

              <th>Print No.Resi</th>


            </tr>

            @foreach($data as $order)

            <tr>
              <td>{{$order->name}}</td>
              <td>{{$order->rec_address}}</td>
              <td>{{$order->phone}}</td>
              <td>{{$order->product->title}}</td>
              <td>Rp.{{ number_format($order->product->price, 0, ',', '.') }}</td>
              <td>

              <img width="150" src="/products/{{$order->product->image}}" >

              </td>
               <td>
                     @php
                        $badgeClass = match(strtolower($order->status)) {
                            'on the way' => 'bg-info',
                            'delivered' => 'bg-success',
                            'in progress' => 'bg-warning text-dark',
                            'canceled' => 'bg-danger',
                            default => 'bg-secondary',};
                       @endphp

                    <span class="badge {{ $badgeClass }}">{{ ucfirst($order->status) }}</span>
              </td>

              <td>
                <a class="btn btn-primary"href="{{url('on_the_way',$order->id)}}'">On the Way</a>

              <a class="btn btn-success" href="{{url('delivered',$order->id)}}">Delivered</a>
              </td>
                  
              <td>
                <a class="btn btn-secondary" href="{{url('print_pdf',$order->id)}}">Print Resi</a>
              </td>

            </tr>

            

            @endforeach

          </table>           
               
          </div>
           <div class="div_deg">
            {{ $data->onEachSide(1)->links()}}
          </div>

                  <!-- ✅ Tombol Print All Orders PDF -->
                <div class="text-center mt-4 mb-5">
                  <a href="{{ url('print_all_pdf') }}" class="btn btn-success btn-lg shadow">
                    📄 Print All Orders PDF
                  </a>
                </div>

           


        </div>
      </div>
    </div>

    <!-- JavaScript files-->
   @include('admin.js')
  </body>
  
</html>