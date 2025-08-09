<!DOCTYPE html>
<html>

<head>
  @include('home.css')
</head>
<body>
  <div class="hero_area">
    <!-- header section starts -->
    @include('home.header')
    <!-- end header section -->

    <!-- slider section -->
    @include('home.slider')
    <!-- end slider section -->
  </div>
  <!-- end hero area -->

  <!-- shop section -->
  @include('home.product_show')
  <!-- end shop section -->

  <!-- contact section -->
  @include('home.contact')
  <!-- end contact section -->

  <!-- info section -->
  @include('home.footer')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
