<?php 
$notification_number = 0;
if(count($notifications)>0){
    $notification_number = count($notifications);
}

/************************************************************************************************************************
 * Construct notification list ***********************************************************************************
 * **********************************************************************************************************************
 */
$notification_list_show = '';

foreach ($notifications as $single_notification){
    $notification_list_show .= '<div class="single_row_notification fix" id="single_notification_row_'.$single_notification->id.'">';
    $notification_list_show .= '<div class="fix single_notification_check_box">';
    $notification_list_show .= '<input class="single_notification_checkbox" type="checkbox" id="single_notification_'.$single_notification->id.'" value="'.$single_notification->id.'">';
    $notification_list_show .= '</div>';
    $notification_list_show .= '<div class="fix single_notification">'.$single_notification->notification.'</div>';
    $notification_list_show .= '<div class="fix single_serve_button">';
    $notification_list_show .= '<button class="single_serve_b" id="notification_serve_button_'.$single_notification->id.'">Collect</button>';
    $notification_list_show .= '</div>';
    $notification_list_show .= '</div>';
    
}

/************************************************************************************************************************
 * End of Construct notification list ***********************************************************************************
 * **********************************************************************************************************************
 */


?>
<!DOCTYPE html>
<html>
<head>
	<title>Xtra.ml</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/waiter_panel/css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Yantramanav" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css">
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet"> 
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/waiter_panel/css/sweetalert2.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/plugins/iCheck/minimal/color-scheme.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="<?php echo base_url()?>assets/waiter_panel/js/jquery-3.3.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/waiter_panel/js/jquery.slimscroll.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/waiter_panel/js/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>

    <base data-base="<?php echo base_url(); ?>"></base>
    <base data-collect-vat="<?php echo $this->session->userdata('collect_vat'); ?>"></base>
    <base data-currency="<?php echo $this->session->userdata('currency'); ?>"></base>
    <base data-role="<?php echo $this->session->userdata('role'); ?>"></base>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/x-icon">
    <!-- Favicon -->
    <link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/x-icon">
</head>
<body>
	<span style="display:none" id="selected_order_for_refreshing_help"></span>
	<div class="wrapper fix">
		<div class="top fix">
			<h1 class="main_header">Waiter Panel - <?php echo $this->session->userdata('outlet_name'); ?></h1>  
			<div class="header_button_div">
				<a href="<?php echo base_url(); ?>Authentication/logOut" id="logout_button"><i class="fas fa-sign-out-alt"></i> Logout</a>
				<button id="notification_button"><i class="fas fa-bell"></i> Notification (<span id="notification_counter"><?php echo $notification_number; ?></span>)</button>
			</div>
			
		</div>
		<div class="bottom fix" style="min-height: 400px;">
            <div class="notification_wrapper fix">
                <h1 id="modal_notification_header">Notification List</h1>
                <div id="notification_list_header_holder">
                    <div class="single_row_notification_header fix" style="height: 25px;border-bottom: 2px solid #cfcfcf;">
                        <div class="fix single_notification_check_box">
                            <input type="checkbox" id="select_all_notification">
                        </div>
                        <div class="fix single_notification"><strong>Select All</strong></div>
                        <div class="fix single_serve_button">
                        </div>
                    </div>    
                </div>


                <div id="notification_list_holder" class="fix">
                    
                    <?php echo $notification_list_show;?>
                </div>
                <!-- <span class="close">&times;</span> -->
                <!-- <p>Some text in the Modal..</p> -->
                <div id="notification_close_delete_button_holder">
                    <button id="notification_remove_all">Remove</button><!-- <button id="notification_close">Close</button> -->
                </div>                
            </div>			
		</div>
	</div>	
	
	<!-- The Modal -->
	<div id="help_modal" class="modal">

		<!-- Modal content -->
		<div class="modal-content" id="modal_help_content">
			<p class="cross_button_to_close">&times;</p>
			<!-- <img class="close_button" src="<?php echo base_url();?>assets/images/close_icon.png"> -->
			<h1 class="main_header">Help</h1>
			<p class="help_content">
				You should click on one/multiple item to mark it as Started Preparing or Done. </br>
				You can not select any item for Take Away or Delivery type orders, as you need to deliver these type of orders as a pack Blue color indicates Started Preparing, where green color indicates that the item is Done cooking. <br/> 
				Until an order is closed from POS Panel, that order will remain here
			</p>
		</div>

	</div>
	<!-- end of item modal -->

	


	<script type="text/javascript" src="<?php echo base_url(); ?>assets/waiter_panel/js/marquee.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/waiter_panel/js/custom.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/waiter_panel/js/datable.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/waiter_panel/js/jquery.cookie.js"></script>
</body>
</html>

<!-- 



-->