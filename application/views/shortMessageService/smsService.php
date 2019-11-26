<?php
if ($this->session->flashdata('exception_2')) {

    echo '<section class="content-header"><div class="alert alert-danger alert-dismissible"> 
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <p><i class="icon fa fa-check"></i>';
    echo $this->session->flashdata('exception_2');
    echo '</p></div></section>';
}
?>  

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
    .required_star{
        color: #dd4b39;
    }

    .radio_button_problem{
        margin-bottom: 19px;
    }
</style>  
<section class="content-header">
    <h1>
        <?php echo lang('sms_service_chose_option'); ?>
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
                        <div class="col-md-3"> 
                            <div class="form-group">
                                <a class="btn btn-primary btn-block" href="https://www.textlocal.com/" target="_blank"><?php echo lang('signup_text_local'); ?></a>
                            </div>  
                        </div> 
                        <div class="col-md-3"> 
                            <div class="form-group">
                                <a class="btn btn-primary btn-block" href="<?php echo base_url();?>Authentication/SMSSetting/1"><?php echo lang('configure_sms'); ?></a>
                            </div>  
                        </div> 
                        <div class="col-md-3"> 
                            <div class="form-group">
                                <a class="btn btn-primary btn-block" href="<?php echo base_url();?>Short_message_service/sendSMS/test"><?php echo lang('send_test_sms'); ?></a>
                            </div>  
                        </div> 
                        <div class="col-md-3"> 
                            <div class="form-group">
                                <a class="btn btn-primary btn-block" href="<?php echo base_url();?>Short_message_service/sendSMS/balance"><?php echo lang('check_balance'); ?></a>
                            </div>  
                        </div>   
                    </div>

                    <div class="row">
                        <div class="col-md-4"> 
                            <div class="form-group">
                                <a class="btn btn-primary btn-block" href="<?php echo base_url();?>Short_message_service/sendSMS/birthday"><?php echo lang('sms_birthday_customer'); ?></a>
                            </div>  
                        </div> 
                        <div class="col-md-4"> 
                            <div class="form-group">
                                <a class="btn btn-primary btn-block" href="<?php echo base_url();?>Short_message_service/sendSMS/anniversary"><?php echo lang('sms_anniversary_customer'); ?></a>
                            </div>  
                        </div>   

                        <div class="col-md-4"> 
                            <div class="form-group">
                                <a class="btn btn-primary btn-block" href="<?php echo base_url();?>Short_message_service/sendSMS/custom"><?php echo lang('send_custom_sms_all_customer'); ?></a>
                            </div>  
                        </div>  
                    </div>
                    <!-- /.box-body -->
                </div>  
            </div>
        </div>
    </div>
</section>