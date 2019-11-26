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
<base data-base="<?php echo base_url(); ?>"></base>
<section class="content-header">
    <div class="row">
        <div class="col-md-6">
            <h2 class="top-left-header"><?php echo lang('sale'); ?> </h2>
        </div>
        <div class="col-md-offset-4 col-md-2">
            <a href="<?php echo base_url() ?>Sale/POS"><button type="button" class="btn btn-block btn-primary pull-right"><?php echo lang('add_sale'); ?></button></a>
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
                                <th style="width: 2%;text-align: center"><?php echo lang('sn'); ?></th>
                                <th style="width: 8%"><?php echo lang('ref_no'); ?></th>
                                <th style="width: 8%"><?php echo lang('order_type'); ?></th>
                                <th style="width: 12%"><?php echo lang('date'); ?>(<?php echo lang('time'); ?>)</th>
                                <th style="width: 15%"><?php echo lang('customer'); ?></th>
                                <th style="width: 17%"><?php echo lang('total_payable'); ?></th> 
                                <th style="width:4%"><?php echo lang('payment_method'); ?></th>
                                <th style="width: 10%"><?php echo lang('added_by'); ?></th>  
                                <th style="width: 5%;text-align: center"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($lists && !empty($lists)) {
                                $i = count($lists);
                            }
                            foreach ($lists as $value) {
                                $order_type = "";
                                if($value->order_type=='1'){
                                    $order_type = "Dine In";
                                }elseif($value->order_type=='2'){
                                    $order_type = "Take Away";
                                }elseif($value->order_type=='3'){
                                    $order_type = "Delivery";
                                }
                                ?>                       
                                <tr> 
                                    <td style="text-align: center"><?php echo $i--; ?></td>
                                    <td><?php echo $value->sale_no; ?></td> 
                                    <td><?php echo $order_type; ?></td> 
                                    <td><?= date($this->session->userdata['date_format'], strtotime($value->sale_date)) ?> <?= $value->order_time ?></td>
                                    <td><?php echo $value->customer_name; ?></td> 
                                    <td><?php echo $this->session->userdata('currency').' '.$value->total_payable; ?></td>
                                    <td><?php echo $value->name; ?></td>  
                                    <td><?php echo $value->full_name; ?></td>  
                                    <td style="text-align: center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right" role="menu"> 
                                                <li><a style="cursor: pointer" onclick="viewInvoice(<?= $value->id ?>)"><i class="fa fa-eye tiny-icon"></i><?php echo lang('view_invoice'); ?></a></li>
                                                <li><a style="cursor: pointer" onclick="change_date(<?= $value->id ?>)"><i class="fa fa-calendar tiny-icon"></i><?php echo lang('change_date'); ?></a></li>
                                                <?php if($this->session->userdata('role')=='Admin'){?>
                                                <li><a class="delete" href="<?php echo base_url() ?>Sale/deleteSale/<?php echo $this->custom->encrypt_decrypt($value->id, 'encrypt'); ?>" ><i class="fa fa-trash tiny-icon"></i><?php echo lang('delete'); ?></a></li> 
                                                <?php } ?>
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
                                <th style="width: 5%"><?php echo lang('sn'); ?></th>
                                <th style="width: 8%"><?php echo lang('ref_no'); ?></th>
                                <th style="width: 8%"><?php echo lang('order_type'); ?></th>
                                <th style="width: 10%"><?php echo lang('date'); ?>(<?php echo lang('time'); ?>)</th>
                                <th style="width: 15%"><?php echo lang('customer'); ?></th>
                                <th style="width: 15%"><?php echo lang('total_payable'); ?></th>  
                                <th style="width: 4%"><?php echo lang('payment_method'); ?></th>
                                <th style="width: 10%"><?php echo lang('added_by'); ?></th>  
                                <th style="width: 5%;text-align: center"><?php echo lang('actions'); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->
            </div> 
        </div> 
    </div> 
</section>
<div id="change_date_modal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document" style="width:300px;">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #3c8dbc;">
        <h5 class="modal-title" style="font-size: 20px;text-align: center;color: #ececec;line-height: 20px;"><?php echo lang('change_date'); ?></h5>
      </div>
      <div class="modal-body">
        <input type="hidden" name="sale_id_hidden" id="sale_id_hidden">
        <input name="change_date_sale" id="change_date_sale_modal" style="width: 100%;height: 35px;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="save_change_date"><?php echo lang('save_changes'); ?></button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_change_date_modal"><?php echo lang('close'); ?></button>
      </div>
    </div>
  </div>
</div>
<!-- DataTables -->
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/POS/js/jquery.cookie.js"></script>
<script>
    var base_url = $('base').attr('data-base');
    $(function () { 
        $('#datatable').DataTable({ 
            'autoWidth'   : false,
            'ordering'    : false
        })
    })
    $( "#change_date_sale_modal" ).datepicker({
        dateFormat:'yy-mm-dd',
        changeYear: true,
        changeMonth: true,
        showMonthAfterYear: true, //this is what you are looking for
        maxDate:0
    });

    function  viewInvoice(id) {

        let newWindow = open("print_invoice/"+id, 'Print Invoice', 'width=450,height=550')
        newWindow.focus();

        newWindow.onload = function() {
          newWindow.document.body.insertAdjacentHTML('afterbegin');
        };
        
    }
    function change_date(id) {
        $('#change_date_sale_modal').val('');
        $('#sale_id_hidden').val('');
        $('#sale_id_hidden').val(id);
        $('#change_date_modal').modal('show');
        // $('#myModal').modal('hide');
        // alert(id);
    }
    $('#close_change_date_modal').on('click',function(){
        $('#change_date_sale_modal').val('');
        $('#sale_id_hidden').val('');
    });
    $('#save_change_date').on('click',function(){
        var change_date = $('#change_date_sale_modal').val();
        var sale_id = $('#sale_id_hidden').val();
        $.ajax({
            url:base_url+"Sale/change_date_of_a_sale_ajax",
            method:"POST",
            data:{
                sale_id : sale_id,
                change_date : change_date,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success:function(response) {
                $('#change_date_sale_modal').val('');
                $('#sale_id_hidden').val('');
                $('#change_date_modal').modal('hide');
            },
            error:function(){
                alert("error");
            }
        });
    });
</script>
