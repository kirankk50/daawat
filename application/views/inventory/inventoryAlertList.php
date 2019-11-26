<style type="text/css">
    .top-left-header{
        margin-top: 0px !important;
    }
</style>

<section class="content-header">
    <div class="col-md-12 text-center">
        <h2 class="top-left-header">Alert Inventory </h2>
    </div>
    <div class="row">
        <div class="col-md-1">
            <a href="<?= base_url() . 'Inventory/index' ?>" class="btn btn-block btn-primary pull-left"><strong>Back</strong></a>
        </div>
        <div class="hidden-lg"><span style="font-size: 4px;color:transparent">hidden text</span></div>
    </div>

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
                                <th class="title" style="width: 5%">SN</th>
                                <th class="title" style="width: 37%">Ingredient(Code)</th>
                                <th class="title" style="width: 20%">Category</th>
                                <th class="title" style="width: 20%">Stock Amount</th>
                                <th class="title" style="width: 20%">Alert Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        <?php
                        $totalStock = 0;
                        $grandTotal = 0;
                        $totalTK = 0;
                        $i = 1;
                        if (!empty($inventory) && isset($inventory)):
                            foreach ($inventory as $key => $value):
                                $totalStock = $value->total_purchase - $value->total_consumption - $value->total_modifiers_consumption - $value->total_waste + $value->total_consumption_plus - $value->total_consumption_minus;
                                $totalTK = $totalStock * getLastPurchaseAmount($value->id);
                                if ($totalStock <= $value->alert_quantity):
                                    if ($totalStock >= 0) {
                                        $grandTotal = $grandTotal + $totalStock * getLastPurchaseAmount($value->id);
                                    }
                                    $key++;
                                    ?>
                                    <tr>
                                        <td style="text-align: center"><?= $i ?></td>
                                        <td><?= $value->name . "(" . $value->code . ")" ?></td>
                                        <td><?= $value->category_name ?></td>
                                        <td><span style="<?= ($totalStock <= $value->alert_quantity) ? 'color:red' : '' ?>"><?= ($totalStock) ? $totalStock : '0.0' ?><?= " " . $value->unit_name ?></span></td>
                                        <td><?= $value->alert_quantity . " " . $value->unit_name ?></td>
                                    </tr>
                                    <?php
                                    $i++;
                                endif;
                            endforeach;
                        endif;
                        ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="title" style="width: 5%">SN</th>
                                <th class="title" style="width: 37%">Ingredient(Code)</th>
                                <th class="title" style="width: 20%">Category</th>
                                <th class="title" style="width: 20%">Stock Qty/Amount</th>
                                <th class="title" style="width: 20%">Alert Qty/Amount</th>
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
        $('#category_id').on('change', function(){
            var category_id = this.value;
            var options = '';
            $.ajax({
                type : 'get',
                url : '<?php echo base_url(); ?>Inventory/getIngredientInfoAjax',
                data: {category_id: category_id,'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},
                datatype: 'json',
                success : function(data){
                    var json = $.parseJSON(data);
                    options += '<option  value="">Ingredient</option>';
                    $.each(json, function (i, v) {
                        options += '<option  value="'+v.id+'">'+v.name+'</option>';
                    });
                    $('#ingredient_id').html(options);
                }
            });
        });
    });

    $(document).ready(function(){
        var category_id = $('select.category_id').find(':selected').val();
        if(category_id){
            var options = '';
            $.ajax({
                type : 'get',
                url : '<?php echo base_url(); ?>Inventory/getIngredientInfoAjax',
                data: {category_id: category_id,'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},
                datatype: 'json',
                success : function(data){
                    var json = $.parseJSON(data);
                    options += '<option  value="">Ingredient</option>';
                    $.each(json, function (i, v) {
                        options += '<option  value="'+v.id+'">'+v.name+'</option>';
                    });
                    $('#ingredient_id').html(options);
                }
            });
        }
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

    var TITLE = "Inventory Report "+today; 

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