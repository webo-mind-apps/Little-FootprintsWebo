<html lang="en">
<head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Little Footprints Academy</title>
      <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
      <link href="<?php echo base_url()?>my_assets/global_assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
      <link href="<?php echo base_url()?>my_assets/global_assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
      <link href="<?php echo base_url()?>my_assets/global_assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
      <link href="<?php echo base_url()?>my_assets/global_assets/css/components.min.css" rel="stylesheet" type="text/css">
      <link href="<?php echo base_url()?>my_assets/global_assets/css/colors.min.css" rel="stylesheet" type="text/css">
      <link href="<?php echo base_url()?>my_assets/assets/css/layout.min.css" rel="stylesheet" type="text/css">
      <!-- /global stylesheets -->
      <!-- Core JS files -->
      <script src="<?php echo base_url()?>my_assets/global_assets/js/main/jquery.min.js"></script>
      <script src="<?php echo base_url()?>my_assets/global_assets/js/jquery-ui/jquery-ui.min.js"></script>
      <script src="<?php echo base_url()?>my_assets/global_assets/js/main/bootstrap.bundle.min.js"></script>
      <script src="<?php echo base_url()?>my_assets/global_assets/js/plugins/loaders/blockui.min.js"></script>
      <!-- /core JS files --
          Theme JS files -->
      <script src="<?php echo base_url()?>my_assets/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
      <script src="<?php echo base_url()?>my_assets/global_assets/js/plugins/tables/datatables/extensions/responsive.min.js"></script>
      <script src="<?php echo base_url()?>my_assets/global_assets/js/plugins/forms/selects/select2.min.js"></script>
      <script src="<?php echo base_url()?>my_assets/global_assets/js/app.js"></script>
      <script src="<?php echo base_url()?>my_assets/global_assets/js/demo_pages/datatables_advanced.js"></script>
      <!-- /theme JS files -->
      <!-- Theme JS files -->
      <script src="<?php echo base_url()?>my_assets/global_assets/js/plugins/forms/styling/uniform.min.js"></script>
      <script src="<?php echo base_url()?>my_assets/global_assets/js/demo_pages/form_layouts.js"></script>
      <!-- /theme JS files -->
      <script src="<?php echo base_url()?>my_assets/global_assets/js/plugins/forms/styling/switchery.min.js"></script>
      <script src="<?php echo base_url()?>my_assets/global_assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
      <script src="<?php echo base_url()?>my_assets/global_assets/js/plugins/ui/moment/moment.min.js"></script>
      <script src="<?php echo base_url()?>my_assets/global_assets/js/plugins/pickers/daterangepicker.js"></script>
      <script src="<?php echo base_url()?>my_assets/global_assets/js/demo_pages/dashboard.js"></script>
      <script src="<?php echo base_url()?>my_assets/global_assets/js/demo_pages/datatables_responsive.js"></script>
      <!-- /theme JS files -->  
      <script src="<?php echo base_url()?>my_assets/global_assets/js/plugins/visualization/d3/d3.min.js"></script>
      <script src="<?php echo base_url()?>my_assets/global_assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
      <!-- /Core JS files -->
      <script src='<?php echo base_url()?>my_assets/global_assets/bootbox/bootbox.min.js'></script>
      <style>
         td{font-size:13px;}
		 .dataTable th{font-size: 13px;}
		 .dataTable tr.child .dtr-title {width:20%;}
         .mr15{margin-right:15px}
         .dropdown-menu.show { display: block; max-height: 250px; overflow-y: auto; }
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
               <div class="card">
                  <div class="card-header header-elements-inline" style="justify-content:flex-start">
                        <span class="card-title payslip_heading mr15" >Summarized Reports</span>
                        <div class="dropdown">
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown" style="border-color: transparent;">
                                <?php echo (!empty($this->input->get('year')))? $this->input->get('year') : date('Y') ?>
                            </button>
                            <div class="dropdown-menu">
                               <?php
                                for ($i= 1; $i < 51; $i++) { 
                                    if((2017 + $i) > date('Y')){
                                        echo '<a class="dropdown-item disabled" href="#!">'.(2017 + $i).'</a>';
                                    }else{
                                        echo '<a class="dropdown-item"  href="'.base_url().'summarized-report?year='.(2017 + $i).'">'.(2017 + $i).'</a>';
                                    }
                                }
                               ?>
                            </div>
                        </div> 
                     
                  </div>
                  <div id="insert-status"></div>
                  <form method="post" id="frm" 
                     action="<?php echo base_url();?>main/employee_details_fetch_for_update">
                     <table class="table datatable-responsive dataTable no-footer dtr-inline ">
                        <thead>
                           <tr>
                              <th>S.no</th>
                              <th>EmpId</th>
                              <th>First Name</th>
                              <th>Last Name</th>
                              <th class="text-right">Govt Pen</th>
                              <th class="text-right">Fedl Tax</th>
                              <th class="text-right">EI Count</th>
                              <th class="text-right">Vacation Rate</th>
                              <th class="text-right">Medical</th>
                              <th class="text-right">Net Pay</th>
                              <th>Action</th>
                        </thead>
                        <tbody>
                             <?php
                                $year = $this->input->get('year');
                                if(!empty($emp)){
                                foreach ($emp as $key => $value) { 
                                    $netPay =($value->ytds['govt_pen'] + $value->ytds['fedl']+ $value->ytds['eicount']+ $value->ytds['medical']);
                                ?>
                                    <tr>
                                        <td><?php echo $key+1 ?></td>
                                        <td><?php echo $value->emp_id ?></td>
                                        <td><?php echo $value->first_name ?></td>
                                        <td><?php echo $value->last_name ?></td>
                                        <td class="text-right"><?php echo  (!empty($value->ytds['govt_pen'])) ?  number_format(round($value->ytds['govt_pen'], 2), 2) : '0' ?></td>
                                        <td class="text-right"><?php echo  (!empty($value->ytds['fedl'])) ?      number_format(round($value->ytds['fedl'], 2), 2) : '0' ?></td>
                                        <td class="text-right"><?php echo  (!empty($value->ytds['eicount'])) ?   number_format(round($value->ytds['eicount'], 2), 2) : '0' ?></td>
                                        <td class="text-right"><?php echo  (!empty($value->ytds['vacation'])) ?  number_format(round($value->ytds['vacation'], 2), 2) : '0' ?></td>
                                        <td class="text-right"><?php echo  (!empty($value->ytds['medical'])) ?   number_format(round($value->ytds['medical'], 2), 2) : '0' ?></td>
                                        <td class="text-right"><?php echo  number_format(round($netPay, 2), 2) ?></td>
                                        <td>
                                            <a target="_blank" href="<?php echo base_url('summarized-report/').$value->emp_id.'?year='.$year ?>"><i class="icon-file-download2 ml-2"></i></a>
                                        </td>
                                    </tr>
                            <?php    }  }?> 
                        </tbody>
                     </table>
                  </form>
               </div>
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