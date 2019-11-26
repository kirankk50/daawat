<style type="text/css">
    .aligning{
        width: auto; float:left
    } 
    .label_aligning{
        float: left; padding: 5px 0px 0px 3px;
    }
</style> 

<script>

<?php
$ingredient_id_container = "[";
if ($modifier_ingredients && !empty($modifier_ingredients)) {
    foreach ($modifier_ingredients as $fmi) {
        $ingredient_id_container .= '"' . $fmi->ingredient_id . '",';
    }
}
$ingredient_id_container = substr($ingredient_id_container, 0, -1);
$ingredient_id_container .= "]";
?>

    var ingredient_id_container = <?php echo $ingredient_id_container; ?>;


    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2();

        $(document).on('keydown', '.integerchk', function(e){ 
            /*$('.integerchk').keydown(function(e) {*/
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

        var suffix = <?php
if (isset($modifier_ingredients)) {
    echo count($modifier_ingredients);
} else {
    echo 0;
};
?>;  
     
        var tab_index = 6;

        $('#ingredient_id').change(function(){
            var ingredient_details=$('#ingredient_id').val();
            if (ingredient_details != '') { 

                var ingredient_details_array = ingredient_details.split('|'); 
 
                var index = ingredient_id_container.indexOf(ingredient_details_array[0]);  

                if (index > -1) {
                    swal({
                        title: "<?php echo lang('alert'); ?>!",
                        text: "<?php echo lang('ingredient_already_remain'); ?>",
                        confirmButtonText:'<?php echo lang('ok'); ?>',
                        confirmButtonColor: '#3c8dbc'
                    });
                    $('#ingredient_id').val('').change();
                    return false;
                } 

                suffix++;
                tab_index++; 

                var cart_row = '<tr id="row_' + suffix + '">'+
                    '<td style="width: 12%; padding-left: 10px;"><p>'+suffix+'</p></td>'+
                    '<td style="width: 23%"><span style="padding-bottom: 5px;">'+ingredient_details_array[1]+'</span></td>'+
                    '<input type="hidden" id="ingredient_id_' + suffix + '" name="ingredient_id[]" value="' + ingredient_details_array[0] + '"/>'+
                    '<td style="width: 30%"><input type="text" tabindex="'+ tab_index +'" id="consumption_' + suffix + '" name="consumption[]" onfocus="this.select();" onkeyup="return replaceConsumption('+suffix+');"  class="form-control integerchk aligning" style="width: 85%;" placeholder="<?php echo lang('consumption'); ?>"/><span class="label_aligning">' + ingredient_details_array[2] + '</span></td>'+
                    '<td style="width: 17%"><a class="btn btn-danger btn-xs" style="margin-left: 5px; margin-top: 10px;" onclick="return deleter(' + suffix + ',' + ingredient_details_array[0] +');" ><i class="fa fa-trash"></i> </a></td>'+
                    '</tr>';  

                $('#ingredient_consumption_table tbody').append(cart_row);    

                ingredient_id_container.push(ingredient_details_array[0]);
                /*
                updateRowNo();*/
                $('#ingredient_id').val('').change();
                updateRowNo();
            }
        }); 
        
         
        // Validate form
        $("#modifier_form").submit(function(){
            var name = $("#name").val();
            var description = $("#description").val();
            var price = $("#price").val();
            var ingredientCount = $("#form-table tbody tr").length;
            var error = false;  


            if(name==""){ 
                $("#name_err_msg").text("<?php echo lang('name_field_required'); ?>");
                $(".name_err_msg_contnr").show(200);
                error = true;
            }  

            if(description.length>200){ 
                $("#description_err_msg").text("<?php echo lang('description_field_can_not_exceed'); ?>");
                $(".description_err_msg_contnr").show(200);
                error = true;
            }

            if(price==""){
                $("#sale_price_err_msg").text("<?php echo lang('price_field_required'); ?>");
                $(".sale_price_err_msg_contnr").show(200);
                error = true;
            }  

            if(ingredient_id_container.length == 0){ 
                $("#ingredient_id_err_msg").text("<?php echo lang('at_least_ingredient'); ?>");
                $(".ingredient_err_msg_contnr").show(200);
                error = true;
            } 
            console.log(ingredient_id_container.length);
  
            for(var n = 1; n <= ingredient_id_container.length+1; n++){  
                var ingredient_id = $.trim($("#ingredient_id_"+n).val()); 
                var consumption = $.trim($("#consumption_"+n).val());   
                    
                if(ingredient_id.length > 0){
                    if(consumption == '' || isNaN(consumption)){ 
                        $("#consumption_"+n).css({"border-color":"red"}).show(200);
                        error = true;
                    }  
                }
            }  
 

            if(error == true){
                return false;
            } 
        });



    }) 

    function deleter(suffix, ingredient_id){
        swal({
            title: "<?php echo lang('alert'); ?>",
            text: "<?php echo lang('are_you_sure'); ?>?",
            confirmButtonColor: '#3c8dbc',
            cancelButtonText:'<?php echo lang('cancel'); ?>',
            confirmButtonText:'<?php echo lang('ok'); ?>',
            showCancelButton: true
        }, function() {
            $("#row_"+suffix).remove();
            var ingredient_id_container_new = [];

            for(var i = 0; i < ingredient_id_container.length; i++){
                if(ingredient_id_container[i] != ingredient_id){
                    ingredient_id_container_new.push(ingredient_id_container[i]);
                }
            }

            ingredient_id_container = ingredient_id_container_new;

            updateRowNo();
        });
    } 

    function updateRowNo(){ 
        var numRows=$("#ingredient_consumption_table tbody tr").length; 
        for(var r=0;r<numRows;r++){
            $("#ingredient_consumption_table tbody tr").eq(r).find("td:first p").text(r+1);
        }
    }
</script>

<style type="text/css">
    .required_star{
        color: #dd4b39;
    }

    .radio_button_problem{
        margin-bottom: 19px;
    }
    .modifierCartInfo{
        border: 2px solid #3c8dbc;
        padding: 15px;
        border-radius: 5px;
        color: #3c8dbc;
        font-size: 14px;
        margin-top: 0px;
        text-align: justify;
    }
    .modifierCartNotice{
        border: 2px solid red;
        padding: 15px;
        border-radius: 5px;
        color: red;
        font-size: 14px;
        margin-top: 0px;
        text-align: justify;
    }
    .cart_container{
        /* border: 1px solid black;*/
    }
    .cart_header{ 
        background-color: #ecf0f5;  
        padding: 5px 0px;
        margin-bottom: 5px;
    }
    .ch_content{
        font-weight: bold;
    }
    .custom_form_control{
        border-radius: 0;
        box-shadow: none;
        border-color: #d2d6de;  
        width: 80%;
        height: 26px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        margin: 0px 3px 7px 0px;
    }
    .center_positition{
        text-align: center !important;
    }
    .error-msg{
        display:none;
    }
</style> 

<section class="content-header">
    <h1>
        <?php echo lang('edit'); ?> <?php echo lang('modifier'); ?>
    </h1>  
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary"> 
                <!-- form start -->
                <?php echo form_open(base_url() . 'Master/addEditModifier/' . $encrypted_id, $arrayName = array('id' => 'modifier_form', 'enctype' => 'multipart/form-data')) ?>

                <div class="box-body">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('name'); ?> <span class="required_star">*</span></label>
                                <input tabindex="1" type="text" id="name" name="name" class="form-control" placeholder="<?php echo lang('name'); ?>" value="<?php echo $modifier_details->name; ?>">
                            </div>
                            <?php if (form_error('name')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <p><?php echo form_error('name'); ?></p>
                                </div>
                            <?php } ?>
                            <div class="alert alert-error error-msg name_err_msg_contnr" style="padding: 5px !important;">
                                <p id="name_err_msg"></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('price'); ?> <span class="required_star">*</span></label>
                                <input tabindex="4" style="width: 100%" type="text" id="price" name="price" class="form-control integerchk" placeholder="<?php echo lang('price'); ?>" value="<?php echo $modifier_details->price; ?>"> 
                            </div>
                            <?php if (form_error('price')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <p><?php echo form_error('price'); ?></p>
                                </div>
                            <?php } ?>
                            <div class="alert alert-error error-msg sale_price_err_msg_contnr" style="padding: 5px !important;">
                                <p id="sale_price_err_msg"></p>
                            </div>

                        </div> 

                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('ingredient_consumptions'); ?> <span class="required_star">*</span></label>
                                <select tabindex="5" class="form-control select2 select2-hidden-accessible" name="ingredient_id" id="ingredient_id" style="width: 100%;">
                                    <option value=""><?php echo lang('select'); ?></option>
                                    <?php foreach ($ingredients as $ingnts) { ?>
                                        <option value="<?php echo $ingnts->id . "|" . $ingnts->name . "|" . $ingnts->unit_name ?>" <?php echo set_select('unit_id', $ingnts->id); ?>><?php echo $ingnts->name . "(" . $ingnts->code . ")"; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php if (form_error('ingredient_id')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <p><?php echo form_error('ingredient_id'); ?></p>
                                </div>
                            <?php } ?>
                            <div class="alert alert-error error-msg ingredient_err_msg_contnr" style="padding: 5px !important;">
                                <p id="ingredient_id_err_msg"></p>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="hidden-xs hidden-sm">&nbsp;</div>
                            <a class="btn btn-danger" style="background-color: red;margin-top: 5px;" data-toggle="modal" data-target="#noticeModal"><?php echo lang('read_me_first'); ?></a>
                        </div>
                        <div class="clearfix"></div>
                        <div class="hidden-lg hidden-sm">&nbsp;</div>

                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="table-responsive" id="ingredient_consumption_table">          
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th><?php echo lang('sn'); ?></th>
                                            <th><?php echo lang('ingredient'); ?></th>
                                            <th><?php echo lang('consumption'); ?></th>
                                            <th><?php echo lang('actions'); ?></th> 
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $i = 0;
                                        if ($modifier_ingredients && !empty($modifier_ingredients)) {
                                            foreach ($modifier_ingredients as $fmi) {
                                                $i++;
                                                echo '<tr id="row_' . $i . '">' .
                                                '<td style="width: 12%; padding-left: 10px;"><p>' . $i . '</p></td>' .
                                                '<td style="width: 23%"><span style="padding-bottom: 5px;">' . (isset($fmi->ingredient_id) && $fmi->ingredient_id ? getIngredientNameById($fmi->ingredient_id) : '') . '</span></td>' .
                                                '<input type="hidden" id="ingredient_id_' . $i . '" name="ingredient_id[]" value="' . $fmi->ingredient_id . '"/>' .
                                                '<td style="width: 30%"><input type="text" tabindex="' . $i . '" id="consumption_' . $i . '" name="consumption[]" value="' . $fmi->consumption . '" onfocus="this.select();" class="form-control integerchk aligning" style="width: 85%;" placeholder="Consumption"/><span  class="label_aligning">' . (isset($fmi->ingredient_id) && $fmi->ingredient_id ? unitName(getUnitIdByIgId($fmi->ingredient_id)) : '') . '</span></td>' .
                                                '<td style="width: 17%"><a class="btn btn-danger btn-xs" style="margin-left: 5px; margin-top: 10px;" onclick="return deleter(' . $i . ',' . $fmi->ingredient_id . ');" ><i class="fa fa-trash"></i> </a></td>' .
                                                '</tr>';
                                            }
                                        }

                                        //$ingredient_id_container = substr($ingredient_id_container, -1);
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?php echo lang('description'); ?></label>
                            <textarea tabindex="3" class="form-control" rows="2" id="description" name="description" placeholder="<?php echo lang('enter'); ?> ..."><?php echo $modifier_details->description; ?></textarea>
                        </div>
                        <?php if (form_error('description')) { ?>
                            <div class="alert alert-error" style="padding: 5px !important;">
                                <p><?php echo form_error('description'); ?></p>
                            </div>
                        <?php } ?>
                        <div class="alert alert-error error-msg description_err_msg_contnr" style="padding: 5px !important;">
                            <p id="description_err_msg"></p>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                </div>

                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
                    <a href="<?php echo base_url() ?>Master/modifiers"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div> 
    <div class="modal fade" id="noticeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="noticeModal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-2x">×</i></span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 hidden-lg hidden-sm">
                            <p class="modifierCartNotice">
                                <strong style="margin-left: 39%"><?php echo lang('notice'); ?></strong><br>
                                <?php echo lang('notice_text_1'); ?>
                            </p>
                        </div>
                        <div class="col-md-12 hidden-xs hidden-sm">
                            <p class="modifierCartNotice">
                                <strong style="margin-left: 43%"><?php echo lang('notice'); ?></strong><br>
                               <?php echo lang('notice_text_1'); ?>
                            </p>
                        </div>
                        <div class="col-md-12 hidden-xs hidden-lg">
                            <p class="modifierCartNotice">
                                <strong style="margin-left: 43%"><?php echo lang('notice'); ?></strong><br>
                                <?php echo lang('notice_text_1'); ?>
                            </p>
                        </div>
                        <div class="col-md-12">
                            <p class="modifierCartInfo">
                                <!-- Please mention the consumption in the unit shown at right. <br>
                                 eg: 5Kg, 0.20Kg, 3L, 0.50L, 1Pcs etc
                                 <br>
                                 <br>-->
                                <a style="font-weight: bold;" href="https://www.convert-me.com/en/convert/" target="_blank"><?php echo lang('click_here'); ?></a>  <?php echo lang('notice_text_2'); ?>
                                <br>
                                <br>
                                <?php echo lang('notice_text_2'); ?>
                                <br>
                                <span style="font-weight: bold; font-style: italic;"><?php echo lang('notice_text_3'); ?></span>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div> 
</section> 