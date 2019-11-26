<style type="text/css">
    .required_star{
        color: #dd4b39;
    }

    .radio_button_problem{
        margin-bottom: 19px;
    }
</style>
<link rel="stylesheet" href="<?= base_url('assets/') ?>buttonCSS/checkBotton.css">
<section class="content-header">
    <h1>
        <?php echo lang('edit_user'); ?>
    </h1>  
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">  
                <!-- form start -->
                <?php echo form_open(base_url('User/addEditUser/' . $encrypted_id)); ?>
                <div class="box-body">
                    <div class="row">

                        <div class="col-md-4">

                            <div class="form-group">
                                <label><?php echo lang('name'); ?> <span class="required_star">*</span></label>
                                <input tabindex="1" type="text" name="full_name" class="form-control" placeholder="<?php echo lang('name'); ?>" 
                                       value="<?php echo $user_details->full_name; ?>">
                            </div>
                            <?php if (form_error('full_name')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <span class="error_paragraph"><?php echo form_error('full_name'); ?></span>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="col-md-4">

                            <div class="form-group">
                                <label><?php echo lang('email_address'); ?> <span class="required_star">*</span></label>
                                <input tabindex="3" type="text" name="email_address" class="form-control" placeholder="<?php echo lang('email_address'); ?>" value="<?php echo $user_details->email_address; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">

                            <div class="form-group">
                                <label><?php echo lang('phone'); ?> </label>
                                <input tabindex="2" type="text" name="phone" class="form-control integerchk" placeholder="<?php echo lang('phone'); ?>" value="<?php echo $user_details->phone; ?>">
                            </div>
                            <?php if (form_error('phone')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <span class="error_paragraph"><?php echo form_error('phone'); ?></span>
                                </div>
                            <?php } ?>  
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('designation'); ?><span class="required_star"> *</span><small><?php echo lang('enter_waiter'); ?></small></label>
                                <input tabindex="2" type="text" name="designation" class="form-control" placeholder="<?php echo lang('designation'); ?>" value="<?php echo $user_details->designation; ?>">
                                </select>
                            </div>
                            <?php if (form_error('designation')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <span class="error_paragraph"><?php echo form_error('designation'); ?></span>
                                </div>
                            <?php } ?>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group radio_button_problem">
                                <label><?php echo lang('will_login'); ?> <span class="required_star">*</span></label>  
                                <div class="radio">
                                    <label> 
                                        <input tabindex="5" type="radio" name="will_login" id="will_login_yes" value="Yes" <?php if($user_details->will_login=="Yes"){echo "checked";} ?>>Yes </label>
                                    <label>

                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 

                                        <input tabindex="6" type="radio" name="will_login" id="will_login_no" value="No" <?php if($user_details->will_login=="No"){echo "checked";} ?>>No 
                                    </label>
                                </div>
                            </div>
                            <?php if (form_error('will_login')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <p><?php echo form_error('will_login'); ?></p>
                                </div>
                            <?php } ?> 
                        </div>
                    </div>

                    <div id="will_login_section" style="display:<?php if($user_details->will_login=="Yes"){echo "block;";}else{echo "none;";}?>">
                        <div class="row">

                            <div class="col-md-4">

                                <div class="form-group">
                                    <label><?php echo lang('password'); ?> <span class="required_star">*</span></label>
                                    <input tabindex="5" type="text" name="password" class="form-control" placeholder="<?php echo lang('password'); ?>" value="<?php echo $user_details->password; ?>">
                                </div>
                                <?php if (form_error('password')) { ?>
                                    <div class="alert alert-error" style="padding: 5px !important;">
                                        <span class="error_paragraph"><?php echo form_error('password'); ?></span>
                                    </div>
                                <?php } ?>  
                            </div> 

                            <div class="col-md-4">

                                <div class="form-group">
                                    <label><?php echo lang('confirm_password'); ?> <span class="required_star">*</span></label>
                                    <input tabindex="4" type="text" name="confirm_password" class="form-control" placeholder="<?php echo lang('confirm_password'); ?>" value="<?php echo $user_details->password; ?>">
                                </div>
                                <?php if (form_error('confirm_password')) { ?>
                                    <div class="alert alert-error" style="padding: 5px !important;">
                                        <span class="error_paragraph"><?php echo form_error('confirm_password'); ?></span>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row">
                            <!-- <div class="col-md-4">
                                <div class="form-group">
                                    <div class="radio">
                                        <label>
                                            <input <?php if($user_details->role=='POS User'){echo 'checked';} ?> class="user_radio" type="radio" name="user_type" value="POS User">
                                            <?php echo lang('pos_user'); ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="radio">
                                        <label>
                                            <input <?php if($user_details->role=='Kitchen User'){echo 'checked';} ?> class="user_radio" type="radio" name="user_type" value="Kitchen User">
                                           <?php echo lang('kitchen_user'); ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="radio">
                                        <label>
                                            <input <?php if($user_details->role=='Bar User'){echo 'checked';} ?> class="user_radio" type="radio" name="user_type" value="Bar User">
                                            <?php echo lang('bar_user'); ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="radio">
                                        <label>
                                            <input <?php if($user_details->role=='Waiter User'){echo 'checked';} ?> class="user_radio" type="radio" name="user_type" value="Waiter User">
                                            <?php echo lang('waiter_user'); ?>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="radio">
                                        <label>
                                            <input <?php if($user_details->role=='User'){echo 'checked';} ?> type="radio" name="user_type" value="">
                                            <?php echo lang('user'); ?>
                                        </label>
                                    </div>
                                </div>
                            </div> -->

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><?php echo lang('menu_access'); ?> <span class="required_star">*</span></label>
                                </div>
                                <label class="container"> <?php echo lang('select_all'); ?>
                                    <input type="checkbox" id="checkbox_userAll">
                                    <span class="checkmark"></span>
                                </label>
                                <hr style="margin: 0px;margin-bottom: 0px;padding: 0px;margin-bottom: 6px;">
                                <?php
                                if ($user_details->role == 'Admin') {
                                    $disabled = 'disabled';
                                } else {
                                    $disabled = '';
                                }

                                if (isset($user_menus)) {
                                    foreach ($user_menus as $um) {
                                        $n=str_replace(" ","_",$um->menu_name);
                                        $m=strtolower($n);
                                        $menu_id_ = $um->id;
                                        $checked = '';
                                        foreach ($user_menu_access as $uma) {
                                            if (in_array($menu_id_, $user_menu_access)) {
                                                $checked = 'checked';
                                            } else {
                                                $checked = '';
                                            }
                                        }
                                        ?>
                                        <label class="container"><?= lang($m) ?>
                                            <input type="checkbox" class="checkbox_user" <?= $checked ?> value="<?= $um->id ?>" name="menu_id[]" <?= set_checkbox('menu_id[]', $um->id) ?>>
                                            <span class="checkmark"></span>
                                        </label>
                                        <?php
                                    }
                                }
                                ?>

                                <?php if (form_error('menu_id')) { ?>
                                    <div class="alert alert-error" style="padding: 5px !important;">
                                        <span class="error_paragraph"><?php echo form_error('menu_id'); ?></span>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
                    <a href="<?php echo base_url() ?>User/users"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function(){
        if($(".checkbox_user").length == $(".checkbox_user:checked").length) {
            $("#checkbox_userAll").prop("checked", true);
        } else {
            $("#checkbox_userAll").removeAttr("checked");
        }
        // Check or Uncheck All checkboxes
        $("#checkbox_userAll").change(function(){
            $('.user_radio').each(function(i, obj) {
                if($(this).is(':checked')){
                    $('#checkbox_userAll').prop('checked',false);
                    $('.checkbox_user').prop('checked',false);
                    return false;
                }
            });
            var checked = $(this).is(':checked');
            if(checked){
                $(".checkbox_user").each(function(){
                    $(this).prop("checked",true);
                });
            }else{
                $(".checkbox_user").each(function(){
                    $(this).prop("checked",false);
                });
            }
        });

        $(".checkbox_user").click(function(){
            $('.user_radio').each(function(i, obj) {
                if($(this).is(':checked')){
                    $('#checkbox_userAll').prop('checked',false);
                    $('.checkbox_user').prop('checked',false);

                    return false;
                }
            });
            if($(".checkbox_user").length == $(".checkbox_user:checked").length) {
                $("#checkbox_userAll").prop("checked", true);
            } else {
                $("#checkbox_userAll").prop("checked", false);
            }
        });
        $('.user_radio').on('click',function(){
            $('#checkbox_userAll').prop('checked',false);
            $('.checkbox_user').prop('checked',false);
        });
        $('#will_login_yes').on('click',function(){
            $('#will_login_section').fadeIn();
        });
        $('#will_login_no').on('click',function(){
            $('#will_login_section').fadeOut();
        });
    });
</script>