<style type="text/css">
    .top-left-header{
        margin-top: 0px !important;
    }
</style>

<section class="content-header">
    <h3  style="text-align: center;margin-top: 0px"><?php echo lang('attendance_report'); ?></h3>
    <hr style="border: 1px solid #3c8dbc;">
    <div class="row">
        <div class="col-md-2">
            <?php echo form_open(base_url() . 'Report/attendanceReport') ?>
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
                <select tabindex="2" class="form-control select2" id="employee_id" name="employee_id" style="width: 100%;">
                    <option value=""><?php echo lang('employee'); ?></option>
                    <?php
                    foreach ($employees as $value) {
                        ?>
                        <option value="<?php echo $value->id ?>" <?php echo set_select('employee_id', $value->id); ?>><?php echo $value->name ?></option>
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
                    <h3><?php echo lang('attendance_report'); ?></h3>
                    <h4><?= isset($start_date) && $start_date && isset($end_date) && $end_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($start_date)) . " - " . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?><?= isset($start_date) && $start_date && !$end_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($start_date)) : '' ?><?= isset($end_date) && $end_date && !$start_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?></h4>
                    <h4 style="text-align: center;margin-top: 0px"><?php
                    if (isset($employee_id) && ($employee_id)){
                        echo lang('employee').": <span style='text-decoration: underline'>" . employeeName($employee_id) . "</span>";
                    } 
                    ?></h4>
                    <br>
                    <table id="datatable"  class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 1%"><?php echo lang('sn'); ?></th>
                                <th style="width: 11%"><?php echo lang('ref_no'); ?></th>
                                <th style="width: 9%"><?php echo lang('date'); ?></th>
                                <th style="width: 18%"><?php echo lang('employee'); ?></th>
                                <th style="width: 10%"><?php echo lang('in_time'); ?></th>
                                <th style="width: 10%"><?php echo lang('out_time'); ?></th> 
                                <th style="width: 14%"><?php echo lang('time_count'); ?></th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total_hours = 0;
                            if (!empty($attendanceReport)) {
                                $i = count($attendanceReport); 
                            foreach ($attendanceReport as $value) { 

                                ?>                       
                                <tr> 
                                    <td><?php echo $i--; ?></td>
                                    <td><?php echo $value->reference_no; ?></td>
                                    <td><?php echo date($this->session->userdata('date_format'), strtotime($value->date)); ?></td>
                                    <td><?php echo employeeName($value->employee_id); ?></td>
                                    <td><?php echo $value->in_time; ?></td>
                                    <td>
                                        <?php 
                                        if($value->out_time == '00:00:00'){ 
                                            echo 'N/A<br>';  
                                        }else{ 
                                            echo $value->out_time; 
                                        } 
                                        ?> 
                                    </td> 
                                    <td>
                                        <?php  
                                        if($value->out_time == '00:00:00'){ 
                                            echo 'N/A'; 
                                        }else{ 
                                            $to_time = strtotime($value->out_time);
                                            $from_time = strtotime($value->in_time);
                                            $minute = round(abs($to_time - $from_time) / 60,2); 
                                            $hour = round(abs($minute) / 60,2);
                                            echo $hour." ".lang('hour');
                                            $total_hours += $hour;
                                        }

                                        ?> 
                                    </td> 
                                </tr> 
                                <?php
                            } }
                            ?> 
                            <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td> 
                                    <td><b><?php echo lang('total'); ?> <?php echo lang('hours'); ?></b></td>
                                    <td><?php echo $total_hours . " ".lang('hours'); ?></td>
                                </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="width: 1%"><?php echo lang('sn'); ?></th>
                                <th style="width: 11%"><?php echo lang('ref_no'); ?></th>
                                <th style="width: 9%"><?php echo lang('date'); ?></th>
                                <th style="width: 18%"><?php echo lang('employee'); ?></th>
                                <th style="width: 10%"><?php echo lang('in_time'); ?></th>
                                <th style="width: 10%"><?php echo lang('out_time'); ?></th> 
                                <th style="width: 14%"><?php echo lang('time_count'); ?></th> 
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

    var TITLE = "<?php echo lang('attendance_report'); ?> "+today; 

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