 
<script type="text/javascript">  
    var ingredient_id_container = [];


    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2();
    })
</script>

<?php
if ($this->session->flashdata('exception')) {

    echo '<section class="content-header"><div class="alert alert-success alert-dismissible"> 
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <p><i class="icon fa fa-check"></i>';
    echo $this->session->flashdata('exception');
    echo '</p></div></section>';
}
?> 

<style type="text/css">
    .top-left-header{
        margin-top: 0px !important;
    }
</style>

<section class="content-header">
    <div class="row">
        <div class="col-md-6">
            <h2 class="top-left-header"><?php echo lang('wastes'); ?> </h2>
        </div>
        <div class="col-md-offset-4 col-md-2">
            <a href="<?php echo base_url() ?>Waste/addEditWaste"><button type="button" class="btn btn-block btn-primary pull-right"><?php echo lang('add_waste'); ?></button></a>
        </div>
    </div> 
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary"> 
                <!-- /.box-header -->
                <div class="box-body table-responsive"> 
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 1%"><?php echo lang('sn'); ?></th>
                                <th style="width: 11%"><?php echo lang('ref_no'); ?></th>
                                <th style="width: 8%"><?php echo lang('date'); ?></th>
                                <th style="width: 9%"><?php echo lang('total_loss'); ?></th>
                                <th style="width: 13%"><?php echo lang('ingredient_count'); ?></th>
                                <th style="width: 15%"><?php echo lang('responsible_person'); ?></th>
                                <th style="width: 21%" style="width: 22%;"><?php echo lang('note'); ?></th>
                                <th style="width: 12%"><?php echo lang('added_by'); ?></th>
                                <th style="width: 6%"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($wastes && !empty($wastes)) {
                                $i = count($wastes);
                            }
                            foreach ($wastes as $wsts) {
                                ?>                       
                                <tr> 
                                    <td style="text-align: center"><?php echo $i--; ?></td>
                                    <td><?php echo $wsts->reference_no; ?></td>
                                    <td><?php echo date($this->session->userdata('date_format'), strtotime($wsts->date)); ?></td>
                                    <td><?php echo $this->session->userdata('currency') . " " . $wsts->total_loss ?></td>
                                    <td style="text-align: center;"><?php echo ingredientCount($wsts->id); ?></td>
                                    <td><?php echo employeeName($wsts->employee_id); ?></td>  
                                    <td><?php echo $wsts->note; ?></td>  
                                    <td><?php echo userName($wsts->user_id); ?></td>  
                                    <td style="text-align: center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right" role="menu"> 
                                                <li><a href="<?php echo base_url() ?>Waste/wasteDetails/<?php echo $this->custom->encrypt_decrypt($wsts->id, 'encrypt'); ?>" ><i class="fa fa-eye tiny-icon"></i><?php echo lang('view_details'); ?></a></li> 
                                                <li><a class="delete" href="<?php echo base_url() ?>Waste/deleteWaste/<?php echo $this->custom->encrypt_decrypt($wsts->id, 'encrypt'); ?>" ><i class="fa fa-trash tiny-icon"></i><?php echo lang('delete'); ?></a></li> 
                                            </ul> 
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?> 
                        </tbody>
                        <tfoot>
                            <tr>
                                <th><?php echo lang('sn'); ?></th>
                                <th><?php echo lang('ref_no'); ?></th>
                                <th><?php echo lang('date'); ?></th>
                                <th><?php echo lang('total_loss'); ?></th>
                                <th><?php echo lang('ingredient_count'); ?></th>
                                <th><?php echo lang('responsible_person'); ?></th> 
                                <th><?php echo lang('note'); ?></th>  
                                <th><?php echo lang('added_by'); ?></th>  
                                <th><?php echo lang('actions'); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->
            </div> 
        </div> 
    </div> 
</section>
<!-- DataTables -->
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script>
    $(function () { 
        $('#datatable').DataTable({ 
            'autoWidth'   : false,
            'ordering'    : false
        })
    })
</script>
