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
        margin-top: 35px;
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
         <?php echo lang('details_inventory_Adjustment'); ?>
    </h1>  
</section>

<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">

                <!-- /.box-header -->
                <!-- form start -->
                <?php echo form_open(base_url() . 'Inventory_adjustment/addEditInventoryAdjustment/' . $encrypted_id, $arrayName = array('id' => 'consumption_form')) ?>
                <div class="box-body">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <h3><?php echo lang('ref_no'); ?></h3>
                                <p class="field_value"><?php echo $inventory_adjustment_details->reference_no; ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <h3><?php echo lang('date'); ?> </h3>
                                <p class="field_value"><?php echo date($this->session->userdata('date_format'), strtotime($inventory_adjustment_details->date)); ?></p>
                            </div> 
                        </div>

                        <div class="col-md-4">
                            <div class="form-group"> 
                                <h3><?php echo lang('responsible_person'); ?> </h3>
                                <p class="field_value"><?php echo employeeName($inventory_adjustment_details->employee_id); ?></p>
                            </div>   
                        </div> 
                    </div> 
                    <div class="row">
                        <div class="col-md-6">  
                            <div class="form-group"> 
                                <h3><?php echo lang('ingredients'); ?> </h3> 
                            </div>   
                        </div> 
                    </div> 

                    <div class="row">
                        <div class="col-md-12"> 
                            <div class="table-responsive" id="consumption_cart">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th width="10%"><?php echo lang('sn'); ?></th>
                                            <th width="25%"><?php echo lang('ingredient'); ?>(<?php echo lang('code'); ?>)</th>
                                            <th width="25%"><?php echo lang('quantity_amount'); ?></th>
                                            <th width="25%"><?php echo lang('consumption_status'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $i = 0;
                                        if ($inventory_adjustment_ingredients && !empty($inventory_adjustment_ingredients)) {
                                            foreach ($inventory_adjustment_ingredients as $wi) {
                                                $i++;
                                                echo '<tr id="row_' . $i . '">' .
                                                '<td style="width: 10%; padding-left: 10px;"><p>' . $i . '</p></td>' .
                                                '<td style="width: 20%"><span style="padding-bottom: 5px;">' . getIngredientNameById($wi->ingredient_id) . ' (' . getIngredientCodeById($wi->ingredient_id) . ')</span></td>' .
                                                '<td style="width: 15%">' . $wi->consumption_amount . unitName(getUnitIdByIgId($wi->ingredient_id)) . '</td>' .
                                                '<td style="width: 15%">' . $wi->consumption_status . '</td>' .
                                                '</tr>';
                                            }
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div> 
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group"> 
                                <h3><?php echo lang('note'); ?></h3>
                                <p class="field_value"><?php echo $inventory_adjustment_details->note; ?></p>
                            </div> 
                        </div> 
                    </div> 
                </div> 
                <div class="box-footer">
                    <a href="<?php echo base_url() ?>Inventory_adjustment/addEditInventoryAdjustment/<?php echo $encrypted_id; ?>"><button type="button" class="btn btn-primary"><?php echo lang('edit'); ?></button></a>
                    <a href="<?php echo base_url() ?>Inventory_adjustment/inventoryAdjustments"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
                </div>
                <?php echo form_close(); ?> 
            </div> 
        </div>
    </div> 
</section>