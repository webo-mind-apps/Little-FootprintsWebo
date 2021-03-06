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
               <div class="row">
                  <div class="col-md-6">
                     <div class="card">
                        <div class="card-header header-elements-inline">
                           <h6 class="card-title payslip_heading">Center Master </h6>
                           <div class="header-elements">
                              <div class="list-icons">
                                 <a class="list-icons-item" data-action="reload"></a>
                              </div>
                           </div>
                        </div>
                        <?php
                           if($this->session->flashdata('insert','success')){
                              ?> 
                        <div class="alert bg-success alert-styled-left">
                           <button type="button" class="close" data-dismiss="alert">&times;</button>
                           <span class="text-semibold">Inserts are saved successfully..!</span>
                        </div>
                        <?php 
                           }
                            	    ?>	
                        <?php
                           if($this->session->flashdata('update','success')){
                              ?> 
                        <div class="alert bg-success alert-styled-left">
                           <button type="button" class="close" data-dismiss="alert">&times;</button>
                           <span class="text-semibold">Updates are saved successfully..!</span>
                        </div>
                        <?php 
                           }
                            	    ?>	
                        <form method="post" id="frm" 
                           action="<?php echo base_url();?>main/center_master_insert_update">
                           <div class="card-body">
                              <div class="form-group">
                                 <label>Select Company</label>
                                 <div class="input-group">
                                 <select name="company_name" id="company-name" class="form-control" required>
                                       <option value="">Select</option>
                                       <?php
                                          $i=1;
                                          foreach($comapny_fetch as $row)
                                          {
                                          	
                                          ?>
                                       <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                                       <?php
                                           $i++;
                                          }
                                          ?>
                                    </select>
                                 </div>
                              </div>
                             
                              <div class="form-group">
                                 <label>Center Name</label>
                                 <div class="input-group">
                                    <input type="text" id="center-name"   class="form-control" placeholder="Center Name" name="center_name" onkeydown="return isalpha();"  required>
                                 </div>
                              </div>
                             
                              <input type="hidden" id="emp-id" name="emp_id">
                              <div class="text-right" style="display:block;" id="insert-activate">
                                 <button  type="submit" id="insert-button" name="insert_button" class="insert btn btn-primary" onclick="">Submit<i class="icon-paperplane ml-2"></i></button>
                              </div>
                              <div class="text-right" style="display:none;" id="update-activate">
                                 <button  type="submit" id="update-button" name="update_button" class="update btn btn-primary">Edit<i class="icon-paperplane ml-2"></i></button>
                              </div>
                        </form>
                        </div>
                        <!-- /card body --> 
                     </div>
                     <!-- /card area -->
                  </div>
               </div>

               <div class="row">
                  <div class="col-md-8">
               <div class="card">
                  <table class="table datatable-responsive dataTable no-footer dtr-inline ">
                     <thead>
                        <tr>
                           <th>S.no</th>
                           <th>Edit</th>
                           <th>Delete</th>
                           <th>Company Name</th>
                           <th>Center Name</th>
                           <th></th>
                           
                     </thead>
                     <tbody>
                        <?php
                           $i=1;
                           foreach($center_fetch as $row)
                           {
                             
                           ?>
                        <tr>
                           <td><?php echo $i;?></td>
                           <td><a href="<?php echo base_url();?>main/center_master_fetch_for_update/<?php echo $row['id'];?>"><span  class='edit'  id='edit-<?php echo $row['id'];?>'><i style='color:green' class='icon-pencil' ></i></span></a></td>

                           <td>   <span  class='del'  id='delete-<?php echo $row['id'];?>'><i style='color:red' class='icon-trash'></i></span>
                           </td>
                           <td><?php echo $row['name'];?></td>
                           <td><?php echo $row['center_name'];?></td>
                          <td></td>
                        </tr>
                        <?php
                           $i++;
                           }
                    
                           ?>
                     </tbody>
                  </table>
                  </div>
               </div>
               </div>
            </div>
            <?php
               if(isset($center_master_fetch_for_update))
               {
               				foreach($center_master_fetch_for_update as $row)
               				{
               					$id=$row['id'];
                                $company_name= $row['company_name'];
                                $center_name= $row['center_name'];
                               }
                               
               				?>
            <script>
               $('#insert-activate').css("display","none");
               $('#update-activate').css("display","block");
               $("#emp-id").val("<?php echo $id;?>");
                $("#company-name").val("<?php echo $company_name;?>");
                $("#center-name").val("<?php echo $center_name; ?>");
               
            </script>
            <?php				
               }				
               ?>
            <!-- Footer -->
            <?php $this->load->view('includes/main_footer') ?>
            <!-- /footer --> 
         </div>
         <!-- /content wrapper --> 
      </div>
      <!-- /page content -->
      <script>
        
        function isalpha(evt) {
               	evt = (evt) ? evt : window.event;
               	var charCode = (evt.which) ? evt.which : evt.keyCode;
               	if (charCode == 32) {
               		return true;
               	} else if (charCode > 31 && (charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122) || charCode == 13) {
               		return false;
               	}
               }


           $('.del').css('cursor', 'pointer');
         <!-- delete -->   
              $(document).on('click', '.del',function(){
              			var del=$(this);
              			var id1 = $(this).attr('id');
              			var delete_id=id1.split("-");
              bootbox.confirm("Do you really want to delete record?", function(result) {
              
              			if(result){
              			jQuery.ajax({
              				url:"<?php echo base_url();?>main/center_master_delete",
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


              var position="<?php echo $company_name; ?>"
                  	$("#position").val(position);
               $(".select select option").filter(function() {
               return $(this).text() == position;
               }).prop('selected', true);
         
      </script>
   </body>
</html>