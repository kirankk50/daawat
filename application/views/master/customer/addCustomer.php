 
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
    })
</script>

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
        <?php echo lang('add_customer'); ?>
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
                <?php echo form_open(base_url('Master/addEditCustomer')); ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">

                            <div class="form-group">
                                <label><?php echo lang('customer_name'); ?> <span class="required_star">*</span></label>
                                <input tabindex="1" type="text" name="name" class="form-control" placeholder="<?php echo lang('customer_name'); ?>" value="<?php echo set_value('name'); ?>">
                            </div>
                            <?php if (form_error('name')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <p><?php echo form_error('name'); ?></p>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-4">

                            <div class="form-group">
                                <label><?php echo lang('phone'); ?> <span class="required_star">*</span></label> <small><?php echo lang('should_country_code'); ?></small>
                                <input tabindex="2" type="text" name="phone" class="form-control integerchk" placeholder="<?php echo lang('phone'); ?>" value="<?php echo set_value('phone'); ?>">
                            </div>
                            <?php if (form_error('phone')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <p><?php echo form_error('phone'); ?></p>
                                </div>
                            <?php } ?>  
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('email'); ?></label>
                                <input tabindex="3" type="text" name="email" class="form-control" placeholder="<?php echo lang('email'); ?>" value="<?php echo set_value('email'); ?>">
                            </div>
                            <?php if (form_error('email')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <p><?php echo form_error('email'); ?></p>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('date_of_birth'); ?></label>
                                <input  tabindex="4" type="text" id="date"  name="date_of_birth" class="form-control datepicker" placeholder="<?php echo lang('date_of_birth'); ?>" value="">
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('date_of_anniversary'); ?></label>
                                <input tabindex="5" type="text" id="dates2" name="date_of_anniversary" class="form-control " placeholder="<?php echo lang('date_of_anniversary'); ?>" value="">
                            </div>

                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('address'); ?></label>
                                <textarea tabindex="6" name="address" class="form-control" placeholder="<?php echo lang('address'); ?>"></textarea>
                            </div>
                        </div>

                        <?php if(collectGST()=="Yes"){?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?php echo lang('gst_number'); ?></label>
                                    <input tabindex="3" type="text" name="gst_number" class="form-control" placeholder="<?php echo lang('gst_number'); ?>" value="<?php echo set_value('gst_number'); ?>">
                                </div>
                                <?php if (form_error('gst_number')) { ?>
                                    <div class="alert alert-error" style="padding: 5px !important;">
                                        <p><?php echo form_error('gst_number'); ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>

                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
                    <a href="<?php echo base_url() ?>Master/customers"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>