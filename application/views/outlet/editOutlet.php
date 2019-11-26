<style type="text/css">
    .required_star{
        color: #dd4b39;
    }

    .radio_button_problem{
        margin-bottom: 19px;
    }
</style>

<script type="text/javascript">
    $(function () {
<?php if ($outlet_information->collect_vat != "Yes") { ?>
            $('#vat_reg_no_container').hide();
<?php } ?> 
        $('input[type=radio][name=collect_vat]').change(function() {
            if (this.value == 'Yes') {
                $('#vat_reg_no_container').show();
            }
            else if (this.value == 'No') {
                $('#vat_reg_no_container').hide();
            }
        });

 
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
<section class="content-header">
    <h1>
       <?php echo lang('edit_outlet'); ?>
    </h1>

</section>

<!-- Main content --> 
<section class="content">
    <div class="row">

        <!-- left column -->
        <div class="col-md-12">
            <div class="box box-primary"> 
                <!-- /.box-header -->
                <!-- form start -->
                <?php echo form_open(base_url('Outlet/addEditOutlet/' . $encrypted_id)); ?>
                <div class="box-body">
                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">
                                <label><?php echo lang('outlet_name'); ?> <span class="required_star">*</span></label>
                                <input tabindex="1" type="text" name="outlet_name" class="form-control" placeholder="<?php echo lang('outlet_name'); ?>" value="<?php echo $outlet_information->outlet_name; ?>">
                            </div>
                            <?php if (form_error('outlet_name')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <p><?php echo form_error('outlet_name'); ?></p>
                                </div>
                            <?php } ?>

                        </div>

                        <div class="col-md-6"> 

                            <div class="form-group">
                                <label><?php echo lang('address'); ?> <span class="required_star">*</span></label>
                                <input tabindex="3" type="text" name="address" class="form-control" placeholder="<?php echo lang('address'); ?>" value="<?php echo $outlet_information->address; ?>">
                            </div>
                            <?php if (form_error('address')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <p><?php echo form_error('address'); ?></p>
                                </div>
                            <?php } ?> 

                        </div> 

                    </div> 

                    <div class="row"> 
                        <div class="col-md-6"> 

                            <div class="form-group">
                                <label><?php echo lang('phone'); ?> <span class="required_star">*</span></label> <small>(Not for login, for showing in print receipt)</small>
                                <input tabindex="4" type="text" name="phone" class="form-control" placeholder="<?php echo lang('phone'); ?>" value="<?php echo $outlet_information->phone; ?>">
                            </div>
                            <?php if (form_error('phone')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <p><?php echo form_error('phone'); ?></p>
                                </div>
                            <?php } ?> 

                        </div>
                        <div class="col-md-6"> 

                            <div class="form-group">
                                <label><?php echo lang('invoice_footer'); ?></label> 
                                <input tabindex="4" type="text" name="invoice_footer" class="form-control" placeholder="<?php echo lang('invoice_footer'); ?>" value="<?php echo $outlet_information->invoice_footer; ?>">
                            </div>
                            <?php if (form_error('invoice_footer')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <p><?php echo form_error('invoice_footer'); ?></p>
                                </div>
                            <?php } ?> 

                        </div>

                    </div>

                    <div class="row">   

                        <div class="col-md-6">
                            <div class="form-group radio_button_problem">
                                <label><?php echo lang('pre_or_post_payment'); ?> <span class="required_star">*</span></label> <a class="top" title="" data-placement="top" data-toggle="tooltip" style="cursor: pointer" data-original-title="Taking payment after eating = Post Payment, taking payment before eating = Pre Payment"><i class="fa fa-question fa-lg form_question"></i></a>  
                                <div class="radio">
                                    <label> 
                                        <input tabindex="5" type="radio" name="pre_or_post_payment" id="pre_or_post_payment_post" value="Post Payment" 
                                        <?php
                                        if ($outlet_information->pre_or_post_payment == "Post Payment") {
                                            echo "checked";
                                        };
                                        ?>
                                        ><?php echo lang('post_payment'); ?> </label>
                                    <label>

                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 

                                        <input tabindex="6" type="radio" name="pre_or_post_payment" id="pre_or_post_payment_pre" value="Pre Payment" 
                                        <?php
                                        if ($outlet_information->pre_or_post_payment == "Pre Payment") {
                                            echo "checked";
                                        };
                                        ?>
                                        ><?php echo lang('pre_payment'); ?>
                                    </label>
                                </div>
                            </div>
                            <?php if (form_error('pre_or_post_payment')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <p><?php echo form_error('pre_or_post_payment'); ?></p>
                                </div>
                            <?php } ?>  
                        </div>  
                    </div> 

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
                    <a href="<?php echo base_url() ?>Outlet/outlets"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div> 
</section>