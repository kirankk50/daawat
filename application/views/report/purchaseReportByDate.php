<style type="text/css">
    .top-left-header{
        margin-top: 0px !important;
    }
</style>

<section class="content-header">
    <h3><?php echo lang('purchase_report'); ?></h3>
    <hr style="border: 1px solid #3c8dbc;">
    <div class="row"> 
        <div class="col-md-2">
            <?php echo form_open(base_url() . 'Report/purchaseReportByDate') ?>
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
                    <h3><?php echo lang('purchase_report'); ?></h3>
                    <h4><?= isset($start_date) && $start_date && isset($end_date) && $end_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($start_date)) . " - " . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?><?= isset($start_date) && $start_date && !$end_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($start_date)) : '' ?><?= isset($end_date) && $end_date && !$start_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?></h4>
                    <br>
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 2%;text-align: center;"><?php echo lang('sn'); ?></th>
                                <th style="width: 10%;"><?php echo lang('ref_no'); ?></th>
                                <th style="width: 5%;"><?php echo lang('date'); ?></th>
                                <th style="width: 10%;"><?php echo lang('supplier'); ?></th>
                                <th style="width: 12%;"><?php echo lang('grand_total'); ?></th>
                                <th style="width: 7%;"><?php echo lang('paid'); ?></th>
                                <th style="width: 7%;"><?php echo lang('due'); ?></th>
                                <th style="width: 32%;"><?php echo lang('ingredients'); ?></th>
                                <th style="width: 15%;"><?php echo lang('purchased_by'); ?></th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sum_of_grand_total = 0;
                            $sum_of_paid = 0;
                            $sum_of_due = 0;

                            if (isset($purchaseReportByDate)):
                                foreach ($purchaseReportByDate as $key => $value) { 
                                    $sum_of_grand_total += $value->grand_total;
                                    $sum_of_paid += $value->paid;
                                    $sum_of_due += $value->due;
                                    $key++;
                                    ?>
                                    <tr>
                                        <td style="text-align: center"><?php echo $key; ?></td>
                                        <td><?php echo $value->reference_no; ?></td> 
                                        <td><?= date($this->session->userdata('date_format'), strtotime($value->date)) ?></td>
                                        <td><?php echo getSupplierNameById($value->supplier_id); ?></td> 
                                        <td><?php echo $value->grand_total ?></td>
                                        <td><?php echo $value->paid ?></td>
                                        <td><?php echo $value->due ?></td>
                                        <td><?php print_r(getPurchaseIngredients($value->id)) ?></td>  
                                        <td><?php echo userName($value->user_id) ?></td>
                                    </tr>
                                    <?php
                                }
                            endif;
                            ?>
                          <tr> 
                                <td>&nbsp;</td> 
                                <td>&nbsp;</td> 
                                <td>&nbsp;</td>  
                                <td style="text-align: right"><?php echo lang('total'); ?> </td>
                                <td><?= number_format($sum_of_grand_total, 2) ?></td>
                                <td><?= number_format($sum_of_paid, 2) ?></td>
                                <td><?= number_format($sum_of_due, 2) ?></td> 
                                <td>&nbsp;</td>  
                                <td>&nbsp;</td>  
                            </tr> 
                        </tbody>
                        <tfoot> 
                            <tr>
                                <th style="width: 2%;text-align: center;"><?php echo lang('sn'); ?></th>
                                <th style="width: 10%;"><?php echo lang('ref_no'); ?></th>
                                <th style="width: 5%;"><?php echo lang('date'); ?></th>
                                <th style="width: 10%;"><?php echo lang('supplier'); ?></th>
                                <th style="width: 12%;"><?php echo lang('grand_total'); ?></th>
                                <th style="width: 7%;"><?php echo lang('paid'); ?></th>
                                <th style="width: 7%;"><?php echo lang('due'); ?></th>
                                <th style="width: 32%;"><?php echo lang('ingredients'); ?></th>
                                <th style="width: 15%;"><?php echo lang('purchased_by'); ?></th> 
                            </tr>
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

    var TITLE = "<?php echo lang('purchase_report'); ?> "+today; 

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