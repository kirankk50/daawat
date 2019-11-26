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
if (!empty($food_menu_modifiers)) {
    $modifier_id_container = "[";
    if ($food_menu_modifiers && !empty($food_menu_modifiers)) {
        foreach ($food_menu_modifiers as $fmm) {
            $modifier_id_container .= '"' . $fmm->modifier_id . '",';
        }
    }
    $modifier_id_container = substr($modifier_id_container, 0, -1);
    $modifier_id_container .= "]";
} else {
    $modifier_id_container = "[]";
}
?>

    var modifier_id_container = <?php echo $modifier_id_container; ?>;


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
if (isset($food_menu_modifiers)) {
    echo count($food_menu_modifiers);
} else {
    echo 0;
};
?>;  
     
        var tab_index = 6;

        $('#modifier_id').change(function(){
            // alert('test');
            var modifiers_details=$('#modifier_id').val();
            if (modifiers_details != '') { 

                var modifiers_details_array = modifiers_details.split('|'); 


          
                var index = modifier_id_container.indexOf(modifiers_details_array[0]);  

                if (index > -1) {
                    swal({
                        title: "Alert",
                        text: "Modifier already remains in cart, you can change the consumption value!",
                        confirmButtonColor: '#3c8dbc'
                    });
                    $('#modifier_id').val('').change();
                    return false;
                } 

                suffix++;
                tab_index++; 

                var cart_row = '<tr id="row_' + suffix + '">'+
                    '<td style="width: 12%; padding-left: 10px;"><p style="margin-top:10px;">'+suffix+'</p></td>'+
                    '<td style="width: 23%"><div class="checkbox"><label><input type="checkbox" id="modifier_id_' + suffix + '" name="modifier_id[]" value="' + modifiers_details_array[0] + '"/>'+ modifiers_details_array[1] +'</label></div></td>'+
                    '<td style="width: 17%"><a class="btn btn-danger btn-xs" style="margin-left: 5px; margin-top: 10px;" onclick="return deleter(' + suffix + ',' + modifiers_details_array[0] +');" ><i class="fa fa-trash"></i> </a></td>'+
                    '</tr>';  

                $('#ingredient_consumption_table tbody').append(cart_row);    

                modifier_id_container.push(modifiers_details_array[0]);
                /*
                updateRowNo();*/
                $('#modifier_id').val('').change();
                updateRowNo();
            }
        }); 
        
         
        // Validate form
        $("#food_menu_form").submit(function(){
            var name = $("#name").val();
            var category_id = $("#category_id").val();
            var veg_or_nonveg_id =$("#veg_or_nonveg_id").val();
            var kitchen_or_bar_id = $("#kitchen_or_bar_id").val();
            var description = $("#description").val();
            var sale_price = $("#sale_price").val(); 
            var ingredientCount = $("#form-table tbody tr").length;
            var error = false;  


            if(name==""){ 
                $("#name_err_msg").text("The Name field is required.");
                $(".name_err_msg_contnr").show(200);
                error = true;
            } 

            /*            if(name.length>18){ 
                $("#name_err_msg").text("The Name field cannot exceed 18 characters in length.");
                $(".name_err_msg_contnr").show(200);
                error = true;
            }*/

            if(category_id==""){ 
                $("#category_id_err_msg").text("The Category field is required.");
                $(".category_err_msg_contnr").show(200);
                error = true;
            } 
            
            if(veg_or_nonveg_id==""){ 
                $("#veg_or_nonveg_id_err_msg").text("The Vegetable or Non Vegetable field is required.");
                $(".veg_or_nonveg_err_msg_contnr").show(200);
                error = true;
            } 
            
            if(kitchen_or_bar_id==""){ 
                $("#kitchen_or_bar_id_err_msg").text("The Kitchen or Bar field is required.");
                $(".kitchen_or_bar_err_msg_contnr").show(200);
                error = true;
            } 

            if(description.length>200){ 
                $("#description_err_msg").text("The Description field cannot exceed 200 characters in length.");
                $(".description_err_msg_contnr").show(200);
                error = true;
            }

            if(sale_price==""){ 
                $("#sale_price_err_msg").text("The Sale Price field is required.");
                $(".sale_price_err_msg_contnr").show(200);
                error = true;
            }  

            if(ingredient_id_container.length == 0){ 
                $("#ingredient_id_err_msg").text("At least 1 Ingredient is required.");
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

             
            /*if(description.length>200){
                $("#description").css({"border-color":"red"});
                $("#description").next("span").show(200).delay(5000).hide(200,function(){
                    $("#description").css({"border-color":"#ccc"});
                });
                error = true;
            } 
            for(var n=0;n<=suffix-1;n++){
                if(deletedRow.indexOf(n)<0){
                    var consumption= $.trim($("#consumption_"+n).val());
                    if(consumption==''||isNaN(consumption)){
                        $("#consumption_"+n).css({"border-color":"red"});
                        $("#consumption_"+n).next("span").show(200).delay(5000).hide(200,function(){
                            $("#consumption_"+n).css({"border-color":"#ccc"});
                        });
                        error = true;
                    } 
                }
            } */ 

            if(error == true){
                return false;
            } 
        });



    }) 

    function deleter(suffix, ingredient_id){
        swal({
            title: "Alert",
            text: "Are you sure?",
            confirmButtonColor: '#3c8dbc',
            showCancelButton: true
        }, function() {
            $("#row_"+suffix).remove();
            var modifier_id_container_new = [];

            for(var i = 0; i < modifier_id_container.length; i++){
                if(modifier_id_container[i] != ingredient_id){
                    modifier_id_container_new.push(modifier_id_container[i]);
                }
            }

            modifier_id_container = modifier_id_container_new;

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
    .foodMenuCartInfo{
        border: 2px solid #3c8dbc;
        padding: 15px;
        border-radius: 5px;
        color: #3c8dbc;
        font-size: 14px;
        margin-top: 0px;
        text-align: justify;
    }
    .foodMenuCartNotice{
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
        Add/Edit Food Menu Modifier
    </h1>  
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary"> 
                <!-- form start -->
                <?php echo form_open(base_url() . 'Master/addEditFoodMenuModifier/' . $encrypted_id, $arrayName = array('id' => 'food_menu_form', 'enctype' => 'multipart/form-data')) ?>

                <div class="box-body">




                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Modifiers </label>
                                <select tabindex="5" class="form-control select2 select2-hidden-accessible" name="modifier_id" id="modifier_id" style="width: 100%;">
                                    <option value="">Select</option>
                                    <?php foreach ($modifiers as $modifier) { ?>
                                        <option value="<?php echo $modifier->id . "|" . $modifier->name ?>" <?php echo set_select('id', $modifier->id); ?>><?php echo $modifier->name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php if (form_error('modifier_id')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <p><?php echo form_error('modifier_id'); ?></p>
                                </div>
                            <?php } ?>
                            <div class="alert alert-error error-msg ingredient_err_msg_contnr" style="padding: 5px !important;">
                                <p id="ingredient_id_err_msg"></p>
                            </div>
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
                                            <th>SN</th>
                                            <th>Modifier</th>

                                            <th>Actions</th> 
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $i = 0;
                                        if ($food_menu_modifiers && !empty($food_menu_modifiers)) {
                                            foreach ($food_menu_modifiers as $fmm) {
                                                $i++;
                                                echo '<tr id="row_' . $i . '">' .
                                                '<td style="width: 12%; padding-left: 10px;"><p style="margin-top:10px;">' . $i . '</p></td>' .
                                                '<td style="width: 30%"><div class="checkbox"><label><input checked  type="checkbox"  tabindex="' . $i . '" id="modifier_id_' . $i . '" name="modifier_id[]" value="' . $fmm->modifier_id . '"  />' . (isset($fmm->modifier_id) && $fmm->modifier_id ? getModifierNameById($fmm->modifier_id) : '') . '</label></div></td>' .
                                                '<td style="width: 17%"><a class="btn btn-danger btn-xs" style="margin-left: 5px; margin-top: 10px;" onclick="return deleter(' . $i . ',' . $fmm->id . ');" ><i class="fa fa-trash"></i> </a></td>' .
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



                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
                        <a href="<?php echo base_url() ?>Master/foodMenus"><button type="button" class="btn btn-primary">Back</button></a>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>

</section>