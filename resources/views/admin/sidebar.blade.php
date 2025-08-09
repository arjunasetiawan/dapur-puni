<div class="d-flex align-items-stretch">
      <!-- Sidebar Navigation-->
      <nav id="sidebar">
        <!-- Sidebar Header-->
        <div class="sidebar-header d-flex align-items-center">
          <div class="avatar"><img src="/images/DPURRR.jpeg" alt="..." class="img-fluid rounded-circle"></div>
          <div class="title">
            <h1 class="h5">Dapur Puni</h1>
            <p>Admin</p>
          </div>
        </div>

        <!-- tampilan side  Menus-->
         

        <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
        <ul class="list-unstyled">
                <li><a href="{{url('admin/dashboard')}}"> <i class="icon-home"></i>Home </a>
              </li>

              <li>
                  <a href="{{url('view_user')}}"> <i class="icon-user">
                  </i>User</a>
                </li>
                <li>

                  <a href="{{url('view_category')}}"> <i class="icon-grid">
                  </i>Category</a>
                </li>


                <li><a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-windows"></i>Products</a>
                  <ul id="exampledropdownDropdown" class="collapse list-unstyled ">
                    <li><a href="{{url('add_product')}}">Add Product</a></li>
                    <li><a href="{{url('view_product')}}">View Product</a></li>
                  </ul>
                </li>

                <li>
                  <a href="{{url('view_orders')}}"> 
                    <i class="icon-grid">
                  </i>Orders</a>
                </li>

                <li><a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-windows"></i>Reason</a>
                 <ul id="exampledropdownDropdown" class="collapse list-unstyled ">  
                  <li><a href="{{url('view_cancel')}}">Cancel</a></li>
                  <li><a href="{{url('view_testimonial')}}">Testimonial</a></li>
                </li>
                
        </ul>
      </nav>