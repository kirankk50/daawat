<style type="text/css">
    .top-left-header{
        margin-top: 0px !important;
    }
</style>

<section class="content-header">
    <div class="row">
        <div class="col-md-12 text-center">
            <h2 class="top-left-header"><?php echo lang('inventory'); ?> </h2>
        </div>
    </div>
    <hr style="border: 1px solid #3c8dbc;">
    <div class="row">
        <?php echo form_open(base_url() . 'Report/inventoryReport') ?>
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="hiddentIngredientID" id="hiddentIngredientID" value="<?= isset($ingredient_id) ? $ingredient_id : '' ?>">
        <div class="col-md-2">
            <div class="form-group"> 
                <select class="form-control select2 category_id" name="category_id" id="category_id" style="width: 100%;">
                    <option value=""><?php echo lang('category'); ?></option>
                    <?php foreach ($ingredient_categories as $value) { ?>
                        <option value="<?php echo $value->id ?>" <?php echo set_select('category_id', $value->id); ?>><?php echo $value->category_name ?></option>
                    <?php } ?>
                </select>
            </div> 
        </div>
        <div class="col-md-2"> 
            <div class="form-group"> 
                <select class="form-control select2" name="ingredient_id" id="ingredient_id" style="width: 100%;">
                    <option value=""><?php echo lang('ingredient'); ?></option>
                    <?php foreach ($ingredients as $value) { ?>
                        <option value="<?php echo $value->id ?>" <?php echo set_select('ingredient_id', $value->id); ?>><?php echo $value->name . "(" . $value->code . ")" ?></option>
                    <?php } ?>
                </select>
            </div> 
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <select class="form-control select2" name="food_id" id="food_id" style="width: 100%;">
                    <option value=""><?php echo lang('food_menu'); ?></option>
                    <?php foreach ($foodMenus as $value) { ?>
                        <option value="<?php echo $value->id ?>" <?php echo set_select('food_id', $value->id); ?>><?php echo substr(ucwords(strtolower($value->name)), 0, 18) . "(" . $value->code . ")" ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-1">
            <button type="submit" name="submit" value="submit" class="btn btn-block btn-primary pull-left"><?php echo lang('submit'); ?></button>
        </div>
        <div class="hidden-lg"><span style="color:transparent">space</span></div>
        <div class="col-md-2">
            <a href="<?= base_url() . 'Inventory/getInventoryAlertList' ?>" class="btn btn-block btn-primary pull-left"><span style="color:red"><?= getAlertCount() ?></span> <?php echo lang('ingredients_alert'); ?> </a>
        </div>
        <div class="hidden-lg"><br><br></div>
        <div class="col-md-3">
            <strong id="stockValue"></strong>
        </div>
    </div>
    <?php echo form_close(); ?>
</section> 
<style type="text/css">
    h1,h2,h3,h4,p{
        margin:3px 0px;
    }
    .body_area{
        padding:1px;
    }
    .tbl  {
        border-collapse:collapse;
        border-spacing:0;
        width: 100%;

    }
    .tbl tr td{
        padding:14px;
        font-family:Arial, sans-serif;
        font-size:15px;
        border-style:solid;
        border-width:1px;
        word-break:break-all;
    }

    .title{
        font-weight: bold;
    }
</style> 
<section class="content"> 
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary"> 
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="title" style="width: 5%"><?php echo lang('sn'); ?></th>
                                <th class="title" style="width: 37%"><?php echo lang('ingredient'); ?>(<?php echo lang('code'); ?>)</th>
                                <th class="title" style="width: 20%"><?php echo lang('category'); ?></th>
                                <th class="title" style="width: 20%"><?php echo lang('stock_qty_amount'); ?></th>
                                <th class="title" style="width: 20%"><?php echo lang('alert_qty_amount'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $totalStock = 0;
                                $grandTotal = 0;
                                $alertCount = 0;
                                $totalTK = 0;
                                if (!empty($inventory) && isset($inventory)):
                                    foreach ($inventory as $key => $value):
                                        $totalStock = $value->total_purchase - $value->total_consumption - $value->total_modifiers_consumption - $value->total_waste + $value->total_consumption_plus - $value->total_consumption_minus;
                                        $totalTK = $totalStock * getLastPurchaseAmount($value->id);
                                        if ($totalStock >= 0) {
                                            $grandTotal = $grandTotal + $totalStock * getLastPurchaseAmount($value->id);
                                        }
                                        $key++;
                                        ?>
                                        <tr>
                                            <td style="text-align: center"><?= $key ?></td>
                                            <td><?= $value->name . "(" . $value->code . ")" ?></td>
                                            <td><?= $value->category_name ?></td>
                                            <td><span style="<?= ($totalStock <= $value->alert_quantity) ? 'color:red' : '' ?>"><?= ($totalStock) ? $totalStock : '0.0' ?><?= " " . $value->unit_name ?></span></td>
                                            <td><?= $value->alert_quantity . " " . $value->unit_name ?></td>
                                        </tr>
                                        <?php
                                    endforeach;
                                endif;
                                ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="title" style="width: 5%"><?php echo lang('sn'); ?></th>
                                <th class="title" style="width: 37%"><?php echo lang('ingredient'); ?>(<?php echo lang('code'); ?>)</th>
                                <th class="title" style="width: 20%"><?php echo lang('category'); ?></th>
                                <th class="title" style="width: 20%"><?php echo lang('stock_qty_amount'); ?></th>
                                <th class="title" style="width: 20%"><?php echo lang('alert_qty_amount'); ?></th>
                            </tr>
                        </tfoot> 
                    </table>
                    <input type="hidden" value="<?= number_format($grandTotal, 2) ?>" id="grandTotal" name="grandTotal">
                </div>
                <!-- /.box-body -->
            </div> 
        </div> 
    </div>

</section>  
<script type="text/javascript">
    $(function(){
        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass   : 'iradio_minimal-blue'
        })
    }) 
    $(function(){
        $('#food_id').on('change', function(){
            var value = this.value;
            if(value){
                $('#category_id').prop('disabled', true);
                $('#ingredient_id').prop('disabled', true);
            }else{
                $('#category_id').prop('disabled', false);
                $('#ingredient_id').prop('disabled', false);
            }
        });
        $('#ingredient_id').on('change', function(){
            var ingredient_id = this.value;
            var category_id = $('select.category_id').find(':selected').val();
            if(ingredient_id || category_id){
                $('#food_id').prop('disabled', true);
            }else{
                $('#food_id').prop('disabled', false);
            }
        });
        $('#category_id').on('change', function(){
            var category_id = this.value;
            if(category_id){
                $('#food_id').prop('disabled', true);
            }else{
                $('#food_id').prop('disabled', false);
            }

            var options = '';
            $.ajax({
                type : 'get',
                url : '<?php echo base_url(); ?>Inventory/getIngredientInfoAjax',
                data: {category_id: category_id,'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},
                datatype: 'json',
                success : function(data){
                    var json = $.parseJSON(data);
                    options += '<option  value=""><?php echo lang('ingredient'); ?></option>';
                    $.each(json, function (i, v) {
                        options += '<option  value="'+v.id+'">'+v.name+'('+v.code+')</option>';
                    });
                    $('#ingredient_id').html(options);
                }
            });
        });
    });

    $(document).ready(function(){
        var category_id = $('select.category_id').find(':selected').val();
        var ingredient_id = $('select.ingredient_id').find(':selected').val();
        var food_id = $('select.food_id').find(':selected').val();
        if(food_id){
            $('#category_id').prop('disabled', false);
            $('#ingredient_id').prop('disabled', false);

        }else if(ingredient_id || category_id){
            $('#category_id').prop('disabled', false);
            $('#ingredient_id').prop('disabled', false);
        }
        else{
            if(food_id){
                $('#category_id').prop('disabled', true);
                $('#ingredient_id').prop('disabled', true);
            }

        }
        if(category_id){
            var options = '';
            var selectedID=$("#hiddentIngredientID").val();
            $.ajax({
                type : 'get',
                url : '<?php echo base_url(); ?>Inventory/getIngredientInfoAjax',
                data: {category_id: category_id,'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},
                datatype: 'json',
                success : function(data){
                    var json = $.parseJSON(data);
                    options += '<option  value=""><?php echo lang('ingredient'); ?></option>';
                    $.each(json, function (i, v) {
                        options += '<option  value="'+v.id+'">'+v.name+'('+v.code+')</option>';
                    });
                    $('#ingredient_id').html(options);
                    $('#ingredient_id').val(selectedID).change();
                }
            });
        }
        $('#stockValue').html('<?php echo lang('stock_value'); ?>: <?php echo $this->session->userdata('currency'); ?> '+$('#grandTotal').val()+'<a class="top" title="" data-placement="top" data-toggle="tooltip" style="cursor:pointer" data-original-title="Calculated based on last purchase price and Ingredient with negative Stock Qty/Amount is not considered"><i class="fa fa-question fa-lg form_question"></i></a>');
    });
</script>  

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script> 

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">

<script> 
    $(function(){ 

    var TITLE = "<?php echo lang('inventory_report'); ?> "+today; 

    $('#datatable').DataTable( {
        'autoWidth'   : false,
        'ordering'    : false,
        dom: 'Bfrtip',
        buttons: [ 
            {
                extend: 'print',
                title: TITLE
            },
            {
                extend: 'excelHtml5',
                title: TITLE
            },
            {
                extend: 'pdfHtml5',
                title: TITLE
            }
        ]
    } );
} );
</script> 