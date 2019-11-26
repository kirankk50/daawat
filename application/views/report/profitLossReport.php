<style type="text/css">
    .top-left-header{
        margin-top: 0px !important;
    }
</style>

<section class="content-header">
    <h3 style="text-align: center"><?php echo lang('profit_loss_report'); ?></h3>
    <hr style="border: 1px solid #3c8dbc;">
    <div class="row">
        <div class="col-md-2">
            <?php echo form_open(base_url() . 'Report/profitLossReport') ?>
            <div class="form-group">
                <input tabindex="1" type="text" id="" name="startDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('start_date'); ?>" value="<?php echo set_value('startDate'); ?>">
            </div>
        </div>
        <div class="col-md-2">

            <div class="form-group">
                <input tabindex="2" type="text" id="endMonth" name="endDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('end_date'); ?>" value="<?php echo set_value('endDate'); ?>">
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                <button type="submit" name="submit" value="submit" class="btn btn-block btn-primary pull-left"><?php echo lang('submit'); ?></button>
            </div>
        </div>
        <div class="hidden-lg">
            <div class="clearfix"></div>
        </div> 
    </div>
</section><style type="text/css">
    h1,h2,h3,h4,p{
        margin:3px 0px;
    }

    .tbl  {
        border-collapse:collapse;
        border-spacing:0;
        width: 100%;
        border:0px solid transparent;
    }
    .tbl tr td{
        border:0px solid transparent;
        padding: 10px;
    }.tbl tr th{
        border:0px solid transparent;
        padding: 10px;
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

                <h3 style="text-align: center"><?php echo lang('profit_loss_report'); ?></h3>
                <h4 style="text-align: center"><?= isset($start_date) && $start_date && isset($end_date) && $end_date ? "Date: " . date($this->session->userdata('date_format'), strtotime($start_date)) . " - " . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?><?= isset($start_date) && $start_date && !$end_date ? "Date: " . date($this->session->userdata('date_format'), strtotime($start_date)) : '' ?><?= isset($end_date) && $end_date && !$start_date ? "Date: " . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?></h4>
                <br>
                <div class="box-body table-responsive">
                    <table class="table table-bordered table-striped" id="datatable">
                        <thead>
                            <th style="width: 70%;">&nbsp;</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tr>
                            <td style="width: 40%;"><?php echo lang('purchase'); ?>(<?php echo lang('only_paid_amount'); ?>)</td> 
                            <td><?= isset($saleReportByDate['total_purchase_amount']) ? $saleReportByDate['total_purchase_amount'] : '0.0' ?> </td>
                        </tr>
                        <tr>
                            <td><?php echo lang('sale'); ?>(<?php echo lang('only_paid_amount'); ?>)</td> 
                            <td><?= isset($saleReportByDate['total_sales_amount']) ? $saleReportByDate['total_sales_amount'] : '0.0' ?> </td>
                        </tr>
                        <tr>
                            <td><?php echo lang('total'); ?> <?php echo lang('vat'); ?></td> 
                            <td><?= isset($saleReportByDate['total_sales_vat']) ? $saleReportByDate['total_sales_vat'] : '0.0' ?></td>
                        </tr>
                        <tr>
                            <td><?php echo lang('expense'); ?></td> 
                            <td><?= isset($saleReportByDate['expense_amount']) ? $saleReportByDate['expense_amount'] : '0.0' ?> </td>
                        </tr>
                        <tr>
                            <td><?php echo lang('supplier_due_payment'); ?></td>
                            <td> <?= isset($saleReportByDate['supplier_payment_amount']) ? $saleReportByDate['supplier_payment_amount'] : '0.0' ?></td>
                        </tr>
                        <tr>
                            <td><?php echo lang('customer_due_receive'); ?></td>
                            <td><?= isset($saleReportByDate['customer_due_receive']) ? $saleReportByDate['customer_due_receive'] : '0.0' ?></td>
                        </tr>
                        <tr>
                            <td><?php echo lang('waste'); ?></td> 
                            <td><?= isset($saleReportByDate['total_loss_amount']) ? $saleReportByDate['total_loss_amount'] : '0.0' ?> </td>
                        </tr> 
                        <tr>
                            <td style="width: 80%;"><?php echo lang('gross_profit'); ?> = ((<?php echo lang('sale'); ?> + <?php echo lang('customer_due_receive'); ?>) - (<?php echo lang('purchase'); ?> + <?php echo lang('waste'); ?> + <?php echo lang('expense'); ?> + <?php echo lang('supplier_due_payment'); ?>))</td>
                            <td style="width: 20%;"><?= isset($saleReportByDate['gross_profit']) ? number_format($saleReportByDate['gross_profit'], 2) : '0.0' ?></td>
                        </tr>
                        <tr>
                            <td style="width: 80%;"><?php echo lang('net_profit'); ?> = ((<?php echo lang('sale'); ?> + <?php echo lang('customer_due_receive'); ?>) - (<?php echo lang('purchase'); ?> + <?php echo lang('waste'); ?> + <?php echo lang('expense'); ?> + <?php echo lang('supplier_due_payment'); ?>) - <?php echo lang('vat'); ?>))</td>
                            <td style="width: 20%;"><?= isset($saleReportByDate['net_profit']) ? number_format($saleReportByDate['net_profit'], 2) : '0.0' ?> </td>
                        </tr>
                        <tfoot>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        </tfoot>                        
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

/*    var jq = $.noConflict();
jq(document).ready(function(){
    jq("button").click(function(){
        jq("p").text("jQuery is still working!");
    });
});*/
    var jqry = $.noConflict();
    jqry(document).ready(function(){

    var TITLE = "Profit/Loss Report "+today; 

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