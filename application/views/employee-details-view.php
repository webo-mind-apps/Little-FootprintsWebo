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
         <!-- Theme JS files -->
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
                  <div class="card-header header-elements-inline">
                     <h6 class="card-title payslip_heading">Employee table</h6>
                     <div class="header-elements">
                        <div class="list-icons">
                           
                           <a class="list-icons-item" data-action="reload"></a>
                           
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
                              <th>Edit&nbsp&nbsp&nbspDelete </th>
                              <th>EmpId</th>
                              <th>Firstname</th>
                              <th>Lastname</th>
                              <th>Empsin</th>
                              <th>Dob</th>
                              <th>phone.No</th>
                              <th>E-mail</th>
                              <th>Address1</th>
                              <th>Address2</th>
                              <th>City</th>
                              <th>Pincode</th>
                              <th>Hire date</th>
                              <th>Rehire date</th>
                              <th>Empcert</th>
                              <th>Hour rate</th>
                              <th>Position</th>
                              <th>Medical</th>
                              <th>Vocation_rate</th>
                              <th>Status</th>
                              <th></th>
                        </thead>
                        <tbody>
                           <?php
                              $i=1;
                              foreach($employee_detail_fetch as $row)
                              {
                              	
                              ?>
                           <tr>
                              <td><?php echo $i;?></td>
                              <td><a href="<?php echo base_url();?>main/employee_details_fetch_for_update/<?php echo $row['id'];?>"><span  class='edit'  id='edit-<?php echo $row['id'];?>'><i style='color:green' class='icon-pencil' ></i></span></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                 <span  class='del' id='delete-<?php echo $row['id'];?>'><i style='color:red' class='icon-trash'></i></span>
                              </td>
                              <td><?php echo $row['emp_id'];?></td>
                              <td><?php echo $row['first_name'];?></td>
                              <td><?php echo $row['last_name'];?></td>
                              <td><?php echo $row['empsin'];?></td>
                              <td><?php echo $row['dob'];?></td>
                              <td><?php echo $row['phone'];?></td>
                              <td><?php echo $row['email'];?></td>
                              <td><?php echo $row['address1'];?></td>
                              <td><?php echo $row['address2'];?></td>
                              <td><?php echo $row['city'];?></td>
                              <td><?php echo $row['pincode'];?></td>
                              <td><?php echo $row['hire_date'];?></td>
                              <td><?php echo $row['rehire_date'];?></td>
                              <td><?php echo $row['empcert'];?></td>
                              <td><?php echo $row['hour_rate'];?></td>
                              <td><?php echo $row['position'];?></td>
                              <td><?php echo $row['medical'];?></td>
                              <td><?php echo $row['vocation_rate'];?></td>
                              <td><?php echo $row['status'];?></td>
                              <td></td>
                           </tr>
                           <?php
                              $i++;
                              }
                              
                              ?>
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
      <script>
         $('.edit').css('cursor', 'pointer');
           $('.del').css('cursor', 'pointer');
         <!-- delete -->   
              $(document).on('click', '.del',function(){
              			var del=$(this);
              			var id1 = $(this).attr('id');
              			var delete_id=id1.split("-");
              bootbox.confirm("Do you really want to delete record?", function(result) {
              
              			if(result){
              			jQuery.ajax({
              				url:"<?php echo base_url();?>main/employee_details_delete",
              				type:"POST",	
              				data:{id:delete_id[1]},
              				success:function(data){
              						
              				del.closest("tr").hide();
              	
              				}
              			 });	
              			}
              			else{
              				
              				bootbox.alert('Record not deleted.');
              			}
              			 });
              });	
      </script>
   </body>
</html>