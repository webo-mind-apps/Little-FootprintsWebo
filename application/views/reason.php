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
        .show-input{
            display: none   
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
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card-header header-elements-inline">
                                        <h6 class="card-title payslip_heading">Record of employee</h6>
                                        <div class="header-elements">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if ($this->session->flashdata('success')) {
                            ?>
                                <div class="alert bg-success alert-styled-left">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <span class="text-semibold"><?php echo $this->session->flashdata('success') ?></span>
                                </div>
                            <?php
                            }
                            ?>
                            <?php
                            if ($this->session->flashdata('error')) {
                            ?>
                                <div class="alert bg-success alert-styled-left">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <span class="text-semibold"><?php echo $this->session->flashdata('error') ?></span>
                                </div>
                            <?php
                            }
                            ?>

                            <div class="card-body">
                                <form method="post" id="frm" action="<?php echo base_url(); ?>main/reason">
                                    <div class="row">
                                        <div class="col-lg-6">

                                            <div class="form-group ">
                                                <label>Code</label>
                                                <div class="input-group">
                                                    <input type="text" id="code" class="form-control" placeholder="Code A" name="code" required>
                                                </div>
                                            </div><!-- Last Work Day  -->

                                            <div class="form-group">
                                                <label>Description</label>
                                                <div class="input-group">
                                                    <textarea name="des" id="des" cols="30" rows="5" class="form-control" required></textarea>
                                                </div>
                                            </div><!-- Last Work Day  -->

                                            <div class="form-group">
                                                <button class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /card body -->
                    </div>
                    <!-- /card area -->
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-hover" width="100%">
                                    <tr>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                    <?php foreach ($reason as $key => $value) { ?>
                                        <tr>
                                            <td><?php echo $key + 1 ?></td>
                                            <td><?php echo $value->code ?></td>
                                            <td><?php echo $value->des ?></td>
                                            <td><a href="<?php echo base_url('main/reason_delete/').$value->id ?>"><span class="del" id="delete" style="cursor: pointer;"><i style="color:red" class="icon-trash"></i></span></a></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Footer -->
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <?php $this->load->view('includes/main_footer') ?>
                </div>
            </div>
            <!-- /footer -->
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /page content -->

   <script>
       $(function () {
           $('.del').click(function (e) { 
               if(confirm('Are you sure you want to delete')){
                   return true
                }else{
                    e.preventDefault();
               }
           });
       });
   </script>

</body>

</html>