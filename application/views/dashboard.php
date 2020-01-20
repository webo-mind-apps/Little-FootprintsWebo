<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Little Footprints</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url();?>my_assets/global_assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url();?>my_assets/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url();?>my_assets/assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url();?>my_assets/assets/css/layout.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url();?>my_assets/assets/css/components.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url();?>my_assets/assets/css/colors.min.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="<?php echo base_url();?>my_assets/global_assets/js/main/jquery.min.js"></script>
	<script src="<?php echo base_url();?>my_assets/global_assets/js/main/bootstrap.bundle.min.js"></script>
	<script src="<?php echo base_url();?>my_assets/global_assets/js/plugins/loaders/blockui.min.js"></script>
	<script src="<?php echo base_url();?>my_assets/global_assets/js/plugins/ui/ripple.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src='https://kit.fontawesome.com/a076d05399.js'></script>
	<script src="<?php echo base_url();?>my_assets/assets/js/app.js"></script>
	<!-- /theme JS files --> 
	 <script src="<?php echo base_url()?>my_assets/assets/js/jquery-ui/jquery-ui.min.js"></script>
	 
</head>

<body>  
	<!-- Main navbar -->
	  <?php $this->load->view('includes/main_nav_bar')?>
	<!-- /main navbar --> 

	<!-- Page content -->
	<div class="page-content"> 

    <!-- Main sidebar ---->
		 <?php $this->load->view('includes/main_side_bar')?>
    <!--/main sidebar --->

	<!-- Main content -->
	<div class="content-wrapper"> 

		<!-- Content area -->
	  <div class="content">  

	<!-- Multiple row inputs (horizontal) -->
        <div class="card" >
		
		</div>
	<!-- /multiple row inputs (horizontal) --> 
	  </div>
		<!-- /content area -->  

		<!-- Footer -->
		<?php $this->load->view('includes/main_footer') ?>
	<!-- /footer --> 
	</div>
	<!-- /content wrapper --> 
	

	
	</div>
	<!-- /page content -->
  
</body>
</html>
