<style type="text/css">
    .top-left-header{
        margin-top: 0px !important;
    }
</style>

<section class="content-header">
    <h3  style="text-align: center;margin-top: 0px"><?php echo lang('kitchen_performance_report'); ?></h3>
    <hr style="border: 1px solid #3c8dbc;">
    <div class="row">
        <div class="col-md-2">
            <?php echo form_open(base_url() . 'Report/kitchenPerformanceReport') ?>
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
                    <h3><?php echo lang('kitchen_performance_report'); ?></h3>
                    <h4><?= isset($start_date) && $start_date && isset($end_date) && $end_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($start_date)) . " - " . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?><?= isset($start_date) && $start_date && !$end_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($start_date)) : '' ?><?= isset($end_date) && $end_date && !$start_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?></h4> 
                    <br>
                    <table id="datatable"  class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 1%"><?php echo lang('sn'); ?></th>
                                <th><?php echo lang('date'); ?></th>
                                <th><?php echo lang('order_number'); ?></th>
                                <th><?php echo lang('type'); ?></th>
                                <th><?php echo lang('order_time'); ?></th>
                                <th><?php echo lang('cooking_start_time'); ?></th>
                                <th><?php echo lang('cooking_end_time'); ?></th>
                                <th><?php echo lang('time_taken'); ?></th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if (isset($kitchenPerformanceReport)):
                                foreach ($kitchenPerformanceReport as $key => $value) { 
                                    $key++;
                                    ?>
                                    <tr>
                                        <td style="text-align: center"><?php echo $key; ?></td>
                                        <td><?= date($this->session->userdata('date_format'), strtotime($value->sale_date)) ?></td>
                                        <td><?php echo $value->sale_no ?></td> 
                                        <td><?php echo getOrderType($value->order_type) ?></td> 
                                        <td><?php echo $value->order_time; ?></td>
                                        <td><?php echo $value->cooking_start_time; ?></td>
                                        <td><?php echo $value->cooking_done_time; ?></td>
                                        <td>
                                            <?php 
                                                if($value->cooking_done_time == '0000-00-00 00:00:00'){ 
                                                    echo 'N/A'; 
                                                }else{   
                                                    $cooking_done_time = strtotime($value->cooking_done_time);
                                                    $order_time = strtotime($value->order_time);
                                                    $minute = round(abs($cooking_done_time - $order_time) / 60,2); 
                                                    $hour = round(abs($minute) / 60,2);
                                                    echo $hour." ".lang('hour'); 
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            endif;
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="width: 1%"><?php echo lang('sn'); ?></th>
                                <th><?php echo lang('date'); ?></th>
                                <th><?php echo lang('order_number'); ?></th>
                                <th><?php echo lang('type'); ?></th>
                                <th><?php echo lang('order_time'); ?></th>
                                <th><?php echo lang('cooking_start_time'); ?></th>
                                <th><?php echo lang('cooking_end_time'); ?></th>
                                <th><?php echo lang('time_taken'); ?></th> 
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

    var TITLE = "<?php echo lang('kitchen_performance_report'); ?> "+today; 

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