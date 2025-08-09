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
      }

      label
      {
        display: inline-block;
        width: 200px;
        padding: 20px;
      }

      .label_deg
      {
        color: white;
      }

      input[type='text']
      {
        width: 300px;
        height: 60px;
      }

      textarea
      {
        width: 450px;
        height: 100px;
      }

      h2{
        color: white;
      }




    </style>
    


  </head>
<!-- tampilan admin-->
  <body>
    @include('admin.header')

    @include('admin.sidebar')  
      <!-- Sidebar Navigation end-->
      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">    

          <h2>Update Product</h2>

          <div class="div_deg">
              <form action="{{url('edit_product',$data->id)}}" method="post" enctype="multipart/form-data">

              @csrf
                      <div>
                        <label class="label_deg">Title</label>
                        <input type="text" name="title" value="{{$data->title}}">
                      </div>

                       <div>
                        <label class="label_deg">Description</label>
                        <textarea name="description">{{$data->description}}</textarea>
                      </div>

                       <div>
                        <label class="label_deg">Price</label>
                        <input type="text" name="price" value="{{$data->price}}">
                      </div>

                      <div>
                        <label class="label_deg">Quantity</label>
                        <input type="number" name="quantity" value="{{$data->quantity}}">
                      </div>

                      <div>
                        <label class="label_deg">Category</label>

                        <select name="category">

                        <option value="{{$data->category}}">{{$data->category}}</option>

                        @foreach($category as $category)

                        <option value="{{$category->category_name}}">{{$category->category_name}}</option>

                        @endforeach

                        </select>
                      </div>

                      <div>
                        <label class="label_deg">Current Image</label>
                         <img width="200" src="/products/{{$data->image}}">
                      </div>

                      <div>
                        <label class="label_deg">New Image</label>
                        <input type="file" name="image">
                      </div>

                      <div>
                        <input class="btn btn-success" type="submit" value="Update Product">
                      </div>

              </form>


          </div>

            

           

        </div>
      </div>
    </div>
    <!-- JavaScript files-->
   @include('admin.js')
  </body>
</html>


