<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Limitless - Responsive Web Application Kit by Eugene Kopyov</title>

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
        

	 	function payroll_show_function(){ 
	 		var payment_date = $("#payment_date").val(); 
	 	 	var pay_end_date = $("#pay_end_date").val();
	 	 	 
             jQuery.ajax({	
					type:'POST',
					url:"<?php echo base_url();?>"+"main_control/pay_roll_dates",
					data:{payment_date:payment_date,pay_end_date:pay_end_date},
					success:function(response){							 
						  $("#payroll_details").empty();
						  $("#payroll_details").html(response);
						//alert(response);
					}
			}); 
	 	 	$(".pay_roll_dropdown").css("display","block");
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
					<h6 class="card-title" style="font-weight:bold;font-size:14px;border-bottom:double 2px black;">EMPLOYESS PAYROLL</h6> 
					
		  </div> 
				<h1></h1>
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
                  <form action="<?php echo site_url('main_control/save_payroll');?>" method="post"> 

				  <table class="table ">
				  			<tr class="table-active table-border-double">
								<td width="25%">
									PAYMENT DATE:<input type="text" onchange="payment_date_empty()" class="payment_date_js" id="payment_date" name="pay_date_val"  style="margin-left:5px;font-size:12px;" autocomplete="off">
								</td>
								<td  width="25%">
								PAY END DATE:<input type="text" onchange="payment_date_empty()" class="payment_date_js" id="pay_end_date" name="pay_end_date_val"  style="margin-left:12px;font-size:12px;" autocomplete="off"> 
								</td>
								<td >
									<div style="color:white;display:none;" id="pay_roll_button">
										<a class="btn btn-primary legitRipple btn-sm" onclick="payroll_show_function()">Show</a>
									</div>
								</td>
							
							</tr>
				  </table>
				  <table class="table " id="payroll_details">
				  
				  </table>
            		<div class="form-group row"> 
            		

					

					<div class="pay_roll_dropdown col-sm-12" style="display:none">
					        <hr style="margin-top:0px">           
                    <div class="text-left col-sm-12">

                    	<a href="#"><button type="button" class="btn btn-primary">Generate Payslip<i class="icon-book ml-2"></i></button></a>

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
  
</body>
</html>
