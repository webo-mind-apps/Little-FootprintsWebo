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
      <script src="<?php echo base_url()?>my_assets/global_assets/js/plugins/forms/selects/select2.min.js"></script>
      <script src="<?php echo base_url()?>my_assets/global_assets/js/main/bootstrap.bundle.min.js"></script>
      <script src="<?php echo base_url()?>my_assets/global_assets/js/plugins/loaders/blockui.min.js"></script>
      <!-- /core JS files --
         <!-- Theme JS files -->
      <script src="<?php echo base_url()?>my_assets/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
      <script src="<?php echo base_url()?>my_assets/global_assets/js/plugins/tables/datatables/extensions/responsive.min.js"></script>
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
                     <h6 class="card-title payslip_heading">Employee master<br><br>
					 <a href="<?php echo base_url();?>main/employee_details_fetch/#search" style="background-color:#3b579d;padding:10px;color:#fff;"><i class="fa fa-search"></i>  Search</a></h6>
                     <div class="header-elements">
                        <div class="list-icons">
                           
                           <a class="list-icons-item" data-action="reload"></a>
                           
                        </div>
                     </div>
                  </div>
                  <?php

                           if($this->session->flashdata('insert','Inserted successfully')){
                              ?> 
                        <div class="alert bg-success alert-styled-left">
                           <button type="button" class="close" data-dismiss="alert">&times;</button>
                           <span class="text-semibold">Inserts are saved successfully..!</span>
                        </div>
                        <?php 
                           }
                            	    ?>	
                        <?php
                           if($this->session->flashdata('update','Updated successfully')){
                              ?> 
                        <div class="alert bg-success alert-styled-left">
                           <button type="button" class="close" data-dismiss="alert">&times;</button>
                           <span class="text-semibold">Updates are saved successfully..!</span>
                        </div>
                        <?php 
                           }
                            	    ?>
                  <form method="post" id="frm" 
                     action="<?php echo base_url();?>main/employee_details_insert_update">
                     <div class="card-body">
                     <div class="row">
                           <div class="col-sm-5" >
                              <div class="form-group">
                                 <label>Company Name</label>
                                 <div class="input-group">
                                 <select name="company_name" id="company-name" class="form-control" onchange="center_select_feild();" required>
                                       <option value="">Select</option>
                                       <?php
                                          $companys = '';
                                          if(!empty($employee_detail_fetch[0]['company'])){
                                             $companys = $employee_detail_fetch[0]['company'];
                                          }
                                          foreach($comapny_fetch as $row)
                                          {
                                       ?>
                                          <option <?php echo ($companys == $row['id'])? 'selected' : '' ?> value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                                       <?php
                                          }
                                       ?>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div class="col-sm-1" ></div>
                           <div class="col-sm-5" >
                              <div class="form-group">
                                 <label>Select Center</label>
                                 <div class="input-group">
                                 <select name="center[]"  id="center-name" class="form-control" required>
                                      
                                 </select>  
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-5" >
                              <div class="form-group">
                                 <label>First name</label>
                                 <div class="input-group">
                                    <input type="text" id="first-name"  class="form-control" placeholder="First name" name="first_name" onkeydown="return isalpha();" maxlength="25" minlength="3" required>
                                 </div>
                              </div>
                           </div>
                           <div class="col-sm-1" ></div>
                           <div class="col-sm-5" >
                              <div class="form-group">
                                 <label>Last name</label>
                                 <div class="input-group">
                                    <input type="text" id="last-name" class="form-control" placeholder="Last name" name="last_name" onkeydown="return isalpha();" maxlength="25"  required>   
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-5" >
                              <div class="form-group">
                                 <label>Empsin</label>
                                 <div class="input-group">
                                    <input type="text" id="empsin1" class="form-control" placeholder="###" name="empsin1"  onkeyup="empsin_check();" maxlength="3" minlength="3" onkeydown="return isNumber();" required>	
                                    <input type="text" id="empsin2" class="form-control" placeholder="###" name="empsin2" maxlength="3" minlength="3" onkeyup="empsin_check();" onkeydown="return isNumber();" required>
                                    <input type="text" id="empsin3" class="form-control" placeholder="###" name="empsin3" maxlength="3" minlength="3" onkeydown="return isNumber();" required>
                                 </div>
                              </div>
                           </div>
                           <div class="col-sm-1" ></div>
                           <div class="col-sm-5" >
                              <div class="form-group">
                                 <label>Dob</label>
                                 <div class="input-group">
                                    <input type="text" id="dob" class="dateformat form-control" placeholder="Dob" name="dob" onkeydown="return isalpha();" onkeypress="return isNumber();" required>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-5" >
                              <div class="form-group">
                                 <label>Address1</label>
                                 <div class="input-group">
                                    <textarea  class="form-control" id="address1" name="address1" cols="45" rows="5" placeholder="Address1" required></textarea>
                                 </div>
                              </div>
                           </div>
                           <div class="col-sm-1" ></div>
                           <div class="col-sm-5" >
                              <div class="form-group">
                                 <label>Address2</label>
                                 <div class="input-group">
                                    <textarea  class="form-control" id="address2" name="address2" cols="45" rows="5" placeholder="Address2" ></textarea>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-5" >
                              <div class="form-group">
                                 <label>City</label>
                                 <div class="input-group">
                                    <input type="text" id="city" class="form-control" placeholder="City" name="city" onkeydown="return isalpha();" maxlength="25" minlenth="3" required>
                                 </div>
                              </div>
                           </div>
                           <div class="col-sm-1" ></div>
                           <div class="col-sm-5" >
                              <div class="form-group">
                                 <label>Pincode (format : L#L#L#)</label>
                                 <div class="input-group">
                                    <input type="text" id="pincode" class="form-control" placeholder="Pincode" name="pincode"  maxlength="6" minlenth="6" onfocusout="pincode_check();"  required>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <!-- <div class="col-sm-1" >
                              <div class="form-group">
                                 <label>Code</label>
                                 <div class="input-group">
                                    <input type="text" id="code" class="form-control" placeholder="+" name="code" maxlength="3" onkeydown="return isNumber();" required>
                                 </div> 
                              </div>
                           </div> -->
                           <div class="col-sm-5" >
                              <div class="form-group">
                                 <label>Phone.No</label>
                                 <div class="input-group">
                                    <input type="text" id="phone" class="form-control" placeholder="Phone.No" name="phone" maxlength="7" onkeydown="return isNumber();" minlength="7" required>
                                 </div>
                              </div>
                           </div>
                           <div class="col-sm-1" ></div>
                           <div class="col-sm-5" >
                              <div class="form-group">
                                 <label>E-mail Id</label>
                                 <div class="input-group">
                                    <input type="email" id="email" class="form-control" placeholder="E-mail Id" name="email" required>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-5" >
                              <div class="form-group">
                                 <label>Hire date</label>
                                 <div class="input-group">
                                    <input type="text" id="hire-date" class="dateformat form-control" placeholder="Hire date" name="hire_date" onkeydown="return isalpha();" onkeypress="return isNumber();"  required>
                                 </div>
                              </div>
                           </div>
                           <div class="col-sm-1" ></div>
                           <div class="col-sm-5" >
                              <div class="form-group">
                                 <label>Rehire date</label>
                                 <div class="input-group">
                                    <input type="text" id="rehire-date" class="dateformat form-control" placeholder="Rehire date" name="rehire_date" onkeydown="return isalpha();" onkeypress="return isNumber();"  format="" >
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-5" >
                              <div class="form-group">
                                 <label>Empcert</label>
                                 <div class="input-group">
                                    <select name="empcert" id="empcert" class="form-control" required>
                                       <option value="">Select</option>
                                       <option value="ECE-IT">ECE-IT</option>
                                       <option value="ECE">ECE</option>
                                       <option value="ECE-Asst">ECE-Asst</option>
                                       <option value="RA">RA</option>
                                       <option value="None">None</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div class="col-sm-1" ></div>
                           <div class="col-sm-5" >
                              <div class="form-group">
                                 <label>Hour rate</label>
                                 <div class="input-group">
                                    <input type="text" id="hour-rate" class="form-control" placeholder="Hour rate" name="hour_rate" onkeydown="return isNumber();" maxlength="3" required>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-5" >
                              <div class="form-group">
                                 <label>Position</label>
                                 <div class="input-group select">
                                    <select name="position" id="position" class="form-control" required>
                                       <option value="">Select</option>
                                       <?php
                                          $i=1;
                                          foreach($employee_position_fetch as $row)
                                          {
                                          	
                                          ?>
                                       <option value="<?php echo $i;?>"><?php echo $row['position'];?></option>
                                       <?php
                                          $i++;
                                          }
                                          
                                          
                                          ?>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div class="col-sm-1" ></div>
                           <div class="col-sm-5" >
                              <div class="form-group">
                                 <label>Medical</label>
                                 <div class="input-group">
                                    <input type="text" id="medical" class="form-control" placeholder="Medical" name="medical" maxlength="3" onkeydown="return isNumber();" required>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-5" >
                              <div class="form-group">
                                 <label>vacation rate (format : 0.0004)</label>
                                 <div class="input-group">
                                    <input type="text" id="vocation-rate" class="form-control" placeholder="Vocation rate" name="vocation_rate" maxlength="6" onfocusout="vocation_rate_check();" required>
                                 </div>
                              </div>
                           </div>
                           <div class="col-sm-1" ></div>
                           <div class="col-sm-5" >
                              <div class="form-group">
                                 <label>status</label>
                                 <div class="input-group">
                                    <select name="status" id="status" class="form-control" required>
                                       <option value="0">Active</option>
                                       <option value="1">In-active</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <input type="hidden" id="emp-id" name="emp_id">
                        <input type="hidden" name="employeeId" value="<?php echo (!empty($employee_detail_fetch[0]['emp_id'])? $employee_detail_fetch[0]['emp_id'] : '') ?>">
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
            <!-- /content area --> 
            <script>
                 $(document).ready(function () {
                  $('#center-name').select2({
                     placeholder: "Select  Centers",
                     multiple: true,
                  });
               });
            </script>
            <?php
            if(!empty($centers)){
               $centerslist =  json_encode($centers);
            }else{
               $centerslist =  json_encode(array());
            }
               if(isset($employee_detail_fetch))
               {
    
                  
               				foreach($employee_detail_fetch as $row)
               				{
               					$id=$row['id'];
               					$emp_id=$row['emp_id'];
               					$first_name=$row['first_name'];
               					$last_name=$row['last_name'];
               					$empsin=$row['empsin'];
               					$dob=$row['dob'];
               					$phone=$row['phone'];
               					$email=$row['email'];
               					$address1=$row['address1'];
               					$address2=$row['address2'];
               					$city=$row['city'];
               					$pincode=$row['pincode'];
               					$hire_date=$row['hire_date'];
               					$rehire_date=$row['rehire_date'];
               					$empcert=$row['empcert'];
               					$hour_rate=$row['hour_rate'];
               					$position=$row['position'];
               					$medical=$row['medical'];
               					$vocation_rate=$row['vocation_rate'];
               					$status=$row['status'];
               					
               				}
               				?>
            <script>

               
               $('#insert-activate').css("display","none");
               $('#update-activate').css("display","block");
                  	$("#first-name").val("<?php echo $first_name;?>");
               
                  	$("#last-name").val("<?php echo $last_name; ?>");
               
               $("#emp-id").val("<?php echo $id; ?>");
               var empsin_code="<?php echo $empsin; ?>"
                  	
               var empsin=empsin_code.split("-");
               $("#empsin1").val(empsin[0]);
               $("#empsin2").val(empsin[1]);
               $("#empsin3").val(empsin[2]);
               
                  	$("#dob").val("<?php echo $dob; ?>");
               var phone=<?php echo $phone; ?>;
               $("#phone").val(phone);
               
               
                  	$("#email").val("<?php echo $email; ?>");
               
                  	$("#address1").val("<?php echo $address1; ?>");
               
                  	$("#address2").val("<?php echo $address2; ?>");
               
                  	$("#city").val("<?php echo $city; ?>");
               
                  	$("#pincode").val("<?php echo $pincode; ?>");
               
               
               
                  	$("#hire-date").val("<?php echo $hire_date; ?>");
               
                  	$("#rehire-date").val("<?php echo $rehire_date; ?>");
               
                  	$("#empcert").val("<?php echo $empcert; ?>");
               
                  	$("#hour-rate").val("<?php echo $hour_rate; ?>");
               
               var position="<?php echo $position; ?>"
                  	$("#position").val(position);
               $(".select select option").filter(function() {
               return $(this).text() == position;
               }).prop('selected', true);
                  	$("#medical").val("<?php echo $medical; ?>");
               
                  	$("#vocation-rate").val("<?php echo $vocation_rate; ?>");
               
                  	$("#status").val("<?php echo $status; ?>");
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
         function pincode_check()
         {
                 var number=/[0-9]/;
                 var letter=/[a-zA-z]/;
                 
                 var pin=$('#pincode').val();
         	
         		
               	  if(!letter.test(pin[0]))
               	  {
               		  $('#pincode').val('');
               	  }
         	  
               	  if(!number.test(pin[1]))
               	  {
               		  $('#pincode').val('');
               	  }
         	  
               	  if(!letter.test(pin[2]))
               	  {
               		  $('#pincode').val('');
               	  }
         	  
               	  if(!number.test(pin[3]))
               	  {
               		  $('#pincode').val('');
               	  }
               	  if(!letter.test(pin[4]))
               	  {
               		  $('#pincode').val('');
               	  }
               	  if(!number.test(pin[5]))
               	  {
               		  $('#pincode').val('');
               	  }
          }
         			
         function vocation_rate_check()
         {
          var number=/[0-9]/;
          var dot=/[.]/;
          var rate=$('#vocation-rate').val();
          var number_count=0;
          var dot_count=0;
          for(var i=0;i<rate.length;i++)
          {
          if(number.test(rate[i]))
               	  {
               		   number_count=++number_count;
               	  }
         	if(dot.test(rate[i]))
               	{
               	  dot_count=++dot_count;
               	}
          }
          if(!dot.test(rate[1]))
          {
         	 $('#vocation-rate').val('');
          }
          if(number_count < 1||dot_count!=1)
               	{
         		$('#vocation-rate').val('');
         	}
          
         }
         
         function isalpha(evt) {
               	evt = (evt) ? evt : window.event;
               	var charCode = (evt.which) ? evt.which : evt.keyCode;
               	if (charCode == 32) {
               		return true;
               	} else if (charCode > 31 && (charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122) || charCode == 13) {
               		return false;
               	}
               }
         
                
                 function isNumber(evt) {
                 evt = (evt) ? evt : window.event;
                 var charCode = (evt.which) ? evt.which : evt.keyCode;
                 if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                 	return false;
                 }
                 return true;
                 
                 }	
         	 
         	 function empsin_check()
         	 {
         		 
         		 if($('#empsin1').val().length==3)
         		 {
         			$('#empsin2').focus();
         		 }
         		 
         		 if($('#empsin2').val().length==3)
         		 {
         			$('#empsin3').focus();
         		 }
         		 
         	 }
         	 
         	 
             $( function()
               {
                 var d = new Date();
                 d.setFullYear(d.getFullYear()+10);
                  
                 var date = $('.dateformat').datepicker({dateFormat: 'dd-M-yy',changeMonth: true,changeYear: true,yearRange: '1960:' + d.getFullYear() }).val();
               } );


               function center_select_feild()
               {

                  var company_name=$('#company-name').val();
                  jQuery.ajax({
              				url:"<?php echo base_url();?>main/center_select_feild?use=<?php echo $this->uri->segment(3) ?>",
              				type:"POST",	
                        dataType:'json',
              				data:{company_name:company_name},
              				success:function(data){
                           $('#center-name').empty();
                           $.each(data, function (index, value) { 
                              $('#center-name').append('<option value="'+value.id+'">'+value.center_name+'</option>');
                           });
              				}
              			 });	

               }
         center_select_feild();
         
         $(document).ready(function () {
            var slr = <?php echo $centerslist ?>;
            var selectedValues = new Array();
            $.each(slr, function (index, value) { 
               var values =  $('#center-name option[value='+value.id+']').attr('selected', 'selected');
               selectedValues[index] = value.id;
            });
            $('#center-name').val(selectedValues).trigger('change');
            console.log(selectedValues);
            
         });
      </script>
   </body>
</html>