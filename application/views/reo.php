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

                            <div class="card-body">
                                <form method="post" id="frm" action="<?php echo base_url(); ?>deduction/reo_insert">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Select Company <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <select name="company" require id="company" class="form-control">
                                                        <option  disabled selected>Select Company</option>
                                                        <?php foreach ($company as $key => $value) { ?>
                                                            <option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div><!-- company -->

                                            <div class="form-group">
                                                <label>Select Employee <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <select name="employee" id="employee" disabled require class="form-control">
                                                        <option value="" disabled selected>Select Employee</option>
                                                    </select>
                                                </div>
                                            </div><!-- company -->

                                            <div class="form-group show-input">
                                                <label>Reason for leaving <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <select name="reason" id="reason" require class="form-control">
                                                        <option value="" disabled>Select Reason</option>
                                                        <?php foreach ($reason as $val) :
                                                            echo '<option value="' . $val->id . '">' . $val->code . '&nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;'.$val->des.'</option>';
                                                        endforeach;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div><!-- reason for leaving  -->

                                            <div class="form-group show-input">
                                                <label>Date of issue <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" id="issued" class="dateformat form-control" placeholder="Date of issue" name="issued" required>
                                                </div>
                                            </div><!-- Date issued  -->

                                            <div class="form-group show-input">
                                                <label>First work day <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" id="fwork" class="dateformat form-control" placeholder="First work day" name="fwork" required>
                                                </div>
                                            </div><!-- First Work Day  -->
                                            
                                            <div class="form-group show-input">
                                                <button type="submit" class="btn btn-primary">Export</button>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group show-input">
                                                <label>Last  paid date <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" id="lwork" class="dateformat form-control" placeholder="Last day for which paid" name="lwork" required>
                                                </div>
                                            </div><!-- Last Work Day  -->

                                            <div class="form-group show-input">
                                                <label>Final pay period ending <span class="text-danger">*</span> </label>
                                                <div class="input-group">
                                                    <input type="text" id="fnending" class="dateformat form-control" placeholder="Final pay period ending" name="fnending" required>
                                                </div>
                                            </div><!-- -->

                                            <div class="form-group show-input">
                                                <label>Expected date of recall</label>
                                                <div class="input-group">
                                                    <input type="text" id="recall" class="dateformat form-control" placeholder="Expected date of recall" name="recall"  >
                                                </div>
                                            </div><!-- Recall  -->

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /card body -->
                    </div>
                    <!-- /card area -->
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
        $(function() {
            // date picker 

            // get employee
            $('#company').change(function(e) {
                var id = $(this).val();
                var options = '';
                $('#employee').empty();
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: "<?php echo base_url() ?>deduction/employee",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        options = '<option value="" disabled selected>Select Employee</option>';
                        if (response.length > 0) {
                            $.each(response, function(i, v) {
                                options += '<option value="' + v.emp_id + '" >' + v.first_name + ' ' + v.last_name + '</option>';
                            });
                            $('#employee').append(options);
                            $('#employee').removeAttr('disabled');

                        } else {
                            options = '<option value="" disabled>No result Found</option>';
                        }
                    }
                });
            });

            $('#employee').change(function(e) {
                e.preventDefault();
                var id = $(this).val();
                $.ajax({
                    type: "post",
                    url: "<?php echo base_url() ?>deduction/employee_detail",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#fwork').val(response.hire_date);
                        $('.show-input').show();
                    }
                });
            });
        });
        
        $(function() {
            var d = new Date();
            d.setFullYear(d.getFullYear() + 10);

            var date = $('.dateformat').datepicker({
                dateFormat: 'dd-M-yy',
                changeMonth: true,
                changeYear: true,
                yearRange: '1960:' + d.getFullYear()
            }).val();
        });
    </script>

</body>

</html>