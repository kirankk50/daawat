<?php 
// echo "<pre>";var_dump($this->session->userdata());echo "</pre>";
$notification_number = 0;
if(count($notifications)>0){
    $notification_number = count($notifications);
}

/*******************************************************************************************************************
 * This secion is to construct menu list****************************************************************************
 *******************************************************************************************************************
 */
$previous_category = 0;
$total_menus = count($food_menus);
$i = 1;
$menu_to_show = "";
$javascript_obects = "";
function cmp($a, $b)
{
    return strcmp($a->category_id, $b->category_id);
}

usort($food_menus, "cmp");
foreach($food_menus as $single_menus){
    //checks that whether its new category or not    
    $is_new_category = false;
    //get current food category
    $current_category = $single_menus->category_id;
    
    //if it the first time of loop then default previous category is 0
    //if it's 0 then set current category id to $previous category and set first category div
    if($previous_category == 0){
        $previous_category = $current_category;    
        $menu_to_show .= '<div id="category_'.$single_menus->category_id.'" class="specific_category_items_holder">';
    }
    //if previous category and current category is not equal. it means it's a new category 
    if($previous_category!=$current_category){
        
        $previous_category = $current_category;
        $is_new_category = true;
    }

    //if category is new and total menus are not finish yet then set exit to previous category and create new category
    //div
    if($is_new_category==true && $total_menus!=$i){
        $menu_to_show .= '</div>';
        $menu_to_show .= '<div id="category_'.$single_menus->category_id.'" class="specific_category_items_holder">';    
    }
    $img_size = @getimagesize(base_url().'assets/POS/images/'.$single_menus->photo);
    if(!empty($img_size) && $single_menus->photo!=""){
        $image_path = base_url().'assets/POS/images/'.$single_menus->photo;
    }else{
        $image_path = base_url().'assets/images/image_thumb.png';
    }

    //construct new single item content
    $menu_to_show .= '<div class="single_item fix" id="item_'.$single_menus->id.'">';
        $menu_to_show .= '<p class="item_price">'.$this->session->userdata('currency').' <span id="price_'.$single_menus->id.'">'.$single_menus->sale_price.'</span></p>';
        $menu_to_show .= '<img src="'.$image_path.'" alt="" width="142">';
        $menu_to_show .= '<p class="item_name">'.$single_menus->name.' ('.$single_menus->code.')</p>';
    $menu_to_show .= '</div>';
    //if its the last content and there is no more category then set exit to last category
    if($is_new_category==false && $total_menus==$i){
        $menu_to_show .= '</div>';
    }

    //checks and hold the status of veg item
    if($single_menus->veg_item=='Veg Yes'){
        $veg_status = "VEG";
    }else{
        $veg_status = "";
    }

    //checks and hold the status of beverage item
    if($single_menus->beverage_item=='Beverage Yes'){
        $soft_status = "BEV";
    }else{
        $soft_status = "";
    }

    //checks and hold the status of bar item
    if($single_menus->bar_item=='Bar Yes'){
        $bar_status = "BAR";
    }else{
        $bar_status = "";
    }
    //get modifiers if menu id match with menu modifiers table
    $modifiers = '';
    $j=1;
    foreach($menu_modifiers as $single_menu_modifier){
        if($single_menu_modifier->food_menu_id==$single_menus->id){
            if($j==count($menu_modifiers)){
                $modifiers .="{menu_modifier_id:'".$single_menu_modifier->modifier_id."',menu_modifier_name:'".$single_menu_modifier->name."',menu_modifier_price:'".$single_menu_modifier->price."'}";    
            }else{
                $modifiers .="{menu_modifier_id:'".$single_menu_modifier->modifier_id."',menu_modifier_name:'".$single_menu_modifier->name."',menu_modifier_price:'".$single_menu_modifier->price."'},";
            }
            
        }
        $j++;
    }
    //this portion construct javascript objects, it is used to search item from search input
    if($total_menus==$i){
        $javascript_obects .= "{item_id:'".$single_menus->id."',item_code:'".$single_menus->code."',category_name:'".$single_menus->category_name."',item_name:'".$single_menus->name."',price:'".$this->session->userdata('currency')." ".$single_menus->sale_price."',image:'".$image_path."',tax_information:'".$single_menus->tax_information."',vat_percentage:'".$single_menus->percentage."',veg_item:'".$veg_status."',beverage_item:'".$soft_status."',bar_item:'".$bar_status."',sold_for:'".$single_menus->item_sold."',modifiers:[".$modifiers."]}";
    }else{
        $javascript_obects .= "{item_id:'".$single_menus->id."',item_code:'".$single_menus->code."',category_name:'".$single_menus->category_name."',item_name:'".$single_menus->name."',price:'".$this->session->userdata('currency')." ".$single_menus->sale_price."',image:'".$image_path."',tax_information:'".$single_menus->tax_information."',vat_percentage:'".$single_menus->percentage."',veg_item:'".$veg_status."',beverage_item:'".$soft_status."',bar_item:'".$bar_status."',sold_for:'".$single_menus->item_sold."',modifiers:[".$modifiers."]},";
    }
    
    //increasing always with the number of loop to check the number of menus
    $i++;    

    
    
}
/*******************************************************************************************************************
 * End of This secion is to construct menu list*********************************************************************
 *******************************************************************************************************************
 */

/*******************************************************************************************************************
 * This secion is to construct category ****************************************************************************
 *******************************************************************************************************************
 */
$i = 1;
$cateogry_slide_to_show = '<button class="category_button" id="button_category_show_all" style="border-left: solid 2px #DEDEDE;">All</button>';
foreach($menu_categories as $single_category){
    
    if($i = 1){
        $cateogry_slide_to_show .= '<button class="category_button" id="button_category_'.$single_category->id.'">'.$single_category->category_name.'</button>';
                               
    }else{
        $cateogry_slide_to_show .= '<button class="category_button" id="button_category_'.$single_category->id.'">'.$single_category->category_name.'</button>';
    }
    
}
/*******************************************************************************************************************
 * End of This secion is to construct category ****************************************************************************
 *******************************************************************************************************************
 */

/********************************************************************************************************************
 * This section is to construct options of customer select input*****************************************************
 * ******************************************************************************************************************
 */
$customers_option = '';
$total_customers = count($customers);
$i = 1;
$customer_objects = '';
foreach ($customers as $customer){
    $selected = '';
    // $selected = ($customer->id=='1' || $customer->name=='Walk-in Customer')?'selected':'';
    if($customer->name=='Walk-in Customer'){
        $customers_option = '<option value="'.$customer->id.'" '.$selected.'>'.$customer->name.' '.$customer->phone.'</option>'.$customers_option;
    }else{
        $customers_option .= '<option value="'.$customer->id.'" '.$selected.'>'.$customer->name.' '.$customer->phone.'</option>';    
    }
    

    if($total_customers==$i){
        $customer_objects .= "{customer_id:'".$customer->id."',customer_name:'".$customer->name."',customer_address:'".$customer->address."',gst_number:'".$customer->gst_number."'}";
    }else{
        $customer_objects .= "{customer_id:'".$customer->id."',customer_name:'".$customer->name."',customer_address:'".$customer->address."',gst_number:'".$customer->gst_number."'},";
    }

    $i++;
}

/********************************************************************************************************************
 * This section is to construct options of customer select input*****************************************************
 * ******************************************************************************************************************
 */

/********************************************************************************************************************
 * This section is to construct options of customer select input*****************************************************
 * ******************************************************************************************************************
 */
$waiters_option = '';

foreach ($waiters as $waiter){
    if($waiter->full_name=='Default Waiter'){
        $waiters_option = '<option value="'.$waiter->id.'">'.$waiter->full_name.'</option>'.$waiters_option;
    }else{
        $waiters_option .= '<option value="'.$waiter->id.'">'.$waiter->full_name.'</option>';
    }
    
}

/********************************************************************************************************************
 * This section is to construct options of customer select input*****************************************************
 * ******************************************************************************************************************
 */

/********************************************************************************************************************
 * This section is to construct table modal's content****************************************************************
 ********************************************************************************************************************
 */
$tables_modal = '';
foreach($tables as $table){
    $tables_modal .= '<div class="floatleft fix single_order_table" id="single_table_info_holder_'.$table->id.'">';
        $tables_modal .= '<p class="table_name" style="font-weight:bold;"><span id="sit_name_'.$table->id.'">'.$table->name.'<span></p>';
        $tables_modal .= '<p class="table_sit_capacity">Sit Capacity: <span id="sit_capacity_number_'.$table->id.'">'.$table->sit_capacity.'<span></p>';
        $tables_modal .= '<p class="table_available">Available: <span id="sit_available_number_'.$table->id.'">'.$table->sit_capacity.'</span></p>';
        $tables_modal .= '<img class="table_image" src="'.base_url().'assets/images/table_icon2.png" alt="">';
        $tables_modal .= '<p class="running_order_in_table">Running orders in table</p>';
        $tables_modal .= '<div class="single_table_order_details_holder fix" id="single_table_order_details_holder_'.$table->id.'">';
            $tables_modal .= '<div class="top fix" id="single_table_order_details_top_'.$table->id.'">';
                $tables_modal .= '<div class="single_row header fix">';
                    $tables_modal .= '<div class="floatleft fix column first_column">Ord.</div>';
                    $tables_modal .= '<div class="floatleft fix column second_column">Time</div>';
                    $tables_modal .= '<div class="floatleft fix column third_column">Person</div>';
                    $tables_modal .= '<div class="floatleft fix column forth_column">Del</div>';
                $tables_modal .= '</div>';
                if(count($table->orders_table)>0){
                    foreach($table->orders_table as $single_order_table){
                        $tables_modal .= '<div class="single_row fix">';
                            $tables_modal .= '<div class="floatleft fix column first_column">'.$single_order_table->sale_id.'</div>';
                            $tables_modal .= '<div class="floatleft fix column second_column">'.$single_order_table->booking_time.'</div>';
                            $tables_modal .= '<div class="floatleft fix column third_column">'.$single_order_table->persons.'</div>';
                            $tables_modal .= '<div class="floatleft fix column forth_column"><i class="fas fa-trash-alt remove_table_order" id="remove_table_order_'.$single_order_table->id.'"></i></div>';
                        $tables_modal .= '</div>';
                    }
                        
                }
                
            $tables_modal .= '</div>';
            $tables_modal .= '<div class="bottom fix" id="single_table_order_details_bottom_'.$table->id.'">';
                $tables_modal .= '<input type="text" name="" placeholder="Order" class="floatleft bottom_order"  id="single_table_order_details_bottom_order_'.$table->id.'" readonly>';
                $tables_modal .= '<input type="text" name="" placeholder="Person" class="floatleft bottom_person" id="single_table_order_details_bottom_person_'.$table->id.'">';
                $tables_modal .= '<button class="floatleft bottom_add" id="single_table_order_details_bottom_add_'.$table->id.'">Add</button>';
            $tables_modal .= '</div>';
        $tables_modal .= '</div>';
    $tables_modal .= '</div>';





    // $tables_modal .= '<div class="single_table_holder" id="singler_table_holder_'.$table->id.'">';
    //     $tables_modal .= '<div class="single_table_div" id="single_table_'.$table->id.'" data-table-checked="unchecked">';
    //         $tables_modal .= '<p class="busy_content">Busy</p>';
    //         $tables_modal .= '<img src="'.base_url().'assets/images/table_icon.png" alt="">';
    //         $tables_modal .= '<div class="table_info">';
    //             $tables_modal .= '<p>Table Name: '.$table->name.'</p>';
    //             $tables_modal .= '<p>Seat Capacity: '.$table->sit_capacity.'</p>';
    //             $tables_modal .= '<p>Position: '.$table->position.'</p>';
    //         $tables_modal .= '</div>';
    //     $tables_modal .= '</div>';
    //     $tables_modal .= '<p class="booked_for"><span class="hour" id="booked_for_hour_'.$table->id.'">00</span>:<span class="minute" id="booked_for_minute_'.$table->id.'">00</span>:<span class="second" id="booked_for_second_'.$table->id.'">00</span></p>';                    
    //     $tables_modal .= '<button class="modify_order_table_modal" id="modify_order_tb_mo_'.$table->id.'">Change Order</button>';                    
    // $tables_modal .= '</div>';                    
}
/********************************************************************************************************************
 * End This section is to construct table modal's content****************************************************************
 ********************************************************************************************************************
 **/
$order_list_left = '';
$i = 1;
foreach($new_orders as $single_new_order){
    $width = 100;
    $total_kitchen_type_items = $single_new_order->total_kitchen_type_items;
    $total_kitchen_type_started_cooking_items = $single_new_order->total_kitchen_type_started_cooking_items;
    $total_kitchen_type_done_items = $single_new_order->total_kitchen_type_done_items;
    if($total_kitchen_type_items==0){
        $total_kitchen_type_items = 1;  
    }
    $splitted_width = round($width/$total_kitchen_type_items,2);
    $percentage_for_started_cooking = round($splitted_width*$total_kitchen_type_started_cooking_items,2);
    $percentage_for_done_cooking = round($splitted_width*$total_kitchen_type_done_items,2);
    if($i==1){
        $order_list_left .= '<div data-started-cooking="'.$total_kitchen_type_started_cooking_items.'" data-done-cooking="'.$total_kitchen_type_done_items.'" class="single_order fix" style="margin-top:0px" data-selected="unselected" id="order_'.$single_new_order->sales_id.'">';    
    }else{
        $order_list_left .= '<div data-started-cooking="'.$total_kitchen_type_started_cooking_items.'" data-done-cooking="'.$total_kitchen_type_done_items.'" class="single_order fix" data-selected="unselected" id="order_'.$single_new_order->sales_id.'">';   
    }
    $order_list_left .='<div class="inside_single_order_container fix">';
    // $order_list_left .='<div class="background_order_started" style="width:'.$percentage_for_started_cooking.'%"></div>';
    // $order_list_left .='<div class="background_order_done" style="width:'.$percentage_for_done_cooking.'%"></div>';
    $order_list_left .='<div class="single_order_content_holder_inside fix">';
    $order_name = '';
    if($single_new_order->order_type=='1'){
        $order_name = 'A '.$single_new_order->sale_no;
    }else if($single_new_order->order_type=='2'){
        $order_name = 'B '.$single_new_order->sale_no;
    }else if($single_new_order->order_type=='3'){
        $order_name = 'C '.$single_new_order->sale_no;
    }
    
    $minutes = $single_new_order->minute_difference;
    $seconds = $single_new_order->second_difference;
    $tables_booked = '';
    if(count($single_new_order->tables_booked)>0){
        $w = 1;
        foreach($single_new_order->tables_booked as $single_table_booked){
            if($w == count($single_new_order->tables_booked)){
                $tables_booked .= $single_table_booked->table_name;
            }else{
                $tables_booked .= $single_table_booked->table_name.', ';
            }
            $w++;
        }    
    }else{
        $tables_booked = 'None';
    }
    
    $order_list_left .= '<span id="open_orders_order_status_'.$single_new_order->sales_id.'" style="display:none;">'.$single_new_order->order_status.'</span><p style="font-size: 16px;text-align: left;width: 125px;float: left;">Order: <span class="running_order_order_number">'.$order_name.'</span></p><img src="'.base_url().'assets/images/right-arrow.png" style="float: right;width: 13px;margin: 2px;transition: .25s ease-out;" class="running_order_right_arrow" id="running_order_right_arrow_'.$single_new_order->sales_id.'">';
    $order_list_left .= '<p>'.lang('table').': <span class="running_order_table_name">'.$tables_booked.'</span></p>';
    $order_list_left .= '<p>'.lang('waiter').': <span class="running_order_waiter_name">'.$single_new_order->waiter_name.'</span></p>';
    $order_list_left .= '<p>'.lang('customer').': <span class="running_order_customer_name">'.$single_new_order->customer_name.'</span></p>';
    $order_list_left .= '</div>';
    $order_list_left .= '<div class="order_condition">';
    $order_list_left .= '<p class="order_on_processing">'.lang('started_cooking').': '.$total_kitchen_type_started_cooking_items.'/'.$total_kitchen_type_items.'</p>';
    $order_list_left .= '<p class="order_done">'.lang('done').': '.$total_kitchen_type_done_items.'/'.$total_kitchen_type_items.'</p>';
    $order_list_left .= '</div>';
    $order_list_left .= '<div class="order_condition">';
    $order_list_left .= '<p style="font-size:16px;">'.lang('time_count').': <span id="order_minute_count_'.$single_new_order->sales_id.'">'.str_pad(round($minutes), 2, "0", STR_PAD_LEFT).'</span>:<span id="order_second_count_'.$single_new_order->sales_id.'">'.str_pad(round($seconds), 2, "0", STR_PAD_LEFT).'</span> M</p>';
    $order_list_left .= '</div>';
    $order_list_left .= '</div>';
    $order_list_left .= '</div>';
    $i++;
}
/************************************************************************************************************************
 * Construct new orders those are still on processing *******************************************************************
 * **********************************************************************************************************************
 */


/************************************************************************************************************************
 * Construct payment method drop down ***********************************************************************************
 * **********************************************************************************************************************
 */
$payment_method_options = '';

foreach ($payment_methods as $payment_method){
    $payment_method_options .= '<option value="'.$payment_method->id.'">'.$payment_method->name.'</option>';
}

/************************************************************************************************************************
 * End of Construct payment method drop down ***********************************************************************************
 * **********************************************************************************************************************
 */


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
    $notification_list_show .= '<button class="single_serve_b" id="notification_serve_button_'.$single_notification->id.'">'.lang('serve_take_delivery').'</button>';
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
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/POS/css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Yantramanav" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/POS/css/font_awesome_all.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/POS/css/sweetalert2.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/select2/dist/css/select2.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>asset/plugins/iCheck/minimal/color-scheme.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/POS/css/jquery-ui.css">
        <script src="<?php echo base_url()?>assets/POS/js/jquery-3.3.1.min.js"></script>
        <script src="<?php echo base_url()?>assets/POS/js/jquery-ui.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/POS/js/jquery.slimscroll.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/POS/js/sweetalert2.all.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/POS/js/calculator.js"></script>
        <script type="text/javascript">
            var warning="<?php echo lang('alert'); ?>";
            var a_error="<?php echo lang('error'); ?>";
            var ok="<?php echo lang('ok'); ?>";
            //alert(warning)
            var cancel="<?php echo lang('cancel'); ?>";
            var please_select_order_to_proceed="<?php echo lang('please_select_order_to_proceed'); ?>";
            var exceeciding_seat="<?php echo lang('exceeding_sit'); ?>";
            var seat_greater_than_zero="<?php echo lang('seat_greater_than_zero'); ?>";
            var are_you_sure_cancel_booking="<?php echo lang('are_you_sure_cancel_booking'); ?>";
            var are_you_delete_notification="<?php echo lang('are_you_delete_notification'); ?>";
            var no_notification_select="<?php echo lang('no_notification_select'); ?>";
            var are_you_delete_all_hold_sale="<?php echo lang('are_you_delete_all_hold_sale'); ?>";
            var no_hold="<?php echo lang('no_hold'); ?>";
            var sure_delete_this_hold="<?php echo lang('sure_delete_this_hold'); ?>";
            var please_select_hold_sale="<?php echo lang('please_select_hold_sale'); ?>";
            var delete_only_for_admin="<?php echo lang('delete_only_for_admin'); ?>";
            var sure_delete_this_order="<?php echo lang('sure_delete_this_order'); ?>";
            var sure_cancel_this_order="<?php echo lang('sure_cancel_this_order'); ?>";
            var please_select_an_order="<?php echo lang('please_select_an_order'); ?>";
            var cart_not_empty="<?php echo lang('cart_not_empty'); ?>";
            var cart_not_empty_want_to_clear="<?php echo lang('cart_not_empty_want_to_clear'); ?>";
            var progress_or_done_kitchen="<?php echo lang('progress_or_done_kitchen'); ?>";
            var order_in_progress_or_done="<?php echo lang('order_in_progress_or_done'); ?>";
            var close_order_without="<?php echo lang('close_order_without'); ?>";
            var want_to_close_order="<?php echo lang('want_to_close_order'); ?>";
            var please_select_open_order="<?php echo lang('please_select_open_order'); ?>";
            var cart_empty="<?php echo lang('cart_empty'); ?>";
            var select_a_customer="<?php echo lang('select_a_customer'); ?>";
            var select_a_waiter="<?php echo lang('select_a_waiter'); ?>";
            var delivery_not_possible_walk_in="<?php echo lang('delivery_not_possible_walk_in'); ?>";
            var delivery_for_customer_must_address="<?php echo lang('delivery_for_customer_must_address'); ?>";
            var select_dine_take_delivery="<?php echo lang('select_dine_take_delivery'); ?>";
            var added_running_order="<?php echo lang('added_running_order'); ?>";
            
            
        </script>

        <base data-base="<?php echo base_url(); ?>"></base>
        <!-- <base data-collect-vat="<?php echo $this->session->userdata('collect_vat'); ?>"></base> -->
        <base data-collect-tax="<?php echo $this->session->userdata('collect_tax'); ?>"></base>
        <base data-currency="<?php echo $this->session->userdata('currency'); ?>"></base>
        <base data-role="<?php echo $this->session->userdata('role'); ?>"></base>
        <base data-collect-gst="<?php echo $this->session->userdata('tax_is_gst'); ?>"></base>
        <base data-gst-state-code="<?php echo $this->session->userdata('gst_state_code'); ?>"></base>

        <!-- Favicon -->
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/x-icon">
        <!-- Favicon -->
        <link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/x-icon">
    </head>
    <body>
        <span id="stop_refresh_for_search" style="display:none;"><?php echo lang('yes'); ?></span>
        <div class="wrapper fix">
            <div class="top_header_part fix">
                <div class="header_part_left_left fix">
                    <div class="fix outlet_holder">
                        <div class="fix outlet_holder_moving">
                            <p class="marquee"><?php echo $this->session->userdata('outlet_name');?></p>
                        </div>
                    </div>                 
                </div>
                <div class="header_part_left fix">
                    <button id="open_hold_sales" style="padding:0px 10px;"><i class="fas fa-folder-open"></i> <?php echo lang('open_hold_sale'); ?></button>
                    <?php $language=$this->session->userdata('language'); ?>
                    <form action="<?php echo base_url(); ?>Authentication/setlanguage" method="POST" style="display: inline-block;width: 20%;">
                                <select tabindex="2" class="form-control select2" name="language" style="width: 100%;" onchange='this.form.submit()'> 
                                    <option value="english" 
                                    <?php if(isset($language)){
                                    if ($language == 'english') 
                                        echo "selected";
                                    }  
                                    ?>>English</option>
                                    <option value="spanish" 
                                    <?php if(isset($language)){
                                    if ($language == 'spanish') 
                                        echo "selected";
                                    }  
                                    ?>>Spanish</option> 
                                    <<option value="french" 
                                    <?php if(isset($language)){
                                    if ($language == 'french') 
                                        echo "selected";
                                    }
                                    ?>>French</option>
                                    <option value="arabic"
                                    <?php if(isset($language)){
                                    if ($language == 'arabic') 
                                        echo "selected";
                                    } 
                                    ?>>Arabic</option>  
                                </select>
                            </form>
                    <button id="help_button" style="padding:0px 10px;background-color: #dc3545 !important; color: white;"><i class="fas fa-question-circle"></i> <?php echo lang('read_before_begin'); ?></button>
                    <button id="calculator_button" style="margin-right: 3px;padding:0px 10px"><i class="fas fa-calculator"></i> <?php echo lang('calculator'); ?></button>
                    <!-- <button id="kitchen_waiter_bar_button" style="    padding: 0px 10px;margin: 0px;"><i class="fas fa-directions"></i> <?php echo lang('kitchen_waiter_bar'); ?></button> -->
                    
                    <!-- <button id="keyboard_shortcuts_button"><i class="fas fa-keyboard"></i> Keyboard Shortcuts</button> -->
                </div>
                <div class="header_part_right fix">
                    <div class="header_single_button_holder" style="width:19%">
                        <button style="float:left;" id="last_ten_sales_button"><i class="fas fa-history"></i> <?php echo lang('last_ten_sales'); ?></button>
                    </div>
                    <div style="text-align:center;width:28%" class="header_single_button_holder">
                        <button id="notification_button"><i class="fas fa-bell"></i> <?php echo lang('kitchen_notification'); ?> (<span id="notification_counter"><?php echo $notification_number; ?></span>)</button>
                    </div>
                    <div class="header_single_button_holder" style="width:20%;">
                        <a href="#" id="register_close"><button style="float:right;"><i class="fas fa-times"></i> <?php echo lang('register'); ?></button></a>
                    </div> 
                    <div class="header_single_button_holder" style="width:17%;">
                        <a href="#" id="go_to_dashboard"><button style="float:right;"><i class="fas fa-caret-square-left"></i> <?php echo lang('back'); ?></button></a>
                    </div>
                    <div class="header_single_button_holder" style="width:15.8%">
                        <a href="<?php echo base_url(); ?>Authentication/logOut"><button style="float:right;"><i class="fas fa-sign-out-alt"></i> <?php echo lang('logout'); ?></button></a>
                    </div>

                </div>
            </div>
            <div id="main_part fix">
                <div class="main_left fix">
                    <div class="holder fix">
                        <div id="running_order_header">
                            <h3><?php echo lang('running_order'); ?></h3>
                            <span id="refresh_order"><i class="fas fa-sync-alt"></i></span>   
                            <input type="text" name="search_running_orders" id="search_running_orders" style="height: 15px;    margin: 0px 0px 0px 5px;width: 90%;" placeholder="<?php echo lang('customer_waiter_order_table'); ?>" /> 
                        </div>
                        
                        <div class="order_details fix" id="order_details_holder">
                            <?php echo $order_list_left; ?>
                        </div>
                        <div style="position: absolute;bottom: 5px;width:100%;" id="left_side_button_holder_absolute">
                            <?php if($this->session->userdata('pre_or_post_payment') == "Post Payment"){?>
                                <button class="operation_button fix" id="modify_order"><i class="fas fa-edit"></i> <?php echo lang('modify_order'); ?></button>
                            <?php } ?>
                            <button class="operation_button fix" id="single_order_details"><i class="fas fa-info-circle"></i> <?php echo lang('order_details'); ?></button>
                            <button class="operation_button fix" id="print_kot"><i class="fas fa-print"></i> <?php echo lang('print_kot'); ?></button>
                            
                            <?php if($this->session->userdata('pre_or_post_payment') == "Post Payment"){?>
                                <button class="operation_button fix" id="create_invoice_and_close"><i class="fas fa-file-invoice"></i> <?php echo lang('create_invoice_close'); ?></button>
                            <?php } ?>

                            <?php if($this->session->userdata('pre_or_post_payment') == "Pre Payment"){?>
                                <button class="operation_button fix" id="print_invoice"><i class="fas fa-file-invoice"></i> <?php echo lang('create_invoice'); ?></button>
                                <button class="operation_button fix" id="close_order_button"><i class="fas fa-times-circle"></i> <?php echo lang('close_order'); ?></button>
                            <?php } ?>

                            <?php if($this->session->userdata('pre_or_post_payment') == "Post Payment"){?>
                                <button class="operation_button fix" id="cancel_order_button"><i class="fas fa-ban"></i> <?php echo lang('cancel_order'); ?></button>
                            <?php } ?>

                            <button class="operation_button fix" id="kitchen_status_button"><i class="fas fa-spinner"></i> <?php echo lang('kitchen_status'); ?></button>	
                        </div>

                    </div>
                </div>
                <div class="main_middle fix">
                    <div class="main_top fix">
                        <div class="button_holder fix">
                            <div class="single_button_middle_holder fix">
                                <button data-selected="unselected" style="float:left;margin-left:2px;" id="dine_in_button"><i class="fas fa-table"></i> <?php echo lang('dine'); ?></button>
                            </div>
                            <div style="text-align:center;" class="single_button_middle_holder fix">
                                <button id="take_away_button"><i class="fas fa-shopping-bag"></i> <?php echo lang('take_away'); ?></button>
                            </div>
                            <div class="single_button_middle_holder fix">
                                <button data-selected="unselected" style="float:right;margin-right:2px;" id="delivery_button"><i class="fas fa-truck"></i> <?php echo lang('delivery'); ?></button>
                            </div>

                        </div>
                        <div class="waiter_customer">
                            <div class="single_button_middle_holder" style="padding-left:.4%;width:32.9%">

                                <select style="width:92%;margin-left:2px;" id="select_waiter" class="select2">
                                    <option value=""><?php echo lang('waiter'); ?></option>
                                    <?php echo $waiters_option; ?>
                                </select>
                            </div>
                            <div class="single_button_middle_holder">
                                <div style="width:92%;margin:0 auto;">
                                    <select id="walk_in_customer" id="select_walk_in_customer" class="select2">
                                        <option value=""><?php echo lang('customer'); ?></option>
                                        <?php echo $customers_option; ?>      
                                    </select>	
                                    <i class="fas fa-pencil-alt" id="edit_customer" style="cursor:pointer;"></i>
                                    <button id="plus_button"><i class="fas fa-plus-square"></i></button>
                                </div>


                            </div>
                            <div class="single_button_middle_holder">
                                <button id="table_button"><i class="fas fa-table"></i> <?php echo lang('table'); ?></button>
                            </div>
                        </div>
                        <!-- <select>
                                <option>Table</option>
                        </select> -->

                    </div>
                    
                        <div class="main_center fix">
                            <div class="order_table_holder fix">
                                <div class="order_table_header_row fix">
                                    <div class="single_header_column fix" id="single_order_item"><?php echo lang('item'); ?></div>
                                    <div class="single_header_column fix" id="single_order_price"><?php echo lang('price'); ?></div>
                                    <div class="single_header_column fix" id="single_order_qty"><?php echo lang('qty'); ?></div>
                                    <div class="single_header_column fix" id="single_order_discount"><?php echo lang('discount'); ?></div>
                                    <div class="single_header_column" id="single_order_total"><?php echo lang('total'); ?></div>
                                </div>
                                <div class="order_holder fix">
                                    
                                </div>
                            </div>
                            
                        </div>
                    <div style="position: absolute;bottom: 1px;width: 100%" id="bottom_absolute">
                        
                        <table cellspacing="0" cellpadding="0">
                                <tr style="background-color: #ffffff">
                                    <th style="width:50%;text-align:left;padding-left:10px">&nbsp;</th>
                                    <th style="width:10%;">&nbsp;</th>
                                    <th style="width:15%;">&nbsp;</th>
                                    <th style="width:10%;">&nbsp;</th>
                                    <th style="width:15%;text-align:right;padding-right:10px;">&nbsp;</th>
                                </tr>
                                <tr style="background-color:#F5F5F5;">
                                    <td style="padding-left:10px;font-weight:bold;text-align:left;"><?php echo lang('total_item'); ?>: <span id="total_items_in_cart_with_quantity">0</span> <span id="total_items_in_cart" style="display: none;">0</span></td>
                                    <td style="font-weight:bold;text-align:right;" colspan="3"><?php echo lang('sub_total'); ?></td>
                                    <td style="font-weight:bold;text-align:right;padding-right:10px;"><?php echo $this->session->userdata('currency'); ?> <span id="sub_total_show">0.00</span><span id="sub_total" style="display:none;">0.00</span>
                                        <span id="total_item_discount" style="display:none">0</span><span id="discounted_sub_total_amount" style="display:none;">0.00</span></td>
                                </tr>
                                <tr style="background-color:#F5F5F5;">
                                    <td></td>
                                    <td style="font-weight:bold;text-align:right;" colspan="3"><?php echo lang('discount'); ?></td>
                                    <td style="text-align:right;padding-right:10px;"><input type="text" name="" class="special_textbox" placeholder="Amt or %" id="sub_total_discount"/><span style="display:none" id="sub_total_discount_amount"></span></td>
                                </tr>
                                <tr style="background-color:#F5F5F5;">
                                    <!-- <td></td>
                                    <td style="font-weight:bold;text-align:right;" colspan="3">VAT</td>
                                    <td style="font-weight:bold;text-align:right;padding-right:10px;"><?php echo $this->session->userdata('currency'); ?> <span id="all_items_vat">0.00</span></td> -->
                                    <td style="font-weight:bold;text-align:right;padding-right:10px;" colspan="5"><span id="all_items_vat" style="display: block;overflow: auto;height: 35px;"></span></td>
                                </tr>
                                <tr style="background-color:#F5F5F5;">
                                    <td></td>
                                    <td style="font-weight:bold;text-align:right;" colspan="3"><?php echo lang('total_discount'); ?></td>
                                    <td style="font-weight:bold;text-align:right;padding-right:10px;"><?php echo $this->session->userdata('currency'); ?> <span id="all_items_discount">0.00</span></td>
                                </tr>
                                <tr style="background-color:#F5F5F5;">
                                    <td></td>
                                    <td style="font-weight:bold;text-align:right;" colspan="3"><?php echo lang('delivery_charge'); ?></td>
                                    <td style="text-align:right;padding-right:10px;"><input type="" name=""  class="special_textbox" placeholder="Amt" id="delivery_charge"/></td>
                                </tr>
                                <tr style="background-color: #D5E5F5;height: 35px;">
                                    <td></td>
                                    <td style="font-weight:bold;text-align:right;" colspan="3"><?php echo lang('total_payable'); ?></td>
                                    <td style="font-weight:bold;text-align:right;padding-right:10px;"><?php echo $this->session->userdata('currency'); ?> <span id="total_payable">0.00</span></td>
                                </tr>
                            </table>
                        <div class="main_bottom fix" style="padding-top:2px;">
                            <div class="button_group fix">
                                <div class="single_button_middle_holder cart_bottom_buttons" style="width:17%;">
                                    <button style="float:left;padding:0px 3px;" id="cancel_button"><i class="fas fa-times"></i> <?php echo lang('cancel'); ?></button>
                                </div>
                                <div style="text-align:center;width:20%;" class="single_button_middle_holder cart_bottom_buttons">
                                    <button id="hold_sale" style="padding:0px 3px;"><i class="fas fa-hand-rock"></i></i> <?php echo lang('hold'); ?></button>
                                </div>
                                <div class="single_button_middle_holder cart_bottom_buttons" style="width:28%;">
                                    <button style="float:right;margin-right:2px;padding:0px 3px;" id="direct_invoice"><i class="fas fa-file-invoice"></i> <span id="place_edit_order_direct_invoice"><?php echo lang('direct_invoice'); ?></span></button>
                                </div>
                                <div class="single_button_middle_holder cart_bottom_buttons" style="width:34%;">
                                    <button style="float:right;margin-right:2px;padding:0px 3px;" id="place_order_operation"><i class="fas fa-utensils"></i> <span id="place_edit_order"><?php echo lang('place_order'); ?></span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main_right fix">
                    <input type="text" name="search" id="search" placeholder="<?php echo lang('name_code_cat_veg_bev_bar'); ?>" />
                    <div class="select_category fix">
                        <button class="category_next_prev" id="previous_category"><i class="fas fa-angle-left"></i></i></button>
                        <div class="select_category_inside">
                            <div class="select_category_inside_inside">
                                <?php echo $cateogry_slide_to_show; ?>
                            </div>

                        </div>
                        <button class="category_next_prev" id="next_category"><i class="fas fa-angle-right"></i></button>
                    </div>
                    <div style="position:relative;" id="main_item_holder">
                        <div style="position:absolute;bottom:0px;width:100%" id="secondary_item_holder">
                            <div class="category_items fix">
                                <?php echo $menu_to_show; ?>

                            </div>    
                        </div>    
                    </div>
                    
                    
                </div>
            </div>
        </div>
        

        <!-- The Modal -->
        <div id="item_modal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <span id="modal_item_row" style="display:none">0</span>
                <span id="modal_item_id" style="display:none"></span>
                <span id="modal_item_price" style="display:none"></span>
                <span id="modal_item_vat_percentage" style="display:none"></span>
                <h1 id="modal_item_name"><?php echo lang('item_name'); ?></h1>
                <div class="section1 fix">
                    <div class="sec1_inside" id="sec1_1"><?php echo lang('quantity'); ?></div>
                    <div class="sec1_inside" id="sec1_2"><i class="fas fa-minus-circle" id="decrease_item_modal"></i> <span id="item_quantity_modal">1</span> <i class="fas fa-plus-circle" id="increase_item_modal"></i></div>
                    <div class="sec1_inside" id="sec1_3"><?php echo $this->session->userdata('currency'); ?> <span id="modal_item_price_variable" style="display:none;">0</span><span id="modal_item_price_variable_without_discount">0</span><span id="modal_discount_amount" style="display:none;">0</span></div>
                </div>
                <div class="section2 fix"> 
                    <div class="sec2_inside" id="sec2_1">Modifiers</div>
                    <div class="sec2_inside" id="sec2_2"><?php echo $this->session->userdata('currency'); ?> <span id="modal_modifier_price_variable">0</span><span id="modal_modifiers_unit_price_variable" style="display: none;">0</span></div>
                </div>
                <div class="section3 fix">
                    <div class="modal_modifiers">
                        <p><?php echo lang('cool_haus_1'); ?></p>
                    </div>
                    <div class="modal_modifiers">
                        <p><?php echo lang('first_scoo_1'); ?></p>
                    </div>
                    <div class="modal_modifiers">
                        <p><?php echo lang('mg_1'); ?></p>
                    </div>
                    <div class="modal_modifiers">
                        <p><?php echo lang('modifier_1'); ?></p>
                    </div>
                    <div class="modal_modifiers">
                        <p><?php echo lang('cool_haus_1'); ?></p>
                    </div>
                    <div class="modal_modifiers">
                        <p><?php echo lang('first_scoo_2'); ?></p>
                    </div>
                    <div class="modal_modifiers">
                        <p><?php echo lang('mg-2'); ?></p>
                    </div>
                    <div class="modal_modifiers">
                        <p><?php echo lang('modifier_1'); ?></p>
                    </div>
                </div>
                <div id="modal_discount_section"><p style="float: left;margin: 0px 0px 0px 2px;font-size: 19px;">Discount</p><input type="text" name="" id="modal_discount" placeholder="Amt or %"/></div>
                <div class="section4 fix">Total&nbsp;&nbsp;&nbsp;<?php echo $this->session->userdata('currency'); ?> <span id="modal_total_price">0</span></div>
                
                <div class="section5 fix">Note</div>
                <div class="section6 fix">
                    <textarea name="item_note" id="modal_item_note" maxlength="50"></textarea>
                </div>
                <div class="section7 fix">
                    <div class="sec7_inside" id="sec7_1"><button id="close_item_modal"><?php echo lang('cancel'); ?></button></div>
                    <div class="sec7_inside" id="sec7_2"><button id="add_to_cart"><?php echo lang('add_to_cart'); ?></button></div>
                </div>
                <!-- <span class="close">&times;</span> -->
                <!-- <p>Some text in the Modal..</p> -->
            </div>

        </div>
        <!-- end of item modal -->

        <!--add customer modal -->
        <!-- The Modal -->
        <div id="add_customer_modal" class="modal" style="padding-top:20px;">

            <!-- Modal content -->
            <div class="modal-content">
                <h1><?php echo lang('add_customer'); ?></h1>
                
                <div class="customer_add_modal_info_holder">
                    <input type="hidden" id="customer_id_modal" value="">
                    <div class="customer_section fix">
                        <p class="input_level"><?php echo lang('name'); ?> <span style="color:red;">*</span></p>
                        <input type="text" class="add_customer_modal_input" id="customer_name_modal" required>
                    </div>
                    <div class="customer_section fix">
                        <p class="input_level"><?php echo lang('phone'); ?> <span style="color:red;">*</span></p> <small>Should have country code</small>
                        <input type="text" class="add_customer_modal_input" id="customer_phone_modal" required>
                    </div>
                    <div class="customer_section fix">
                        <p class="input_level"><?php echo lang('email'); ?></p>
                        <input type="email" class="add_customer_modal_input" id="customer_email_modal">

                    </div>
                    <div class="customer_section fix">
                        <p class="input_level"><?php echo lang('dob'); ?></p>
                        <input type="datable" class="add_customer_modal_input" id="customer_dob_modal" data-datable="yyyymmdd"  data-datable-divider=" - ">
                    </div>
                    <div class="customer_section fix">
                        <p class="input_level"><?php echo lang('doa'); ?></p>
                        <input type="datable" class="add_customer_modal_input" id="customer_doa_modal" data-datable="yyyymmdd"  data-datable-divider=" - ">
                    </div>
                    <div class="customer_section fix">
                        <p class="input_level"><?php echo lang('delivery_address'); ?></p>
                        <textarea id="customer_delivery_address_modal"></textarea>
                    </div>    
                     <?php if(collectGST()=="Yes"){?>
                        <div class="customer_section fix">
                            <p class="input_level">GST Number</p>
                            <input type="text" class="add_customer_modal_input" id="customer_gst_number_modal">

                        </div>
                    <?php } ?>
                </div>
                
                <div class="section7 fix">
                    <div class="sec7_inside" id="sec7_1"><button id="close_add_customer_modal"><?php echo lang('cancel'); ?></button></div>
                    <div class="sec7_inside" id="sec7_2"><button id="add_customer"><?php echo lang('add_customer'); ?></button></div>
                </div>
                <!-- <span class="close">&times;</span> -->
                <!-- <p>Some text in the Modal..</p> -->
            </div>

        </div>
        <!-- end add customer modal -->

         <!--add customer modal -->
        <!-- The Modal -->
        <!-- <div id="show_tables_modal" class="modal">

            <div class="modal-content" id="modal_content_show_tables">
                <h1>Tables</h1>
                
                <div class="select_table_modal_info_holder fix">
                    <?php echo $tables_modal; ?>   
                        
                                            
                </div>
                
                <div class="section7 fix">
                    <div class="sec7_inside" id="sec7_1"><button id="close_select_table_modal">Cancel</button></div>
                    <div class="sec7_inside" id="sec7_2"><button id="selected_table_done">Done</button></div>
                </div>
            </div>

        </div> -->
        <!-- end add customer modal -->

        <!-- The Modal -->
        <div id="show_tables_modal2" class="modal">

            <!-- Modal content -->
            <div class="modal-content" id="modal_content_show_tables2">
                <h1><?php echo lang('tables'); ?></h1>
                <p id="new_or_order_number_table"><?php echo lang('order_number'); ?>: <span id="order_number_or_new_text"><?php echo lang('new'); ?></span></p>
                <div class="select_table_modal_info_holder2 fix">
                    <?php echo $tables_modal;?>
                </div>
                <div class="fix bottom_button_holder_table_modal">
                    <div class="left fix floatleft half">
                        <button id="please_read_table_modal_button"><i class="fas fa-question-circle"></i> <?php echo lang('please_read'); ?></button>
                    </div>
                    <div class="right fix floatleft half">
                        <button class="floatright" id="submit_table_modal"><?php echo lang('submit'); ?></button>
                        <button class="floatright" id="proceed_without_table_button"><?php echo lang('proceed_without_table'); ?></button>
                        <button class="floatright" id="table_modal_cancel_button"><?php echo lang('cancel'); ?></button>
                    </div>
                </div>
                <!-- <span class="close">&times;</span> -->
                <!-- <p>Some text in the Modal..</p> -->
            </div>

        </div>
        <!-- end add customer modal -->

        <!-- The sale hold modal -->
        <div id="show_sale_hold_modal" class="modal">

            <!-- Modal content -->
            <div class="modal-content" id="modal_content_hold_sales">
                <p class="cross_button_to_close" id="hold_sales_close_button_cross">&times;</p>
                <!-- <img id="hold_sales_close_button_cross" class="close_button" src="<?php echo base_url();?>assets/images/close_icon.png"> -->
                <div class="hold_sale_modal_info_holder fix">
                    <h1 class="main_header fix"><?php echo lang('hold_sale'); ?></h1>
                    <div class="detail_hold_sale_holder fix">
                        <div class="hold_sale_left fix">
                            <div class="hold_list_holder fix">
                                <div class="header_row fix">
                                    <div class="first_column column fix"><?php echo lang('hold_number'); ?></div>
                                    <div class="second_column column fix"><?php echo lang('customer'); ?></div>
                                    <div class="third_column column fix"><?php echo lang('table'); ?></div>
                                </div>
                                <div class="detail_holder fix">
                                    <div class="single_hold_sale fix">
                                        <div class="first_column column fix">09</div>
                                        <div class="second_column column fix"></div>
                                        <div class="third_column column fix"><?php echo lang('table'); ?> 8</div>  
                                    </div>
                                    <div class="single_hold_sale fix">
                                        <div class="first_column column fix">08</div>
                                        <div class="second_column column fix"><?php echo lang('walk_in_customer'); ?></div>
                                        <div class="third_column column fix"><?php echo lang('table'); ?> 7</div>  
                                    </div>
                                    <div class="single_hold_sale fix">
                                        <div class="first_column column fix">07</div>
                                        <div class="second_column column fix"><?php echo lang('walk_in_customer'); ?></div>
                                        <div class="third_column column fix"><?php echo lang('table'); ?> 7</div>  
                                    </div>
                                </div>
                                <div class="delete_all_hold_sales_container fix">
                                    <button id="delete_all_hold_sales_button"><?php echo lang('delete_all_hold_sale'); ?></button>
                                </div>
                            </div>
                        </div>
                        <div class="hold_sale_right fix">
                            <div class="top fix">
                                <div class="top_middle fix">
                                    <h1><?php echo lang('order_details'); ?></h1>
                                    <div class="waiter_customer_table fix">
                                        <div class="fix order_type"><span style="font-weight: bold;"><?php echo lang('order_type'); ?>: </span><span id="hold_order_type"></span><span id="hold_order_type_id" style="display:none;"></span></div>
                                    </div>
                                    <div class="waiter_customer_table fix">
                                        <div class="waiter fix"><span style="font-weight: bold;"><?php echo lang('waiter'); ?>: </span><span style="display:none;" id="hold_waiter_id"></span><span id="hold_waiter_name"></span></div>
                                        <div class="customer fix"><span style="font-weight: bold;"><?php echo lang('customer'); ?>: </span><span style="display:none;" id="hold_customer_id"></span><span id="hold_customer_name"></span></div>
                                        <div class="table fix"><span style="font-weight: bold;"><?php echo lang('table'); ?>: </span><span style="display:none;" id="hold_table_id"></span><span id="hold_table_name"></span></div>
                                    </div>
                                    <div class="item_modifier_details fix">
                                        <div class="modifier_item_header fix">
                                            <div class="first_column_header column_hold fix"><?php echo lang('item'); ?></div>
                                            <div class="second_column_header column_hold fix"><?php echo lang('price'); ?></div>
                                            <div class="third_column_header column_hold fix"><?php echo lang('qty'); ?></div>
                                            <div class="forth_column_header column_hold fix"><?php echo lang('discount'); ?></div>
                                            <div class="fifth_column_header column_hold fix"><?php echo lang('total'); ?></div>
                                        </div>
                                        <div class="modifier_item_details_holder fix">
                                        </div>
                                        <div class="bottom_total_calculation_hold fix">
                                            <div class="single_row first fix">
                                                <div class="first_column fix"><?php echo lang('total_item'); ?>: <span id="total_items_in_cart_hold">0</span></div>
                                                <div class="second_column fix"><?php echo lang('sub_total'); ?></div>
                                                <div class="third_column fix"><?php echo $this->session->userdata('currency'); ?> <span id="sub_total_show_hold">0.00</span>
                                                    <span id="sub_total_hold" style="display:none;">0.00</span>
                                                    <span id="total_item_discount_hold" style="display:none;">0.00</span>
                                                    <span id="discounted_sub_total_amount_hold" style="display:none;">0.00</span>
                                                </div>
                                            </div>
                                            <div class="single_row second fix">
                                                <div class="first_column fix"><?php echo lang('discount'); ?></div>
                                                <div class="second_column fix"><span id="sub_total_discount_hold"></span><span id="sub_total_discount_amount_hold" style="display:none;">0.00</span></div>
                                            </div>
                                            <div class="single_row third fix">
                                                <!-- <div class="first_column fix">VAT</div> -->
                                                <div class="second_column fix"  colspan="5" style="width:100%;"><span id="all_items_vat_hold" style="display: block;overflow: auto;height: 40px;">0.00</span></div>
                                            </div>
                                            <div class="single_row forth fix">
                                                <div class="first_column fix"><?php echo lang('total_discount'); ?></div>
                                                <div class="second_column fix"><?php echo $this->session->userdata('currency'); ?> <span id="all_items_discount_hold">0.00</span></div>
                                            </div>
                                            <div class="single_row fifth fix">
                                                <div class="first_column fix"><?php echo lang('delivery_charge'); ?></div>
                                                <div class="second_column fix"><?php echo $this->session->userdata('currency'); ?> <span id="delivery_charge_hold">0.00</span></div>
                                            </div>
                                            <div class="single_row sixth fix">
                                                <div class="first_column fix"><?php echo lang('total_payable'); ?></div>
                                                <div class="second_column fix"><?php echo $this->session->userdata('currency'); ?> <span id="total_payable_hold">0.00</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bottom">
                                <div class="button_holder">
                                    <div class="single_button_holder">
                                        <button id="hold_sales_close_button"><?php echo lang('cancel'); ?></button>
                                    </div>
                                    <div class="single_button_holder">
                                        <button id="hold_delete_button"><?php echo lang('delete'); ?></button>
                                    </div>
                                    <div class="single_button_holder">
                                        <button id="hold_edit_in_cart_button"><?php echo lang('edit_in_cart'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- end sale hold modal -->

        <!-- The sale hold modal -->
        <div id="show_last_ten_sales_modal" class="modal">

            <!-- Modal content -->
            <div class="modal-content" id="modal_content_last_ten_sales">
                <p class="cross_button_to_close" id="last_ten_sales_close_button_cross">&times;</p>
                <div class="last_ten_sales_modal_info_holder fix">
                    <h1 class="main_header fix"><?php echo lang('last_ten_sales'); ?></h1>
                    <div class="last_ten_sales_holder fix">
                        <div class="hold_sale_left fix">
                            <div class="hold_list_holder fix">
                                <div class="header_row fix">
                                    <div class="first_column column fix"><?php echo lang('sale_no'); ?></div>
                                    <div class="second_column column fix"><?php echo lang('customer'); ?></div>
                                    <div class="third_column column fix"><?php echo lang('table'); ?></div>
                                </div>
                                <div class="detail_holder fix">
                                    <div class="single_hold_sale fix">
                                        <div class="first_column column fix">09</div>
                                        <div class="second_column column fix"><?php echo lang('walk_in_customer'); ?></div>
                                        <div class="third_column column fix"><?php echo lang('table'); ?> 8</div>  
                                    </div>
                                    <div class="single_hold_sale fix">
                                        <div class="first_column column fix">08</div>
                                        <div class="second_column column fix"><?php echo lang('walk_in_customer'); ?></div>
                                        <div class="third_column column fix"><?php echo lang('table'); ?> 7</div>  
                                    </div>
                                    <div class="single_hold_sale fix">
                                        <div class="first_column column fix">07</div>
                                        <div class="second_column column fix"><?php echo lang('walk_in_customer'); ?></div>
                                        <div class="third_column column fix"><?php echo lang('table'); ?> 7</div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hold_sale_right fix">
                            <div class="top fix">
                                <div class="top_middle fix">
                                    <h1><?php echo lang('order_details'); ?></h1>
                                    <div class="waiter_customer_table fix">
                                        <div class="fix order_type">
                                            <span style="font-weight: bold;"><?php echo lang('order_type'); ?>: </span>
                                            <span id="last_10_order_type" style="width: 112px;display: inline-block;">&nbsp;</span>
                                            <span id="last_10_order_type_id" style="display:none;"></span>
                                            <span style="font-weight: bold;"><?php echo lang('invoice_no'); ?>: </span>
                                            <span id="last_10_order_invoice_no"></span>
                                        </div>
                                    </div>
                                    <div class="waiter_customer_table fix">
                                        <div class="waiter fix"><span style="font-weight: bold;"><?php echo lang('waiter'); ?>: </span><span style="display:none;" id="last_10_waiter_id"></span><span id="last_10_waiter_name"></span></div>
                                        <div class="customer fix"><span style="font-weight: bold;"><?php echo lang('customer'); ?>: </span><span style="display:none;" id="last_10_customer_id"></span><span id="last_10_customer_name"></span></div>
                                        <div class="table fix"><span style="font-weight: bold;"><?php echo lang('table'); ?>: </span><span style="display:none;" id="last_10_table_id"></span><span id="last_10_table_name"></span></div>
                                    </div>
                                    <div class="item_modifier_details fix">
                                        <div class="modifier_item_header fix">
                                            <div class="first_column_header column_hold fix"><?php echo lang('item'); ?></div>
                                            <div class="second_column_header column_hold fix"><?php echo lang('price'); ?></div>
                                            <div class="third_column_header column_hold fix"><?php echo lang('qty'); ?></div>
                                            <div class="forth_column_header column_hold fix"><?php echo lang('discount'); ?></div>
                                            <div class="fifth_column_header column_hold fix"><?php echo lang('total'); ?></div>
                                        </div>
                                        <div class="modifier_item_details_holder fix">
                                        </div>
                                        <div class="bottom_total_calculation_hold fix">
                                            <div class="single_row first fix">
                                                <div class="first_column fix"><?php echo lang('total_item'); ?>: <span id="total_items_in_cart_last_10">0</span></div>
                                                <div class="second_column fix"><?php echo lang('sub_total'); ?></div>
                                                <div class="third_column fix"><?php echo $this->session->userdata('currency'); ?> <span id="sub_total_show_last_10">0.00</span>
                                                    <span id="sub_total_last_10" style="display:none;">0.00</span>
                                                    <span id="total_item_discount_last_10" style="display:none;">0.00</span>
                                                    <span id="discounted_sub_total_amount_last_10" style="display:none;">0.00</span>
                                                </div>
                                            </div>
                                            <div class="single_row second fix">
                                                <div class="first_column fix"><?php echo lang('discount'); ?></div>
                                                <div class="second_column fix"><span id="sub_total_discount_last_10"></span><span id="sub_total_discount_amount_last_10" style="display:none;">0.00</span></div>
                                            </div>
                                            <div class="single_row third fix">
                                                <!-- <div class="first_column fix">VAT</div> -->
                                                <div class="second_column fix"  colspan="5" style="width:100%;"><span id="all_items_vat_last_10"style="display: block;overflow: auto;height: 40px;"></span></div>
                                            </div>
                                            <div class="single_row forth fix">
                                                <div class="first_column fix"><?php echo lang('total_discount'); ?></div>
                                                <div class="second_column fix"><?php echo $this->session->userdata('currency'); ?> <span id="all_items_discount_last_10">0.00</span></div>
                                            </div>
                                            <div class="single_row fifth fix">
                                                <div class="first_column fix"><?php echo lang('delivery_charge'); ?></div>
                                                <div class="second_column fix"><?php echo $this->session->userdata('currency'); ?> <span id="delivery_charge_last_10">0.00</span></div>
                                            </div>
                                            <div class="single_row sixth fix">
                                                <div class="first_column fix"><?php echo lang('total_payable'); ?></div>
                                                <div class="second_column fix"><?php echo $this->session->userdata('currency'); ?> <span id="total_payable_last_10">0.00</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bottom">
                                <div class="button_holder">
                                    <div class="single_button_holder">
                                        <button id="last_ten_sales_close_button"><?php echo lang('cancel'); ?></button>
                                    </div>
                                    <div class="single_button_holder">
                                        <button id="last_ten_delete_button"><?php echo lang('delete'); ?></button>
                                    </div>
                                    <div class="single_button_holder">
                                        <button id="last_ten_print_invoice_button"><?php echo lang('print_invoice'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- end sale hold modal -->

        <!-- The sale hold modal -->
        <div id="generate_sale_hold_modal" class="modal">

            <!-- Modal content -->
            <div class="modal-content" id="modal_content_generate_hold_sales">
                <h1><?php echo lang('hold'); ?></h1>
                <div class="generate_hold_sale_modal_info_holder fix">
                    <p style="margin: 0px 0px 5px 0px;"><?php echo lang('hold_number'); ?> <span style="color:red;">*</span></p>
                    <input type="text" name="" id="hold_generate_input">
                </div>
                <div class="section7 fix">
                    <div class="sec7_inside" id="sec7_1"><button id="close_hold_modal"><?php echo lang('cancel'); ?></button></div>
                    <div class="sec7_inside" id="sec7_2"><button id="hold_cart_info"><?php echo lang('submit'); ?></button></div>
                </div>
            </div>

        </div>
        <!-- end add customer modal -->
        <!-- The order details modal -->
        <div id="order_detail_modal" class="modal">

            <!-- Modal content -->
            <div class="modal-content" id="modal_content_sale_details">
                <div class="order_detail_modal_info_holder fix">
                    <div class="top fix">
                        <div class="top_middle fix">
                            <h1><?php echo lang('order_details'); ?></h1>
                            <div class="waiter_customer_table fix">
                                <div class="fix order_type">
                                    <span style="font-weight: bold;"><?php echo lang('order_type'); ?>: </span>
                                    <span id="order_details_type" style="display: inline-block;width:118px;"></span>
                                    <span id="order_details_type_id" style="display:none;"></span>
                                    <span style="font-weight: bold;"><?php echo lang('order_number'); ?>: </span>
                                    <span id="order_details_order_number" style="display: inline-block;"></span>
                                </div>
                            </div>
                            <div class="waiter_customer_table fix">
                                <div class="waiter fix"><span style="font-weight: bold;"><?php echo lang('waiter'); ?>: </span><span style="display:none;" id="order_details_waiter_id"></span><span id="order_details_waiter_name"></span></div>
                                <div class="customer fix"><span style="font-weight: bold;"><?php echo lang('customer'); ?>: </span><span style="display:none;" id="order_details_customer_id"></span><span id="order_details_customer_name"></span></div>
                                <div class="table fix"><span style="font-weight: bold;"><?php echo lang('table'); ?>: </span><span style="display:none;" id="order_details_table_id"></span><span id="order_details_table_name"></span></div>
                            </div>
                            <div class="item_modifier_details fix">
                                <div class="modifier_item_header fix">
                                    <div class="first_column_header column_hold fix"><?php echo lang('item'); ?></div>
                                    <div class="second_column_header column_hold fix"><?php echo lang('price'); ?></div>
                                    <div class="third_column_header column_hold fix"><?php echo lang('qty'); ?></div>
                                    <div class="forth_column_header column_hold fix"><?php echo lang('discount'); ?></div>
                                    <div class="fifth_column_header column_hold fix"><?php echo lang('total'); ?></div>
                                </div>
                                <div class="modifier_item_details_holder fix">
                                </div>
                                <div class="bottom_total_calculation_hold fix">
                                    <div class="single_row first fix">
                                        <div class="first_column fix"><?php echo lang('total_item'); ?>: <span id="total_items_in_cart_order_details">0</span></div>
                                        <div class="second_column fix"><?php echo lang('sub_total'); ?></div>
                                        <div class="third_column fix"><?php echo $this->session->userdata('currency'); ?> <span id="sub_total_show_order_details">0.00</span>
                                            <span id="sub_total_order_details" style="display:none;">0.00</span>
                                            <span id="total_item_discount_order_details" style="display:none;">0.00</span>
                                            <span id="discounted_sub_total_amount_order_details" style="display:none;">0.00</span>
                                        </div>
                                    </div>
                                    <div class="single_row second fix">
                                        <div class="first_column fix"><?php echo lang('discount'); ?></div>
                                        <div class="second_column fix"><span id="sub_total_discount_order_details"></span><span id="sub_total_discount_amount_order_details" style="display:none;">0.00</span></div>
                                    </div>
                                    <div class="single_row third fix">
                                        <!-- <div class="first_column fix">VAT</div> -->
                                        <div class="second_column fix"  colspan="5" style="width:100%;"><span id="all_items_vat_order_details"  style="display: block;overflow: auto;height: 40px;">0.00</span></div>
                                    </div>
                                    <div class="single_row forth fix">
                                        <div class="first_column fix"><?php echo lang('total_discount'); ?></div>
                                        <div class="second_column fix"><?php echo $this->session->userdata('currency'); ?> <span id="all_items_discount_order_details">0.00</span></div>
                                    </div>
                                    <div class="single_row fifth fix">
                                        <div class="first_column fix"><?php echo lang('delivery_charge'); ?></div>
                                        <div class="second_column fix"><span id="delivery_charge_order_details">0.00</span></div>
                                    </div>
                                    <div class="single_row sixth fix">
                                        <div class="first_column fix"><?php echo lang('total_payable'); ?></div>
                                        <div class="second_column fix"><?php echo $this->session->userdata('currency'); ?> <span id="total_payable_order_details">0.00</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if($this->session->userdata('pre_or_post_payment') == "Pre Payment"){?>
                        <div class="create_invoice_close_order_in_order_details" id="order_details_pre_invoice_buttons">
                            <div class="half fix floatleft textcenter">
                                <button id="order_details_create_invoice_button"><i class="fas fa-file-invoice"></i> <?php echo lang('create_invoice'); ?></button> 
                            </div>
                            <div class="half fix floatleft textcenter">
                                <button id="order_details_close_order_button"><i class="fas fa-times-circle"></i> <?php echo lang('close_order'); ?></button> 
                            </div>
                        </div>
                    <?php } ?>
                    <?php if($this->session->userdata('pre_or_post_payment') == "Post Payment"){?>
                        <div class="create_invoice_close_order_in_order_details" id="order_details_post_invoice_buttons">
                            <button id="order_details_create_invoice_close_order_button"><i class="fas fa-file-invoice"></i> <?php echo lang('create_invoice_close'); ?></button>
                        </div>
                    <?php } ?>
                    <div class="create_invoice_close_order_in_order_details">
                        <button id="order_details_print_kot_button"><i class="fas fa-file-invoice"></i> <?php echo lang('print_kot'); ?></button>
                    </div>
                    <button id="order_details_close_button"><?php echo lang('close'); ?></button>
                </div>
            </div>
        </div>
        <!-- end add customer modal -->

        <!-- The kitchen status modal -->
        <div id="kitchen_status_modal" class="modal">

            <!-- Modal content -->
            <div class="modal-content" id="modal_kitchen_status_details">
                <div class="kitchen_status_modal_info_holder fix">
                    <h1 id="kitchen_status_main_header"><?php echo lang('kitchen_status'); ?></h1>
                    <p><span style="font-weight:bold"><?php echo lang('order_number'); ?>:</span> <span id="kitchen_status_order_number"></span> <span style="font-weight:bold"><?php echo lang('order_type'); ?>:</span> <span id="kitchen_status_order_type"></span></p>
                    <p style="text-align:left;">
                        <span style="font-weight:bold"><?php echo lang('waiter'); ?>: </span><span id="kitchen_status_waiter_name">Tamim Shahriar</span>
                        <span style="font-weight:bold"><?php echo lang('customer'); ?>: </span><span id="kitchen_status_customer_name">Faruq Hussain</span>
                        <span style="font-weight:bold"><?php echo lang('order_table'); ?>: </span><span id="kitchen_status_table">Table 01</span>
                    </p>
                    <div id="kitchen_status_detail_holder" class="fix">
                        <div id="kitchen_status_detail_header" class="fix">
                            <div class="fix first"><?php echo lang('item'); ?></div>
                            <div class="fix second"><?php echo lang('quantity'); ?></div>
                            <div class="fix third"><?php echo lang('status'); ?></div>
                        </div>
                        <div id="kitchen_status_item_details" class="fix">
                            <div class="kitchen_status_single_item fix" style="background-color:#ADD8E6;">
                                <div class="fix">Chicken Picata</div>
                                <div class="fix">2</div>
                                <div class="fix">Started Cooking 12:34 Min Ago</div>
                            </div>
                            <div class="kitchen_status_single_item fix" style="background-color:#90EE90;">
                                <div class="fix">Beef Chili Onion</div>
                                <div class="fix">3</div>
                                <div class="fix">Done Cooking 16:34 Min Ago</div>
                            </div>
                            <div class="kitchen_status_single_item fix">
                                <div class="fix">Tanduri Chicken</div>
                                <div class="fix">5</div>
                                <div class="fix">In the queue</div>
                            </div>
                        </div>
                    </div>
                    <h1 id="kitchen_status_order_placed"><?php echo lang('order_placed_at'); ?>: 14:22</h1>
                    <h1 id="kitchen_status_time_count"><?php echo lang('time_count'); ?>: <span id="kitchen_status_ordered_minute">23</span>:<span id="kitchen_status_ordered_second">55</span> M</h1>
                    <button id="kitchen_status_close_button"><?php echo lang('close'); ?></button>
                </div>
            </div>
        </div>
        <!-- end kitchen status modal -->

        <!-- The table modal please read -->
        <div id="please_read_modal" class="modal">

            <!-- Modal content -->
            <div class="modal-content" id="modal_please_read_details">
                <p class="cross_button_to_close" id="please_read_close_button_cross">&times;</p>
                <h1 id="please_read_modal_header" style="color: #dc3545;"><?php echo lang('please_read'); ?></h1>
                <div class="help_modal_info_holder fix">
                    
                    <!-- <p class="para_type_1">How order process works</p> -->
                    <p class="para_type_1"><?php echo lang('please_read_text_1'); ?>:</p>
                    <p class="para_type_2"><?php echo lang('please_read_text_2'); ?></p>
                    <p class="para_type_1"><?php echo lang('please_read_text_3'); ?>:</p>
                    <p class="para_type_2"><?php echo lang('please_read_text_4'); ?></p>   
                    <button id="please_read_close_button"><?php echo lang('close'); ?></button>
                </div>
            </div>
        </div>
        <!-- end table modal please read modal -->

        <!-- The kitchen status modal -->
        <div id="help_modal" class="modal">

            <!-- Modal content -->
            <div class="modal-content" id="modal_help_details">
                <p class="cross_button_to_close" id="help_close_button_cross">&times;</p>
                <h1 id="help_modal_header" style="color: #dc3545;"><?php echo lang('read_before_begin'); ?></h1>
                <div class="help_modal_info_holder fix">
                    <p class="para_type_1"><?php echo lang('read_help_text_1'); ?></p>
                    <p class="para_type_2"><?php echo lang('read_help_text_2'); ?></p> 
                    <p class="para_type_1"><?php echo lang('read_help_text_3'); ?></p>
                    <p class="para_type_2"><?php echo lang('read_help_text_4'); ?></p>  
                    
                    <!-- <p class="para_type_1">How order process works</p>
                    <p class="para_type_2" style="font-weight: bold;">Who take Post-Payment:</p>
                    <p class="para_type_2">Post payment means your customer orders first, then kitchen, then eat then invoice and pay.</p>
                    <p class="para_type_2">For this process, you will place the order first, that will go to Running Orders as well as to Kitchen, then the order will be hung in Running Orders until food comes from kitchen and customer finishes eating, after finishing eating, you will click on Create Invoice & Close.</p>
                    <p class="para_type_2">System will print an invoice and remove the order from Running Order list as well as change status of that order to Closed.</p>
                    <p class="para_type_2" style="font-weight: bold;">Who take Pre-Payment:</p>
                    <p class="para_type_2">Place the order and click on Create Invoice, system will print an invoice but it will not wipe the order from Running Orders as well as it will also be sent to Kitchen. And when Kitchen finishes delivery, just click on Close Order.</p>  -->
                    <p class="para_type_1"><?php echo lang('read_help_text_5'); ?></p>
                    <p class="para_type_2"><?php echo lang('read_help_text_6'); ?></p>   
                    <p class="para_type_1"><?php echo lang('read_help_text_7'); ?></p>
                    <p class="para_type_2"><?php echo lang('read_help_text_8'); ?></p>
                    <p class="para_type_2"><?php echo lang('read_help_text_9'); ?></p>
                    <p class="para_type_2"><?php echo lang('read_help_text_10'); ?></p>
                    <p class="para_type_1"><?php echo lang('read_help_text_11'); ?></p>
                    <p class="para_type_2"><?php echo lang('read_help_text_12'); ?></p>                    
                    <p class="para_type_2"><?php echo lang('read_help_text_13'); ?></p>                    
                    <p class="para_type_2"><?php echo lang('read_help_text_14'); ?></p>                    
                    <p class="para_type_2"><?php echo lang('read_help_text_15'); ?></p>                    
                    <p class="para_type_1"><?php echo lang('read_help_text_16'); ?></p>
                    <p class="para_type_2"><?php echo lang('read_help_text_17'); ?></p>  
                    <p class="para_type_1"><?php echo lang('read_help_text_18'); ?></p>
                    <p class="para_type_2"><?php echo lang('read_help_text_19'); ?></p>
                    <p class="para_type_1"><?php echo lang('read_help_text_20'); ?></p>
                    <p class="para_type_2"><?php echo lang('read_help_text_21'); ?></p>
                    <p class="para_type_1"><?php echo lang('read_help_text_22'); ?></p>
                    <p class="para_type_2"><?php echo lang('read_help_text_23'); ?></p>
                    <p class="para_type_1"><?php echo lang('read_help_text_24'); ?></p>
                    <p class="para_type_2"><?php echo lang('read_help_text_25'); ?></p> 
                    <button id="help_close_button"><?php echo lang('close'); ?></button>
                </div>
            </div>
        </div>
        <!-- end kitchen status modal -->

        <!-- The Modal -->
        <div id="finalize_order_modal" class="modal">

            <!-- Modal content -->
            <div class="modal-content" id="modal_finalize_order_details">
                <h1 id="modal_finalize_header"><?php echo lang('finalize_order'); ?></h1>
                <div class="fo_1 fix">
                    <span style="display:none;" id="finalize_update_type"></span>
                    <div class="half fix floatleft"><?php echo lang('total_payable'); ?></div>
                    <div class="half fix floatleft textright"><?php echo $this->session->userdata('currency');?> <span id="finalize_total_payable">0.00</span></div>
                </div>
                <div class="fo_2 fix">
                    <div class="half fix floatleft"><?php echo lang('total_payment'); ?></div>
                    <div class="half fix floatleft textright">
                        <select name="finalie_order_payment_method" id="finalie_order_payment_method">
                            <option value=""><?php echo lang('payment_method'); ?></option>
                            <?php echo $payment_method_options; ?>
                        </select>
                    </div>
                    
                </div>
                <div class="fo_3 fix">
                     <div class="half fix floatleft textleft"><?php echo lang('pay_amount'); ?></div>
                     <div class="half fix floatleft textright"><?php echo lang('due_amount'); ?></div>
                     <div class="half fix floatleft textleft"><input type="text" name="pay_amount_invoice_modal_input" id="pay_amount_invoice_input"></div>
                     <div class="half fix floatleft textright"><input type="text" name="due_amount_invoice_modal_input" id="due_amount_invoice_input" disabled></div>
                </div>
                <div class="fo_3 fix">
                     <div class="half fix floatleft textleft"><?php echo lang('given_amount'); ?></div>
                     <div class="half fix floatleft textright"><?php echo lang('change_amount'); ?></div>
                     <div class="half fix floatleft textleft"><input type="text" name="given_amount_modal_input" id="given_amount_input"></div>
                     <div class="half fix floatleft textright"><input type="text" name="change_amount_modal_input" id="change_amount_input" disabled></div>
                </div>
                <div class="bottom_buttons fix">
                    <div class="bottom_single_button floatleft textleft half fix"><button id="finalize_order_cancel_button"><?php echo lang('cancel'); ?></button></div>
                    <div class="bottom_single_button floatleft textright half fix"><button id="finalize_order_button"><?php echo lang('submit'); ?></button></div>
                </div>
                <!-- <span class="close">&times;</span> -->
                <!-- <p>Some text in the Modal..</p> -->
            </div>

        </div>
        <!-- end of item modal -->

        <!-- The Notification List Modal -->
        <div id="notification_list_modal" class="modal">

            <!-- Modal content -->
            <div class="modal-content" id="modal_notification_list_details">
                <h1 id="modal_notification_header"><?php echo lang('notification_list'); ?></h1>
                <div id="notification_list_header_holder">
                    <div class="single_row_notification_header fix" style="height: 25px;border-bottom: 2px solid #cfcfcf;">
                        <div class="fix single_notification_check_box">
                            <input type="checkbox" id="select_all_notification">
                        </div>
                        <div class="fix single_notification"><strong><?php echo lang('select_all'); ?></strong></div>
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
                    <button id="notification_remove_all"><?php echo lang('remove'); ?></button><button id="notification_close"><?php echo lang('close'); ?></button>
                </div>
            </div>

        </div>
        <!-- end of notification list modal -->

        
        <!-- The Notification List Modal -->
        <div id="kitchen_bar_waiter_panel_button_modal" class="modal">

            <!-- Modal content -->
            <div class="modal-content" id="modal_kitchen_bar_waiter_details" style="position: relative;">
                <p class="cross_button_to_close" id="kitchen_bar_waiter_modal_close_button_cross">&times;</p>
                <h1 id="switch_panel_modal_header"><?php echo lang('kitchen_waiter_bar'); ?></h1>
                <div style="padding:30px;">

                    <a href="<?php echo base_url(); ?>Demo_panel/switchTo/kitchen" target="_blank" style="width: 32%;display: inline-block;text-align: center;">
                        <button style="width:100%;"><?php echo lang('kitchen_panel'); ?></button>
                    </a>
                    <a href="<?php echo base_url(); ?>Demo_panel/switchTo/waiter" target="_blank" style="width: 32%;display: inline-block;text-align: center;">
                        <button style="width:100%;"><?php echo lang('waiter_panel'); ?></button>
                    </a>
                    <a href="<?php echo base_url(); ?>Demo_panel/switchTo/bar" target="_blank" style="width: 32%;display: inline-block;text-align: center;">
                        <button style="width:100%;"><?php echo lang('bar_panel'); ?></button>
                    </a>    
                </div>
                
            </div>

        </div>
        <!-- end of notification list modal -->


        <!-- The KOT Modal -->
        <div id="kot_list_modal" class="modal">

            <!-- Modal content -->
            <div class="modal-content" id="modal_kot_list_details">
                <h1 id="modal_kot_header"><?php echo lang('kot'); ?></h1>
                <h2 id="kot_modal_modified_or_not"><?php echo lang('modified'); ?></h2>
                <div id="kot_header_info" class="fix">
                    <p><?php echo lang('order_no'); ?>: <span id="kot_modal_order_number"></span></p>
                    <p><?php echo lang('date'); ?>: <span id="kot_modal_order_date"></span></p>
                    <p><?php echo lang('customer'); ?>: <span id="kot_modal_customer_id" style="display:none;"></span><span id="kot_modal_customer_name"></span></p>
                    <p><?php echo lang('table'); ?>: <span id="kot_modal_table_name"></span></p>                    
                    <p><?php echo lang('waiter'); ?>: <span id="kot_modal_waiter_name"></span>, <?php echo lang('order_type'); ?>: <span id="kot_modal_order_type"></span></p>                    
                </div>
                <div id="kot_table_content" class="fix">
                    <div class="kot_modal_table_content_header fix">
                        <div class="kot_header_row fix floatleft kot_check_column"><input type="checkbox" id="kot_check_all"></div>
                        <div class="kot_header_row fix floatleft kot_item_name_column"><?php echo lang('item'); ?></div>
                        <div class="kot_header_row fix floatleft kot_qty_column"><?php echo lang('qty'); ?></div>
                        <div class="kot_header_row fix floatleft kot_modifier_column"><?php echo lang('modifiers'); ?></div>    
                    </div>
                    <div id="kot_list_holder" class="fix">
                        
                    </div>

                </div>
                <div id="kot_bottom_buttons" class="fix">
                    <button id="cancel_kot_modal"><?php echo lang('cancel'); ?></button><button id="print_kot_modal"><?php echo lang('print_kot'); ?></button>
                </div>
                
            </div>

        </div>
        <!-- end of KOT modal -->
        
        <div id="calculator_main">
            <div class="calculator">
                <input type="text" readonly>
                <div class="row">
                    <div class="key">1</div>
                    <div class="key">2</div>
                    <div class="key">3</div>
                    <div class="key last">0</div>
                </div>
                <div class="row">
                    <div class="key">4</div>
                    <div class="key">5</div>
                    <div class="key">6</div>
                    <div class="key last action instant">cl</div>
                </div>
                <div class="row">
                    <div class="key">7</div>
                    <div class="key">8</div>
                    <div class="key">9</div>
                    <div class="key last action instant">=</div>
                </div>
                <div class="row">
                    <div class="key action">+</div>
                    <div class="key action">-</div>
                    <div class="key action">x</div>
                    <div class="key last action">/</div>
                </div>
          </div>    
        </div>      
        <div id="modify_button_tool_tip" style="display:none;position: absolute;background: #fff;border: 1px solid #cfcfcf;border-radius: 5px;box-shadow: 2px 2px 2px #cfcfcf;padding:5px;">
            <h1 class="title" style="margin:0px;font-size: 20px;line-height: 25px;">Choose This For:</h1>
            <p style="margin:0px;margin: 0px;font-size: 14px;line-height: 16px;">1. Add New Item</p>
            <p style="margin:0px;margin: 0px;font-size: 14px;line-height: 16px;">2. Change Table</p>
            <p style="margin:0px;margin: 0px;font-size: 14px;line-height: 16px;">3. Change anything in an Order</p> 
        </div>  
        <div id="direct_invoice_button_tool_tip" style="display:none;position: absolute;background: #fff;border: 1px solid #cfcfcf;border-radius: 5px;box-shadow: 2px 2px 2px #cfcfcf;padding:5px;">
            <h1 class="title" style="margin:0px;font-size: 20px;line-height: 25px;">For Fast Food Restaurants</h1>
        </div> 
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/POS/js/marquee.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/POS/js/custom.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/POS/js/items.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/POS/js/datable.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/POS/js/jquery.cookie.js"></script>

        <script type="text/javascript">
            $('.select2').select2();
            window.customers = [<?php echo $customer_objects;?>];
            window.items = [<?php echo $javascript_obects;?>];
            function searchItemAndConstructGallery(searchedValue){
                
                var resultObject = search(searchedValue, window.items);
                return resultObject;
            }
            function searchCustomerAddress(searchValue){
                
                var resultObject = searchAddress(searchValue, window.customers);
                return resultObject;
            }
            $.datable();

            $('#register_close').on('click',function(){
                var r = confirm("Are you sure to close register?");
                
                if (r == true) {
                    $.ajax({
                        url: '<?php echo base_url("Sale/closeRegister"); ?>',
                        method:"POST",
                        data:{
                            csrf_test_name: $.cookie('csrf_cookie_name')
                        },
                        success:function(response) {
                            swal({
                                title: '<?php echo lang('alert'); ?>',
                                text: '<?php echo lang('register_close'); ?>!!',
                                confirmButtonText:'<?php echo lang('ok'); ?>',
                                confirmButtonColor: '#b6d6f6' 
                            });
                            $('#close_register_button').hide();
                            window.location.href = '<?php echo base_url()?>Authentication/logOut';

                        },
                        error:function(){
                            alert("error");
                        }
                    });     
                }    
            });

            $('#go_to_dashboard').on('click',function(){
                /*var r = confirm("Are you sure to close register?");
                
                if (r == true) {
                    $.ajax({
                        url: '<?php echo base_url("Sale/closeRegister"); ?>',
                        method:"POST",
                        data:{
                            csrf_test_name: $.cookie('csrf_cookie_name')
                        },
                        success:function(response) {
                            swal({
                                title: 'Alert',
                                text: 'Register closed successfully!!',
                                confirmButtonColor: '#b6d6f6' 
                            });
                            $('#close_register_button').hide();
                            window.location.href = '<?php echo base_url()?>Authentication/logOut';

                        },
                        error:function(){
                            alert("error");
                        }
                    });     
                }  */  
  
                window.location.href = '<?php echo base_url(); ?>Authentication/userProfile'; 
            });
            
        </script>
    </body>
</html>