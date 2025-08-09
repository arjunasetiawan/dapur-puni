<!DOCTYPE html>
<html>

<head>
  @include('home.css')
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    /* Bagian Hero */
    .about-hero {
      display: flex;
      background-color: #fcb0b3;
      color: white;
      padding: 50px;
      flex-wrap: wrap;
    }

    .about-hero-text {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .about-hero-text h1 {
      font-size: 3rem;
      font-weight: bold;
      margin-bottom: 15px;
    }

    .about-hero-text p {
      font-size: 1.4rem;
      line-height: 1.6;
    }

    .about-hero-image {
      flex: 1;
      text-align: center;
    }

    .about-hero-image img {
      max-width: 300px;
      height: auto;
    }

    /* Konten Tengah */
    .about-content {
      display: flex;
      min-height: 300px;
      flex-wrap: wrap;
    }

    .about-left {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2.5rem;
      font-weight: bold;
      padding: 20px;
      background-color: #fbb1d3;
      text-align: center;
    }

    .about-center {
      flex: 2;
      padding: 50px;
      background-color: white;
      font-size: 1.2rem;
      line-height: 1.8;
      text-align: justify;
    }

    .about-right {
      flex: 1;
      background-color: #f25c54;
    }

    /* Bagian Footer About */
    .about-footer {
      display: flex;
      flex-wrap: wrap;
    }

    .about-footer-image {
      flex: 1;
      text-align: center;
    }

    .about-footer-image img {
      max-width: 300px;
      height: auto;
    }

    .about-footer-text {
      flex: 1;
      padding: 50px;
      color: white;
      display: flex;
      align-items: center;
      font-size: 1.3rem;
      line-height: 1.8;
      background-color: #7fc8f8;
    }

    /* Responsif */
    @media (max-width: 768px) {
      .about-hero,
      .about-content,
      .about-footer {
        flex-direction: column;
        text-align: center;
      }

      .about-hero-image img,
      .about-footer-image img {
        max-width: 200px;
      }

      .about-center {
        padding: 20px;
      }
    }
  </style>
</head>

<body>
  <div class="hero_area">
    @include('home.header')
  </div>

  <div class="about-section">
    <!-- Hero -->
    <div class="about-hero">
      <div class="about-hero-text">
        <h1>Selamat datang di Dapur Puni.</h1>
        <p>Menghadirkan cita rasa rumahan terbaik dengan sentuhan hangat penuh kasih.</p>
      </div>
      <div class="about-hero-image">
        <img src="/images/aboutus.png" alt="Hero Image">
      </div>
    </div>

    <!-- Konten Tengah -->
    <div class="about-content">
      <div class="about-left">
        <h2>About Us</h2>
      </div>
      <div class="about-center">
        <p>
          Dapur Puni adalah usaha mikro yang dirintis dan dikelola secara mandiri oleh seorang ibu rumah tangga.
          Berawal dari produksi kue kering seperti nastar dan kastengel untuk Hari Raya, kini Dapur Puni menghadirkan
          berbagai menu lezat seperti nasi kuning, ayam goreng bumbu khas, bolu ketan, tumpeng mini, dan es kopyor.
        </p>
      </div>
      <div class="about-right">
        <!-- Bisa diisi gambar atau dekorasi -->
      </div>
    </div>

    <!-- Footer About -->
    <div class="about-footer">
      <div class="about-footer-image">
        <img src="/images/Dapurpunii.png" alt="Footer Image">
      </div>
      <div class="about-footer-text">
        <p>
          Dengan ketekunan, kreativitas, dan konsistensi, kami terus menjaga kualitas rasa dan berinovasi,
          menjadi bagian dari momen istimewa pelanggan dari hari ke hari.
        </p>
      </div>
    </div>
  </div>

  @include('home.footer')

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
