<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Xtra.ml | POS</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> 
        <!-- jQuery 3 -->
        <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script> 
        <!-- Select2 -->
        <script src="<?php echo base_url(); ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>
        <!-- Select2 -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/select2/dist/css/select2.min.css">
        <!-- InputMask -->
        <script src="<?php echo base_url(); ?>assets/plugins/input-mask/jquery.inputmask.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
        <!-- iCheck -->
        <script src="<?php echo base_url(); ?>assets/plugins/iCheck/icheck.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/iCheck/all.css">
        <!-- Sweet alert -->
        <script src="<?php echo base_url(); ?>assets/bower_components/sweetalert2/dist/sweetalert.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/sweetalert2/dist/sweetalert.min.css">
        <!-- Include a polyfill for ES6 Promises (optional) for IE11 and Android browser -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>

        <!-- Numpad -->
        <script src="<?php echo base_url(); ?>assets/bower_components/numpad/jquery.numpad.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/numpad/jquery.numpad.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/numpad/theme.css">
        <!--datepicker-->
        <!-- bootstrap datepicker -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/datepicker/datepicker.css">

        <!-- bootstrap datepicker -->
        <script src="<?php echo base_url(); ?>assets/bower_components/datepicker/bootstrap-datepicker.js"></script>

        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/Ionicons/css/ionicons.min.css"> 

        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/jquery.mCustomScrollbar.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.css">
        <!-- iCheck -->
        <link href="<?php echo base_url(); ?>asset/plugins/iCheck/minimal/color-scheme.css" rel="stylesheet">
        <!-- Favicon -->
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/x-icon">
        <!-- Favicon -->
        <link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/x-icon">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.css"> 

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <style type="text/css">
            .company_info{
                min-height: 41px;
                color: white !important;
                text-align: center;
                font-weight: bold;
            }
            .breadcrumb{
                padding: 0px 5px !important;
            }
            .btn-primary{
                background-color: #3c8dbc;
            }
            .form_question{
                font-size: 24px;
                color: #3c8dbc; 
                padding-top: 7px; 
            }
            .main-footer{
                padding: 10px !important;
            }
            .main-footer p{
                padding-top: 10px;
            }
            .left-sdide{
                float: left !important;
            }
            .navbar-nav > .user-menu > .dropdown-menu dropdown-menu-right{
                width: 50px;
            }
            .dropdown-menu{
                border: 1px solid #3c8dbc !important;
            }
            .loader{
                display: none;
            }
            #myModal .modal-title{text-align: left;}
            #register_details_body p{ text-align:left; margin:0px 0px 10px 0px;}
        </style>
        <script>
            jQuery(document).ready(function($) { 
                $('[data-mask]').inputmask()
                $('.select2').select2() 
                $(".delete").click(function(e){
                    e.preventDefault();
                    var linkURL = this.href;
                    warnBeforeRedirect(linkURL);
                });
                function warnBeforeRedirect(linkURL) {
                    swal({
                        title: "<?php echo lang('alert') ?>!",
                        text: "<?php echo lang('are_you_sure') ?>?",
                        cancelButtonText:'<?php echo lang('cancel'); ?>',
                        confirmButtonText:'<?php echo lang('ok'); ?>',
                        confirmButtonColor: '#3c8dbc',
                        showCancelButton: true
                    }, function() {
                        window.location.href = linkURL;
                    });
                }
                //iCheck for checkbox and radio inputs
                $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                    checkboxClass: 'icheckbox_minimal-blue',
                    radioClass   : 'iradio_minimal-blue'
                })


                $(document).on('keydown', '.integerchk', function(e){ 
                    return (
                    keys == 8 ||
                        keys == 9 ||
                        keys == 13 ||
                        keys == 46 ||
                        keys == 110 ||
                        keys == 86 ||
                        keys == 190 ||
                        (keys >= 35 && keys <= 40) ||
                        (keys >= 48 && keys <= 57) ||
                        (keys >= 96 && keys <= 105));
                });

                $(document).on('keyup', '.integerchk', function(e){
                    var input = $(this).val();
                    var ponto = input.split('.').length;
                    var slash = input.split('-').length;
                    if (ponto > 2)
                        $(this).val(input.substr(0,(input.length)-1));
                    $(this).val(input.replace(/[^0-9]/,''));
                    if(slash > 2)
                        $(this).val(input.substr(0,(input.length)-1));
                    if (ponto ==2)
                        $(this).val(input.substr(0,(input.indexOf('.')+3)));
                    if(input == '.')
                        $(this).val("");

                });
                
            });
        </script>
        <script>  
            $(function () {

                //Date picker
                $('#date').datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true
                });
                $('#dates2').datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true
                });
                $('.customDatepicker').datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true
                });
                $(".datepicker_months").datepicker({
                    format: 'yyyy-M',
                    autoclose: true,
                    viewMode: "months",
                    minViewMode: "months"
                });
            })

            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1; //January is 0!
            var yyyy = today.getFullYear();

            if(dd<10) {
                dd = '0'+dd
            } 

            if(mm<10) {
                mm = '0'+mm
            }  
            today = yyyy + '-' + mm + '-' + dd;
        </script>
    </head>

    <?php
    $uri = $this->uri->segment(2);
    ?>
    <div class="loader"></div>
    <!-- ADD THE CLASS sidebar-collapse TO HIDE THE SIDEBAR PRIOR TO LOADING THE SITE -->
    <body class="hold-transition skin-blue sidebar-mini <?php
    if ($uri == "POS" || $uri == "sales" || $uri == "customers") {
        echo "sidebar-collapse";
    }
    ?>">
        <!--<body class="hold-transition skin-blue sidebar-collapse sidebar-mini">-->
        <!-- Site wrapper -->
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="#" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini">iR</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><img src="<?php echo base_url(); ?>assets/images/logo_white.png"></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span> 
                    </a> 

                    <div class="navbar-custom-menu left-sdide">
                        <ul class="nav navbar-nav">

                            <?php if ($this->session->userdata('outlet_id')) { ?>
                                <!-- User Account: style can be found in dropdown.less -->
                                <?php if (in_array('Sale', $this->session->userdata('menu_access'))) { ?> 
                                    <li class="dropdown user user-menu">
                                        <a href="<?php echo base_url(); ?>Sale/POS">
                                            <i class="fa fa-cutlery"></i>
                                            <span class="hidden-xs"><?php echo lang('pos'); ?></span>
                                        </a> 
                                    </li> 
                                <?php } ?>
                                <?php if (in_array('Purchase', $this->session->userdata('menu_access'))) { ?> 
                                    <li class="dropdown user user-menu">
                                        <a href="<?php echo base_url(); ?>Purchase/addEditPurchase">
                                            <i class="fa fa-truck"></i>
                                            <span class="hidden-xs"><?php echo lang('add_purchase'); ?></span>
                                        </a> 
                                    </li> 
                                <?php } ?>
                                <?php if ($this->session->userdata('role') == "Admin") { ?> 
                                    <li class="dropdown user user-menu">
                                        <a href="#" onclick="todaysSummary();" class="dropdown-toggle" data-toggle="dropdown">
                                            <i class="fa fa-list"></i><span class="hidden-xs"><?php echo lang('todays_summary'); ?></span>
                                        </a>
                                    </li> 
                                    <?php
                                }
                                $url = $this->uri->segment(2);
                                if ($url == "addEditSale"):
                                    ?>
                                    <li class="dropdown user user-menu">
                                        <a href="#" onclick="shortcut();" class="dropdown-toggle" data-toggle="dropdown">
                                            <i class="fa fa-keyboard-o"></i><span class="hidden-xs"><?php echo lang('shortcut_keys'); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <li class="dropdown user user-menu">
                                    <a href="#" id="register_details">
                                        <i class="fa fa-info-circle"></i><span class="hidden-xs"><?php echo lang('register_details'); ?></span>
                                    </a>
                                </li>
                                <li class="dropdown user user-menu" id="close_register_button" style="display:none">
                                    <a href="#" id="register_close">
                                        <i class="fa fa-times-circle"></i><span class="hidden-xs"><?php echo lang('close_register'); ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="navbar-custom-menu">
                       <ul class="nav navbar-nav">
                             <li class="dropdown messages-menu open" 
                            style="width: 150px;padding-top: 12px;">
                            <?php $language=$this->session->userdata('language'); ?>
                            <form action="<?php echo base_url(); ?>Authentication/setlanguage" method="POST">
                                <select tabindex="2" class="form-control select2" name="language" style="width: 100%;" onchange='this.form.submit()'> 
                                    <option value="english" 
                                    <?php if(isset($language)){
                                    if ($language == 'english') 
                                        echo "selected";
                                    }  
                                    ?>>English</option>
                                    <option value="spanish" 
                                    <?php if(isset($language)){
                                    if ($language == 'spanish') 
                                        echo "selected";
                                    }  
                                    ?>>Spanish</option> 
                                    <<option value="french" 
                                    <?php if(isset($language)){
                                    if ($language == 'french') 
                                        echo "selected";
                                    }
                                    ?>>French</option>
                                    <option value="arabic"
                                    <?php if(isset($language)){
                                    if ($language == 'arabic') 
                                        echo "selected";
                                    } 
                                    ?>>Arabic</option> 
                                </select>
                            </form>
                              </li> 
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="<?php echo base_url(); ?>Authentication/logOut">Logout
                                </a> 
                            </li> 
                        </ul>
                    </div>
                </nav>
            </header>

            <!-- Left side column. contains the sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel --> 
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php echo base_url(); ?>assets/images/chef.png" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p><?php echo $this->session->userdata('outlet_name'); ?></p>
                            <p><?php echo $this->session->userdata('full_name'); ?></p>  
                        </div> 
                    </div>  
                    <ul class="sidebar-menu">
                        <li class="header"><?php echo lang('main_navigation'); ?></li>
                    </ul>
                    <div id="left_menu_to_scroll">
                        <!-- sidebar menu: : style can be found in sidebar.less -->
                        <ul class="sidebar-menu" data-widget="tree">
                            <li>
                                <a href="<?php echo base_url(); ?>Authentication/userProfile"><i class="fa fa-home"></i> <span><?php echo lang('home'); ?></span></a>
                            </li>
                            <?php
                            if ($this->session->userdata('role') == 'Admin') {
                                ;
                                ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>Restaurant_setting/setting"><i class="fa fa-gear"></i> <span><?php echo lang('restaurant_setting'); ?></span></a>
                                </li>
                                <!-- <li>
                                    <a href="<?php echo base_url(); ?>Outlet/outlets"><i class="fa fa-list-ol"></i> <span><?php echo lang('outlet_list'); ?></span></a>
                                </li> -->
                            <?php } ?> 
<?php if (in_array('Kitchen', $this->session->userdata('menu_access')) || in_array('Bar', $this->session->userdata('menu_access')) || in_array('Waiter', $this->session->userdata('menu_access'))) { ?> 
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-file-text"></i> <span><?php echo lang('all_screen'); ?></span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <?php if (in_array('Sale', $this->session->userdata('menu_access'))) { ?> 
                                        <li><a href="<?php echo base_url(); ?>Sale/POS"><i class="fa fa-angle-double-right"></i><?php echo lang('pos'); ?></a></li>
                                        <?php } ?>
                                        <?php if (in_array('Kitchen', $this->session->userdata('menu_access'))) { ?> 
                                        <li><a href="<?php echo base_url(); ?>Kitchen/panel"><i class="fa fa-angle-double-right"></i><?php echo lang('kitchen'); ?></a></li>
                                        <?php } ?>
                                        <?php if (in_array('Bar', $this->session->userdata('menu_access'))) { ?> 
                                        <li><a href="<?php echo base_url(); ?>Bar/panel"><i class="fa fa-angle-double-right"></i><?php echo lang('bar'); ?></a></li>
                                        <?php } ?>
                                        <?php if (in_array('Waiter', $this->session->userdata('menu_access'))) { ?> 
                                        <li><a href="<?php echo base_url(); ?>Waiter/panel"><i class="fa fa-angle-double-right"></i><?php echo lang('waiter'); ?></a></li> 
                                        <?php } ?>
                                    </ul>
                                </li>
                            <?php } ?>
<?php if (in_array('Dashboard', $this->session->userdata('menu_access'))) { ?> 
                                <li>
                                    <a href="<?php echo base_url(); ?>Dashboard/dashboard"><i class="fa fa-dashboard"></i> <span><?php echo lang('dashboard'); ?></span></a>
                                </li>
                            <?php } ?>
<?php if (in_array('Purchase', $this->session->userdata('menu_access'))) { ?> 
                                <li>
                                    <a href="<?php echo base_url(); ?>Purchase/purchases"><i class="fa fa-truck"></i> <span><?php echo lang('purchase'); ?></span></a>
                                </li>
                            <?php } ?>
<?php if (in_array('Sale', $this->session->userdata('menu_access'))) { ?> 
                                <li>
                                    <a href="<?php echo base_url(); ?>Sale/sales"><i class="fa fa-cutlery"></i> <span><?php echo lang('sale'); ?></span></a>
                                </li>
                            <?php } ?>
<?php if (in_array('Inventory', $this->session->userdata('menu_access'))) { ?> 
                                <li>
                                    <a href="<?php echo base_url(); ?>Inventory/index"><i class="fa fa-hdd-o"></i> <span><?php echo lang('inventory'); ?></span></a>
                                </li>
                            <?php } ?>
<?php if (in_array('Inventory_adjustment', $this->session->userdata('menu_access'))) { ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>Inventory_adjustment/inventoryAdjustments"><i class="fa fa-adjust"></i> <span><?php echo lang('inventory_adjustments'); ?></span></a>
                                </li>
                            <?php } ?>
<?php if (in_array('Waste', $this->session->userdata('menu_access'))) { ?> 
                                <li>
                                    <a href="<?php echo base_url(); ?>Waste/wastes"><i class="fa fa-trash"></i> <span><?php echo lang('waste'); ?></span></a>
                                </li>
                            <?php } ?>
<?php if (in_array('Expense', $this->session->userdata('menu_access'))) { ?> 
                                <li>
                                    <a href="<?php echo base_url(); ?>Expense/expenses"><i class="fa fa-money"></i> <span><?php echo lang('expense'); ?></span></a>
                                </li>
                            <?php } ?>
<?php if (in_array('SupplierPayment', $this->session->userdata('menu_access'))) { ?> 
                                <li>
                                    <a href="<?php echo base_url(); ?>SupplierPayment/supplierPayments"><i class="fa fa-money"></i> <span><?php echo lang('supplier_due_payment'); ?></span></a>
                                </li> 
                            <?php } ?>
<?php if (in_array('Customer_due_receive', $this->session->userdata('menu_access'))) { ?> 
                                <li>
                                    <a href="<?php echo base_url(); ?>Customer_due_receive/customerDueReceives"><i class="fa fa-money"></i> <span><?php echo lang('customer_due_receive'); ?></span></a>
                                </li> 
                            <?php } ?>
<?php if (in_array('Short_message_service', $this->session->userdata('menu_access'))) { ?> 
                                <li>
                                    <a href="<?php echo base_url(); ?>Short_message_service/smsService"><i class="fa fa-envelope"></i> <span><?php echo lang('send_sms'); ?></span></a>
                                </li> 
                            <?php } ?> 
<?php if (in_array('Attendance', $this->session->userdata('menu_access'))) { ?> 
                                <li>
                                    <a href="<?php echo base_url(); ?>Attendance/attendances"><i class="fa fa-clock-o"></i> <span><?php echo lang('attendance'); ?></span></a>
                                </li> 
                            <?php } ?> 
<?php if (in_array('Report', $this->session->userdata('menu_access'))) { ?> 
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-file-text"></i> <span><?php echo lang('report'); ?></span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="<?php echo base_url(); ?>Report/registerReport"><i class="fa fa-angle-double-right"></i><?php echo lang('register_report'); ?></a></li>  
                                        <li><a href="<?php echo base_url(); ?>Report/dailySummaryReport"><i class="fa fa-angle-double-right"></i><?php echo lang('daily_summary_report'); ?></a></li>  
                                        <li><a href="<?php echo base_url(); ?>Report/foodMenuSales"><i class="fa fa-angle-double-right"></i><?php echo lang('food_sale_report'); ?></a></li>
                                        <li><a href="<?php echo base_url(); ?>Report/saleReportByDate"><i class="fa fa-angle-double-right"></i><?php echo lang('daily_sale_report'); ?></a></li> 
                                        <li><a href="<?php echo base_url(); ?>Report/detailedSaleReport"><i class="fa fa-angle-double-right"></i><?php echo lang('detailed_sale_report'); ?></a></li> 
                                        <li><a href="<?php echo base_url(); ?>Report/consumptionReport"><i class="fa fa-angle-double-right"></i><?php echo lang('consumption_report'); ?></a></li>
                                        <li><a href="<?php echo base_url(); ?>Report/inventoryReport"><i class="fa fa-angle-double-right"></i><?php echo lang('inventory_report'); ?></a></li> 
                                        <li><a href="<?php echo base_url(); ?>Inventory/getInventoryAlertList"><i class="fa fa-angle-double-right"></i><?php echo lang('low_inventory_report'); ?></a></li> 
                                        <li><a href="<?php echo base_url(); ?>Report/profitLossReport"><i class="fa fa-angle-double-right"></i><?php echo lang('profit_loss_report'); ?></a></li>
                                        <li><a href="<?php echo base_url(); ?>Report/vatReport"><i class="fa fa-angle-double-right"></i><?php echo lang('vat_report'); ?></a></li> 
                                        <li><a href="<?php echo base_url(); ?>Report/kitchenPerformanceReport"><i class="fa fa-angle-double-right"></i><?php echo lang('kitchen_performance_report'); ?></a></li> 
                                        <li><a href="<?php echo base_url(); ?>Report/attendanceReport"><i class="fa fa-angle-double-right"></i><?php echo lang('attendance_report'); ?></a></li> 
                                        <li><a href="<?php echo base_url(); ?>Report/supplierReport"><i class="fa fa-angle-double-right"></i><?php echo lang('supplier_ledger'); ?></a></li> 
                                        <li><a href="<?php echo base_url(); ?>Report/supplierDueReport"><i class="fa fa-angle-double-right"></i><?php echo lang('supplier_due_report'); ?></a></li>
                                        <li><a href="<?php echo base_url(); ?>Report/customerDueReport"><i class="fa fa-angle-double-right"></i><?php echo lang('customer_due_report'); ?></a></li>
                                        <li><a href="<?php echo base_url(); ?>Report/customerReport"><i class="fa fa-angle-double-right"></i><?php echo lang('customer_ledger'); ?></a></li> 
                                        <!-- <li><a href="<?php echo base_url(); ?>Report/saleReportByMonth"><i class="fa fa-angle-double-right"></i>Sale Report by Month</a></li>  --> 
                                        <li><a href="<?php echo base_url(); ?>Report/purchaseReportByDate"><i class="fa fa-angle-double-right"></i><?php echo lang('purchase_report'); ?></a></li> 
                                        <!-- <li><a href="<?php echo base_url(); ?>Report/purchaseReportByMonth"><i class="fa fa-angle-double-right"></i>Pur. Report by Month</a></li>  -->
                                        <!-- <li><a href="<?php echo base_url(); ?>Report/purchaseReportByDate"><i class="fa fa-angle-double-right"></i>Pur. Report by Date</a></li> 
                                        <li><a href="<?php echo base_url(); ?>Report/purchaseReportByIngredient"><i class="fa fa-angle-double-right"></i>Pur. Report by Ingredient</a></li>  -->
                                        <!-- <li><a href="<?php echo base_url(); ?>Report/detailedPurchaseReport"><i class="fa fa-angle-double-right"></i>Detailed Pur. Report</a></li>  -->
                                        <li><a href="<?php echo base_url(); ?>Report/expenseReport"><i class="fa fa-angle-double-right"></i><?php echo lang('expense_report'); ?></a></li> 
                                        <li><a href="<?php echo base_url(); ?>Report/wasteReport"><i class="fa fa-angle-double-right"></i><?php echo lang('waste_report'); ?></a></li> 
                                    </ul>
                                </li>
                            <?php } ?>  
<?php if (in_array('Master', $this->session->userdata('menu_access'))) { ?> 
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-database"></i> <span><?php echo lang('master'); ?></span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="<?php echo base_url(); ?>Master/ingredientCategories"><i class="fa fa-angle-double-right"></i><?php echo lang('ingredient_categories'); ?></a></li>
                                        <li><a href="<?php echo base_url(); ?>Master/Units"><i class="fa fa-angle-double-right"></i><?php echo lang('ingredient_units'); ?></a></li>
                                        <li><a href="<?php echo base_url(); ?>Master/ingredients"><i class="fa fa-angle-double-right"></i><?php echo lang('ingredients'); ?></a></li>
                                        <li><a href="<?php echo base_url(); ?>Master/VATs"><i class="fa fa-angle-double-right"></i><?php echo lang('vats'); ?></a></li>
                                        <li><a href="<?php echo base_url(); ?>Master/modifiers"><i class="fa fa-angle-double-right"></i><?php echo lang('modifiers'); ?></a></li>
                                        <li><a href="<?php echo base_url(); ?>Master/foodMenuCategories"><i class="fa fa-angle-double-right"></i><?php echo lang('food_menu_categories'); ?></a></li>
                                        <li><a href="<?php echo base_url(); ?>Master/foodMenus"><i class="fa fa-angle-double-right"></i><?php echo lang('food_menus'); ?></a></li>
                                        <li><a href="<?php echo base_url(); ?>Master/suppliers"><i class="fa fa-angle-double-right"></i><?php echo lang('suppliers'); ?></a></li>
                                        <li><a href="<?php echo base_url(); ?>Master/customers"><i class="fa fa-angle-double-right"></i><?php echo lang('customers'); ?></a></li> 
                                        <li><a href="<?php echo base_url(); ?>Master/expenseItems"><i class="fa fa-angle-double-right"></i><?php echo lang('expense_items'); ?></a></li>
                                        <li><a href="<?php echo base_url(); ?>Master/paymentMethods"><i class="fa fa-angle-double-right"></i><?php echo lang('payment_methods'); ?></a></li> 
                                        <li><a href="<?php echo base_url(); ?>Master/tables"><i class="fa fa-angle-double-right"></i><?php echo lang('tables'); ?></a></li> 
                                    </ul>
                                </li>
<?php } ?> 
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-user"></i> <span><?php echo lang('account'); ?></span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu"> 
                                    <li><a href="<?php echo base_url(); ?>Authentication/setting/<?php echo $this->session->userdata('company_id') ?>"><i class="fa fa-angle-double-right"></i><?php echo lang('general_settings'); ?></a></li>
                                    <li><a href="<?php echo base_url(); ?>Authentication/SMSSetting/<?php echo $this->session->userdata('company_id') ?>"><i class="fa fa-angle-double-right"></i><?php echo lang('sms_setting'); ?></a></li>
                                    <?php if (in_array('User', $this->session->userdata('menu_access'))) { ?>  
                                        <li><a href="<?php echo base_url(); ?>User/users"><i class="fa fa-angle-double-right"></i><?php echo lang('manage_users'); ?></a></li> 
<?php } ?>
                                    <li><a href="<?php echo base_url(); ?>Authentication/changeProfile"><i class="fa fa-angle-double-right"></i><?php echo lang('change_profile'); ?></a></li>
                                    <li><a href="<?php echo base_url(); ?>Authentication/changePassword"><i class="fa fa-angle-double-right"></i><?php echo lang('change_password'); ?></a></li>
                                    <li><a href="<?php echo base_url(); ?>Authentication/logOut"><i class="fa fa-angle-double-right"></i><?php echo lang('logout'); ?></a></li>
                                </ul>
                            </li> 


                        </ul>
                    </div>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- =============================================== -->

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">  
                <!-- Main content -->

                <?php
                if (isset($main_content)) {
                    echo $main_content;
                }
                ?> 
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <footer class="main-footer">  
                <div class="row">
                    <div class="col-md-12" style="text-align: center;">
                        <strong>Xtra.ml</strong>, POS 
                        <div class="hidden-lg">

                        </div> 
                    </div> 
                </div> 
            </footer> 
        </div>

        <div class="modal fade" id="todaysSummary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="ShortCut">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-2x">×</i></span></button>
                        <h2 style="text-align: center" id="myModalLabel"><?php echo lang('todays_summary'); ?></h2> 
                    </div>
                    <div class="modal-body">
                        <div class="box-body table-responsive">
                            <table class="table">
                                <tr>
                                    <td style="width: 80%;"><?php echo lang('purchase'); ?>(<?php echo lang('only_paid_amount'); ?>)</td>
                                    <td><span id="purchase"></span></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang('sale'); ?>(<?php echo lang('only_paid_amount'); ?>)</td>
                                    <td><span id="sale"></span></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang('total'); ?> <?php echo lang('vat'); ?></td>
                                    <td><span id="totalVat"></span></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang('expense'); ?></td>
                                    <td><span id="Expense"></span></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang('supplier_due_payment'); ?></td>
                                    <td><span id="supplierDuePayment"></span></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang('customer_due_receive'); ?></td>
                                    <td><span id="customerDueReceive"></span></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang('waste'); ?></td>
                                    <td><span id="waste"></span></td>
                                </tr>
                                <tr>
                                    <td>Balance = (<?php echo lang('sale'); ?> + <?php echo lang('customer_due_receive'); ?>) - (<?php echo lang('purchase'); ?> + <?php echo lang('supplier_due_payment'); ?> + <?php echo lang('expense'); ?>))</td>
                                    <td><span id="balance"></span></td>
                                </tr>
                            </table>

                            <br>
                            <div id="showCashStatus"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ./wrapper -->

        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><?php echo lang('register_details'); ?> <span id="opening_closing_register_time">(<span id="opening_register_time"></span> <?php echo lang('to'); ?> <span id="closing_register_time"></span>)</span></h4>
                    </div>
                    <div class="modal-body" id="register_details_body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></button>
                    </div>
                </div>

            </div>
        </div>


        <!-- Bootstrap 3.3.7 -->
        <script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- SlimScroll -->
        <script src="<?php echo base_url(); ?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="<?php echo base_url(); ?>assets/bower_components/fastclick/lib/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/POS/js/jquery.cookie.js"></script>
        <!-- custom scrollbar plugin -->
        <script src="<?php echo base_url(); ?>assets/dist/js/jquery.mCustomScrollbar.concat.min.js"></script>
        <script>
            var window_height = $(window).height();
            var main_header_height = $('.main-header').height();
            var user_panel_height = $('.user-panel').height();
            var left_menu_height_should_be = (parseFloat(window_height)-(parseFloat(main_header_height)+parseFloat(user_panel_height))).toFixed(2);
            left_menu_height_should_be = (parseFloat(left_menu_height_should_be)-parseFloat(60)).toFixed(2);
            $("#left_menu_to_scroll").css('height',left_menu_height_should_be+'px');
            // $("#left_menu_to_scroll").mCustomScrollbar();
            $("#left_menu_to_scroll").mCustomScrollbar({
                theme:"light",
                autoHideScrollbar: true,
                scrollInertia: 300
            });
            var currency = "<?php echo $this->session->userdata('currency') ?>";
            var base_url = "<?php echo base_url(); ?>"
            $.ajax({
                url: '<?php echo base_url("Register/checkRegisterAjax") ?>',
                method:"POST",
                data:{
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
                success:function(response) {
                    if(response=='2'){
                        $('#close_register_button').css('display','none');
                    }else{
                        $('#close_register_button').css('display','block');

                    }
                },
                error:function(){
                    alert("error");
                }
            });
            $('#register_details').on('click',function(){
                $.ajax({
                    url: '<?php echo base_url("Sale/registerDetailCalculationToShowAjax") ?>',
                    method:"POST",
                    data:{
                        csrf_test_name: $.cookie('csrf_cookie_name')
                    },
                    success:function(response) {
                        console.log(response);
                        if(!IsJsonString(response)){
                            var r = confirm("Register is not open, do you want to open register?");
                            if (r == true) {
                                window.location.replace(base_url+'Register/openRegister');
                            }
                            return false;    
                        }

                        response = JSON.parse(response);
                        $('#myModal').modal('show');
                        $('#opening_closing_register_time').show();
                        $('#opening_register_time').html(response.opening_date_time);
                        

                        var t1 = response.opening_date_time.split(/[- :]/);
                        var d1 = new Date(Date.UTC(t1[0], t1[1]-1, t1[2], t1[3], t1[4], t1[5]));
                        var t2 = response.closing_date_time.split(/[- :]/);
                        var d2 = new Date(Date.UTC(t2[0], t2[1]-1, t2[2], t2[3], t2[4], t2[5]));

                        if(d1>d2){
                            $('#closing_register_time').html('<?php echo lang('not_closed_yet'); ?>');
                        }else{
                            $('#closing_register_time').html(response.closing_date_time);
                        }

                        
                        var register_detail_modal_content = '';
                        var customer_due_receive = (response.customer_due_receive==null)?0:response.customer_due_receive;
                        var opening_balance = (response.opening_balance==null)?0:response.opening_balance;
                        var sale_due_amount = (response.sale_due_amount==null)?0:response.sale_due_amount;
                        var sale_in_card = (response.sale_in_card==null)?0:response.sale_in_card;
                        var sale_in_cash = (response.sale_in_cash==null)?0:response.sale_in_cash;
                        var sale_in_paypal = (response.sale_in_paypal==null)?0:response.sale_in_paypal;
                        var sale_paid_amount = (response.sale_paid_amount==null)?0:response.sale_paid_amount;
                        var sale_total_payable_amount = (response.sale_total_payable_amount==null)?0:response.sale_total_payable_amount;

                        var balance = (parseFloat(opening_balance)+parseFloat(sale_paid_amount)+parseFloat(customer_due_receive)).toFixed(2);
                        register_detail_modal_content += '<p><?php echo lang('opening_balance'); ?>: '+currency+' '+opening_balance+'</p>';
                        // register_detail_modal_content += '<p>Sale Total Amount: '+currency+' '+sale_total_payable_amount+'</p>';
                        register_detail_modal_content += '<p><?php echo lang('sale'); ?> (<?php echo lang('paid_amount'); ?>): '+currency+' '+sale_paid_amount+'</p>';
                        // register_detail_modal_content += '<p>Sale Due Amount: '+currency+' '+sale_due_amount+'</p>';
                        // register_detail_modal_content += '<p>&nbsp;</p>';
                        register_detail_modal_content += '<p><?php echo lang('customer_due_receive'); ?>: '+currency+' '+customer_due_receive+'</p>';
                        register_detail_modal_content += '<p>Balance {<?php echo lang('opening_balance'); ?> + <?php echo lang('sale'); ?> (<?php echo lang('paid_amount'); ?>) + <?php echo lang('customer_due_receive'); ?>}: '+currency+' '+balance+'</p>';
                        register_detail_modal_content += '<p style="width:100%;border-bottom:1px solid #b5d6f6;line-height:0px;">&nbsp;</p>';

                        register_detail_modal_content += '<p><?php echo lang('sale'); ?> <?php echo lang('in'); ?> <?php echo lang('cash'); ?>: '+currency+' '+sale_in_cash+'</p>';
                        register_detail_modal_content += '<p><?php echo lang('sale'); ?> <?php echo lang('in'); ?> <?php echo lang('paypal'); ?>: '+currency+' '+sale_in_paypal+'</p>';
                        register_detail_modal_content += '<p><?php echo lang('sale'); ?> <?php echo lang('sale'); ?> <?php echo lang('card'); ?>: '+currency+' '+sale_in_card+'</p>';
                        
                        // register_detail_modal_content += '<p style="width:100%;border-bottom:1px solid #b5d6f6;line-height:0px;">&nbsp;</p>';
                        // register_detail_modal_content += '<p>Balance: '+currency+' '+balance+'</p>';

                        
                        $('#register_details_body').html(register_detail_modal_content);
                        // $('#myModal').modal('hide');

                    },
                    error:function(){
                        alert("error");
                    }
                });
            });

            $('#register_close').on('click',function(){
                var r = confirm("Are you sure to close register?");
                
                if (r == true) {
                    $.ajax({
                        url: '<?php echo base_url("Sale/closeRegister"); ?>',
                        method:"POST",
                        data:{
                            csrf_test_name: $.cookie('csrf_cookie_name')
                        },
                        success:function(response) {
                            swal({
                                title: 'Alert',
                                text: 'Register closed successfully!!',
                                confirmButtonColor: '#b6d6f6' 
                            });
                            $('#close_register_button').hide();

                        },
                        error:function(){
                            alert("error");
                        }
                    });     
                }    
            });
            function IsJsonString(str) {
                try {
                    JSON.parse(str);
                } catch (e) {
                    return false;
                }
                return true;
            }
            function todaysSummary() {
                $.ajax({
                    url     : '<?php echo base_url('Report/todayReport') ?>',
                    method  : 'get',
                    dataType: 'json',
                    data    : {},
                    success:function(data){
                        $("#purchase").text("<?php echo $this->session->userdata('currency') ?> "+data.total_purchase_amount);
                        $("#sale").text("<?php echo $this->session->userdata('currency') ?> "+data.total_sales_amount);
                        $("#totalVat").text("<?php echo $this->session->userdata('currency') ?> "+data.total_sales_vat);
                        $("#Expense").text("<?php echo $this->session->userdata('currency') ?> "+data.expense_amount);
                        $("#supplierDuePayment").text("<?php echo $this->session->userdata('currency') ?> "+data.supplier_payment_amount);
                        $("#customerDueReceive").text("<?php echo $this->session->userdata('currency') ?> "+data.customer_receive_amount);
                        $("#waste").text("<?php echo $this->session->userdata('currency') ?> "+data.total_loss_amount);
                        $("#balance").text("<?php echo $this->session->userdata('currency') ?> "+data.balance);
                        $.ajax({
                            url     : '<?php echo base_url('Report/todayReportCashStatus') ?>',
                            method  : 'get',
                            datatype: 'json',
                            data    : {},
                            success:function(data){
                                var json = $.parseJSON(data);
                                var i = 1;
                                var html = '<table class="table">';
                                $.each(json, function (index, value) {
                                    html+='<tr><td style="width: 86%">'+i+'. Sale in '+value.name+'</td> <td><?php echo $this->session->userdata('currency') ?> '+value.total_sales_amount+'</td></tr>';
                                    i++;
                                });
                                html+='</table>';
                                $("#showCashStatus").html(html);
                            }
                        });
                    }
                });
                $("#todaysSummary").modal("show");
            }


        </script>
    </body>
</html>
