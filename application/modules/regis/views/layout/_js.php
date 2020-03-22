  <!-- Vendor JS Files -->
  <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/php-email-form/validate.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/wow/wow.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/venobox/venobox.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/superfish/superfish.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/hoverIntent/hoverIntent.js"></script>

  <script src="<?php echo base_url(); ?>assets/js/main.js"></script>

      <!-- ALL JS FILES -->
  <script src="<?php echo base_url(); ?>assets/js/all.js"></script>
    <!-- ALL PLUGINS -->
  <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/swiper.min.js"></script>
  <script>
    var swiper = new Swiper('.swiper-container', {
      loop: true,
      effect: 'coverflow',
      centeredSlides: true,
      loopFillGroupWithBlank: true,
      slidesPerView: 3,
            initialSlide: 3,
            keyboardControl: true,
            mousewheelControl: false,
            lazyLoading: true,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      breakpoints: {
                1199: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                991: {
                    slidesPerView: 3,
                    spaceBetween: 10,
                },
                767: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                575: {
                    slidesPerView: 1,
                    spaceBetween: 3,
                }
            }
    });
    </script>


  <!-- Template Main JS File -->
  <!-- <script src="<?php echo base_url(); ?>assets/js/main.js"></script> -->



