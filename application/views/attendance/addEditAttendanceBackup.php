<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<style type="text/css">
    .required_star{
        color: #dd4b39;
    }

    .radio_button_problem{
        margin-bottom: 19px;
    }

    .alert-info{
        background-color: white !important;
        color: #0C5889 !important;
        padding: 3px 3px 3px 15px;
        border: 1px solid #0C5889;
        display: none;
    }
</style>  
<script>  
    $(function () {
        $('#in_time').timepicker({
            timeFormat: 'HH:mm:ss',
            interval: 15,  
            <?php if($encrypted_id == ''){ echo "defaultTime: 'now',"; } ?> 
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });

        $('#out_time').timepicker({
            timeFormat: 'HH:mm:ss',
            interval: 15,  
            <?php if($encrypted_id != ''){ echo "defaultTime: 'now',"; } ?> 
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });

        /*$("#in_time").hide();
        $("#out_time").hide();
        $("#in_time_container").hide();
        $("#out_time_container").hide();         
        $('#employee_id').change(function(){

            var employee_id = $('#employee_id').val();   
            var date = $('#date').val();  

            if (date == '') {
                swal({
                    title: "Alert!",
                    text: "Select date first!",
                    confirmButtonColor: '#b6d6f6' 
                })  
 
                return false;
            } 

            $.ajax({
                type: "GET",
                url: '<?php echo base_url(); ?>Attendance/inOrOut',
                data: {
                    employee_id: employee_id, date: date
                },
                success: function(data){  
                    if (data == 'In') {
                        $("#in_time").show();
                        $("#out_time").hide(); 

                        $("#in_time_container").show();
                        $("#out_time_container").hide(); 

                        $("#in_or_out").val("In");
                    }else{
                        $("#in_time").hide();
                        $("#out_time").show(); 

                        $("#in_time_container").hide();
                        $("#out_time_container").show();   

                        $("#in_or_out").val("Out");                 
                    } 
                }
            });
        })

        // Validate form
        $("#attendance_form").submit(function(){
            var date = $("#date").val();
            var employee_id = $("#employee_id").val();
            var in_time = $("#in_time").val();
            var out_time = $("#out_time").val(); 
 

            if(supplier_id==""){ 
                $("#supplier_id_err_msg").text("The Supplier field is required.");
                $(".supplier_id_err_msg_contnr").show(200);

                error = true;
            } 

            if(date==""){ 
                $("#date_err_msg").text("The Date field is required.");
                $(".date_err_msg_contnr").show(200);

                error = true;
            } 

            if(ingredientCount < 1){ 
                $("#ingredient_id_err_msg").text("At least 1 Ingredient should be selected.");
                $(".ingredient_id_err_msg_contnr").show(200);

                error = true;
            }  
            
            if(paid==""){ 
                $("#paid_err_msg").text("The Paid field is required.");
                $(".paid_err_msg_contnr").show(200);
                error = true;
            }

            $(".countID").each(function () {
                var n = $(this).attr("data-countID");
                var quantity_amount = $.trim($("#quantity_amount_"+n).val());
                if(quantity_amount == '' || isNaN(quantity_amount)){
                    $("#quantity_amount_"+n).css({"border-color":"red"}).show(200).delay(2000,function(){
                        $("#quantity_amount_"+n).css({"border-color":"#d2d6de"});
                    });
                    error = true;
                }
            });

            if(error == true){
                return false;
            } 
        });*/

    })
</script>

<section class="content-header">
    <h1>
        Add/Update Attendance
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
                <?php echo form_open(base_url('Attendance/addEditAttendance/' . $encrypted_id) ); ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Reference No</label>
                                <input tabindex="1" type="text" id="reference_no" readonly name="reference_no" class="form-control" placeholder="Reference No" value="<?php echo $reference_no; ?>">
                            </div>
                            <?php if (form_error('reference_no')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <p><?php echo form_error('reference_no'); ?></p>
                                </div>
                            <?php } ?>
                        </div> 
                        <div class="col-md-4"> 
                            <div class="form-group">
                                <label>Date <span class="required_star">*</span></label>
                                <input tabindex="1" type="text" id="date" readonly name="date" class="form-control" placeholder="Date" value="<?php if($encrypted_id == ''){ echo set_value('date'); }else{ echo $attendance_details->date; }?>">
                            </div>
                            <?php if (form_error('date')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <p><?php echo form_error('date'); ?></p>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Employee <span class="required_star">*</span></label>
                                <select tabindex="3" class="form-control select2" id="employee_id" name="employee_id" style="width: 100%;">
                                    <option value="">Select</option>
                                    <?php foreach ($employees as $value) { ?>

                                        <?php if($encrypted_id == ''){ ?>
                                            <option value="<?php echo $value->id ?>" <?php echo set_select('value_id', $value->id); ?>><?php echo $value->name ."-". $value->designation ."-". $value->phone?></option>
                                        <?php }else{ ?>   
                                            <option value="<?php echo $value->id ?>" 
                                            <?php
                                            if ($attendance_details->employee_id == $value->id) {
                                                echo "selected";
                                            }
                                            ?>>
                                            <?php echo $value->name ."-". $value->designation ."-". $value->phone?> 
                                            </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="alert alert-info"></div>
                            <?php if (form_error('employee_id')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <p><?php echo form_error('employee_id'); ?></p>
                                </div>
                            <?php } ?>
                        </div> 
                    </div> 
                    <div class="row">
                        <div class="col-md-4" id="in_time_container">
                            <div class="form-group"> 
                                <label>In Time <?php if($encrypted_id == ''){ echo '<span class="required_star">*</span>'; } ?></label>
                                <input tabindex="2" type="text" name="in_time" id="in_time" class="form-control" style="width: 100%;" placeholder="In Time" value="<?php if($encrypted_id == ''){ echo set_value('in_time'); }else{ echo $attendance_details->in_time; }?>">
                            </div>
                            <?php if (form_error('in_time')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <p><?php echo form_error('in_time'); ?></p>
                                </div>
                            <?php } ?> 
                        </div>
                        <div class="col-md-4" id="out_time_container">
                            <div class="form-group"> 
                                <label>Out Time <?php if($encrypted_id != ''){ echo '<span class="required_star">*</span>'; } ?></label>
                                <input tabindex="2" type="text" name="out_time" id="out_time" class="form-control" style="width: 100%;" placeholder="Out Time" value="<?php if($encrypted_id == ''){ echo set_value('out_time'); }else{ echo $attendance_details->out_time; }?>">
                            </div>
                            <?php if (form_error('out_time')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <p><?php echo form_error('out_time'); ?></p>
                                </div>
                            <?php } ?> 
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Note</label>
                                <textarea tabindex="5" class="form-control" rows="4" name="note" placeholder="Enter ..."><?php echo $this->input->post('note'); ?></textarea>
                            </div> 
                            <?php if (form_error('note')) { ?>
                                <div class="alert alert-error" style="padding: 5px !important;">
                                    <p><?php echo form_error('note'); ?></p>
                                </div>
                            <?php } ?>  
                        </div> 

                    </div>
                    <!-- /.box-body -->
                </div>  

                <input type="hidden" name="in_or_out" value="">
                
                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
                    <a href="<?php echo base_url() ?>Attendance/attendances"><button type="button" class="btn btn-primary">Back</button></a>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>

