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
        <div class="col-md-6">
            <h2 class="top-left-header">Ingredients </h2>
        </div>
        <div class="col-md-offset-2 col-md-4">
            <ul class="list-inline text-right">
                <li><a href="<?php echo base_url() ?>Master/addEditIngredient"><button type="button" class="btn btn-block btn-primary pull-right">Add Ingredient</button></a>
                </li>
                <li><a href="<?php echo base_url() ?>Master/uploadingredients"><button type="button" class="btn btn-block btn-primary pull-right">Upload Ingredient</button></a>
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
                                <th style="width: 1%">SN</th>
                                <th style="width: 6%">Code</th>
                                <th style="width: 22%">Name</th>
                                <th style="width: 16%">Category</th>
                                <th style="width: 12%">Purchase Price</th>
                                <th style="width: 15%">Alert Quantity/Amount</th>
                                <th style="width: 4%">Unit</th>
                                <th style="width: 15%">Added By</th>
                                <th style="width: 6%;text-align: center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($ingredients && !empty($ingredients)) {
                                $i = count($ingredients);
                            }
                            foreach ($ingredients as $ingrnts) {
                                ?>                       
                                <tr> 
                                    <td style="text-align: center"><?php echo $i--; ?></td>
                                    <td><?php echo $ingrnts->code; ?></td> 
                                    <td><?php echo $ingrnts->name; ?></td> 
                                    <td><?php echo categoryName($ingrnts->category_id); ?></td> 
                                    <td> <?php echo $this->session->userdata('currency'); ?> <?php echo $ingrnts->purchase_price; ?></td>
                                    <td><?php echo $ingrnts->alert_quantity; ?></td> 
                                    <td><?php echo unitName($ingrnts->unit_id); ?></td>  
                                    <td><?php echo userName($ingrnts->user_id); ?></td>  
                                    <td style="text-align: center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right" role="menu"> 
                                                <li><a href="<?php echo base_url() ?>Master/addEditIngredient/<?php echo $this->custom->encrypt_decrypt($ingrnts->id, 'encrypt'); ?>" ><i class="fa fa-pencil tiny-icon"></i>Edit</a></li>
                                                <li><a class="delete" href="<?php echo base_url() ?>Master/deleteIngredient/<?php echo $this->custom->encrypt_decrypt($ingrnts->id, 'encrypt'); ?>" ><i class="fa fa-trash tiny-icon"></i>Delete</a></li> 
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
                                <th>SN</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Purchase Price</th>
                                <th>Alert Quantity/Amount</th>
                                <th>Unit</th>
                                <th>Added By</th>  
                                <th style="text-align: center">Actions</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->
            </div> 
        </div> 
    </div> 
</section>
<div class="modal fade" id="uploadingredentsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-2x">×</i></span></button>
                <h4 class="modal-title" id="myModalLabel"><i style="color:#3c8dbc" class="fa fa-plus-square-o"></i> Upload Ingredients</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="<?php echo base_url() ?>Master/ExcelDataAddIngredints" method="post" accept-charset="utf-8">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Upload File<span style="color:red;">  *</span></label>
                        <div class="col-sm-7">
                            <input type="file" class="form-control" name="userfile" id="userfile" placeholder="Upload file" value="">
                            <div class="alert alert-error error-msg customer_err_msg_contnr" style="padding: 5px !important;">
                                <p class="customer_err_msg"></p>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="addNewGuest">
                    <i class="fa fa-save"></i> Upload </button>
                <a class="btn btn-primary" href="<?php echo base_url() ?>Master/downloadPDF/Ingredient_Upload.xlsx">
                    <i class="fa fa-save"></i> Download Sample</a>
            </div>
        </div>
    </div>
</div>
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
