
<style>
	.main-nave{background-color:#2e3951}
	.navbar-brand img {
    height: 25px;
    display: block;
}
.navbar-brand img {
    height: 25px;
    display: inline-block;
    top: -5px;
    position: relative;
}
</style>
<!-- Main navbar -->
	<div class="navbar navbar-expand-md navbar-dark main-nave">
		<div class="navbar-brand wmin-200">
			<a href="index.html" class="d-inline-block">
				<img src="<?php echo base_url();?>my_assets/global_assets/images/webo.png" />
				<span style="color:#fff;z-index: 999999;
    font-size: 12px;">Webomindapps Payroll Software</span>
			</a>
		</div>

		<div class="d-md-none">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
				<i class="icon-tree5"></i>
			</button>
			<button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
				<i class="icon-paragraph-justify3"></i>
			</button>
		</div>

		<div class="collapse navbar-collapse" id="navbar-mobile">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
						<i class="icon-paragraph-justify3"></i>
					</a>
				</li>
			</ul>

			<span class="navbar-text ml-md-auto mr-md-3">
				
			</span>

			<ul class="navbar-nav">
				
				<li class="nav-item dropdown dropdown-user">
					<a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
						
						<span>Admin</span>
					</a>

					<div class="dropdown-menu dropdown-menu-right">
						
						<a href="<?php echo base_url(); ?>home/logout" class="dropdown-item"><i class="icon-switch2"></i> Logout</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->