<!---- Main sidebar ------------------------------------------>
<style>
	.dashboard-logo{background-image:url("<?php echo base_url();?>my_assets/global_assets/images/bg1.jpg");}
	.text-shadow-dark {color:#000;}
	.sidebar-user-material .sidebar-user-material-body 
	{
    background-size: cover;
    height: 180px;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<div class="sidebar sidebar-light sidebar-main sidebar-expand-md">

			<!-- Sidebar mobile toggler -->
			<div class="sidebar-mobile-toggler text-center">
				<a href="#" class="sidebar-mobile-main-toggle">
					<i class="icon-arrow-left8"></i>
				</a>
				Navigation
				<a href="#" class="sidebar-mobile-expand">
					<i class="icon-screen-full"></i>
					<i class="icon-screen-normal"></i>
				</a>
			</div>
			<!-- /sidebar mobile toggler -->


			<!-- Sidebar content -->
			<div class="sidebar-content">

				<!-- User menu -->
				<div class="sidebar-user-material dashboard-logo">
					<div class="sidebar-user-material-body">
						<div class="card-body text-center">
							<a href="#">
								<img src="<?php echo base_url();?>my_assets/global_assets/images/foot-print-logo.png" class="img-fluid   mb-3" width="60%" style="padding-top: 8%;" alt="">
							</a>
							<h6 class="mb-0 ">Admin</h6>
							<span class="font-size-sm ">Canada</span>
						</div>
													
						
					</div>

					
				</div>
				<!-- /user menu -->


				<!-- Main navigation -->
				<div class="card card-sidebar-mobile ">
					<ul class="nav nav-sidebar" data-nav-type="accordion">

						<!-- Main -->
						
						<li class="nav-item">
							<a href="<?php echo base_url();?>main/dashboard/#dashboard" class="nav-link">
								<i class="icon-home4"></i>
								<span>
									Dashboard
								</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url();?>main/index/#employee-master" class="nav-link">
								<i class="icon-users"></i>
								<span>
								 Employee Master
								</span>
							</a>
						</li>
						<li class="nav-item nav-item-submenu">
								<a href="" class="nav-link"><i class="fa fa-cogs"></i> <span>Master</span></a>

								<ul class="nav nav-group-sub" data-submenu-title="Layouts">
									<li class="nav-item"><a href="<?php echo base_url();?>main/government_pension/#government-pension" class="nav-link">Government Pension</a></li>
									<li class="nav-item"><a href="<?php echo base_url();?>main/federal_tax/#federal-tax" class="nav-link">Federal Tax</a></li>
									<li class="nav-item"><a href="<?php echo base_url();?>main/ei_contribution/#ei-contribution" class="nav-link">Ei Contribution</a></li>
									<li class="nav-item"><a href="<?php echo base_url();?>main/company_master/#company-master" class="nav-link">Company Master</a></li>
									<li class="nav-item"><a href="<?php echo base_url();?>main/center_master/#center-master" class="nav-link">Center Master</a></li>
									<li class="nav-item"><a href="<?php echo base_url();?>main/reason" class="nav-link">Reason For Leaving</a></li>
									
								</ul>
							</li>

						<li class="nav-item">
							<a href="<?php echo base_url('payroll') ?>" class="nav-link">
								<i class="fa fa-usd" style="font-size:18px;"></i>
								<span>
									Payroll
								</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url('send-pay-stub') ?>" class="nav-link">
								<i class="fa fa-envelope-o" style="font-size:18px;"></i>
								<span>
									Mail Pay Stub
								</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url('net-pay-report') ?>" class="nav-link">
							<i class="fa fa-money" aria-hidden="true" style="font-size:18px;"></i>
								<span>
									Net Pay Report
								</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url('summarized-report?year=').date('Y') ?>" class="nav-link">
								<i class="fa fa-file-text-o" style="font-size:18px;"></i>
								<span>
									T4
								</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url() ?>deduction-report" class="nav-link">
								<i class="fa  fa-scissors" style="font-size:18px;"></i>
								<span>
									Deduction Report
								</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url() ?>reo" class="nav-link">
								<i class="fa fa-user" style="font-size:18px;"></i>
								<span>
									Record of Employment
								</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url() ?>backup" class="nav-link">
								<i class="fa fa-hdd-o" style="font-size:18px;"></i>
								<span>
									Backup
								</span>
							</a>
						</li>
						<!-- <li class="nav-item">
							<a href="" class="nav-link">
								<i class="icon-gear" style="font-size:18px;"></i>
								<span>
									Settings
								</span>
							</a>
						</li> -->
						<!-- /page kits -->
					</ul>
				</div>
				<!-- /main navigation -->
			</div>
			<!-- /sidebar content -->
		</div>
<!---- /main sidebar ----------------------------------------->
