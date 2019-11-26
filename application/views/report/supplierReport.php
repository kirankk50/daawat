<style type="text/css">
    .top-left-header{
        margin-top: 0px !important;
    }
</style>

<style type="text/css">
    .required_star{
        color: #dd4b39;
    }

    .radio_button_problem{
        margin-bottom: 19px;
    }
    .foodMenuCartNotice{
        border: 2px solid red;
        padding: 4px;
        border-radius: 5px;
        color: red;
        font-size: 14px;
        margin-top: 5px;
        margin-bottom: 44px;
    }
    .cart_container{
        /* border: 1px solid black;*/
    }
    .cart_header{
        background-color: #ecf0f5;
        padding: 5px 0px;
        margin-bottom: 5px;
    }
    .ch_content{
        font-weight: bold;
    }
    .custom_form_control{
        border-radius: 0;
        box-shadow: none;
        border-color: #d2d6de;
        width: 80%;
        height: 26px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        margin: 0px 3px 7px 0px;
    }
    .center_positition{
        text-align: center !important;
    }
    .error-msg{
        display:none;
    }
    .aligning{
        width: 80%; float:left;
    }
    .aligning_x{
        width: 80%;
    }
    .label_aligning{
        float: left; padding: 5px 0px 0px 3px;
    }
    .label-aligning_x{
        float: left; padding: 5px 0px 0px 3px;
    }
</style>
<script>
    $(function () {
        $("#supplierReport").submit(function () {
            var supplier_id = $("#supplier_id").val();
            var error = false;
            if (supplier_id == "") {
                $("#supplier_id_err_msg").text("The Supplier field is required.");
                $(".supplier_id_err_msg_contnr").show(200);
                error = true;
            }

            if (error == true) {
                return false;
            }
        });
    });
</script>
<section class="content-header">
    <h3  style="text-align: center;margin-top: 0px"><?php echo lang('supplier_report'); ?></h3>
    <hr style="border: 1px solid #3c8dbc;">
    <div class="row">
        <div class="col-md-2">
            <?php echo form_open(base_url() . 'Report/supplierReport', $arrayName = array('id' => 'supplierReport')) ?>
            <div class="form-group">
                <input tabindex="1" type="text" id="" name="startDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('start_date'); ?>" value="<?php echo set_value('startDate'); ?>">
            </div>
        </div>
        <div class="col-md-2">

            <div class="form-group">
                <input tabindex="2" type="text" id="endMonth" name="endDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('end_date'); ?>" value="<?php echo set_value('endDate'); ?>">
            </div>
        </div>
        <div class="col-md-3">

            <div class="form-group">
                <select tabindex="2" class="form-control select2"  id="supplier_id" name="supplier_id" style="width: 100%;">
                    <option value=""><?php echo lang('suppliers'); ?></option>
                    <?php
                    foreach ($suppliers as $value) {
                        ?>
                        <option value="<?php echo $value->id ?>" <?php echo set_select('supplier_id', $value->id); ?>><?php echo $value->name ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="alert alert-error error-msg supplier_id_err_msg_contnr" style="padding: 5px !important;">
                <p id="supplier_id_err_msg"></p>
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
                    <h3>Supplier Report</h3>
                    <h4 style="text-align: center;margin-top: 0px"><?php
                    if (isset($supplier_id) && $supplier_id):
                        echo "<span>" . getSupplierNameById($supplier_id) . "</span>";
                    endif;
                    ?></h4>
                    <h4><?= isset($start_date) && $start_date && isset($end_date) && $end_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($start_date)) . " - " . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?><?= isset($start_date) && $start_date && !$end_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($start_date)) : '' ?><?= isset($end_date) && $end_date && !$start_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?></h4>
                    <br>
                    <h4 style="text-align: left;margin-bottom: 10px"><?php echo lang('purchase'); ?></h4>
                    <table class="datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 2%;text-align: center"><?php echo lang('sn'); ?></th>
                                <th><?php echo lang('date'); ?></th>
                                <th><?php echo lang('reference'); ?></th>
                                <th><?php echo lang('g_total'); ?></th>
                                <th><?php echo lang('paid'); ?></th>
                                <th><?php echo lang('due'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $pGrandTotal = 0;
                            $pPaid = 0;
                            $pDue = 0;
                            if (isset($supplierReport)):
                                foreach ($supplierReport as $key => $value) {
                                    $pGrandTotal+=$value->grand_total;
                                    $pPaid+=$value->paid;
                                    $pDue+=$value->due;
                                    $key++;
                                    ?>
                                    <tr>
                                        <td style="text-align: center"><?php echo $key; ?></td>
                                        <td><?= date($this->session->userdata('date_format'), strtotime($value->date)) ?></td>
                                        <td><?php echo $value->reference_no ?></td>
                                        <td><?php echo $value->grand_total ?></td>
                                        <td><?php echo $value->paid ?></td>
                                        <td><?php echo $value->due ?></td>
                                    </tr>
                                    <?php
                                }
                            endif;
                            ?>
                        </tbody>
                        <tfoot>
                        <th style="width: 2%;text-align: center"></th>
                        <th></th>
                        <th style="text-align: right"><?php echo lang('total'); ?></th>
                        <th><?= number_format($pGrandTotal, 2) ?></th>
                        <th><?= number_format($pPaid, 2) ?></th>
                        <th><?= number_format($pDue, 2) ?></th>
                        </tfoot>
                    </table>
                    <br>
                    <h4 style="text-align: left;margin-bottom: 10px"><?php echo lang('due_payment'); ?></h4>
                    <table class="datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 2%;text-align: center"><?php echo lang('sn'); ?></th>
                                <th><?php echo lang('date'); ?></th>
                                <th><?php echo lang('payment_amount'); ?></th>
                                <th style="width: 45%"><?php echo lang('note'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totalAmount = 0;

                            if (isset($supplierDuePaymentReport)):
                                foreach ($supplierDuePaymentReport as $key => $value) {
                                    $totalAmount+=$value->amount;
                                    $key++;
                                    ?>
                                    <tr>
                                        <td style="text-align: center"><?php echo $key; ?></td>
                                        <td><?= date($this->session->userdata('date_format'), strtotime($value->date)) ?></td>
                                        <td><?php echo $value->amount ?></td>
                                        <td><?php echo $value->note ?></td>
                                    </tr>
                                    <?php
                                }
                            endif;
                            ?>
                        </tbody>
                        <tfoot>
                        <th style="width: 2%;text-align: center"></th>
                        <th style="text-align: right"><?php echo lang('total'); ?></th>
                        <th><?= number_format($totalAmount, 2) ?></th>
                        <th></th>
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
    var jqry = $.noConflict();
    jqry(document).ready(function(){

    var TITLE = "<?php echo lang('supplier_ledger_report'); ?> "+today; 

    jqry('.datatable').DataTable( {
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