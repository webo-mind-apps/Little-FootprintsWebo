<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Little Footprints Academy</title>

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
	 <script> 
	 	$( function(){
			var d = new Date();
			d.setFullYear(d.getFullYear()+10); 
			var date = $('.payment_date_js').datepicker({dateFormat: 'dd-M-yy',changeMonth: true,changeYear: true,yearRange: '1960:' + d.getFullYear() }).val();
		});
	  
	 	function payment_date_empty(){  
	 	 	var payment_date = $("#payment_date").val(); 
	 	 	var pay_end_date = $("#pay_end_date").val();
             if(payment_date&&pay_end_date){ 
	 	 		 $("#pay_roll_button").css("display","block");
	 	 	}
        }
        

	 	
	 </script>
	<style type="text/css">
		.payslip_heading{
			font-weight:bold;
			font-size:12px;
		}
		.earnings_padding{
			 padding-top:15px;
		} 
		.input-icons i { 
            position: absolute; 
        }  
        .input-icons { 
            width: 100%; 
            margin-bottom: 10px; 
        }  
        .icon { 
            padding:5px 0 0 220px; 
            min-width: 40px; 
        }  
        .icon1 { 
            padding:49px 0 0 220px; 
            min-width: 40px; 
        } 
		.table th {
			font-weight: 500;
			font-size: 11px;
		}
		#payroll_details tr td {
			padding-bottom: 0;
		}
		#payroll_details tr td input{
			text-align:center;
			border-color:#333;
			max-width: 75px;
			margin:auto;
		}
		.text-center input{margin:auto !important}
		select, input{font-size: 12px; width: 100%; height: 30px; border-radius: 3px; border: 1px solid #b0b0b0;}
		input:not([type]), input[type=checkbox]{height: 10px}
		label{margin-bottom: 0; font-size: 10px;}
		input{margin:0px !important}
		#import-btn-group{display:none}
	</style>
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
		  <div class="card-header header-elements-inline">
				<h6 class="card-title" style="font-weight:bold;font-size:14px;border-bottom:double 2px black;">EMPLOYEES PAYROLL</h6> 
				<div class="right" id="import-btn-group">
					<button class=" btn btn-small btn-primary" id="import-btn">Import &nbsp;&nbsp;&nbsp;<i class="fa fa-download" aria-hidden="true"></i></button>
					<br>
					<a href="<?php echo base_url() ?>my_assets/payroll-format.xlsx" target="_blank">Download Format</a>
				</div>
		  </div> 
          <div class="card-body">
          	<?php
   				if($this->session->flashdata('abc','success')){
   			?> 
          			<div class="alert bg-success alert-styled-left">
					  		<button type="button" class="close" data-dismiss="alert">&times;</button>
							<span class="text-semibold">Updates are saved successfully..!</span>
					</div>
		    <?php 
   				}
          	?>

			<?php if($this->session->flashdata('success')){ ?> 
          			<div class="alert bg-success alert-styled-left">
					  		<button type="button" class="close" data-dismiss="alert">&times;</button>
							<span class="text-semibold"><?php echo $this->session->flashdata('success') ?></span>
					</div>
		    <?php } ?>			

			<?php if($this->session->flashdata('error')){ ?> 
          			<div class="alert bg-danger alert-styled-left">
					  		<button type="button" class="close" data-dismiss="alert">&times;</button>
							<span class="text-semibold"><?php echo $this->session->flashdata('error') ?></span>
					</div>
		    <?php } ?>	

                  <form action="<?php echo site_url('payroll/save_payroll');?>" method="post" id="import-form" enctype="multipart/form-data"> 
				  	<input style="display:none" type="file" name="import" id="import-file" accept=".xls, .xlt, .xlm, .xlsx, .xlsm, .xltx, .xltm, .xlsb, .xla, .xlam, .xll, .xlw">
				  <table class="table ">
				  			<tr class="table-active table-border-double">
								<td  width="18%">
				   					<label for="">SELECT COMPANY</label><br>
									<select id="companySelect" name="company">
				   						<?php foreach ($company as $key => $value) {
											echo '<option value="'.$value->id.'" >'.$value->name.'</option>';
										} ?>
									</select>
								</td>
								<td  width="18%">
				   					<label for="">SELECT CENTER</label><br>
									<select id="centerSelect" name="center"> </select>
								</td>
								<td width="18%">
									<label>PAY PERIOD START DATE</label><br>
									<input type="text" onchange="payment_date_empty()" class="payment_date_js" id="payment_date" name="pay_date_val"  style="margin-left:5px;font-size:12px;" autocomplete="off">
								</td>
								<td   width="18%">
									<label>PAY PERIOD END DATE</label><br>
									<input type="text" onchange="payment_date_empty()" class="payment_date_js" id="pay_end_date" name="pay_end_date_val"  style="margin-left:12px;font-size:12px;" autocomplete="off"> 
								</td>

								<td width="18%">
									<label>PAYMENT DATE</label><br>
									<input type="text" onchange="payment_date_empty()" class="payment_date_js" id="payment_date_on" name="pay_date"  style="margin-left:5px;font-size:12px;" autocomplete="off">
								</td>
								
								
							</tr>
				  </table>
				  <table class="table " id="payroll_details">
				  
				  </table>
            		<div class="form-group row"> 
            		

					

					<div class="pay_roll_dropdown col-sm-12" style="display:none">
					        <hr style="margin-top:0px">           
                    <div class="text-left col-sm-12">

                    	<a href="<?php echo base_url('summarized-report?year=2020') ?>"><button type="button" class="btn btn-primary">Generate Payslip<i class="icon-book ml-2"></i></button></a>

                    	<button type="submit" class="btn btn-primary" style="float:right;">Save<i class="icon-download ml-2"></i></button>
                     
                    </div>
                  </div>
                  </form>
		  </div>
		</div>
	<!-- /multiple row inputs (horizontal) --> 
	  </div>
		<!-- /content area -->  
	</div>
	<!-- /content wrapper --> 

	<!-- Footer -->
		 <?php $this->load->view('includes/main_footer') ?>
	<!-- /footer --> 
	</div>
	<!-- /page content -->
  
  <script>
	$(document).ready(function () {
		$('#payment_date , #pay_end_date, #companySelect, #centerSelect, #payment_date_on').change(function(){
			payroll_show_function();
		});

		// fetch center
		$('#companySelect').change(function() { 
			centerList();
		});

		centerList();
	});
	function payroll_show_function(){ 
	 	var payment_date = $("#payment_date").val(); 
	 	var pay_end_date = $("#pay_end_date").val();
	 	var companySelect= $("#companySelect").val();
	 	var centerSelect = $("#centerSelect").val();
	 	var date 		 = $("#payment_date_on").val();
	 	if(payment_date != '' && pay_end_date != '' && companySelect != '' && centerSelect != ''){
			$('#import-btn-group').show();
			jQuery.ajax({	
				type:'POST',
				url:"<?php echo base_url();?>"+"payroll/pay_roll_dates",
				data:{
					payment_date	:	payment_date,
					pay_end_date	:	pay_end_date,
					company 		: 	companySelect,
					center 			:	centerSelect,
					pay_date		:	date,
				},
				success:function(response){							 
					$("#payroll_details").empty();
					$("#payroll_details").html(response);
				}
			}); 
			$(".pay_roll_dropdown").css("display","block");
		}else{
			$('#import-btn-group').hide();
		}
	}

	function centerList(){
		var company_name = $('#companySelect').val();
		$.ajax({
         	url:"<?php echo base_url();?>main/center_select_feild",
         	type:"POST",	
         	dataType:'json',
         	data:{company_name:company_name},
         	success:function(data){
				$("#centerSelect").empty();
            	$.each(data, function (index, value) { 
               		$('#centerSelect').append('<option value="'+value.id+'">'+value.center_name+'</option>');
            	});
         	}
         });	
	}

	$(document).on('change', '#checkall', function(){
		if($(this).prop('checked')){
			$('.vacchek').prop('checked', true);
		}else{
			$('.vacchek').prop('checked', false);
		}
	});

	$(document).ready(function () {
		$('#import-btn').click(function (e) { 
			e.preventDefault();
			$('#import-file').trigger('click');
		});

		$('#import-file').change(function (e) { 
			e.preventDefault();
			$('#import-form').submit();
		});
	});

  </script>
</body>
</html>
