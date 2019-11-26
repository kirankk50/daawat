`
<style type="text/css">
    .required_star{
        color: #dd4b39;
    }

    .radio_button_problem{
        margin-bottom: 19px;
    }
</style>  
<section class="content-header">
    <h1>
        SMS Balance
    </h1>  
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">

                <!-- /.box-header -->
                <!-- form start --> 
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12"> 
                            <div class="form-group">
                               <h3>Your current textlocal sms credit balance is <b><?php echo $balance; ?></b>, please check in <a href="https://textlocal.com" target="_blank">TextLocal</a> to know how many sms you can send by this credit.</h3>
                            </div>  
                        </div>    
                    </div> 
                    <!-- /.box-body -->
                </div> 
                <div class="box-footer"> 
                    <a href="<?php echo base_url() ?>Short_message_service/smsService"><button type="button" class="btn btn-primary">Back</button></a>
                </div> 
            </div>
        </div>
    </div>
</section>