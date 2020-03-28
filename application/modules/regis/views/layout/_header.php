 <header id="header">
  <div class="container">

    <div id="logo" class="pull-left">
      <h1>
        <a href="<?php base_url() ?>#intro" class="scrollto">
          <img src="<?php base_url() ?>assets/img/logo-joyn-gbt.svg" alt=""> 
        </a>
      </h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="#intro"><img src="<?php base_url() ?>assets/img/logo.png" alt=""></a> -->
    </div>

    <!-- nav -->
    <?php require_once('_nav.php') ;?>
    
  </div>
</header><!-- End Header -->
<?php 
  date_default_timezone_set("Asia/Jakarta");

  $hour = date("G", time());
  $session_id = $this->session->userdata('form_isi');
  if($session_id == 1){
    ?>
    <script>
      alert('Registration Successful'); 
    </script>
    <?php
    $this->session->unset_userdata('form_isi'); 
    $this->session->set_userdata('form_isi', 0); 
  }
  else{

  }

  if ($hour>=0 && $hour<=11)
  {
    $Salam = 'Selamat Pagi';
    $Pesan = 'Awali harimu dengan kemudahan aktivitas bersama aplikasi Anak Bangsa';
  }
  elseif ($hour >=12 && $hour<=14)
  {
    $Salam = 'Selamat Siang';
    $Pesan = 'Ringankan aktivitas harimu dengan aplikasi Anak Bangsa ini';
  }
  elseif ($hour >=15 && $hour<=17)
  {
    $Salam = 'Selamat sore';
    $Pesan = 'Aplikasi karya Anak Bangsa ini siap membantu kesibukan aktivitasmu';
  }
  elseif ($hour >=17 && $hour<=18)
  {
    $Salam = 'Selamat petang';
    $Pesan = 'Bahagiakan orang-orang kesayanganmu dengan layanan aplikasi Anak Bangsa ini';
  }
  elseif ($hour >=19 && $hour<=23)
  {
    $Salam = 'Selamat Malam';
    $Pesan = 'Setelah seharian beraktivitas, hilangkan kepenatan dengan layanan aplikasi Anak Bangsa ini';
  }
?>
<!-- ======= Intro Section ======= -->
<section id="intro">

  <div class="intro-text">
    <h2><?php echo $Salam; ?></h2>
    <p><?php echo $Pesan; ?></p>
    <a href="#main" class="btn-get-started scrollto">Get Started</a>
  </div>

  <div class="product-screens">

    <div class="product-screen-1 wow fadeInUp" data-wow-delay="0.4s" data-wow-duration="0.6s">
      <img src="<?php base_url() ?>assets/img/f1.jpeg" alt="">
    </div>

    <div class="product-screen-2 wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="0.6s">
      <img src="<?php base_url() ?>assets/img/f2.jpeg" alt="">
    </div>

    <div class="product-screen-3 wow fadeInUp" data-wow-duration="0.6s">
      <img src="<?php base_url() ?>assets/img/f3.jpeg" alt="">
    </div>

  </div>

</section><!-- End Intro Section -->

<br><br>