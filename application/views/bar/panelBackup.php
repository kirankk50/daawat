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
    $notification_list_show .= '<button class="single_serve_b" id="notification_serve_button_'.$single_notification->id.'">Delete</button>';
    $notification_list_show .= '</div>';
    $notification_list_show .= '</div>';
    
}

/************************************************************************************************************************
 * End of Construct notification list ***********************************************************************************
 * **********************************************************************************************************************
 */ 
    $show_all_orders = '';
    if(count($getUnReadyOrders)>0){
        
        foreach($getUnReadyOrders as $singleOrder){
            if($singleOrder->order_type==1){
                $order_type = "Dine In";
                $order_name = "A ".$singleOrder->sale_no;
            }elseif($singleOrder->order_type==2){
                $order_type = "Take Away";
                $order_name = "B ".$singleOrder->sale_no;
            }elseif($singleOrder->order_type==3){
                $order_type = "Delivery";
                $order_name = "C ".$singleOrder->sale_no;
            }
            $to_time = strtotime(date('Y-m-d H:i:s'));
            $from_time = strtotime($singleOrder->date_time);
            $minutes = round(abs($to_time - $from_time) / 60,2);
            $seconds = abs($to_time - $from_time) % 60;
            $width = 100;
            $total_bar_type_items = $singleOrder->total_bar_type_items;
            $total_bar_type_started_cooking_items = $singleOrder->total_bar_type_started_cooking_items;
            $total_bar_type_done_items = $singleOrder->total_bar_type_done_items;
            $selected_unselected = "unselected"; 

            if($total_bar_type_items!=$total_bar_type_done_items){
                $show_all_orders .= '<div class="fix floatleft single_order" data-order-type="'.$order_type.'" data-selected="'.$selected_unselected.'" id="single_order_'.$singleOrder->sale_id.'">';
                    $show_all_orders .= '<div class="header_portion light-blue-background fix">';
                        $show_all_orders .= '<div class="fix floatleft half">';
                            $show_all_orders .= '<p class="order_number">'.$order_name.'</p> ';
                        $show_all_orders .= '</div>';
                        $show_all_orders .= '<div class="fix floatleft half">';
                            $show_all_orders .= '<p class="order_duration dark-blue-background"><span id="bar_time_minute_'.$singleOrder->sale_id.'">'.str_pad(round($minutes), 2, "0", STR_PAD_LEFT).'</span>:<span id="bar_time_second_'.$singleOrder->sale_id.'">'.str_pad(round($seconds), 2, "0", STR_PAD_LEFT).'</span></p>';
                        $show_all_orders .= '</div>';
                    $show_all_orders .= '</div>';
                    $show_all_orders .= '<div class="fix items_holder">';
                    $items = $singleOrder->items;
                    foreach($items as $single_item){
                        $item_background = '';
                        $font_style = '';
                        $cooking_status = '';
                        if($single_item->cooking_status=="Done"){
                            $item_background = "green-background";
                            $font_style = "color:#fff;";
                            $cooking_status = "Done";
                        }else if($single_item->cooking_status=="Started Preparing"){
                            $item_background = "light-blue-background";
                            $font_style = "color:#fff;";
                            $cooking_status = "Preparing";
                        }

                        $show_all_orders .= '<div data-selected="unselected" class="fix single_item '.$item_background.'" data-order-id="'.$singleOrder->sale_id.'" data-item-id="'.$single_item->previous_id.'" id="detail_item_id_'.$single_item->previous_id.'" data-cooking-status="'.$single_item->cooking_status.'">';
                            $show_all_orders .= '<div class="single_item_left_side fix">';
                                $show_all_orders .= '<div class="fix floatleft item_quantity">';
                                    $show_all_orders .= '<p class="item_quanity_text" style="'.$font_style.'">'.$single_item->qty.'</p>';
                                $show_all_orders .= '</div>';
                                $show_all_orders .= '<div class="fix floatleft item_detail">';
                                    $show_all_orders .= '<p class="item_name" style="'.$font_style.'">'.$single_item->menu_name.'</p>';
                                    $show_all_orders .= '<p class="item_qty" style="font-weight:bold; '.$font_style.'">Qty: '.$single_item->qty.'</p>';

                                    $modifiers = $single_item->modifiers;
                                    $modifiers_length = count($modifiers);
                                    $w = 1;
                                    $modifiers_name = '';
                                    foreach($modifiers as $single_modifier){
                                       if($w==$modifiers_length){
                                            $modifiers_name .= $single_modifier->name;
                                       }else{
                                            $modifiers_name .= $single_modifier->name.', ';
                                       }
                                       $w++; 
                                    }
                                    if($modifiers_length>0){
                                        $show_all_orders .= '<p class="modifiers" style="'.$font_style.'">- '.$modifiers_name.'</p>';    
                                    }
                                    if($single_item->menu_note!=""){
                                        $show_all_orders .= '<p class="note" style="'.$font_style.'">- '.$single_item->menu_note.'</p>';    
                                    }
                                $show_all_orders .= '</div>';
                            $show_all_orders .= '</div>';
                            $show_all_orders .= '<div class="single_item_right_side fix">';
                                $show_all_orders .= '<p class="single_item_cooking_status" style="'.$font_style.'">'.$cooking_status.'</p>';
                            $show_all_orders .= '</div>';
                        $show_all_orders .= '</div>';
                    }
                    
                    $show_all_orders .= '</div>';
                    $show_all_orders .= '<div class="single_order_button_holder" id="single_order_button_holder_'.$singleOrder->sale_id.'">';
                        $show_all_orders .= '<button class="select_all_of_an_order" id="select_all_of_an_order_'.$singleOrder->sale_id.'">Select All</button><button class="unselect_all_of_an_order" id="unselect_all_of_an_order_'.$singleOrder->sale_id.'">Unselect All</button><button class="start_cooking_button" id="start_cooking_button_'.$singleOrder->sale_id.'">Prepare</button><button class="done_cooking" id="done_cooking_'.$singleOrder->sale_id.'">Done</button>';    
                    $show_all_orders .= '</div>';
                $show_all_orders .= '</div>';
            }

        }
    }

?>
<!DOCTYPE html>
<!-- saved from url=(0049)http://localhost/iRestora_PLUS/Bar/panel.html -->
<html class="gr__localhost">
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    	<!-- <meta http-equiv="Content-Security-Policy" content="default-src *; style-src 'self' 'unsafe-inline'; script-src 'self' 'unsafe-inline' 'unsafe-eval'"> -->
        <title>Xtra.ml</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bar_panel/css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Yantramanav" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css">
        <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet"> 
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bar_panel/css/sweetalert2.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/select2/dist/css/select2.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>asset/plugins/iCheck/minimal/color-scheme.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="<?php echo base_url()?>assets/bar_panel/js/jquery-3.3.1.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/bar_panel/js/jquery.slimscroll.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/bar_panel/js/sweetalert2.all.min.js"></script>
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
        <span style="display:none" id="refresh_it_or_not">Yes</span>
        <div class="wrapper fix">
            <div class="fix main_top">
                <div class="fix floatleft top_header"><h1>Bar Panel</h1></div>
                <div class="fix floatleft top_menu">
                    
                    <a href="<?php echo base_url(); ?>Authentication/logOut" id="logout_button"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    <button id="help_button"><i class="fas fa-question-circle"></i> Help</button>
                    <button id="notification_button"><i class="fas fa-bell"></i> Notification (<span id="notification_counter"><?php echo $notification_number; ?></span>)</button>
                    <div class="fix top_menu_right" id="group_by_order_item_holder" style="height:37px;float:right; margin: 10px 10px 0px 0px;"></div>
                    <div class="fix top_menu_right" style="float:right; margin: 10px 10px 0px 0px;"><p style="font-size: 18px;line-height: 28px;text-align: right;color:#fff"><i class="fas fa-sync-alt" style="cursor:pointer;" id="refresh_orders_button"></i></p></div>
                </div>
            </div>

            <div class="fix main_bottom">
                <div class="fix order_holder" id="order_holder">
                    <?php echo $show_all_orders ?>                    
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

    <!-- The Notification List Modal -->
    <div id="notification_list_modal" class="modal">

        <!-- Modal content -->
        <div class="modal-content" id="modal_notification_list_details">
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
                <button id="notification_remove_all">Remove</button><button id="notification_close">Close</button>
            </div>
        </div>

    </div>
    <!-- end of notification list modal -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/bar_panel/js/marquee.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/bar_panel/js/datable.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/bar_panel/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/bar_panel/js/custom.js"></script>
    <script type="text/javascript">
            $('.select2').select2();
            
            $.datable();
            $(document).ready(function(){
                
            });
            function searchItems(searchedValue){
                
                var resultObject = search(searchedValue, window.order_items);
                return resultObject;
            }
            function search(nameKey, myArray){
                var foundResult=new Array();
                for (var i=0; i < myArray.length; i++) {
                    if (myArray[i].menu_name.toLowerCase().includes(nameKey.toLowerCase())) {
                        foundResult.push(myArray[i]);
                        
                    }
                }
                return foundResult.sort( function(a, b) {
                  return parseInt(b.sold_for)-parseInt(a.sold_for);
                });
                
            }
        </script>
    </body>
</html>
