<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    @include('home.css')
    <title>@yield('title')</title>
</head>
<body>
    <div class="hero_area">
        @include('home.header')

        @yield('content')
        <br>
        <br>
        <br>

        

        @include('home.footer')
    </div>
</body>
</html>
