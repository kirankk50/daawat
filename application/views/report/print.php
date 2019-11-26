<style type="text/css">
    .top-left-header{
        margin-top: 0px !important;
    }
</style>

<section class="content-header"> 
    <h3>Daily Summary Report</h3>
    <hr style="border: 1px solid #3c8dbc;">
    <div class="row">
        <div class="col-md-2">
            <?php echo form_open(base_url() . 'Report/dailySummaryReport') ?>
            <div class="form-group"> 
                <input tabindex="1" type="text" id="date" name="date" readonly class="form-control" placeholder="Date" value="<?php echo set_value('date'); ?>">
            </div> 
        </div>
        <div class="col-md-1">
            <div class="form-group">
                <button type="submit" name="submit" value="submit" class="btn btn-block btn-primary pull-left">Submit</button>
            </div>
        </div>
        <div class="hidden-lg">
            <div class="clearfix"></div>
        </div> 
        <div class="col-md-offset-8 col-md-1">
            <div class="form-group"> 
                <a class="btn btn-block btn-primary pull-left" href="<?php echo base_url(); ?>Report/printDailySummaryReport/<?php echo $selectedDate; ?>">Print</a>
            </div>
        </div>
    </div> 
</section> 
<style type="text/css">
    h1,h2,h3,h4,p{
        margin:3px 0px;
        text-align: center;
    }

    .tbl  {
        border-collapse:collapse;
        border-spacing:0;
        width: 100%;

    }
    .tbl tr td{
        padding:5px;
        font-family:Arial, sans-serif;
        font-size:15px;
        border-style:solid;
        border-width:1px;
        word-break:break-all;
    }
    .tbl tr th{
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
    .box-primary{
        border-top-color: white !important;
        margin-top: 5px;
    }

</style> 
<section class="content"> 
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">  


                <!-- /.box-header -->
                <div class="box-body table-responsive"> 
                    <h1><?php echo $this->session->userdata('outlet_name'); ?></h1>
                    <hr>
                    <h3 style="text-align: center;">Daily Summary Report</h3>
                    <h4><?= isset($selectedDate) && $selectedDate ? "Date: " . date($this->session->userdata('date_format'), strtotime($selectedDate)) : '' ?></h4>
                    <hr>
                    <h4 style="font-weight: bold; text-align: center; margin-top: 20px;">Purchases</h4>
                    <hr>
                    <table style="width: 100%" class="tbl">    
                        <tr>
                            <th style="font-weight: bold; text-align: center;">SN</th>
                            <th>Reference No</th>
                            <th>Supplier</th> 
                            <th>G. Total</th>
                            <th>Paid</th>
                            <th>Due</th> 
                        </tr> 
                        <?php  
                            $sum_of_gtotal = 0;
                            $sum_of_paid = 0;
                            $sum_of_due = 0;
                            if (!empty($result['purchases']) && isset($result['purchases'])):
                                foreach ($result['purchases'] as $key => $value): 
                                    $sum_of_gtotal += $value->grand_total; 
                                    $sum_of_paid += $value->paid;  
                                    $sum_of_due += $value->due;  
                                    $key++;
                                    ?>
                                    <tr>
                                        <td style="text-align: center"><?= $key ?></td>
                                        <td><?= $value->reference_no; ?></td>
                                        <td><?= getSupplierNameById($value->supplier_id) ?></td>  
                                        <td><?= $value->grand_total ?></td>
                                        <td><?= $value->paid ?></td> 
                                        <td><?= $value->due ?></td> 
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                        ?>
                        <tr> 
                            <td>&nbsp;</td> 
                            <td>&nbsp;</td> 
                            <td style="font-weight: bold; text-align: right;">Sum</td>  
                            <td>&nbsp;<?= $sum_of_gtotal ?></td>
                            <td>&nbsp;<?= $sum_of_paid ?></td> 
                            <td>&nbsp;<?= $sum_of_due ?></td> 
                        </tr>
                    </table> 

                    <hr>
                    <h4 style="font-weight: bold; text-align: center; margin-top: 20px;">Sales</h4>
                    <hr>
                    <table style="width: 100%" class="tbl">    
                        <tr>
                            <th style="font-weight: bold; text-align: center;">SN</th>
                            <th>Reference No</th>
                            <th>Order Type</th>
                            <th>Table</th>
                            <th>Customer</th>
                            <th>Total Payable</th>
                            <th>Discount</th> 
                            <th>Paid</th>
                            <th>Due</th>  
                        </tr> 
                        <?php  
                            $sum_of_stotal_payable = 0;
                            $sum_of_sdisc_actual = 0;
                            $sum_of_spaid_amount = 0;
                            $sum_of_sdue_amount = 0;
                            if (!empty($result['sales']) && isset($result['sales'])):
                                foreach ($result['sales'] as $key => $value): 
                                    $sum_of_stotal_payable += $value->total_payable; 
                                    $sum_of_sdisc_actual += $value->disc_actual;  
                                    $sum_of_spaid_amount += $value->paid_amount;  
                                    $sum_of_sdue_amount += $value->due_amount;  
                                    $key++;
                                    ?>
                                    <tr>
                                        <td style="text-align: center"><?= $key ?></td>
                                        <td><?= $value->sale_no; ?></td>
                                        <td><?php echo getOrderType($value->order_type); ?></td>
                                        <td><?php if(!empty($value->table_id)){ echo getTableName($value->table_id); } ?></td>
                                        <td><?= getCustomerName($value->customer_id) ?></td>  
                                        <td><?= $value->total_payable ?></td>
                                        <td><?= $value->disc_actual ?></td> 
                                        <td><?= $value->paid_amount ?></td> 
                                        <td><?= $value->due_amount ?></td>  
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                        ?>
                        <tr>  
                            <td>&nbsp;</td> 
                            <td>&nbsp;</td> 
                            <td>&nbsp;</td> 
                            <td>&nbsp;</td> 
                            <td style="font-weight: bold; text-align: right;">Sum</td>  
                            <td>&nbsp;<?= $sum_of_stotal_payable ?></td>
                            <td>&nbsp;<?= $sum_of_sdisc_actual ?></td> 
                            <td>&nbsp;<?= $sum_of_spaid_amount ?></td> 
                            <td>&nbsp;<?= $sum_of_sdue_amount ?></td> 
                        </tr>
                    </table> 


                    <hr>
                    <h4 style="font-weight: bold; text-align: center; margin-top: 20px;">Expenses</h4>
                    <hr>
                    <table style="width: 100%" class="tbl">    
                        <tr>
                            <th style="font-weight: bold; text-align: center;">SN</th>
                            <th>Amount</th>
                            <th>Category</th>
                            <th>Responsible Person</th>
                            <th>Note</th> 
                        </tr> 
                        <?php  
                            $sum_of_eamount = 0; 
                            if (!empty($result['expenses']) && isset($result['expenses'])):
                                foreach ($result['expenses'] as $key => $value): 
                                    $sum_of_eamount += $value->amount;  
                                    $key++;
                                    ?>
                                    <tr>
                                        <td style="text-align: center"><?= $key ?></td>
                                        <td><?= $value->amount; ?></td> 
                                        <td><?php echo expenseItemName($value->category_id); ?></td>  
                                        <td><?php echo employeeName($value->employee_id); ?></td>
                                        <td><?= $value->note ?></td>  
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                        ?>
                        <tr>   
                            <td style="font-weight: bold; text-align: right;">Sum</td>  
                            <td>&nbsp;<?= $sum_of_eamount ?></td> 
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    </table> 

                    <hr>
                    <h4 style="font-weight: bold; text-align: center; margin-top: 20px;">Supplier Due Payments</h4>
                    <hr>
                    <table style="width: 100%" class="tbl">    
                        <tr>
                            <th style="font-weight: bold; text-align: center;">SN</th>
                            <th>Amount</th>
                            <th>Supplier</th> 
                            <th>Note</th> 
                        </tr> 
                        <?php  
                            $sum_of_samount = 0; 
                            if (!empty($result['supplier_due_payments']) && isset($result['supplier_due_payments'])):
                                foreach ($result['supplier_due_payments'] as $key => $value): 
                                    $sum_of_samount += $value->amount;  
                                    $key++;
                                    ?>
                                    <tr>
                                        <td style="text-align: center"><?= $key ?></td>
                                        <td><?= $value->amount; ?></td> 
                                        <td><?php echo getSupplierNameById($value->supplier_id); ?></td>
                                        <td><?= $value->note ?></td>  
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                        ?>
                        <tr>   
                            <td style="font-weight: bold; text-align: right;">Sum</td>  
                            <td>&nbsp;<?= $sum_of_samount ?></td> 
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>                            
                        </tr>
                    </table> 

                    <hr>
                    <h4 style="font-weight: bold; text-align: center; margin-top: 20px;">Customer Due Receives</h4>
                    <hr>
                    <table style="width: 100%" class="tbl">    
                        <tr>
                            <th style="font-weight: bold; text-align: center;">SN</th>
                            <th>Amount</th>
                            <th>Customer</th> 
                            <th>Note</th> 
                        </tr> 
                        <?php  
                            $sum_of_camount = 0; 
                            if (!empty($result['customer_due_receives']) && isset($result['customer_due_receives'])):
                                foreach ($result['customer_due_receives'] as $key => $value): 
                                    $sum_of_camount += $value->amount;  
                                    $key++;
                                    ?>
                                    <tr>
                                        <td style="text-align: center"><?= $key ?></td>
                                        <td><?= $value->amount; ?></td> 
                                        <td><?php echo getCustomerName($value->customer_id); ?></td>
                                        <td><?= $value->note ?></td>  
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                        ?>
                        <tr>   
                            <td style="font-weight: bold; text-align: right;">Sum</td>  
                            <td>&nbsp;<?= $sum_of_camount ?></td> 
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    </table> 

                    <hr>
                    <h4 style="font-weight: bold; text-align: center; margin-top: 20px;">Wastes</h4>
                    <hr>
                    <table style="width: 100%" class="tbl">    
                        <tr>
                            <th style="font-weight: bold; text-align: center;">SN</th>
                            <th>Reference No</th>
                            <th>Loss Amount</th> 
                            <th>Responsible Person</th> 
                            <th>Note</th> 
                        </tr> 
                        <?php  
                            $sum_of_wamount = 0; 
                            if (!empty($result['wastes']) && isset($result['wastes'])):
                                foreach ($result['wastes'] as $key => $value): 
                                    $sum_of_wamount += $value->total_loss;  
                                    $key++;
                                    ?>
                                    <tr>
                                        <td style="text-align: center"><?= $key ?></td>
                                        <td><?= $value->reference_no; ?></td> 
                                        <td><?= $value->total_loss; ?></td> 
                                        <td><?php echo employeeName($value->employee_id); ?></td>
                                        <td><?= $value->note ?></td>  
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                        ?>
                        <tr>   
                            <td>&nbsp;</td>
                            <td style="font-weight: bold; text-align: right;">Sum</td>  
                            <td>&nbsp;<?= $sum_of_wamount ?></td> 
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    </table> 
                </div>
                <!-- /.box-body -->
            </div> 
        </div> 
    </div> 
</section>  