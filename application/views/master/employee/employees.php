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
            <h2 class="top-left-header"><?php echo lang('employees'); ?> </h2>
        </div>
        <div class="col-md-offset-4 col-md-2">
            <a href="<?php echo base_url() ?>Master/addEditEmployee"><button type="button" class="btn btn-block btn-primary pull-right"><?php echo lang('add_employee'); ?></button></a>
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
                                <th style="width: 25%"><?php echo lang('name'); ?></th>
                                <th style="width: 16%"><?php echo lang('designation'); ?></th>
                                <th style="width: 11%"><?php echo lang('phone'); ?></th>
                                <th style="width: 22%"><?php echo lang('description'); ?></th>
                                <th style="width: 16%"><?php echo lang('added_by'); ?></th>
                                <th style="width: 6%;text-align: center"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($employees && !empty($employees)) {
                                $i = count($employees);
                            }
                            foreach ($employees as $empls) {
                                ?>                       
                                <tr> 
                                    <td style="text-align: center"><?php echo $i--; ?></td>
                                    <td><?php echo $empls->name; ?></td> 
                                    <td><?php echo $empls->designation; ?></td> 
                                    <td><?php echo $empls->phone; ?></td> 
                                    <td><?php if ($empls->description != NULL) echo $empls->description; ?></td> 
                                    <td><?php echo userName($empls->user_id); ?></td>  
                                    <td style="text-align: center">
                                        <?php if ($empls->name != "Default Waiter") { ?>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right" role="menu"> 
                                                <li><a href="<?php echo base_url() ?>Master/addEditEmployee/<?php echo $this->custom->encrypt_decrypt($empls->id, 'encrypt'); ?>" ><i class="fa fa-pencil tiny-icon"></i><?php echo lang('edit'); ?></a></li>
                                                <li><a class="delete" href="<?php echo base_url() ?>Master/deleteEmployee/<?php echo $this->custom->encrypt_decrypt($empls->id, 'encrypt'); ?>" ><i class="fa fa-trash tiny-icon"></i><?php echo lang('delete'); ?></a></li> 
                                            </ul> 
                                        </div>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?> 
                        </tbody>
                        <tfoot>
                            <tr>
                                <th><?php echo lang('sn'); ?></th>
                                <th><?php echo lang('name'); ?></th>
                                <th><?php echo lang('designation'); ?></th>
                                <th><?php echo lang('phone'); ?></th>
                                <th><?php echo lang('description'); ?></th>
                                <th><?php echo lang('added_by'); ?></th>  
                                <th style="text-align: center"><?php echo lang('actions'); ?></th>
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
