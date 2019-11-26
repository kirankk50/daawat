<?php 
    
    $show_register_report = "";
    if(isset($register_info) && count($register_info)>0){
        
        $i = 1;
        foreach($register_info as $single_register_info){
            $payment_methods_sale = json_decode($single_register_info->payment_methods_sale);
            // echo "<pre>";
            // var_dump($payment_methods_sale);
            // echo "</pre>";
            $cash = is_null($payment_methods_sale)?lang('register_cash').' 0.00':lang('register_cash').$payment_methods_sale->Cash;
            $paypal = is_null($payment_methods_sale)?lang('register_paypal').'0.00':lang('register_paypal').$payment_methods_sale->Paypal;
            $card = is_null($payment_methods_sale)?lang('register_card').'0.00':lang('register_card').$payment_methods_sale->Card;
            $show_register_report .= "<tr>";
            $show_register_report .= '<td>'.$i.'</td>';
            $show_register_report .= '<td>'.$single_register_info->opening_balance_date_time.'</td>';
            $show_register_report .= '<td>'.$single_register_info->opening_balance.'</td>';
            $show_register_report .= '<td>'.$single_register_info->sale_paid_amount.'</td>';
            $show_register_report .= '<td>'.$single_register_info->customer_due_receive.'</td>';
            $show_register_report .= '<td>'.$single_register_info->closing_balance_date_time.'</td>';
            $show_register_report .= '<td>'.$single_register_info->closing_balance.'</td>';
            $show_register_report .= '<td>'.$cash.', '.$paypal.', '.$card.'</td>';
            // $show_register_report .= '<td>'.$payment_methods_sale->Cash.', '.$payment_method_sale->Paypal.', '.$payment_method_sale->Card.'</td>';
            $show_register_report .= "</tr>";        
            $i++;
        }
    }
    $user_option = '';
    foreach($users as $single_user){
        $user_option .= '<option value="'.$single_user->id.'">'.$single_user->full_name.'</option>';
    }
    
?>

<style type="text/css">
    .top-left-header{
        margin-top: 0px !important;
    }
</style>

<section class="content-header">
    <h3><?php echo lang('register_report'); ?></h3>
    <hr style="border: 1px solid #3c8dbc;">
    <div class="row"> 
        <div class="col-md-2">
            <?php echo form_open(base_url() . 'Report/registerReport') ?>
            <div class="form-group"> 
                <input tabindex="1" type="text" id="" name="startDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('start_date'); ?>" value="<?php echo set_value('startDate'); ?>">
            </div> 
        </div>
        <div class="col-md-2">

            <div class="form-group">
                <input tabindex="2" type="text" id="endMonth" name="endDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('end_date'); ?>" value="<?php echo set_value('endDate'); ?>">
            </div>
        </div>
        <div class="col-md-2">

            <div class="form-group">
                <select tabindex="2" class="form-control select2" id="user_id" name="user_id" style="width: 100%;">
                    <option value=""><?php echo lang('user'); ?></option>
                    <option value="<?= $this->session->userdata['user_id']; ?>"><?= $this->session->userdata['full_name']; ?></option>
                    <?php
                    foreach ($users as $value) {
                        ?>
                        <option value="<?php echo $value->id ?>"><?php echo $value->full_name ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                <button type="submit" name="submit" value="submit" class="btn btn-block btn-primary pull-left"><?php echo lang('submit'); ?></button>
            </div>
        </div>
        <div class="hidden-lg">
            <div class="clearfix"></div>
        </div><!-- 
        <div class="col-md-offset-3 col-md-2">
            <div class="form-group">
                <a target="_blank" href="<?= base_url() . 'PdfGenerator/saleReportByDate/' ?><?= isset($start_date) && $start_date ? $this->custom->encrypt_decrypt($start_date, 'encrypt') : '0'; ?>/<?= isset($end_date) && $end_date ? $this->custom->encrypt_decrypt($end_date, 'encrypt') : '0'; ?>/<?= isset($user_id) && $user_id ? $this->custom->encrypt_decrypt($user_id, 'encrypt') : '0'; ?>" class="btn btn-block btn-primary pull-left">Export PDF</a>
            </div>
        </div>  -->
    </div> 
</section> 
<style type="text/css">
    h1,h2,h3,h4,p{
        margin:3px 0px;
        text-align: center;
    }

    .tbl  {
        border-collapse:collapse;
        border-spacing:0;
        width: 100%;

    }
    .tbl tr td{
        padding:14px;
        font-family:Arial, sans-serif;
        font-size:15px;
        border-style:solid;
        border-width:1px;
        word-break:break-all;
    }

    .title{
        font-weight: bold;
    }
    .box-primary{
        border-top-color: white !important;
        margin-top: 5px;
    }
</style> 
<section class="content"> 
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary"> 
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <h3><?php echo lang('register_report'); ?></h3>
                    <h4 style="text-align: center;margin-top: 0px"><?php
                    if (isset($user_id) && $user_id):
                        echo "User: " . userName($user_id) . "</span>";
                    endif;
                    ?></h4>
                    <h4><?= isset($start_date) && $start_date && isset($end_date) && $end_date ? "Date: " . date($this->session->userdata('date_format'), strtotime($start_date)) . " - " . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?><?= isset($start_date) && $start_date && !$end_date ? "Date: " . date($this->session->userdata('date_format'), strtotime($start_date)) : '' ?><?= isset($end_date) && $end_date && !$start_date ? "Date: " . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?></h4>
                    <br>
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="title" style="width: 5%"><?php echo lang('sn'); ?></th>
                                <th class="title" style="width: 10%"><?php echo lang('opening_date_time'); ?></th>
                                <th class="title" style="width: 15%"><?php echo lang('opening_balance'); ?></th>
                                <th class="title" style="width: 15%"><?php echo lang('sale'); ?> (<?php echo lang('paid_amount'); ?>)</th>
                                <th class="title" style="width: 15%"><?php echo lang('customer_due_receive'); ?></th>
                                <th class="title" style="width: 10%"><?php echo lang('closing_date_time'); ?></th>
                                <th class="title" style="width: 15%"><?php echo lang('closing_balance'); ?></th>
                                <th class="title" style="width: 15%"><?php echo lang('sale_in_payment_method'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            echo $show_register_report;
                            ?>
                        </tbody>
                        <!-- <tfoot>
                            <tr>
                                <th style="width: 2%;text-align: center"></th>
                                <th style="text-align: right">Total </th>
                                <th><?= number_format($grandTotal, 2) ?></th>
                            </tr>
                        </tfoot> -->
                    </table>
                </div>
                <!-- /.box-body -->
            </div> 
        </div> 
    </div> 
</section>   

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script> 

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">

<script>  
    var jqry = $.noConflict();
    jqry(document).ready(function(){

    var TITLE = "Register Report "+today; 

    jqry('#datatable').DataTable( {
        'autoWidth'   : false,
        'ordering'    : false,
        dom: 'Bfrtip',
        buttons: [ 
            {
                extend: 'print',
                title: TITLE
            },
            {
                extend: 'excelHtml5',
                title: TITLE
            },
            {
                extend: 'pdfHtml5',
                title: TITLE
            }
        ]
    } );
} );
</script> 