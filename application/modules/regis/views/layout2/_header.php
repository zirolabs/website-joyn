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
 ?>
<!-- ======= Intro Section ======= -->
  <section id="intro">

    <div class="intro-text">
      <h2>Welcome to <?php echo SITE_NAME ?></h2>
      <p>We are team of talanted designers making websites with Bootstrap</p>
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