 
<script type="text/javascript">  
    var ingredient_id_container = [];


    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2();
    })

</script>
<style>
    .input-sm{
        font-size:17px;
    }
</style>

<?php
if ($this->session->flashdata('exception')) {

    echo '<section class="content-header"><div class="alert alert-success alert-dismissible"> 
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <p><i class="icon fa fa-check"></i>';
    echo $this->session->flashdata('exception');
    echo '</p></div></section>';
}
?>


<?php
if ($this->session->flashdata('exception_err')) {

    echo '<section class="content-header"><div class="alert alert-danger alert-dismissible"> 
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <p><i class="icon fa fa-times"></i>';
    echo $this->session->flashdata('exception_err');
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
        <div class="col-md-2">
            <h2 class="top-left-header"><?php echo lang('modifiers'); ?> </h2>
        </div> 
        <div class="col-md-offset-8 col-md-2">
            <a href="<?php echo base_url() ?>Master/addEditModifier"><button type="button" class="btn btn-block btn-primary pull-right"><?php echo lang('add'); ?> <?php echo lang('modifier'); ?></button></a>
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
                                <th style="width: 13%"><?php echo lang('price'); ?></th>
                                <th style="width: 13%"><?php echo lang('description'); ?></th>
                                <th style="width: 13%"><?php echo lang('total'); ?> <?php echo lang('ingredients'); ?></th>
                                <th style="width: 18%"><?php echo lang('added_by'); ?></th>
                                <th style="width: 6%;text-align: center"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($modifiers && !empty($modifiers)) {
                                $i = count($modifiers);
                            }
                            foreach ($modifiers as $fdmns) {
                                ?>                       
                                <tr> 
                                    <td style="text-align: center"><?php echo $i--; ?></td> 
                                    <td><?php echo $fdmns->name; ?></td>
                                    <td> <?php echo $this->session->userdata('currency'); ?> <?php echo $fdmns->price; ?></td>
                                    <td><?php echo $fdmns->description; ?></td>
                                    <td style="text-align: center"><?php echo count(modifierIngredients($fdmns->id)); ?></td>
                                    <td><?php echo userName($fdmns->user_id); ?></td>  
                                    <td style="text-align: center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right" role="menu"> 
                                                <li><a href="<?php echo base_url() ?>Master/modifierDetails/<?php echo $this->custom->encrypt_decrypt($fdmns->id, 'encrypt'); ?>" ><i class="fa fa-eye tiny-icon"></i><?php echo lang('view_details'); ?></a></li>
                                                <li><a href="<?php echo base_url() ?>Master/addEditModifier/<?php echo $this->custom->encrypt_decrypt($fdmns->id, 'encrypt'); ?>" ><i class="fa fa-pencil tiny-icon"></i><?php echo lang('edit'); ?></a></li>
                                                <li><a class="delete" href="<?php echo base_url() ?>Master/deleteModifier/<?php echo $this->custom->encrypt_decrypt($fdmns->id, 'encrypt'); ?>" ><i class="fa fa-trash tiny-icon"></i><?php echo lang('delete'); ?></a></li> 
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
                                <th style="width: 1%"><?php echo lang('sn'); ?></th> 
                                <th style="width: 25%"><?php echo lang('name'); ?></th>
                                <th style="width: 13%"><?php echo lang('price'); ?></th>
                                <th style="width: 13%"><?php echo lang('description'); ?></th>
                                <th style="width: 13%"><?php echo lang('total'); ?> <?php echo lang('ingredients'); ?></th>
                                <th style="width: 18%"><?php echo lang('added_by'); ?></th>
                                <th style="width: 6%;text-align: center"><?php echo lang('actions'); ?></th>
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
