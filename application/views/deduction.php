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
		.payslip_heading{ font-weight:bold; font-size:12px; }
		.earnings_padding{ padding-top:15px; } 
		.input-icons i { position: absolute; } 
		.input-icons { width: 100%; margin-bottom: 10px; } 
		.icon { padding:5px 0 0 220px; min-width: 40px; } 
		.icon1 { padding:49px 0 0 220px; min-width: 40px; } 
		.table th { font-weight: 500; font-size: 11px; } 
		#payroll_details tr td { padding-bottom: 0; } 
		#payroll_details tr td input{ text-align:center; border-color:#333; max-width: 75px; margin:auto; }
		.text-center input{margin:auto !important}
		select, input{font-size: 12px; width: 100%; height: 30px; border-radius: 3px; border: 1px solid #b0b0b0;}
		input:not([type]), input[type=checkbox]{height: 10px}
		label{margin-bottom: 0; font-size: 10px;}
		input{margin:0px !important}
		.action-list { list-style-type: none; text-align:center; padding:0}
		.action-list li { display: inline-block; position:relative; } 
		.action-list li a{ padding: 0 9px; color:#333 } 
		.action-list li a:hover{ color: #1f88b9 } 
		.action-list li:after { position:absolute; content: '|'; right:0; } 
		.action-list li:last-child:after { position:absolute; content: ''; right:0; }
		.cols3{
			border-bottom: transparent !important;
			font-size: 13px !important;
			padding: 5px 0 0 !important;
		}
		thead tr:nth-child(2) th{border:transparent  !important}
		thead tr:nth-child(1){background: #e7e7e7;}
		thead tr:nth-child(2){background: #ccc;}

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
				<h6 class="card-title" style="font-weight:bold;font-size:14px;border-bottom:double 2px black;">Deduction Report</h6> 
		  </div> 
          <div class="card-body">
          	<?php
   				if($this->session->flashdata('success')){
   			?> 
          			<div class="alert bg-success alert-styled-left">
					  		<button type="button" class="close" data-dismiss="alert">&times;</button>
							<span class="text-semibold"><?php echo $this->session->flashdata('success') ?></span>
					</div>
		    <?php 
				   }
				   if($this->session->flashdata('error')){
					?> 
						   <div class="alert bg-danger alert-styled-left">
								   <button type="button" class="close" data-dismiss="alert">&times;</button>
								 <span class="text-semibold"><?php echo $this->session->flashdata('error') ?></span>
						 </div>
				 <?php 
						}
						
						
				   ?>			
                  <form action="<?php echo site_url('main_control/save_payroll');?>" method="post"> 

				    <table class="table ">
				  		<tr class="table-active table-border-double">
							<td   style="width:300px">
				   				<label for="">SELECT COMPANY</label><br>
								<select id="companySelect">
				   					<?php foreach ($company as $key => $value) {
										   $select = ($key == 0)? 'selected' : '';
										echo '<option '.$select.' value="'.$value->id.'" >'.$value->name.'</option>';
									} ?>
								</select>
							</td>
							<td  style="width:300px">
                                <label>Select Year</label><br>
							    <select name="year" id="year">
									<?php
										for ($i=2019; $i < 2100; $i++) { 
											$select = (date('Y') == $i)? 'selected' : '';
											echo '<option '.$select.'>'.$i.'</option>';
										}
									?>
                                </select>
                            </td>
							<td  style="width:300px">
                                <label>Select Month</label><br>
							    <select name="month" id="month">
									<?php
									for($iM =1;$iM<=12;$iM++){
										$select = (date('M') == date("M", strtotime("$iM/12/10")))? 'selected' : '';
										echo '<option '.$select.'>'.date("M", strtotime("$iM/12/10")).'</option>';
									}
									?>
                                </select>
                            </td>
							<td>
                                <a href="#!"  class="btn btn-primary export-btn" style="margin-top: 13px; font-size: 11px;">Export  &nbsp;&nbsp;<i class="fa fa-download" aria-hidden="true"></i></a>
                            </td>
								
						</tr>
				    </table>
				    <table class="table " id="payroll_details">
                        <thead>
                            <tr>
								<th rowspan="2">SL NO</th>
                                <th rowspan="2">Emp Id</th>
                                <th rowspan="2">First Name</th>
                                <th rowspan="2">Last Name</th>
								<th class="text-center cols3" colspan="3">DEDUCTIONS</th>
                            </tr>
							<tr>
								<th class="text-right">Employee</th>
                                <th class="text-right">Employer</th>
								<th class="text-right">Total</th>
							</tr>
                        </thead>
                        <tbody>
                        </tbody>
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
  
  <script>
	$(document).ready(function () {
		$('#companySelect, #year, #month').change(function (e) { 
			e.preventDefault();
			empPaySlips();
		});
		empPaySlips();

	});




    // employee payslips
    function empPaySlips(){
        var company   		=   $("#companySelect").val();
        var year            =   $('#year').val();
        var month           =   $('#month').val();
        $.ajax({
            type: "post",
            url: "<?php echo base_url();?>"+"deduction/get_deduction",
            data: {
                company : company,
                year    : year,
                month   : month,
            },
            dataType: "json",
            success: function (response) {
                $('#payroll_details tbody').empty();
                var content = '';
				var empDeduction = 0;
				var emprDeduction = 0;
				var totalDeduction = 0;

                $.each(response, function (i, v) { 
                   
                    var vacation    = 0;
                    // calculations
                    $cpp = parseFloat(v.empYtd.govt_pen);
                    $ei  = parseFloat(v.empYtd.eicount) * 1.4;
					empDeduction 	=  parseFloat(v.empYtd.govt_pen) + parseFloat(v.empYtd.fedl)  + parseFloat(v.empYtd.eicount);
					emprDeduction 	=  $cpp + parseFloat(v.empYtd.fedl)  + $ei;
					totalDeduction  = empDeduction + emprDeduction;
									
					if (v.is_mail_sent == 1) {
						sent 	= '<i class="fa fa-check text-success" aria-hidden="true"></i>';
					}
                    content += '<tr>';
                    content += '<td>'+ (i+1) +'</td>';
                    content += '<td>'+ v.empid +'</td>';
                    content += '<td>'+ v.first_name +'</td>';
                    content += '<td>'+ v.last_name +'</td>';
                    content += '<td class="text-right">'+ empDeduction.toFixed(2) +'</td>';
                    content += '<td class="text-right">'+ emprDeduction.toFixed(2) +'</td>';  
					content += '<td class="text-right">'+ totalDeduction.toFixed(2) +'</td>';
                    content += '<tr>';
                });
                $('#payroll_details tbody').append(content);
            }
        });
    }



    $('.export-btn').click(function (e) { 
        e.preventDefault();
		var company   		=   $("#companySelect").val();
        var year            =   $('#year').val();
        var month           =   $('#month').val();
        window.location.href = '<?php echo base_url('export-deductions?company=') ?>'+company+'&year='+year+'&month='+month;
    });

  </script>
</body>
</html>
