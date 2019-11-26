<style type="text/css">
    .required_star{
        color: #dd4b39;
    }

    .radio_button_problem{
        margin-bottom: 19px;
    }

    .alert-info{
        background-color: white !important;
        color: #0C5889 !important;
        padding: 3px 3px 3px 15px;
        border: 1px solid #0C5889;
        display: none;
    }
</style> 
<script>  
    $(function () { 
        var currency = "<?php echo $this->session->userdata('currency'); ?>";
        $('#customer_id').change(function(){

            var customer_id = $('#customer_id').val();   

            $.ajax({
                type: "GET",
                url: '<?php echo base_url(); ?>Customer_due_receive/getCustomerDue',
                data: {
                    customer_id: customer_id
                },
                success: function(data){  
                    $("#remaining_due").show();
                    $("#remaining_due").text("Current Due: "+ data+" "+currency);
                }
            });
        })
    })
</script>

<section class="content-header">
    <h1>
        <?php echo lang('add_customer_due_receive'); ?>
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
                <?php echo form_open(base_url('Customer_due_receive/addCustomerDueReceive')); ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('ref_no'); ?></label>
                                <input tabindex="1" type="text" id="reference_no" readonly name="reference_no" class="form-control" placeholder="<?php echo lang('ref_no'); ?>" value="<?php echo $reference_no; ?>">
                            </div>
                            <?php if (form_error('reference_no')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <p><?php echo form_error('reference_no'); ?></p>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-4">

                            <div class="form-group">
                                <label><?php echo lang('date'); ?> <span class="required_star">*</span></label>
                                <input tabindex="1" type="text" id="date" readonly name="date" class="form-control" placeholder="<?php echo lang('date'); ?>" value="<?php echo set_value('date'); ?>">
                            </div>
                            <?php if (form_error('date')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <p><?php echo form_error('date'); ?></p>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('customer'); ?> <span class="required_star">*</span></label>
                                <select tabindex="3" class="form-control select2" id="customer_id" name="customer_id" style="width: 100%;">
                                    <option value=""><?php echo lang('select'); ?></option>
                                    <?php foreach ($customers as $customer) { ?>
                                        <option value="<?php echo $customer->id ?>" <?php echo set_select('customer_id', $customer->id); ?>><?php echo $customer->name ." ". $customer->phone?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="alert alert-info" id="remaining_due"></div>
                            <?php if (form_error('customer_id')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <p><?php echo form_error('customer_id'); ?></p>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group"> 
                                <label><?php echo lang('amount'); ?> <span class="required_star">*</span></label>
                                <input tabindex="2" type="text" name="amount" onfocus="this.select();" class="form-control integerchk" style="width: 100%;" placeholder="<?php echo lang('amount'); ?>" value="<?php echo set_value('amount'); ?>">
                            </div>
                            <?php if (form_error('amount')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <p><?php echo form_error('amount'); ?></p>
                                </div>
                            <?php } ?>


                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('note'); ?></label>
                                <textarea tabindex="5" class="form-control" rows="4" name="note" placeholder="<?php echo lang('enter'); ?> ..."><?php echo $this->input->post('note'); ?></textarea>
                            </div> 
                            <?php if (form_error('note')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <p><?php echo form_error('note'); ?></p>
                                </div>
                            <?php } ?>  
                        </div> 

                    </div>
                    <!-- /.box-body -->
                </div> 
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
                    <a href="<?php echo base_url() ?>Customer_due_receive/customerDueReceives"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>