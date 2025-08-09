<!DOCTYPE html>
<html>
<head>
  @include('home.css')
  <style>
    .div_center {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 30px;
    }

    .detail-box {
      padding: 15px;
    }

    .star-rating {
      direction: rtl;
      display: inline-flex;
    }

    .star-rating input[type="radio"] {
      display: none;
    }

    .star-rating label {
      font-size: 24px;
      color: #ccc;
      cursor: pointer;
      padding: 0 5px;
      transition: color 0.2s;
    }

    .star-rating input[type="radio"]:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label {
      color: gold;
    }
  </style>
</head>
<body>
  <div class="hero_area">
    @include('home.header')
  </div>

  <!-- product details start-->
  <section class="shop_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>Latest Products</h2>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="div_center">
              <img width="400" src="/products/{{$data->image}}" alt="">
            </div>

            <div class="detail-box">
              <h6>{{ $data->title }}</h6>
              <h6>Price: <span>{{ $data->price }}</span></h6>
            </div>

            <div class="detail-box">
              <h6>Category: {{ $data->category }}</h6>
              <h6>Available Quantity: <span>{{ $data->quantity }}</span></h6>
            </div>

            <div class="detail-box">
              <p>{{ $data->description }}</p>
            </div>

            <div style="padding: 20px; display: flex; gap: 10px;">
              <a href="{{ url('/') }}" class="btn btn-secondary">&larr; Back</a>
              <form action="{{ url('add_cart', $data->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Add to Cart</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- testimonial form -->
  <section class="testimonial_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>Leave a Testimonial</h2>
      </div>

      <form action="{{ url('submit_testimonial/' . $data->id) }}" method="POST">
        @csrf
        <div class="mb-3">
          <label for="comment" class="form-label">Your Comment</label>
          <textarea class="form-control" name="comment" rows="3" required></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Your Rating</label><br>
          <div class="star-rating">
            @for ($i = 5; $i >= 1; $i--)
              <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required>
              <label for="star{{ $i }}">&#9733;</label>
            @endfor
          </div>
        </div>

        <button type="submit" class="btn btn-success mt-3">Submit Testimonial</button>
      </form>
    </div>
  </section>

  <!-- display testimonials -->
  <section class="testimonial_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>What Customers Say</h2>
      </div>

      <div class="row mt-4">
        @foreach ($testimonials as $testi)
          <div class="col-md-4 mb-4">
            <div class="card p-3 shadow-sm">
              <div>
                @for ($i = 1; $i <= 5; $i++)
                  @if ($i <= $testi->rating)
                    <span style="color: gold;">&#9733;</span>
                  @else
                    <span style="color: #ccc;">&#9733;</span>
                  @endif
                @endfor
              </div>
              <p class="mt-2">"{{ $testi->comment }}"</p>
              <h6 class="mb-0">- {{ $testi->user->name ?? 'Anonymous' }}</h6>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- footer -->
  @include('home.footer')
</body>
</html>
