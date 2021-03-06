<html lang="en">

<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <title>Little Footprints Academy</title>
   <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
   <link href="<?php echo base_url() ?>my_assets/global_assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
   <link href="<?php echo base_url() ?>my_assets/global_assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
   <link href="<?php echo base_url() ?>my_assets/global_assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
   <link href="<?php echo base_url() ?>my_assets/global_assets/css/components.min.css" rel="stylesheet" type="text/css">
   <link href="<?php echo base_url() ?>my_assets/global_assets/css/colors.min.css" rel="stylesheet" type="text/css">
   <link href="<?php echo base_url() ?>my_assets/assets/css/layout.min.css" rel="stylesheet" type="text/css">
   <!-- /global stylesheets -->
   <!-- Core JS files -->
   <script src="<?php echo base_url() ?>my_assets/global_assets/js/main/jquery.min.js"></script>
   <script src="<?php echo base_url() ?>my_assets/global_assets/js/jquery-ui/jquery-ui.min.js"></script>
   <script src="<?php echo base_url() ?>my_assets/global_assets/js/main/bootstrap.bundle.min.js"></script>
   <script src="<?php echo base_url() ?>my_assets/global_assets/js/plugins/loaders/blockui.min.js"></script>
   <!-- /core JS files --
         <!-- Theme JS files -->
   <script src="<?php echo base_url() ?>my_assets/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
   <script src="<?php echo base_url() ?>my_assets/global_assets/js/plugins/tables/datatables/extensions/responsive.min.js"></script>
   <script src="<?php echo base_url() ?>my_assets/global_assets/js/plugins/forms/selects/select2.min.js"></script>
   <script src="<?php echo base_url() ?>my_assets/global_assets/js/app.js"></script>
   <script src="<?php echo base_url() ?>my_assets/global_assets/js/demo_pages/datatables_advanced.js"></script>
   <!-- /theme JS files -->
   <!-- Theme JS files -->
   <script src="<?php echo base_url() ?>my_assets/global_assets/js/plugins/forms/styling/uniform.min.js"></script>
   <script src="<?php echo base_url() ?>my_assets/global_assets/js/demo_pages/form_layouts.js"></script>
   <!-- /theme JS files -->
   <script src="<?php echo base_url() ?>my_assets/global_assets/js/plugins/forms/styling/switchery.min.js"></script>
   <script src="<?php echo base_url() ?>my_assets/global_assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
   <script src="<?php echo base_url() ?>my_assets/global_assets/js/plugins/ui/moment/moment.min.js"></script>
   <script src="<?php echo base_url() ?>my_assets/global_assets/js/plugins/pickers/daterangepicker.js"></script>
   <script src="<?php echo base_url() ?>my_assets/global_assets/js/demo_pages/dashboard.js"></script>
   <script src="<?php echo base_url() ?>my_assets/global_assets/js/demo_pages/datatables_responsive.js"></script>
   <!-- /theme JS files -->
   <script src="<?php echo base_url() ?>my_assets/global_assets/js/plugins/visualization/d3/d3.min.js"></script>
   <script src="<?php echo base_url() ?>my_assets/global_assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
   <!-- /Core JS files -->
   <script src='<?php echo base_url() ?>my_assets/global_assets/bootbox/bootbox.min.js'></script>
   <style>
      td {
         font-size: 13px;
      }

      .dataTable th {
         font-size: 13px;
      }

      .dataTable tr.child .dtr-title {
         width: 20%;
      }
   </style>
</head>

<body>
   <!-- Main navbar -->
   <?php $this->load->view('includes/main_nav_bar') ?>
   <!-- /main navbar -->
   <!-- Page content -->
   <div class="page-content">
      <!-- Main sidebar ---->
      <?php $this->load->view('includes/main_side_bar') ?>
      <!--/main sidebar --->
      <!-- Main content -->
      <div class="content-wrapper">
         <!-- Content area -->
         <div class="content">
            <!-- Multiple row inputs (horizontal) -->
            <div class="row">
               <div class="col-md-12">
                  <div class="card">
                     <div class="card-header header-elements-inline">
                        <h6 class="card-title payslip_heading">Company Master</h6>
                        <div class="header-elements">
                           <div class="list-icons">
                              <a class="list-icons-item" href="#DataTables_Table_0_wrapper" class="view"><i class="icon-list"></i></a>
                           </div>
                        </div>
                     </div>
                     <?php
                     if ($this->session->flashdata('insert', 'success')) {
                     ?>
                        <div class="alert bg-success alert-styled-left">
                           <button type="button" class="close" data-dismiss="alert">&times;</button>
                           <span class="text-semibold">Inserts are saved successfully..!</span>
                        </div>
                     <?php
                     }
                     ?>
                     <?php
                     if ($this->session->flashdata('update', 'success')) {
                     ?>
                        <div class="alert bg-success alert-styled-left">
                           <button type="button" class="close" data-dismiss="alert">&times;</button>
                           <span class="text-semibold">Updates are saved successfully..!</span>
                        </div>
                     <?php
                     }
                     ?>
                     <form method="post" id="frm" action="<?php echo base_url(); ?>main/company_master_insert_update">
                        <div class="card-body">
                           <div class="row">
                              <div class="col-lg-6">

                                 <div class="form-group">
                                    <label>Company Name</label>
                                    <div class="input-group">
                                       <input type="text" id="comp-name" class="form-control" placeholder="Company Name" name="comp_name" minlength="2" required>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label>Employeer A/c number</label>
                                    <div class="input-group">
                                       <input type="text" id="at-num" class="form-control" placeholder="Employeer A/c number" name="at_num" onkeypress="return isNumber();" required>
                                    </div>
                                 </div>

                                 <div class="form-group">
                                    <label>Number of payment</label>
                                    <div class="input-group">
                                       <input type="text" id="num-pay" class="form-control" placeholder="Number of payment per year" name="num_pay" onkeypress="return isNumber();" required>
                                    </div>
                                 </div>

                                 <div class="form-group">
                                    <label>Issuer Name</label>
                                    <div class="input-group">
                                       <input type="text" id="issuer" class="form-control" placeholder="Issuer Name" name="issuer" required>
                                    </div>
                                 </div>

                                 <div class="form-group">
                                    <label>Phone Number</label>
                                    <div class="input-group">
                                       <input type="text" id="phone" class="form-control" placeholder="Phone Number" maxlength="15" minlength="10" name="phone" onkeypress="return isNumber();" required>
                                    </div>
                                 </div>



                                 <input type="hidden" id="emp-id" name="emp_id">
                                 <div class="text-right" style="display:block;" id="insert-activate">
                                    <button type="submit" id="insert-button" name="insert_button" class="insert btn btn-primary" onclick="">Submit<i class="icon-paperplane ml-2"></i></button>
                                 </div>
                                 <div class="text-right" style="display:none;" id="update-activate">
                                    <button type="submit" id="update-button" name="update_button" class="update btn btn-primary">Edit<i class="icon-paperplane ml-2"></i></button>
                                 </div>
                              </div>
                              <div class="col-lg-6">
                                 <div class="form-group">
                                    <label>Address</label>
                                    <div class="input-group">
                                       <textarea name="address" class="form-control" id="address" cols="30" rows="5"></textarea>
                                    </div>
                                 </div>
                              </div>
                           </div>
                     </form>
                  </div>
                  <!-- /card body -->
               </div>
               <!-- /card area -->
            </div>
         </div>
         <div class="row">
            <div class="col-md-12">
               <div class="card">
                  <table class="table datatable-responsive dataTable no-footer dtr-inline ">
                     <thead>
                        <tr>
                           <th>S.no</th>
                           <th>Edit</th>
                           <th>Delete</th>
                           <th>Company Name</th>
                           <th>Issuer</th>
                           <th>Phone</th>
                           <th>A/c Number</th>
                           <th>Number of payment</th>
                           <th>Address</th>
                     </thead>
                     <tbody>
                        <?php
                        $i = 1;
                        foreach ($comapny_fetch as $row) {

                        ?>
                           <tr>
                              <td><?php echo $i; ?></td>
                              <td><a href="<?php echo base_url(); ?>main/company_master_fetch_for_update/<?php echo $row['id']; ?>"><span class='edit' id='edit-<?php echo $row['id']; ?>'><i style='color:green' class='icon-pencil'></i></span></a></td>
                              <td> <span class='del' id='delete-<?php echo $row['id']; ?>'><i style='color:red' class='icon-trash'></i></span>
                              </td>
                              <td><?php echo $row['name']; ?></td>
                              <td><?php echo $row['isser']; ?></td>
                              <td><?php echo $row['phone']; ?></td>
                              <td><?php echo $row['ac_num']; ?></td>
                              <td><?php echo $row['no_pay_period']; ?></td>
                              <td><?php echo $row['address']; ?></td>
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
      if (isset($company_master_fetch_for_update)) {
         foreach ($company_master_fetch_for_update as $row) {
            $id = $row['id'];
            $name = $row['name'];
            $at_num = $row['ac_num'];
            $num_pay = $row['no_pay_period'];
            $phone = $row['phone'];
            $issuer = $row['isser'];
            $address = $row['address'];
         }
      ?>
         <script>
            $('#insert-activate').css("display", "none");
            $('#update-activate').css("display", "block");
            $("#emp-id").val("<?php echo $id; ?>");
            $("#comp-name").val("<?php echo $name; ?>");
            $("#at-num").val("<?php echo $at_num; ?>");
            $("#num-pay").val("<?php echo $num_pay; ?>");
            $("#phone").val("<?php echo $phone; ?>");
            $("#issuer").val("<?php echo $issuer; ?>");
            $("#address").text("<?php echo $address; ?>");
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
      } <
      !--Numeric validation-- >
      function isNumber(evt) {
         evt = (evt) ? evt : window.event;
         var charCode = (evt.which) ? evt.which : evt.keyCode;
         if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
         }
         return true;

      }


      $('.del').css('cursor', 'pointer'); <
      !--delete-- >
      $(document).on('click', '.del', function() {
         var del = $(this);
         var id1 = $(this).attr('id');
         var delete_id = id1.split("-");
         bootbox.confirm("Do you really want to delete record?", function(result) {

            if (result) {
               jQuery.ajax({
                  url: "<?php echo base_url(); ?>main/company_master_delete",
                  type: "POST",
                  data: {
                     id: delete_id[1]
                  },
                  success: function(data) {
                     del.closest("tr").hide();
                  }
               });
            } else {

               bootbox.alert('Record not deleted.');
            }
         });
      });
   </script>
</body>

</html>