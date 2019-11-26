 

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2() 

        $('.integerchk').keydown(function(e) {
            var keys = e.charCode || e.keyCode || 0;
            // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
            // home, end, period, and numpad decimal
            return (
            keys == 8 || 
                keys == 9 ||
                keys == 13 ||
                keys == 46 ||
                keys == 110 ||
                keys == 86 ||
                keys == 190 ||
                (keys >= 35 && keys <= 40) ||
                (keys >= 48 && keys <= 57) ||
                (keys >= 96 && keys <= 105));
        });
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
        Upload Foodmenu Ingredients
    </h1>  

    <?php
    if ($this->session->flashdata('exception')) {

        echo '<div class="alert alert-success alert-dismissible"> 
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <p><i class="icon fa fa-check"></i>';
        echo $this->session->flashdata('exception');
        echo '</p></div>';
    }
    if ($this->session->flashdata('exception_err')) {

        echo '<div class="alert alert-danger alert-dismissible"> 
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <p><i class="icon fa fa-check"></i>';
        echo $this->session->flashdata('exception_err');
        echo '</p></div>';
    }
    ?> 
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary"> 
                <!-- form start -->
                <?php echo form_open_multipart(base_url('Master/ExcelDataAddFoodmenusingredient')); ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group">
                                <label>Upload File <span class="required_star">*</span></label>
                                <input tabindex="1" type="file" name="userfile" class="form-control" placeholder="Upload file" value="<?php echo set_value('name'); ?>">
                            </div>
                            <?php if (form_error('userfile')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <p><?php echo form_error('userfile'); ?></p>
                                </div>
                            <?php } ?> 
                        </div>                     

                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
                    <a href="<?php echo base_url() ?>Master/foodMenus"><button type="button" class="btn btn-primary">Back</button></a>
                    <a class="btn btn-primary" href="<?php echo base_url() ?>Master/downloadPDF/Food_Menu_Ingredients_Upload.xlsx">
                        <i class="fa fa-save"></i> Download Sample</a>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div> 

</section>