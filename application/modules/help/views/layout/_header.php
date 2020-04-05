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
?>
<!-- ======= Intro Section ======= -->
<section id="intro-help">

  <div class="intro-help-text">
    <h2><?php echo "Anda memerlukan bantuan?"; ?></h2>
    <!-- <p><?php echo $Pesan; ?></p> -->
    <!-- <a href="#main" class="btn-get-started scrollto">Get Started</a> -->
    <div class="input-group md-form form-sm form-1">
      <div class="input-group-append form-header">
        <input class="form-control my-0 py-1 green-border" type="text" placeholder="Search" aria-label="Search">
        <span class="input-group-text cyan lighten-2" id="basic-text1">
          <i class="fas fa-search" aria-hidden="true"></i>
        </span>
      </div>
    </div>
  </div>


</section><!-- End Intro Section -->

<br><br>