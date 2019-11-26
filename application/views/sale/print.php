<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Invoice No: <?= $info->sale_no ?></title>
        <meta http-equiv="cache-control" content="max-age=0" />
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="expires" content="0" />
        <meta http-equiv="pragma" content="no-cache" />
        <script src="/cdn-cgi/apps/head/Bx0hUCX-YaUCcleOh3fM_NqlPrk.js"></script>
        <link rel="stylesheet" href="theme.css" type="text/css" />
        <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
        <script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="print.css" type="text/css" />
        <style type="text/css" media="all">
            body { color: #000; }
            #wrapper { max-width: 480px; margin: 0 auto; padding-top: 20px; }
            .btn { border-radius: 0; margin-bottom: 5px; }
            .bootbox .modal-footer { border-top: 0; text-align: center; }
            h3 { margin: 5px 0; }
            .order_barcodes img { float: none !important; margin-top: 5px; }
            @media print {
                .no-print { display: none; }
                #wrapper { max-width: 480px; width: 100%; min-width: 250px; margin: 0 auto; }
                .no-border { border: none !important; }
                .border-bottom { border-bottom: 1px solid #ddd !important; }
                table tfoot { display: table-row-group; }
            }
        </style>
    </head>
    <body>
        <div id="wrapper">
            <div id="receiptData">

                <div id="receipt-data">
                    <div class="text-center">
                        <h3><?php echo $this->session->userdata('outlet_name'); ?></h3>
                        <p><?php echo $this->session->userdata('address'); ?>
                            <br>
                            Tel: <?php echo $this->session->userdata('phone'); ?>
                            <br>
                            <?php
                            if ($this->session->userdata['vat_reg_no'] && $this->session->userdata['collect_vat'] == "Yes" ):
                                ?>
                                 <?php
                            echo "VAT Reg: ".$this->session->userdata('vat_reg_no')."<br>";
                            endif;
                            ?>   </p>
                    </div>
                    Order No: <?= $info->sale_no ?><br> 
                    Date: <?= date($this->session->userdata('date_format'), strtotime($info->sale_date)); ?> <?= $info->sale_time ?><br> 
                    Sales Associate: <?php echo $info->full_name; ?><br> 
                    Customer: <?php echo "$info->customer_name"; ?><?= isset($info->table_name) && $info->table_name ? " Table No: " . $info->table_name : '' ?><br>  
                    <table class="table table-condensed">
                        <thead>
                            <tr style="font-weight: bold;">
                                <td style="width: 5%;">SN</td>
                                <td style="width: 40%;">Item</td>
                                <td style="width: 10%;" style="text-align: center;">Qty</td>
                                <td style="width: 10%;" style="text-align: center;">Price</td>
                                <td style="width: 10%;" style="text-align: center;">Discount</td>
                                <td style="width: 20%;" class="text-right">Total</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($details)) {
                                $i = 1;
                                $totalItems = 0;
                                foreach ($details as $row) {
                                    $totalItems+=$row->qty;
                                    ?>
                                    <tr>
                                        <td># <?php echo $i++; ?></td> 
                                        <td>
                                            <?php echo $row->menu_name; ?> <br>
                                            Modifiers: Modifier 1, Modifier 2, Modifier 2
                                        </td>  
                                        <td style="text-align: center;"><?php echo $row->qty; ?> </td>   
                                        <td style="text-align: center;"><?php echo $row->price; ?> </td>  
                                        <td style="text-align: center;"><?php echo $row->discount_amount; ?> </td>  
                                        <td class="text-right"><?php echo $row->total; ?> </td>  
                                    </tr>  
                                <?php }
                            }
                            ?> 
                        </tbody>
                        <tfoot> 
                            <tr>
                                <th colspan="5" style="text-align: right;">Sub Total</th>
                                <th class="text-right"><?php echo $this->session->userdata('currency') . " " . number_format($info->sub_total, 2); ?></th>
                            </tr>
                            <tr>
                                <th colspan="5" style="text-align: right;">Disc Amt:</th>
                                <th class="text-right"><?php echo $this->session->userdata('currency') . " " . $info->disc_actual; ?></th>
                            </tr>
                        <?php
                        if ($this->session->userdata['collect_vat'] == "Yes"):
                            ?>
                            <tr>
                                <th colspan="5" style="text-align: right;">Vat</th>
                                <th class="text-right"><?php echo $this->session->userdata('currency') . " " . number_format($info->vat, 2); ?></th>
                                </tr>
                            <?php
                        endif;
                        ?> 
                        <tr>
                            <th colspan="5" style="text-align: right;">Total Payable</th>
                            <th class="text-right"><?php echo $this->session->userdata('currency') . " " . number_format($info->total_payable, 2); ?></th>
                        </tr>
                            <tr>
                                <th style="text-align: center;" colspan="6">Total Item(s): <?= $totalItems ?></th> 
                            </tr>
                        </tfoot>
                    </table> 
                    <p class="text-center"><?php echo $this->session->userdata('invoice_footer'); ?></p>

                </div>
                <div style="clear:both;"></div>
            </div> 
            
            <div id="buttons" style="padding-top:10px; text-transform:uppercase;" class="no-print">
                <hr>
                <span class="pull-right col-xs-12">
                <button onclick="window.print();" class="btn btn-block btn-primary">Print</button> </span>
                <div style="clear:both;"></div>
                <div class="col-xs-12" style="background:#F5F5F5; padding:10px; color: red;">
                    <p style="font-weight:bold; text-transform: none;">
                        Please follow these steps before you print for first time:
                    </p>
                    <p style="text-transform: capitalize;">
                        1. Disable Header and Footer in browser's print setting<br>
                        For Firefox: File &gt; Page Setup &gt; Margins &amp; Header/Footer &gt; Headers & Footers &gt; Make all --blank--<br>
                        For Chrome: Menu &gt; Print &gt; Uncheck Header/Footer in More Options 
                    </p>  
                </div>
                <div style="clear:both;"></div>
            </div>
        </div>
        <script src="<?php echo base_url(); ?>assets/dist/js/print/jquery-2.0.3.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/dist/js/print/custom.js"></script>
        <script type="text/javascript">
            $(window).load(function () {
                window.print();
                return false;
            });
        </script>
    </body>
</html>
