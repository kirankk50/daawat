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
if ($this->session->flashdata('exception_1')) {

    echo '<section class="content-header"><div class="alert alert-danger alert-dismissible"> 
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <p><i class="icon fa fa-check"></i>';
    echo $this->session->flashdata('exception_1');
    echo '</p></div></section>';
}
?>

<?php
if ($this->session->flashdata('exception_2')) {

    echo '<section class="content-header"><div class="alert alert-danger alert-dismissible"> 
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <p><i class="icon fa fa-check"></i>';
    echo $this->session->flashdata('exception_2');
    echo '</p></div></section>';
}
?>

<style type="text/css">
    .top-left-header{
        margin-top: 0px !important;
    }
</style>

<!-- <section class="content-header">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info alert-dismissible"> 
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <p style="color: red;"><i class="icon fa fa-check"></i>Please enter into an outlet by clicking on Enter button</p>
            </div>
        </div> 
    </div> 
</section> -->

<section class="content-header">
    <div class="row">
        <div class="col-md-6">
            <h2 class="top-left-header"><?php echo lang('outlets'); ?></h2>
        </div>
        <div class="col-md-offset-4 col-md-2">
            <a href="<?php echo base_url() ?>Outlet/addEditOutlet"><button type="button" class="btn btn-block btn-primary pull-right"><?php echo lang('add_outlet'); ?></button></a>
        </div>
    </div> 
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <!-- /.col -->
                <?php
                foreach ($outlets as $value) {
                    ?>
                    <div class="col-md-4" style="margin-bottom: 10px;">

                        <div class="info-box" style="background-color: white; color:black; padding:1%; padding-left: 3%;">
                            <h3 style="text-align: center;background-color: #3c8dbc;color:white;padding-bottom: 12px;padding-top: 12px;margin-left: -10px;;margin-right: -3px;margin-top: -3px;border-top-left-radius: 4px;border-top-right-radius: 4px;"><?php echo $value->outlet_name . "     "; ?> <br><span style="font-size: 14px;"><?php echo lang('outlet_code'); ?>: <?php echo $value->outlet_code; ?></span></h3> 
                            <h4><?php echo lang('address'); ?>: <?php echo $value->address; ?> </h4>
                            <h4><?php echo lang('phone'); ?>: <?php echo $value->phone; ?> </h4>
                            <h4><?php echo lang('started_date'); ?>: <?php echo date($this->session->userdata('date_format'), strtotime($value->starting_date)); ?></h4>
                        </div>
                        <div style="width: 100%; float: left;">
                            <div style="width: 30%; float: left; margin-right: 3.33%">
                                <a style="padding: 12px;" class="btn btn-success btn btn-block" href="<?php echo base_url(); ?>Outlet/setOutletSession/<?php echo $this->custom->encrypt_decrypt($value->id, 'encrypt'); ?>"> <strong><?php echo lang('enter'); ?></strong></a>                                
                            </div>
                            <div style="width: 30%; float: left; margin-right: 3.33%">
                                <a style="padding: 12px;background-color: #3c8dbc" class="btn btn-primary btn btn-block" href="<?php echo base_url() ?>Outlet/addEditOutlet/<?php echo $this->custom->encrypt_decrypt($value->id, 'encrypt'); ?>">  <strong><?php echo lang('edit'); ?></strong></a>
                            </div>
                            <div style="width: 33.33%; float: left;">
                                <a style="padding: 12px;" class="btn btn-danger btn btn-block delete" href="<?php echo base_url() ?>Outlet/deleteOutlet/<?php echo $this->custom->encrypt_decrypt($value->id, 'encrypt'); ?>">  <strong><?php echo lang('delete'); ?></strong></a>
                            </div>

                        </div> 
                    </div> 
                    <?php
                }
                ?>
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
