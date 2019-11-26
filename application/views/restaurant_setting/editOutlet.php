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
<?php //if ($outlet_information->collect_vat != "Yes") { ?>
            //$('#vat_reg_no_container').hide();
<?php //} ?> 
        $('#restaurant_setting_form').on('submit',function(){
            var error = 0; 

            var outlet_name = $('#outlet_name');
            var address = $('#address');
            var phone = $('#phone');
            var collect_tax_yes = $('#collect_tax_yes');
            var collect_tax_no = $('#collect_tax_no');
            var tax_title = $('#tax_title');
            var tax_registration_no = $('#tax_registration_no');
            var tax_is_gst_yes = $('#tax_is_gst_yes');
            var tax_is_gst_no = $('#tax_is_gst_no');
            var state_code = $('#state_code');
            var pre_or_post_payment_post = $('#pre_or_post_payment_post');

            if(outlet_name.val()==""){
                error++;
                $('#outlet_name_error').fadeIn();
            }
            if(address.val()==""){
                error++;
                $('#address_error').fadeIn();
            }
            if(phone.val()==""){
                error++;
                $('#phone_error').fadeIn();
            }
            if(!collect_tax_yes.is(':checked') && !collect_tax_no.is(':checked')){
                error++;
            }
            if(collect_tax_yes.is(':checked')){
                if(tax_title.val()==""){
                    error++;
                    $('#tax_title_error').fadeIn();
                }
                if(tax_registration_no.val()==""){
                    error++;
                    $('#tax_registration_no').fadeIn();
                }
                if(!tax_is_gst_yes.is(':checked') && !tax_is_gst_no.is(':checked')){
                    error++;
                }
                if(tax_is_gst_yes.is(':checked')){
                    if(state_code.val()==""){
                        error++;
                        $('#state_code_error').fadeIn();
                    }
                }
            }
            
            
            if(pre_or_post_payment_post.val()==""){
                error++;
            }
            /*console.log('Here are '+error+' errors');
            
            return false;*/
        });
        $(document).on('click','.remove_this_tax_row',function(){
            var this_row = $(this);
            var this_row_id = this_row.attr('id').substr(20);
            $('#tax_row_'+this_row_id).remove();
            var j = 1;
            $('.remove_this_tax_row').each(function(i, obj) {
                $(this).attr('id','remove_this_tax_row_'+j);
                $(this).parent().parent().attr('id','tax_row_'+j);
                $(this).parent().parent().find('td:first-child').text(j);
                j++;
            });
        });
        $(document).on('click','#remove_all_taxes',function(){
            $('.tax_single_row').remove();
        });
        $('#collect_tax_yes').on('click',function(){
            $('#tax_yes_section').fadeIn();   
        });
        $('#collect_tax_no').on('click',function(){
            $('#tax_yes_section').fadeOut() 
        });
        
        $('#tax_is_gst_yes').on('click',function(){
            $('#gst_yes_section').fadeIn();   
        });
        $('#tax_is_gst_no').on('click',function(){
            $('#gst_yes_section').fadeOut() 
        });
        $('#add_tax').on('click',function(){
            var table_tax_body = $('#tax_table_body');
            var tax_body_row_length = table_tax_body.find('tr').length;
            var new_row_number = tax_body_row_length+1;
            var show_tax_row = ''; 
            show_tax_row += '<tr class="tax_single_row" id="tax_row_'+new_row_number+'">'; 
            show_tax_row += '<td>'+new_row_number+'</td>'; 
            show_tax_row += '<td><input type="text" name="taxes[]" class="form-control"/></td>'; 
            show_tax_row += '<td><span class="remove_this_tax_row" id="remove_this_tax_row_'+new_row_number+'" style="cursor:pointer;">X</span></td>'; 
            show_tax_row += '</tr>';

            table_tax_body.append(show_tax_row); 
        });
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
                <?php 
                $attributes = array('id' => 'restaurant_setting_form');
                echo form_open(base_url('Restaurant_setting/setting/' . $encrypted_id),$attributes); ?>
                <div class="box-body">
                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">
                                <label><?php echo lang('outlet_name'); ?> <span class="required_star">*</span></label>
                                <input tabindex="1" type="text" id="outlet_name" name="outlet_name" class="form-control" placeholder="<?php echo lang('outlet_name'); ?>" value="<?php echo $outlet_information->outlet_name; ?>">
                            </div>
                            <?php if (form_error('outlet_name')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <p><?php echo form_error('outlet_name'); ?></p>
                                </div>
                            <?php } ?>
                            <div class="alert alert-error" style="padding: 5px !important;display:none;" id="outlet_name_error">
                                <p>The Outlet Name field is required.</p>
                            </div>


                        </div>

                        <div class="col-md-6"> 

                            <div class="form-group">
                                <label><?php echo lang('address'); ?> <span class="required_star">*</span></label>
                                <input tabindex="3" type="text" id="address" name="address" class="form-control" placeholder="<?php echo lang('address'); ?>" value="<?php echo $outlet_information->address; ?>">
                            </div>
                            <?php if (form_error('address')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <p><?php echo form_error('address'); ?></p>
                                </div>
                            <?php } ?> 
                            <div class="alert alert-error" style="padding: 5px !important;display:none;" id="address_error">
                                <p>The Address field is required.</p>
                            </div>

                        </div> 

                    </div> 

                    <div class="row"> 
                        <div class="col-md-6"> 

                            <div class="form-group">
                                <label><?php echo lang('phone'); ?> <span class="required_star">*</span></label> <small>(Not for login, for showing in print receipt)</small>
                                <input tabindex="4" type="text" id="phone" name="phone" class="form-control" placeholder="<?php echo lang('phone'); ?>" value="<?php echo $outlet_information->phone; ?>">
                            </div>
                            <?php if (form_error('phone')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <p><?php echo form_error('phone'); ?></p>
                                </div>
                            <?php } ?> 
                            <div class="alert alert-error" style="padding: 5px !important;display:none;" id="phone_error">
                                <p>The Phone field is required.</p>
                            </div>

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
                                <label><?php echo lang('collect_tax'); ?> <span class="required_star">*</span></label>  
                                <div class="radio">
                                    <label> 
                                        <input tabindex="5" type="radio" name="collect_tax" id="collect_tax_yes" value="Yes" 
                                        <?php
                                        if ($outlet_information->collect_tax == "Yes") {
                                            echo "checked";
                                        };
                                        ?>
                                               >Yes </label>
                                    <label>

                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 

                                        <input tabindex="6" type="radio" name="collect_tax" id="collect_tax_no" value="No" 
                                        <?php
                                        if ($outlet_information->collect_tax == "No" || ($outlet_information->collect_tax != "Yes" && $outlet_information->collect_tax != "No")) {
                                            echo "checked";
                                        };
                                        ?>
                                               >No 
                                    </label>
                                </div>
                            </div>
                            <?php if (form_error('collect_tax')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <p><?php echo form_error('collect_tax'); ?></p>
                                </div>
                            <?php } ?> 
                            

                        </div> 

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
        
                    <div id="tax_yes_section" style="display:<?php if($outlet_information->collect_tax=="Yes"){echo "block;";}else{echo "none;";}?>">
                        <div class="row">
                            <div class="col-md-6">
                                <button id="show_sample_invoice_with_tax" type="button" class="btn btn-primary" data-toggle="modal" data-target="#show_sample_invoice_with_tax_modal"><?php echo lang('show_invoice_sample'); ?></button>
                            </div>
                        </div>
                        <br>

                        <div class="row"> 
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label><?php echo lang('my_tax_title'); ?> <span class="required_star">*</span></label>
                                    <input tabindex="1" type="text" id="tax_title" name="tax_title" class="form-control" placeholder="<?php echo lang('my_tax_title'); ?>" value="<?php echo $outlet_information->tax_title; ?>">
                                </div>
                                <?php if (form_error('tax_title')) { ?>
                                    <div class="alert alert-error" style="padding: 5px !important;">
                                        <p><?php echo form_error('tax_title'); ?></p>
                                    </div>
                                <?php } ?>
                                <div class="alert alert-error" style="padding: 5px !important;display:none;" id="tax_title_error">
                                    <p>The Tax Title field is required.</p>
                                </div>
                                <button id="show_how_tax_title_works" type="button" class="btn btn-primary" data-toggle="modal" data-target="#show_how_tax_title_works_modal"><?php echo lang('how_tax_title_works'); ?></button>


                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label><?php echo lang('tax_registration_no'); ?> <span class="required_star">*</span></label>
                                    <input tabindex="1" type="text" id="tax_registration_no" name="tax_registration_no" class="form-control" placeholder="<?php echo lang('tax_registration_no'); ?>" value="<?php echo $outlet_information->tax_registration_no; ?>">
                                </div>
                                <?php if (form_error('tax_registration_no')) { ?>
                                    <div class="alert alert-error" style="padding: 5px !important;">
                                        <p><?php echo form_error('tax_registration_no'); ?></p>
                                    </div>
                                <?php } ?>
                                <div class="alert alert-error" style="padding: 5px !important;display:none;" id="tax_registration_no_error">
                                    <p>The Tax Registration No field is required.</p>
                                </div>

                            </div>
                             
                            
                        </div> 
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group radio_button_problem">
                                    <label><?php echo lang('tax_is_gst'); ?> <span class="required_star">*</span></label>  
                                    <div class="radio">
                                        <label> 
                                            <input tabindex="5" type="radio" name="tax_is_gst" id="tax_is_gst_yes" value="Yes" 
                                            <?php
                                            if ($outlet_information->tax_is_gst == "Yes") {
                                                echo "checked";
                                            };
                                            ?>
                                                   >Yes </label>
                                        <label>

                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 

                                            <input tabindex="6" type="radio" name="tax_is_gst" id="tax_is_gst_no" value="No" 
                                            <?php
                                            if ($outlet_information->tax_is_gst == "No" || ($outlet_information->tax_is_gst != "Yes" && $outlet_information->tax_is_gst != "No")) {
                                                echo "checked";
                                            };
                                            ?>
                                                   >No 
                                        </label>
                                    </div>
                                </div>
                                <?php if (form_error('tax_is_gst')) { ?>
                                    <div class="alert alert-error" style="padding: 5px !important;">
                                        <p><?php echo form_error('tax_is_gst'); ?></p>
                                    </div>
                                <?php } ?>  
                                <button id="what_will_happen_if_i_say_yes" type="button" class="btn btn-primary" data-toggle="modal" data-target="#what_will_happen_if_i_say_yes_modal"><?php echo lang('if_i_say_yes'); ?></button>

                            </div>
                        </div>
                        <div id="gst_yes_section" style="display:<?php if($outlet_information->tax_is_gst=="Yes"){echo "block;";}else{echo "none;";} ?>">
                            <div class="row"> 
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label><?php echo lang('state_code'); ?> <span class="required_star">*</span></label>
                                        <input tabindex="1" type="text" id="state_code" name="state_code" class="form-control" placeholder="<?php echo lang('state_code'); ?>" value="<?php echo $outlet_information->state_code; ?>">
                                    </div>
                                    <?php if (form_error('state_code')) { ?>
                                        <div class="alert alert-error" style="padding: 5px !important;">
                                            <p><?php echo form_error('state_code'); ?></p>
                                        </div>
                                    <?php } ?>
                                    <div class="alert alert-error" style="padding: 5px !important;display:none;" id="state_code_error">
                                        <p>The State Code field is required.</p>
                                    </div>

                                </div>

                                  
                            </div>    
                        </div> 
                        <br>
                     
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label><?php echo lang('my_tax_fields');?> <span class="required_star">*</span></label>
                                <table id="datatable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 1%">SN</th>
                                            <th style="width: 20%">Name</th>
                                            <th style="width: 10%"><span id="remove_all_taxes" style="cursor:pointer;">X</span></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tax_table_body">
                                        <?php 
                                            $new_row_number = 1;
                                            $show_tax_row = '';
                                            if(isset($outlet_taxes) && count($outlet_taxes)>0){
                                                foreach($outlet_taxes as $single_tax){
                                                    $show_tax_row .= '<tr class="tax_single_row" id="tax_row_'.$new_row_number.'">'; 
                                                    $show_tax_row .= '<td>'.$new_row_number.'</td>'; 
                                                    $show_tax_row .= '<td><input type="text" name="taxes[]" class="form-control" value="'.$single_tax->tax.'"/></td>'; 
                                                    $show_tax_row .= '<td><span class="remove_this_tax_row" id="remove_this_tax_row_'.$new_row_number.'" style="cursor:pointer;">X</span></td>'; 
                                                    $show_tax_row .= '</tr>';
                                                    $new_row_number++;
                                                }    
                                            }
                                            
                                            echo $show_tax_row;
                                        ?>
                                    </tbody>
                                </table>
                                <button id="add_tax" class="btn btn-primary" type="button"><?php echo lang('add_more'); ?></button>
                                <!-- <input tabindex="1" type="text" name="state_code" class="form-control" placeholder="State Code" value="<?php echo set_value('state_code'); ?>" /> -->
                            </div>
                            <?php if (form_error('taxes[]')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <p><?php echo form_error('taxes[]'); ?></p>
                                </div>
                            <?php } ?>
                            <button id="show_how_tax_fields_work" type="button" class="btn btn-primary" data-toggle="modal" data-target="#show_how_tax_fields_work_modal"><?php echo lang('how_tax_fields_work'); ?></button> 
                        </div> 
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
                    <!-- <a href="<?php echo base_url() ?>Restaurant_setting/setting"><button type="button" class="btn btn-primary">Back</button></a> -->
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div> 
</section>

<!-- Modal -->
<div id="show_sample_invoice_with_tax_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Sample Invoice</h4>
      </div>
      <div class="modal-body">
        <p class="text-center">
            <img src="<?php echo base_url()?>assets/images/GST Invoice.jpg">
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal -->
<div id="show_how_tax_title_works_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo lang('how_tax_title_works'); ?></h4>
      </div>
      <div class="modal-body">
        <p>
            Which will be shown in Invoice<br>
Like GST for India<br>
HST for Canada<br>
VAT for Bangladesh<br>
Sales Tax for Other etc.<br>
It will be shown at Top of the invoice like:   <br>
TAX TITLE Registration Number: XXXXXXX<br>
It will be shown at bottom of the invoice like: <br>
Total TAX TITLE = XXX Amount  <br>
Note that UPPERCASE texts are variable
</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal -->
<div id="what_will_happen_if_i_say_yes_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">What will happen if I say Yes</h4>
      </div>
      <div class="modal-body">
        <p>
    You will get two additional reports: <br>
If you dont enter customer's GST number, system will apply CGST and SGST<br>
But for this you have to add CGST, SGST, IGST and VAT in Tax Fields<br>
In POS, when selecting customer you will get option to set customer's GST Number and system will match your state code with customer's state code, if these match, system will apply CGST and IGST, if does not, system will apply CGST and SGST<br>
1. GST Report in Excel and (coming soon)<br>
2. GST Report in JSON (coming soon)<br>

        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal -->
<div id="show_how_tax_fields_work_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">How tax fields work</h4>
      </div>
      <div class="modal-body">
        <p>
        All of these input fields will be appeared in each of your Item profile. You can then set amount application for all of these for that specific item. If an item does not have any of these's tax, you just put that's value 0. Like if you use GST and the item is an alchohol item you will set value in only VAT field and leave other field blank, then only VAT will be applicable for that item. If you are using GST, you should put value in all CGST, SGST and IGST, system will determine where to select SGST or IGST as you have chosen My Tax is GST above.<br>
And if you are dealing with a single Tax amount, just add one field here. Note that which names you add here, will be appeared in your invoice.

        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>