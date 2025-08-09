<section class="slider_section">
  <div class="slider_container">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="4000">
      <!-- INDIKATOR -->
      <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
      </ol>

      <!-- SLIDE ITEM -->
      <div class="carousel-inner">

        <!-- Slide 1 -->
        <div class="carousel-item active">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-7">
                <div class="detail-box">
                  <h1>Cemilan Terbaik Harga Rumahan Rasa Tidak Murahan</h1>
                  <p>Berbagai Macam Kue Kering Untuk Lebaran Dan Menjadi Teman Cemilan Tiap Hari Dibuat Dengan Bahan Terbaik.</p>
                  <a href="{{ url('/aboutus') }}">About Us</a>
                </div>
              </div>
              <div class="col-md-5">
                <div class="img-box">
                  <img style="width:600px" src="images/kue4.png" class="img-fluid" alt="Gambar Kue">
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Slide 2 -->
        <div class="carousel-item">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-7">
                <div class="detail-box">
                  <h1>Kue Lebaran Fresh & Nikmat</h1>
                  <p>Kami buat kue setiap hari dengan bahan premium, cocok untuk camilan keluarga.</p>
                  <a href="{{ url('/shop') }}">Shop Now</a>
                </div>
              </div>
              <div class="col-md-5">
                <div class="img-box">
                  <img style="width:400px" src="images/chesssscake.png" class="img-fluid" alt="">
                </div>
              </div>
            </div>
          </div>
        </div>

                          <!-- Slide 3 -->
                  <div class="carousel-item">
                    <div class="container-fluid">
                      <div class="row">
                        <div class="col-md-7">
                          <div class="detail-box">
                            <h1>Testimoni Pelanggan Kami</h1>
                            <p>Dengarkan cerita langsung dari pelanggan yang telah menikmati kelezatan kue kami.</p>
                            <a href="{{ url('/testimonial') }}">Lihat Testimonial</a>
                          </div>
                        </div>
                        <div class="col-md-5">
                          <div class="img-box">
                            <img style="width:400px" src="images/kue_2-removebg-preview.png" class="img-fluid" alt="Ikon Testimonial">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>


      <!-- TOMBOL NEXT / PREV -->
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
      </a>
    </div>
  </div>
</section>

<!-- CSS FIX -->
<style>
  .detail-box {
    position: relative;
    z-index: 10;
  }
  .detail-box a {
    position: relative;
    z-index: 11;
    display: inline-block;
    padding: 10px 20px;
    background: #f39c12;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
  }
  .detail-box a:hover {
    background: #e67e22;
  }
  .img-box img {
    position: relative;
    z-index: 1;
  }
  
</style>

<!-- SCRIPT BOOTSTRAP -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
