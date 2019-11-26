 
<script type="text/javascript">  
    var ingredient_id_container = [];


    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2();
    })

</script>
<style>
    .input-sm{
        font-size:17px;
    }
</style>

<?php
if ($this->session->flashdata('exception')) {

    echo '<section class="content-header"><div class="alert alert-success alert-dismissible"> 
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <p><i class="icon fa fa-check"></i>';
    echo $this->session->flashdata('exception');
    echo '</p></div></section>';
}
?> 

<style type="text/css">
    .top-left-header{
        margin-top: 0px !important;
    }
</style>

<section class="content-header">
    <div class="row">
        <div class="col-md-3">
            <h2 class="top-left-header"><?php echo lang('food_menus'); ?> </h2>
        </div>
        <div class="col-md-3">
            <?php echo form_open(base_url() . 'Master/foodMenus') ?>
            <select name="category_id" class="form-control select2" >
                <option value=""><?php echo lang('category'); ?></option>
                <?php foreach ($foodMenuCategories as $ctry) { ?>
                    <option value="<?php echo $ctry->id ?>" <?php echo set_select('category_id', $ctry->id); ?>><?php echo $ctry->category_name ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="hidden-lg">&nbsp;</div>
        <div class="col-md-1">
            <button type="submit" name="submit" value="submit" class="btn btn-block btn-primary pull-left"><?php echo lang('submit'); ?></button>
        </div>
        <div class="hidden-lg">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
        <div class="col-md-5 text-right">
            <ul class="list-inline text-right">
                <li>
                    <a href="<?php echo base_url() ?>Master/addEditFoodMenu"><button type="button" class="btn btn-block btn-primary pull-right"><?php echo lang('add_food_menu'); ?></button></a>
                </li>
                <li>
                    <a href="<?php echo base_url() ?>Master/uploadFoodMenu"><button type="button" class="btn btn-block btn-primary pull-right"><?php echo lang('upload_food_menu'); ?></button></a>
                </li>
                <li>
                    <a href="<?php echo base_url() ?>Master/uploadFoodMenuIngredients"><button type="button" class="btn btn-block btn-primary pull-right"><?php echo lang('upload_food_menu_ingredients'); ?></button></a>
                </li>
            </ul>
        </div>
    </div> 
</section> 

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
                                <th style="width: 1%"><?php echo lang('sn'); ?></th>
                                <th style="width: 8%"><?php echo lang('code'); ?></th>
                                <th style="width: 25%"><?php echo lang('name'); ?></th>
                                <th style="width: 13%"><?php echo lang('category'); ?></th>
                                <th style="width: 13%"><?php echo lang('sale_price'); ?></th>
                                <th style="width: 13%"><?php echo lang('total_ingredients'); ?></th>
                                <th style="width: 18%"><?php echo lang('added_by'); ?></th>
                                <th style="width: 6%;text-align: center"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($foodMenus && !empty($foodMenus)) {
                                $i = count($foodMenus);
                            }
                            foreach ($foodMenus as $value) {
                                ?>                       
                                <tr> 
                                    <td style="text-align: center"><?php echo $i--; ?></td>
                                    <td><?php echo $value->code; ?></td> 
                                    <td><?php echo $value->name; ?></td> 
                                    <td><?php echo foodMenucategoryName($value->category_id); ?></td> 
                                    <td> <?php echo $this->session->userdata('currency'); ?> <?php echo $value->sale_price; ?></td>
                                    <td style="text-align: center"><?php echo totalIngredients($value->id); ?></td>
                                    <td><?php echo userName($value->user_id); ?></td>  
                                    <td style="text-align: center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right" role="menu"> 
                                                <li><a href="<?php echo base_url() ?>Master/foodMenuDetails/<?php echo $this->custom->encrypt_decrypt($value->id, 'encrypt'); ?>" ><i class="fa fa-eye tiny-icon"></i><?php echo lang('view_details'); ?></a></li>
                                                <li><a href="<?php echo base_url() ?>Master/addEditFoodMenu/<?php echo $this->custom->encrypt_decrypt($value->id, 'encrypt'); ?>" ><i class="fa fa-pencil tiny-icon"></i><?php echo lang('edit'); ?></a></li>
                                                <li><a href="<?php echo base_url() ?>Master/assignFoodMenuModifier/<?php echo $this->custom->encrypt_decrypt($value->id, 'encrypt'); ?>" ><i class="fa fa-plus tiny-icon"></i><?php echo lang('assign_modifier'); ?></a></li>
                                                <li><a class="delete" href="<?php echo base_url() ?>Master/deleteFoodMenu/<?php echo $this->custom->encrypt_decrypt($value->id, 'encrypt'); ?>" ><i class="fa fa-trash tiny-icon"></i><?php echo lang('delete'); ?></a></li> 
                                            </ul> 
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?> 
                        </tbody>
                        <tfoot>
                            <tr>
                                <th><?php echo lang('sn'); ?></th>
                                <th><?php echo lang('code'); ?></th>
                                <th><?php echo lang('name'); ?></th>
                                <th><?php echo lang('category'); ?></th>
                                <th><?php echo lang('sale_price'); ?></th> 
                                <th><?php echo lang('total_ingredients'); ?></th>
                                <th><?php echo lang('added_by'); ?></th>  
                                <th style="text-align: center"><?php echo lang('actions'); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->
            </div> 
        </div> 
    </div> 
</section>
<!-- DataTables -->
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script>
    $(function () { 
        $('#datatable').DataTable({ 
            'autoWidth'   : false,
            'ordering'    : false
        })
    })
</script>
