<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css')
    
      <style type="text/css">

        .div_deg
        {
          display: flex;
          justify-content: center;
          align-items: center;
          margin-top: 60px;
        }

        .table_deg
        {
          border: 2px solid greenyellow;
        }

        th
        {
            background-color: skyblue;
            color: white;
            font-size: 19px;
            font-weight: bold;
            padding: 15px;
        }

        td
        {
          border: 1px solid skyblue;
          text-align: center;
          color: white;
        }

        input[type='search']
      {
        width: 500px;
        height: 60px;
        margin-left: 50px;
      }

      td.price-column, th.price-column {
      width: 150px; 
}

      </style>
    </head>
  <body>
    @include('admin.header')

    @include('admin.sidebar')  
      <!-- Sidebar Navigation end-->
      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">    

          <form action="{{url('product_search')}}" method="get">
            @csrf
            <input type="search" name="search">
            <input type="submit" class="btn btn-secondary" value="Search">
          </form>


          <div class="div_deg">

          

            <table class="table_deg">
              <tr>
                <th class="price-column">Produk Title</th>

                <th>Descripton</th>

                <th>Category</th>

                <th class="price-column">Price</th>

                <th>Quantity</th>

                <th>Image</th>

                <th>Edit</th>

                <th>Delete</th>

              </tr>

              @foreach($product as $products)

              <tr>

              <td class="price-column">{{$products->title}}</td>

              <td>{!!Str::limit($products->description,50)!!}</td>

              <td>{{$products->category}}</td>

              <td class="price-column">Rp. {{ number_format($products->price, 0, ',', '.') }}</td>

              <td>{{$products->quantity}}</td>
              

              <td>

                <img src="products/{{$products->image}}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;">

              </td>

              <td>
                <a class="btn btn-success" href="{{url('update_product',$products->id)}}'">Edit</a>
              </td>


              <td>
                <a class="btn btn-danger" onclick="confirmation(event)" href="{{url('delete_product',$products->id)}}">Delete</a>
              </td>

              </tr>

              @endforeach

            </table>   

          </div>

          <div class="div_deg">
            {{$product->onEachSide(1)->links()}}
          </div>


        </div>
      </div>
    </div>

    <!-- JavaScript files-->
   @include('admin.js')
  </body>
</html>