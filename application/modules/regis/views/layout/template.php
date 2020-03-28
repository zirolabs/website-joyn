<!DOCTYPE html>
<html>

<head>
	<title>
		<?php echo 'ini title' ?>
	</title>
	<link href='<?php echo base_url("assets/upload/images/$favicon"); ?>' rel='shortcut icon' type='image/x-icon' />
	<!-- meta -->
	<?php require_once('_meta.php') ;?>

	<!-- css -->
	<?php require_once('_css.php') ;?>
<!-- 	<script src="<?php echo base_url('assets');?>/vendor/jquery/jquery.min.js"></script> -->
</head>


<body class="fixed">
	<!-- <div class="container"> -->
		<!-- header -->
		<?php require_once('_header.php') ;?>
		<!-- sidebar -->
		<!-- <?php require_once('_sidebar.php') ;?> -->
		<!-- content -->
		<div class="content-wrapper">
			<!-- Main content -->
			<section class="content">
				<?php echo $contents ;?>
			</section>
		</div>
		<!-- footer -->
		<?php require_once('_footer.php') ;?>

  	<a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>  
	<!-- </div> -->
	<!-- js -->
	<?php require_once('_js.php') ;?>
</body>

</html>
