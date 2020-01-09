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
	<script src="<?php echo base_url();?>my_assets/assets/js/app.js"></script>
	<!-- /theme JS files --> 
	<style type="text/css">
		.payslip_heading{
			font-weight:bold;
			font-size:13px;
		}
		.earnings_padding{
			 padding-top:15px;
		}

	</style>
</head>

<body> 

	<!-- Main navbar -->
	  <?php $this->load->view('includes/main_nav_bar')?>
	<!-- /main navbar -->


	<!-- Page content -->
	<div class="page-content"> 

<!---- Main sidebar ------------------------------------------>
		 <?php $this->load->view('includes/main_side_bar')?>
<!---- /main sidebar ----------------------------------------->


		<!-- Main content -->
		<div class="content-wrapper"> 
			<!-- Content area -->
			<div class="content">  

		<!-- Multiple row inputs (horizontal) -->
	            <div class="card" >
					<div class="card-header header-elements-inline">
						<h6 class="card-title" style="font-weight:bold;font-size:14px;">EMPLOYESS PAYROLL</h6> 
						<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                		<a class="list-icons-item" data-action="reload"></a>
		                		<a class="list-icons-item" data-action="remove"></a>
		                	</div>
	                	</div>
					</div>

					<div class="col-md-2" style="margin-left:10px;" >
						PAYMENT DATE:<input type="text" name="payment_date required">
						PAY END DATE:<input type="text" name="payment_end_date required">
					</div>
					
	                <div class="card-body">
	                  <form action="#"> 
                		<div class="form-group row"> 
							<div class="col-lg-12">
								<div class="row">
									<div class="col-md-2" >
										<div class="form-group payslip_heading">
			                                <th>EARNINGS</th>
		                                </div> 
									</div>
									<div class="col-md-2">
										<div class="form-group payslip_heading">
			                                <th>RATE</th>
		                                </div> 
									</div> 
									<div class="col-md-2">
										<div class="form-group payslip_heading">
			                                <th>CURRENT HRS/UNITS</th>
		                                </div> 
									</div>
									<div class="col-md-2">
										<div class="form-group payslip_heading">
			                                <th>CURRENT AMOUNT</th>
		                                </div> 
									</div>
									<div class="col-md-2">
										<div class="form-group payslip_heading">
			                                <th>YTD HRS/UNITS</th>
		                                </div> 
									</div>
									<div class="col-md-2">
										<div class="form-group payslip_heading">
			                                <th>YTD AMOUNT</th>
		                                </div> 
									</div>
								</div>
							</div>
						</div> 

						<div class="form-group row"> 
							<div class="col-lg-12">
								<div class="row">
									<div class="col-md-2 earnings_padding">
										<div class="form-group ">
			                                <th >REGULAR</th>
		                                </div> 
									</div>
									<div class="col-md-2">
										<div class="form-group">
			                                <input type="text" class="form-control" placeholder="Rate">
		                                </div> 
									</div>
									
									<div class="col-md-2">
										<div class="form-group">
			                            <input type="text" class="form-control" placeholder="Current HRS/Units">
		                                </div> 
									</div>
                                    
                                    <div class="col-md-2">
										<div class="form-group">
			                            <input type="text" class="form-control" placeholder="$">
		                                </div> 
									</div> 

                                    <div class="col-md-2">
										<div class="form-group">
			                                <input type="text" class="form-control" placeholder="YTD HRS/Units">
		                                </div> 
									</div> 

									<div class="col-md-2">
										<div class="form-group">
			                            <input type="text" class="form-control" placeholder="$">
		                                </div> 
									</div>
								</div>
							</div>
						</div> 

						<div class="form-group row"> 
							<div class="col-lg-12">
								<div class="row">
									<div class="col-md-2">
										<div class="form-group earnings_padding">
			                                <th >STAT HOL</th>
		                                </div> 
									</div>
									<div class="col-md-2">
										<div class="form-group">
			                                <input type="text" class="form-control" placeholder="Rate">
		                                </div> 
									</div>
									
									<div class="col-md-2">
										<div class="form-group">
			                                <input type="text" class="form-control" placeholder="Current HRS/Units">
		                                </div> 
									</div>
                                    
                                    <div class="col-md-2">
										<div class="form-group">
			                            <input type="text" class="form-control" placeholder="$">
		                                </div> 
									</div> 

                                    <div class="col-md-2">
										<div class="form-group">
			                                <input type="text" class="form-control" placeholder="YTD HRS/Units">
		                                </div> 
									</div> 

									<div class="col-md-2">
										<div class="form-group">
			                            <input type="text" class="form-control" placeholder="$">
		                                </div> 
									</div> 
								</div>
							</div>
						</div>

						<div class="form-group row"> 
							<div class="col-lg-12">
								<div class="row">
									<div class="col-md-2">
										<div class="form-group earnings_padding">
			                                <th >WAGE BC</th>
		                                </div> 
									</div>
									<div class="col-md-2">
										 
										<div class="form-group">
			                                <input type="text" class="form-control" placeholder="Rate">
		                                </div> 
									</div>
									
									<div class="col-md-2">
										<div class="form-group">
			                                <input type="text" class="form-control" placeholder="Current HRS/Units">
		                                </div> 
									</div>
                                    
                                    <div class="col-md-2">
										<div class="form-group">
			                            <input type="text" class="form-control" placeholder="$">
		                                </div> 
									</div> 

                                    <div class="col-md-2">
										<div class="form-group">
			                                <input type="text" class="form-control" placeholder="YTD HRS/Units">
		                                </div> 
									</div> 

									<div class="col-md-2">
										<div class="form-group">
			                            <input type="text" class="form-control" placeholder="$">
		                                </div> 
									</div> 
								</div>
							</div>
						</div>

						<div class="form-group row"> 
							<div class="col-lg-12">
								<div class="row">
									<div class="col-md-2">
										<div class="form-group earnings_padding">
			                                <th >TOTAL EARNINGS</th>
		                                </div> 
									</div>
									<div class="col-md-2">
										<div class="form-group">
			                                <input type="text" class="form-control" placeholder="Rate">
		                                </div> 
									</div>
									
									<div class="col-md-2">
										<div class="form-group">
			                                <input type="text" class="form-control" placeholder="Current HRS/Units">
		                                </div> 
									</div>

									<div class="col-md-2">
										<div class="form-group">
			                            <input type="text" class="form-control" placeholder="$">
		                                </div> 
									</div> 
                                    
                                    <div class="col-md-2">
										<div class="form-group">
			                                <input type="text" class="form-control" placeholder="YTD HRS/Units">
		                                </div> 
									</div> 

									<div class="col-md-2">
										<div class="form-group">
			                            <input type="text" class="form-control" placeholder="$">
		                                </div> 
									</div> 
								</div>
							</div>
						</div> 

						<div class="form-group row"> 
							<div class="col-lg-12">
								<div class="row">
									<div class="col-md-2" >
										<div class="form-group payslip_heading">
			                                <th>DEDUCTIONS</th>
		                                </div> 
									</div>
									<div class="col-md-2">
										<div class="form-group payslip_heading">
			                                <th>CURRENT AMOUNT</th>
		                                </div> 
									</div> 
									<div class="col-md-2">
										<div class="form-group payslip_heading">
			                                <th>YTD AMOUNT</th>
		                                </div> 
									</div>
									<div class="col-md-2">
										<div class="form-group payslip_heading">
			                                <th>DEDUCTIONS</th>
		                                </div> 
									</div>
									<div class="col-md-2">
										<div class="form-group payslip_heading">
			                                <th>CURRENT AMOUNT</th>
		                                </div> 
									</div>
									<div class="col-md-2">
										<div class="form-group payslip_heading">
			                                <th>YTD AMOUNT</th>
		                                </div> 
									</div>
								</div>
							</div>
						</div> 

						<div class="form-group row"> 
							<div class="col-lg-12">
								<div class="row">
									<div class="col-md-2">
										<div class="form-group earnings_padding earnings_padding">
			                                <th>GOVT PEN</th>
		                                </div> 
									</div>
									<div class="col-md-2">
										<div class="form-group">
			                                <input type="text" class="form-control" placeholder="Current Amount">
		                                </div> 
									</div>
									
									<div class="col-md-2">
										<div class="form-group">
			                                <input type="text" class="form-control" placeholder="$">
		                                </div> 
									</div>

									<div class="col-md-2">
										<div class="form-group earnings_padding"> 
			                                <th>EI CONT</th>  
		                                </div> 
									</div> 
                                    
                                    <div class="col-md-2">
										<div class="form-group">
			                                <input type="text" class="form-control" placeholder="Current Amount">
		                                </div> 
									</div> 

									<div class="col-md-2">
										<div class="form-group">
			                            <input type="text" class="form-control" placeholder="$">
		                                </div> 
									</div> 
								</div>
							</div>
						</div> 

						<div class="form-group row"> 
							<div class="col-lg-12">
								<div class="row">
									<div class="col-md-2">
										<div class="form-group earnings_padding">
			                                <th>FEDL TAX</th>
		                                </div> 
									</div>
									<div class="col-md-2">
										<div class="form-group">
			                                <input type="text" class="form-control" placeholder="Current Amount">
		                                </div> 
									</div>
									
									<div class="col-md-2">
										<div class="form-group">
			                                <input type="text" class="form-control" placeholder="$">
		                                </div> 
									</div>

									<div class="col-md-2">
										<div class="form-group earnings_padding">
			                                <th>MEDICAL</th>
		                                </div> 
									</div>
                                    
                                    <div class="col-md-2">
										<div class="form-group">
			                                <input type="text" class="form-control" placeholder="Current Amount">
		                                </div> 
									</div> 

									<div class="col-md-2">
										<div class="form-group">
			                            <input type="text" class="form-control" placeholder="$">
		                                </div> 
									</div> 
								</div>
							</div>
						</div>
                        <div class="text-right">
                        	<button type="submit" class="btn btn-primary">Generate<i class="icon-paperplane ml-2"></i></button>
                        </div>
                      </form>
				    </div>
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
