`
<style type="text/css">
    .required_star{
        color: #dd4b39;
    }

    .radio_button_problem{
        margin-bottom: 19px;
    }
</style>  
<section class="content-header">
    <h1>
        <?php echo lang('sms_balance'); ?>
    </h1>  
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">

                <!-- /.box-header -->
                <!-- form start --> 
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12"> 
                            <div class="form-group">
                               <h3><?php echo lang('your_current_textlocal'); ?> <b><?php echo $balance; ?></b>, <?php echo lang('please_check_in'); ?> <a href="https://textlocal.com" target="_blank"><?php echo lang('textlocal'); ?></a> <?php echo lang('to_know_how'); ?></h3>
                            </div>  
                        </div>    
                    </div> 
                    <!-- /.box-body -->
                </div> 
                <div class="box-footer"> 
                    <a href="<?php echo base_url() ?>Short_message_service/smsService"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
                </div> 
            </div>
        </div>
    </div>
</section>