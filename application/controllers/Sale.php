<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sale extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->model('Sale_model');
        $this->load->model('Kitchen_model');
        $this->load->model('Bar_model');
        $this->load->model('Waiter_model');
        $this->load->model('Master_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();
        
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        if (!$this->session->has_userdata('outlet_id')) {
            $this->session->set_flashdata('exception_2', 'Please click on green Enter button of an outlet');

            $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
            $this->session->set_userdata("clicked_method", $this->uri->segment(2));
            redirect('Outlet/outlets');
        }

        if (!$this->session->has_userdata('outlet_id')) {
            $this->session->set_flashdata('exception_2', 'Please click on green Enter button of an outlet');

            $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
            $this->session->set_userdata("clicked_method", $this->uri->segment(2));
            redirect('Outlet/outlets');
        }
        $getAccessURL = $this->uri->segment(1);
        
        if (!in_array($getAccessURL, $this->session->userdata('menu_access')) && $this->session->userdata('role')!='POS User') {
            redirect('Authentication/userProfile');
        }
        //check register is open or not
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        if($this->Common_model->isOpenRegister($user_id,$outlet_id)==0){
            $this->session->set_flashdata('exception_3', 'Register is not open, enter your opening balance!');
            if($this->uri->segment(2)=='registerDetailCalculationToShowAjax' || $this->uri->segment(2)=='closeRegister'){
                redirect('Register/openRegister');
            }else{
                $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
                $this->session->set_userdata("clicked_method", $this->uri->segment(2));
                redirect('Register/openRegister');
            }
               
        }

    }

    /* ----------------------Sale Start-------------------------- */

    public function sales() {
        /* print('<Pre>');
          print_r($this->session->userdata());exit; */
        $outlet_id = $this->session->userdata('outlet_id');
        $data = array();
        $data['lists'] = $this->Sale_model->getSaleList($outlet_id);
        $data['main_content'] = $this->load->view('sale/sales', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    public function deleteSale($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        // $this->Common_model->deleteStatusChangeWithChild($id, $id, "tbl_sales", "tbl_sales_details", 'id', 'sales_id');
        // $consumptionDeleteID = getConsumptionID($id);
        // $this->Common_model->deleteStatusChangeWithChild($id, $consumptionDeleteID, "tbl_sale_consumptions", "tbl_sale_consumptions_of_menus", 'sale_id', 'sale_consumption_id');
        if($this->session->userdata('role')=='Admin'){
            $isDeleted = $this->delete_specific_order_by_sale_id($id);
            if($isDeleted){
                $this->session->set_flashdata('exception', 'Information has been deleted successfully!');
                redirect('Sale/sales');    
            }else{
                $this->session->set_flashdata('exception_2', 'Something went wrong!');
                redirect('Sale/sales');    
            }    
        }else{
            $this->session->set_flashdata('exception_2', 'Only admin is allowed to delete sale!');
            redirect('Sale/sales');
        }
        
        
    }

    public function POS($encrypted_id = "") {

        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $company_id = $this->session->userdata('company_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $data = array();
        $data['vatamount'] = $this->db->query("SELECT percentage FROM tbl_vats WHERE id=1")->row('percentage');
        $tables = $this->Sale_model->getTablesByOutletId($outlet_id);
        $data['tables'] = $this->getTablesDetails($tables);
        $data['categories'] = $this->Sale_model->getFoodMenuCategories($company_id, 'tbl_food_menu_categories');
        $data['item_menus'] = $this->Sale_model->getAllItemmenus();
        $data['customers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_customers');
        $data['food_menus'] = $this->Sale_model->getAllFoodMenus();
        $data['menu_categories'] = $this->Sale_model->getAllMenuCategories();
        $data['menu_modifiers'] = $this->Sale_model->getAllMenuModifiers();
        $data['waiters'] = $this->Sale_model->getWaitersForThisCompany($company_id,'tbl_users');
        $data['new_orders'] = $this->get_new_orders();
        $data['payment_methods'] = $this->Sale_model->getAllPaymentMethods();
        $data['notifications'] = $this->get_new_notification();
        /* $data['saleSuspends'] = $this->Common_model->getAllSaleSuspends($outlet_id, 'tbl_sale_suspends'); */
        $this->load->view('sale/POS/main_screen', $data);
    }
    public function getTablesDetails($tables){
        foreach($tables as $table){
            $table->orders_table = $this->Sale_model->getOrdersOfTableByTableId($table->id);
            foreach($table->orders_table as $order_table){
                
                $start_date = new DateTime($order_table->booking_time);
                $since_start = $start_date->diff(new DateTime());
                $order_table->booked_in_minute = $since_start->i;
            }
        }
        return $tables;
    }

    public function Save() {
        $data = array();
        $data['customer_id'] = $this->input->get('customer_id');
        $data['total_items'] = $this->input->get('total_items');
        $data['sub_total'] = $this->input->get('sub_total');
        $data['disc'] = $this->input->get('disc');
        $data['disc_actual'] = $this->input->get('disc_actual');
        $data['vat'] = $this->input->get('vat');
        $data['paid_amount'] = $this->input->get('paid_amount');
        $data['due_amount'] = $this->input->get('due_amount');
        $data['table_id'] = $this->input->get('table_id');
        $data['token_no'] = $this->input->get('token_no');
        if ($this->input->get('due_payment_date')) {
            $data['due_payment_date'] = $this->input->get('due_payment_date');
        } else {
            $data['due_payment_date'] = Null;
        }

        $data['total_payable'] = $this->input->get('total_payable');
        $data['payment_method_id'] = $this->input->get('payment_method_id');
        $data['user_id'] = $this->session->userdata('user_id');
        $data['outlet_id'] = $this->session->userdata('outlet_id');
        $data['sale_date'] = $this->input->get('sale_date');
        $data['sale_time'] = date('h:i A');
        $outlet_id = $this->session->userdata('outlet_id');
        $sale_no = $this->db->query("SELECT count(id) as bno
               FROM tbl_sales WHERE outlet_id=$outlet_id")->row('bno');
        $sale_no = str_pad($sale_no + 1, 6, '0', STR_PAD_LEFT);
        $data['sale_no'] = $sale_no;
        ////////////
        $food_menu_id = $this->input->get('food_menu_id');
        $menu_name = $this->input->get('menu_name');
        $price = $this->input->get('price');
        $qty = $this->input->get('qty');
        $discount_amount = $this->input->get('discountNHiddenTotal');
        $total = $this->input->get('total');
        /////////////////////
        $i = 0;
        $this->db->trans_begin();
        $query = $this->db->insert('tbl_sales', $data);
        $sales_id = $this->db->insert_id();

        $comsump = array();
        $comsump['outlet_id'] = $this->session->userdata('outlet_id');
        $comsump['date'] = date('Y-m-d');
        $comsump['date_time'] = date('h:i A');
        $comsump['user_id'] = $this->session->userdata('user_id');
        $comsump['sale_id'] = $sales_id;
        $query = $this->db->insert('tbl_sale_consumptions', $comsump);
        $sale_consumption_id = $this->db->insert_id();

        //////////////////////////////////
        foreach ($food_menu_id as $value) {
            $data1['food_menu_id'] = $value;
            $data1['sales_id'] = $sales_id;
            $data1['menu_name'] = $menu_name[$i];
            $data1['price'] = $price[$i];
            $data1['qty'] = $qty[$i];
            $data1['discount_amount'] = $discount_amount[$i];
            $data1['total'] = $total[$i];
            $data1['user_id'] = $this->session->userdata('user_id');
            $data1['outlet_id'] = $this->session->userdata('outlet_id');
            $this->db->insert('tbl_sales_details', $data1);
            //////////////////////

            $ingredlist = $this->Sale_model->getFoodMenuIngredients($value);
            foreach ($ingredlist as $inrow) {
                $data3 = array();
                $data3['sale_consumption_id'] = $sale_consumption_id;
                $data3['ingredient_id'] = $inrow->ingredient_id;
                $data3['consumption'] = $inrow->consumption * $qty[$i];
                $data3['user_id'] = $this->session->userdata('user_id');
                $data3['outlet_id'] = $this->session->userdata('outlet_id');
                $this->db->insert('tbl_sale_consumptions_of_menus', $data3);
            }
            //////////////////////
            $i++;
        }
        $returndata = array('sales_id' => $sales_id);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            echo json_encode($returndata);
            $this->db->trans_commit();
        }
    }

    public function deleteSuspend() {
        $suspendID = $this->input->get('minusSuspendID');
        $this->session->unset_userdata('customer_id_' . $suspendID);
        $this->session->unset_userdata('total_item_hidden_' . $suspendID);
        $this->session->unset_userdata('sub_total_' . $suspendID);
        $this->session->unset_userdata('disc_' . $suspendID);
        $this->session->unset_userdata('disc_actual_' . $suspendID);
        $this->session->unset_userdata('vat_' . $suspendID);
        $this->session->unset_userdata('gTotalDisc_' . $suspendID);
        $this->session->unset_userdata('total_payable_' . $suspendID);
        $this->session->unset_userdata('tables_' . $suspendID);
        $this->session->unset_userdata('countSuspend_' . $suspendID);
        $this->session->unset_userdata('countTimeSuspend_' . $suspendID);
        $this->session->unset_userdata('countSuspendCurrent');
        echo json_encode("success");
    }

    public function getSuspend() {
        $suspendID = $this->input->get('suspendID');
        $checkSuspend = $this->session->userdata('countSuspend_' . $suspendID);
        if ($checkSuspend) {
            $data['status'] = true;
            $data['sus_id'] = $suspendID;
            $data['customer_id'] = $this->session->userdata('customer_id_' . $suspendID);
            $data['total_item_hidden'] = $this->session->userdata('total_item_hidden_' . $suspendID);
            $data['sub_total'] = $this->session->userdata('sub_total_' . $suspendID);
            $data['disc'] = $this->session->userdata('disc_' . $suspendID);
            $data['disc_actual'] = $this->session->userdata('disc_actual_' . $suspendID);
            $data['gTotalDisc'] = $this->session->userdata('gTotalDisc_' . $suspendID);
            $data['vat'] = $this->session->userdata('vat_' . $suspendID);
            $data['total_payable'] = $this->session->userdata('total_payable_' . $suspendID);
            $data['tables'] = $this->session->userdata('tables_' . $suspendID);
        } else {
            $data['status'] = false;
        }
        echo json_encode($data);
    }

    public function getSuspendCurrent() {

        $checkSuspend = $this->session->userdata('countSuspendCurrent');
        $suspendID = "current";

        $data['status'] = true;
        $data['customer_id'] = $this->session->userdata('customer_id_' . $suspendID);
        $data['total_item_hidden'] = $this->session->userdata('total_item_hidden_' . $suspendID);
        $data['sub_total'] = $this->session->userdata('sub_total_' . $suspendID);
        $data['disc'] = $this->session->userdata('disc_' . $suspendID);
        $data['disc_actual'] = $this->session->userdata('disc_actual_' . $suspendID);
        $data['vat'] = $this->session->userdata('vat_' . $suspendID);
        $data['gTotalDisc'] = $this->session->userdata('gTotalDisc_' . $suspendID);
        $data['total_payable'] = $this->session->userdata('total_payable_' . $suspendID);
        $data['tables'] = $this->session->userdata('tables_' . $suspendID);
        echo json_encode($data);
    }

    public function setSuspend() {
        $check1 = $this->session->userdata('countSuspend_1');
        $check2 = $this->session->userdata('countSuspend_2');
        $check3 = $this->session->userdata('countSuspend_3');

        $checkTime1 = $this->session->userdata('countTimeSuspend_1');
        $checkTime2 = $this->session->userdata('countTimeSuspend_2');
        $checkTime3 = $this->session->userdata('countTimeSuspend_3'); 

        $times = date('Y-m-d h:i:s');

        if (!$check1) {
            $temp = 1;
            $this->session->set_userdata('countSuspend_1', 1);
            $this->session->set_userdata('countTimeSuspend_1', $times);
        } elseif (!$check2) {
            $temp = 2;
            $this->session->set_userdata('countSuspend_2', 2);
            $this->session->set_userdata('countTimeSuspend_2', $times);
        } elseif (!$check3) {
            $this->session->set_userdata('countSuspend_3', 3);
            $this->session->set_userdata('countTimeSuspend_3', $times);
            $temp = 3;
        } else {

            if ($checkTime1 < $checkTime2) {
                if ($checkTime1 < $checkTime3) {
                    $temp = 1;
                    $this->session->unset_userdata('countSuspend_' . $temp);
                    $this->session->set_userdata('countSuspend_1', 1);
                    $this->session->unset_userdata('countTimeSuspend_' . $temp);
                    $this->session->set_userdata('countTimeSuspend_1', $times);
                } else {
                    $temp = 3;
                    $this->session->unset_userdata('countSuspend_' . $temp);
                    $this->session->set_userdata('countSuspend_3', 3);
                    $this->session->unset_userdata('countTimeSuspend_' . $temp);
                    $this->session->set_userdata('countTimeSuspend_3', $times);
                }
            } else {
                if ($checkTime2 < $checkTime3) {
                    $temp = 2;
                    $this->session->unset_userdata('countSuspend_' . $temp);
                    $this->session->set_userdata('countSuspend_2', 2);
                    $this->session->unset_userdata('countTimeSuspend_' . $temp);
                    $this->session->set_userdata('countTimeSuspend_2', $times);
                } else {
                    $temp = 3;
                    $this->session->unset_userdata('countSuspend_' . $temp);
                    $this->session->set_userdata('countSuspend_3', 3);
                    $this->session->unset_userdata('countTimeSuspend_' . $temp);
                    $this->session->set_userdata('countTimeSuspend_3', $times);
                }
            }
        }

        //set session value
        $i = 0;
        $food_menu_id = $this->input->get('food_menu_id');
        $menu_name = $this->input->get('menu_name');
        $price = $this->input->get('price');
        $qty = $this->input->get('qty');
        $VATHidden = $this->input->get('VATHidden');
        $VATHiddenTotal = $this->input->get('VATHiddenTotal');
        $discountN = $this->input->get('discountN');
        $discountNHidden = $this->input->get('discountNHidden');
        $discountNHiddenTotal = $this->input->get('discountNHiddenTotal');
        $total = $this->input->get('total');
        $tableRow = "";
        foreach ($food_menu_id as $value) {
            $trID = "row_" . $i;
            $inputID = "food_menu_id_" . $i;
            $tableRow .= "<tr data-id='$i' class='clRow' id='row_$i'><input id='food_menu_id_$i' name='food_menu_id[]' value='$value' type='hidden'><input id='$inputID' name='menu_name[]' value='$menu_name[$i]' type='hidden'><input id='discountNHidden_$i' name='discountNHidden[]' value='$discountNHidden[$i]' type='hidden'><input id='discountNHiddenTotal_$i' name='discountNHiddenTotal[]' value='$discountNHiddenTotal[$i]' type='hidden'><input id='VATHidden_$i' name='VATHidden[]' value='$VATHidden[$i]' type='hidden'><input id='VATHiddenTotal_$i' name='VATHiddenTotal[]' value='$VATHiddenTotal[$i]' type='hidden'><td>$menu_name[$i]</td><td><input class='pri-size txtboxToFilter' onfocus='this.select();' id='price_$i' name='price[]' value='$price[$i]' onblur='return calculateRow($i);' onkeyup='return calculateRow($i)' type='text'></td><td><input class='qty-size txtboxToFilter' onfocus='this.select();' min='1' id='qty_$i' name='qty[]' value='$qty[$i]' onmouseup='return helloThere($i)' onblur='return calculateRow($i);' onkeyup='return checkQuantity($i);' onkeydown='return calculateRow($i);' type='number'></td><td><input class='qty-size discount' onfocus='this.select();'  id='discountN_$i' name='discountN[]' value='$discountN[$i]' onmouseup='return helloThere($i)' onblur='return calculateRow($i);' onkeyup='return checkQuantity($i);' onkeydown='return calculateRow($i);' type='text'></td><td><input class='pri-size' readonly='' id='total_$i' name='total[]' style='background-color: #dddddd;border:1px solid #7e7f7f;' value='$total[$i]' type='text'></td><td style='text-align: center'><a class='btn btn-danger btn-xs' onclick='return deleter($i,$value);'><i style='color:white' class='fa fa-trash'></i></a></td></tr>";
            $i++;
        }
        $customer_id = $this->input->get('customer_id');
        $total_item_hidden = $this->input->get('total_items');
        $sub_total = $this->input->get('sub_total');
        $disc = $this->input->get('disc');
        $disc_actual = $this->input->get('disc_actual');
        $vat = $this->input->get('vat');
        $gTotalDisc = $this->input->get('gTotalDisc');
        $total_payable = $this->input->get('total_payable');
        $tables = $tableRow;
        $this->session->set_userdata('customer_id_' . $temp, $customer_id);
        $this->session->set_userdata('total_item_hidden_' . $temp, $total_item_hidden);
        $this->session->set_userdata('sub_total_' . $temp, $sub_total);
        $this->session->set_userdata('disc_' . $temp, $disc);
        $this->session->set_userdata('disc_actual_' . $temp, $disc_actual);
        $this->session->set_userdata('vat_' . $temp, $vat);
        $this->session->set_userdata('gTotalDisc_' . $temp, $gTotalDisc);
        $this->session->set_userdata('total_payable_' . $temp, $total_payable);
        $this->session->set_userdata('tables_' . $temp, $tables);
        $data['suspend_id'] = $temp;
        echo json_encode($data);
    }

    public function setSuspendCurrent() {

        $currentStatus = $this->input->get('currentStatus');
        if ($currentStatus == "1") {
            $temp = "current";
            $this->session->set_userdata('countSuspendCurrent', 1);
            //set session value
            $i = 0;
            $ingredient_id = $this->input->get('ingredient_id');
            $menu_name = $this->input->get('menu_name');
            $price = $this->input->get('price');
            $qty = $this->input->get('qty');
            $VATHidden = $this->input->get('VATHidden');
            $VATHiddenTotal = $this->input->get('VATHiddenTotal');
            $discountN = $this->input->get('discountN');
            $discountNHidden = $this->input->get('discountNHidden');
            $discountNHiddenTotal = $this->input->get('discountNHiddenTotal');
            $total = $this->input->get('total');
            $tableRow = "";
            foreach ($ingredient_id as $value) {
                $trID = "row_" . $i;
                $inputID = "ingredient_id_" . $i;
                $tableRow .= "<tr data-id='$i' class='clRow' id='row_$i'><input id='ingredient_id_$i' name='ingredient_id[]' value='$value' type='hidden'><input id='$inputID' name='menu_name[]' value='$menu_name[$i]' type='hidden'><input id='discountNHidden_$i' name='discountNHidden[]' value='$discountNHidden[$i]' type='hidden'><input id='discountNHiddenTotal_$i' name='discountNHiddenTotal[]' value='$discountNHiddenTotal[$i]' type='hidden'><input id='VATHidden_$i' name='VATHidden[]' value='$VATHidden[$i]' type='hidden'><input id='VATHiddenTotal_$i' name='VATHiddenTotal[]' value='$VATHiddenTotal[$i]' type='hidden'><td>$menu_name[$i]</td><td><input class='pri-size txtboxToFilter' onfocus='this.select();' id='price_$i' name='price[]' value='$price[$i]' onblur='return calculateRow($i);' onkeyup='return calculateRow($i)' type='text'></td><td><input class='qty-size txtboxToFilter' onfocus='this.select();' min='1' id='qty_$i' name='qty[]' value='$qty[$i]' onmouseup='return helloThere($i)' onblur='return calculateRow($i);' onkeyup='return checkQuantity($i);' onkeydown='return calculateRow($i);' type='number'></td><td><input class='qty-size discount' onfocus='this.select();'  id='discountN_$i' name='discountN[]' value='$discountN[$i]' onmouseup='return helloThere($i)' onblur='return calculateRow($i);' onkeyup='return checkQuantity($i);' onkeydown='return calculateRow($i);' type='text'></td><td><input class='pri-size' readonly='' id='total_$i' name='total[]' style='background-color: #dddddd;border:1px solid #7e7f7f;' value='$total[$i]' type='text'></td><td style='text-align: center'><a class='btn btn-danger btn-xs' onclick='return deleter($i,$value);'><i style='color:white' class='fa fa-trash'></i></a></td></tr>";
                $i++;
            }
            $customer_id = $this->input->get('customer_id');
            $total_item_hidden = $this->input->get('total_items');
            $sub_total = $this->input->get('sub_total');
            $disc = $this->input->get('disc');
            $disc_actual = $this->input->get('disc_actual');
            $vat = $this->input->get('vat');
            $total_payable = $this->input->get('total_payable');
            $tables = $tableRow;

            $this->session->set_userdata('customer_id_' . $temp, $customer_id);
            $this->session->set_userdata('total_item_hidden_' . $temp, $total_item_hidden);
            $this->session->set_userdata('sub_total_' . $temp, $sub_total);
            $this->session->set_userdata('disc_' . $temp, $disc);
            $this->session->set_userdata('disc_actual_' . $temp, $disc_actual);
            $this->session->set_userdata('vat_' . $temp, $vat);
            $this->session->set_userdata('total_payable_' . $temp, $total_payable);
            $this->session->set_userdata('tables_' . $temp, $tables);
            $data['suspend_id'] = $temp;

            echo json_encode($data);
        }
    }

    public function setServiceSession() {
        $serviceValue = $this->input->get('serviceValue');
        $this->session->set_userdata('serviceSession', $serviceValue);
    }

    public function getServiceSession() {
        $serviceValue = $this->session->userdata['serviceSession'];
        $data['serviceData'] = $serviceValue;
        echo json_encode($data);
    }

    public function view($sales_id=3) {
        $sales_id = $this->custom->encrypt_decrypt($sales_id, 'decrypt');

        $outlet_id = $this->session->userdata('outlet_id');
        $data = array();
        $data['info'] = $this->Sale_model->getSaleInfo($sales_id);
        $data['details'] = $this->Sale_model->getSaleDetails($sales_id);
        //$data['main_content'] = $this->load->view('sale/print', $data, TRUE);
        $this->load->view('sale/print', $data);
    }

    public function view_A4($sales_id) {
        $sales_id = $this->custom->encrypt_decrypt($sales_id, 'decrypt');
        $outlet_id = $this->session->userdata('outlet_id');
        $data = array();
        $data['info'] = $this->Sale_model->getSaleInfo($sales_id);
        $data['details'] = $this->Sale_model->getSaleDetails($sales_id);
        //$data['main_content'] = $this->load->view('sale/print', $data, TRUE);
        $this->load->view('sale/print_A4', $data);
    }

    public function view_invoice($sales_id) {
        $sales_id = $this->custom->encrypt_decrypt($sales_id, 'decrypt');
        $outlet_id = $this->session->userdata('outlet_id');
        $data = array();
        $data['info'] = $this->Sale_model->getSaleInfo($sales_id);
        $data['details'] = $this->Sale_model->getSaleDetails($sales_id);
        //$data['main_content'] = $this->load->view('sale/print', $data, TRUE);
        $this->load->view('sale/print_invoice', $data);
    }

    public function saveSalesItems($item_menu_items, $ingredient_id, $table_name) {
        foreach ($item_menu_items as $row => $ingredient_id):
            $fmi = array();
            $fmi['ingredient_id'] = $ingredient_id;
            $fmi['consumption'] = $_POST['consumption'][$row];
            $fmi['ingredient_id'] = $ingredient_id;
            $fmi['user_id'] = $this->session->userdata('user_id');
            $fmi['outlet_id'] = $this->session->userdata('outlet_id');
            $this->Common_model->insertInformation($fmi, "tbl_sales_items");
        endforeach;
    }

    public function itemMenuDetails($id) {
        $encrypted_id = $id;
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $data = array();
        $data['encrypted_id'] = $encrypted_id;
        $data['item_menu_details'] = $this->Common_model->getDataById($id, "tbl_sales");
        $data['main_content'] = $this->load->view('sale/itemMenuDetails', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    function addNewCustomerByAjax() {
        $data['name'] = $_GET['customer_name'];
        $data['phone'] = $_GET['mobile_no'];
        $data['email'] = $_GET['customerEmail'];
        $data['date_of_birth'] = $_GET['customerDateOfBirth'];
        $data['date_of_anniversary'] = $_GET['customerDateOfAnniversary'];
        $data['address'] = $_GET['customerAddress'];
        $data['user_id'] = $this->session->userdata('user_id');
        $data['company_id'] = $this->session->userdata('company_id');
        $this->db->insert('tbl_customers', $data);
        $customer_id = $this->db->insert_id();
        $data1 = array('customer_id' => $customer_id);
        echo json_encode($data1);
    }

    function getEncriptValue() {
        $id = $this->custom->encrypt_decrypt($_GET['sales_id'], 'encrypt');
        $data['encriptID'] = $id;
        echo json_encode($data);
    }

    function getCustomerList() {
        $company_id = $this->session->userdata('company_id');
        $data1 = $this->db->query("SELECT * FROM tbl_customers 
              WHERE company_id=$company_id")->result();
        foreach ($data1 as $value) {
            if ($value->name == "Walk-in Customer") {
                echo '<option value="' . $value->id . '" >' . $value->name . '</option>';
            }
        }
        foreach ($data1 as $value) {
            if ($value->name != "Walk-in Customer") {
                echo '<option value="' . $value->id . '" >' . $value->name . ' (' . $value->phone . ')' . '</option>';
            }
        }
        exit;
    }
    function add_customer_by_ajax(){
        $dob = explode("-",$this->input->post($this->security->xss_clean('customer_dob')));
        $doa = explode("-",$this->input->post($this->security->xss_clean('customer_doa')));

        $dob2 = explode(" - ",$this->input->post($this->security->xss_clean('customer_dob')));
        $doa2 = explode(" - ",$this->input->post($this->security->xss_clean('customer_doa')));
        $full_dob = null;
        $full_doa = null;
        if(count($dob)==3){
            $full_dob = $dob[2].'-'.$dob[1].'-'.$dob[0];     
        }elseif(count($dob2)==3){
            $full_dob = $dob2[2].'-'.$dob2[1].'-'.$dob2[0];
        }
        if(count($doa)==3){
            $full_doa = $doa[2].'-'.$doa[1].'-'.$doa[0];
        }if(count($doa2)==3){
            $full_doa = $doa2[2].'-'.$doa2[1].'-'.$doa2[0];
        }
        $customer_id = $this->input->post($this->security->xss_clean('customer_id'));
        $data['name'] = trim(htmlspecialchars($this->input->post($this->security->xss_clean('customer_name'))));
        $data['phone'] = trim(htmlspecialchars($this->input->post($this->security->xss_clean('customer_phone'))));
        $data['email'] = trim($this->input->post($this->security->xss_clean('customer_email')));
        $data['date_of_birth'] = date('Y-m-d',strtotime($full_dob));
        $data['date_of_anniversary'] = date('Y-m-d',strtotime($full_doa));
        $data['address'] = trim(preg_replace('/\s+/', ' ', $this->input->post($this->security->xss_clean('customer_delivery_address'))));
        $data['gst_number'] = trim($this->input->post($this->security->xss_clean('customer_gst_number')));
        $data['user_id'] = $this->session->userdata('user_id');
        $data['company_id'] = $this->session->userdata('company_id');
        if($customer_id>0 && $customer_id!=""){
            $this->db->where('id', $customer_id);
            $this->db->update('tbl_customers', $data); 
        }else{
            $this->db->insert('tbl_customers', $data);
        }
        echo 1 ;
    }
    function get_all_customers_for_this_user(){
        $company_id = $this->session->userdata('company_id');
        $data1 = $this->db->query("SELECT * FROM tbl_customers 
              WHERE company_id=$company_id")->result();  
        echo json_encode($data1);      
    }
    function add_sale_by_ajax(){
        $order_details = json_decode(json_decode($this->input->post('order')));
        $orders_table = json_decode(json_decode($this->input->post('orders_table')));
        //this id will be 0 when there is new order, but will be greater then 0 when there is modification
        //on previous order
        $sale_id = $this->input->post('sale_id');
        $close_order = $this->input->post('close_order');
        // echo "<pre>"; var_dump($order_details->items); echo"</pre>"; exit;
        $data = array();
        $data['customer_id'] = trim($order_details->customer_id);
        $data['total_items'] = trim($order_details->total_items_in_cart);
        $data['sub_total'] = trim($order_details->sub_total);
        $data['vat'] = trim($order_details->total_vat);
        // if($order_details->selected_table!=0){
        //     $data['table_id'] = trim($order_details->selected_table);
        // }
        

        $data['total_payable'] = trim($order_details->total_payable);
        $data['total_item_discount_amount'] = trim($order_details->total_item_discount_amount);
        $data['sub_total_with_discount'] = trim($order_details->sub_total_with_discount);
        $data['sub_total_discount_amount'] = trim($order_details->sub_total_discount_amount);
        $data['total_discount_amount'] = trim($order_details->total_discount_amount);
        $data['delivery_charge'] = trim($order_details->delivery_charge);
        $data['sub_total_discount_value'] = trim($order_details->sub_total_discount_value);
        $data['sub_total_discount_type'] = trim($order_details->sub_total_discount_type);
        $data['user_id'] = $this->session->userdata('user_id');
        $data['waiter_id'] = trim($order_details->waiter_id);
        $data['outlet_id'] = $this->session->userdata('outlet_id');
        $data['sale_date'] = date('Y-m-d');
        $data['date_time'] = date('Y-m-d H:i:s');
        $data['order_time'] = date("H:i:s"); 
        $data['order_status'] = trim($order_details->order_status);
        $data['sale_vat_objects'] = json_encode($order_details->sale_vat_objects);
        $data['order_type'] = trim($order_details->order_type);
        $outlet_id = $this->session->userdata('outlet_id');
        // $sale_no = $this->db->query("SELECT count(id) as bno
        //        FROM tbl_sales WHERE outlet_id=$outlet_id")->row('bno');
        // $sale_no = str_pad($sale_no + 1, 6, '0', STR_PAD_LEFT);
        // $data['sale_no'] = $sale_no;
        $this->db->trans_begin();
        if($sale_id>0){
            $data['modified'] = 'Yes';
            $this->db->where('id', $sale_id);
            $this->db->update('tbl_sales', $data); 
            
            //this section sends notification to bar/kitchen panel if there is any modification 
            $single_table_information = $this->get_all_information_of_a_sale($sale_id);
            $order_number = '';
            if($single_table_information->order_type==1){
                $order_number = 'A '.$single_table_information->sale_no;
            }else if($single_table_information->order_type==2){
                $order_number = 'B '.$single_table_information->sale_no;
            }else if($single_table_information->order_type==3){
                $order_number = 'C '.$single_table_information->sale_no;
            }
            $notification_message = 'Order:'.$order_number.' has been modified';
            $bar_kitchen_notification_data = array();
            $bar_kitchen_notification_data['notification'] = $notification_message;
            $bar_kitchen_notification_data['outlet_id'] = $this->session->userdata('outlet_id');;
            $query = $this->db->insert('tbl_notification_bar_kitchen_panel', $bar_kitchen_notification_data);
            //end of send notification process

            $this->db->delete('tbl_sales_details', array('sales_id' => $sale_id));    
            $this->db->delete('tbl_sales_details_modifiers', array('sales_id' => $sale_id));
            $this->db->delete('tbl_sale_consumptions', array('sale_id' => $sale_id));    
            $this->db->delete('tbl_sale_consumptions_of_menus', array('sales_id' => $sale_id));
            $this->db->delete('tbl_sale_consumptions_of_modifiers_of_menus', array('sales_id' => $sale_id));

            $sales_id = $sale_id;
            $sale_no = str_pad($sales_id, 6, '0', STR_PAD_LEFT);
        }else{
            $query = $this->db->insert('tbl_sales', $data);
            $sales_id = $this->db->insert_id();
            $sale_no = str_pad($sales_id, 6, '0', STR_PAD_LEFT);
            $sale_no_update_array = array('sale_no' => $sale_no);
            $this->db->where('id', $sales_id);
            $this->db->update('tbl_sales', $sale_no_update_array);
        }
        foreach($order_details->orders_table as $single_order_table){
            $order_table_info = array();
            $order_table_info['persons'] = $single_order_table->persons;
            $order_table_info['booking_time'] = date('Y-m-d H:i:s');
            $order_table_info['sale_id'] = $sales_id;
            $order_table_info['sale_no'] = $sale_no;
            $order_table_info['outlet_id'] = $this->session->userdata('outlet_id');
            $order_table_info['table_id'] = $single_order_table->table_id; 
            
            $query = $this->db->insert('tbl_orders_table',$order_table_info);
        }
        $data_sale_consumptions = array();
        $data_sale_consumptions['sale_id'] = $sales_id;
        $data_sale_consumptions['user_id'] = $this->session->userdata('user_id'); 
        $data_sale_consumptions['outlet_id'] = $this->session->userdata('outlet_id');
        $data_sale_consumptions['del_status'] = 'Live'; 
        $query = $this->db->insert('tbl_sale_consumptions',$data_sale_consumptions);
        $sale_consumption_id = $this->db->insert_id();

        if($sales_id>0 && count($order_details->items)>0){
            foreach($order_details->items as $item){
                
                 
                $item_date = array();
                $item_data['food_menu_id'] = $item->item_id;
                $item_data['menu_name'] = $item->item_name;
                $item_data['qty'] = $item->item_quantity;
                $item_data['menu_price_without_discount'] = $item->item_price_without_discount;
                $item_data['menu_price_with_discount'] = $item->item_price_with_discount;
                $item_data['menu_unit_price'] = $item->item_unit_price;
                $item_data['menu_taxes'] = json_encode($item->item_vat);
                $item_data['menu_discount_value'] = $item->item_discount;
                $item_data['discount_type'] = $item->discount_type;
                $item_data['menu_note'] = $item->item_note;
                $item_data['discount_amount'] = $item->item_discount_amount;
                $item_data['item_type'] = ($this->Sale_model->getItemType($item->item_id)->item_type=="Bar No")?"Kitchen Item":"Bar Item";
                $item_data['cooking_status'] = ($item->item_cooking_status=="")?NULL:$item->item_cooking_status;
                $item_data['cooking_start_time'] = ($item->item_cooking_start_time=="" || $item->item_cooking_start_time=="0000-00-00 00:00:00")?'0000-00-00 00:00:00':date('Y-m-d H:i:s',strtotime($item->item_cooking_start_time));
                $item_data['cooking_done_time'] = ($item->item_cooking_done_time=="" || $item->item_cooking_done_time=="0000-00-00 00:00:00")?'0000-00-00 00:00:00':date('Y-m-d H:i:s',strtotime($item->item_cooking_done_time));
                $item_data['previous_id'] = ($item->item_previous_id=="")?0:$item->item_previous_id;
                $item_data['sales_id'] = $sales_id;
                $item_data['user_id'] = $this->session->userdata('user_id');
                $item_data['outlet_id'] = $this->session->userdata('outlet_id');
                $item_data['del_status'] = 'Live';
                $query = $this->db->insert('tbl_sales_details', $item_data);
                $sales_details_id = $this->db->insert_id();

                if($item->item_previous_id==""){
                    $previous_id_update_array = array('previous_id' => $sales_details_id);
                    $this->db->where('id', $sales_details_id);
                    $this->db->update('tbl_sales_details', $previous_id_update_array);
                }
                
                
                $food_menu_ingredients = $this->db->query("SELECT * FROM tbl_food_menus_ingredients WHERE food_menu_id=$item->item_id")->result();

                foreach($food_menu_ingredients as $single_ingredient){
                    
                    $data_sale_consumptions_detail = array();
                    $data_sale_consumptions_detail['ingredient_id'] = $single_ingredient->ingredient_id;
                    $data_sale_consumptions_detail['consumption'] = $item->item_quantity*$single_ingredient->consumption; 
                    $data_sale_consumptions_detail['sale_consumption_id'] = $sale_consumption_id;
                    $data_sale_consumptions_detail['sales_id'] = $sales_id;
                    $data_sale_consumptions_detail['food_menu_id'] = $item->item_id;
                    $data_sale_consumptions_detail['user_id'] = $this->session->userdata('outlet_id');
                    $data_sale_consumptions_detail['outlet_id'] = $this->session->userdata('outlet_id');
                    $data_sale_consumptions_detail['del_status'] = 'Live'; 
                    $query = $this->db->insert('tbl_sale_consumptions_of_menus',$data_sale_consumptions_detail);    
                }

                $modifier_id_array = ($item->modifiers_id!="")?explode(",",$item->modifiers_id):null;
                $modifier_price_array = ($item->modifiers_price!="")?explode(",",$item->modifiers_price):null;

                if(!empty($modifier_id_array)>0){
                    $i = 0;
                    foreach($modifier_id_array as $single_modifier_id){
                        $modifier_data = array();
                        $modifier_data['modifier_id'] =$single_modifier_id; 
                        $modifier_data['modifier_price'] = $modifier_price_array[$i]; 
                        $modifier_data['food_menu_id'] = $item->item_id; 
                        $modifier_data['sales_id'] = $sales_id; 
                        $modifier_data['sales_details_id'] = $sales_details_id; 
                        $modifier_data['user_id'] = $this->session->userdata('user_id');
                        $modifier_data['outlet_id'] = $this->session->userdata('outlet_id'); 
                        $modifier_data['customer_id'] =$order_details->customer_id;
                        $query = $this->db->insert('tbl_sales_details_modifiers', $modifier_data);
                        
                        $modifier_ingredients = $this->db->query("SELECT * FROM tbl_modifier_ingredients WHERE modifier_id=$single_modifier_id")->result();

                        foreach($modifier_ingredients as $single_ingredient){
                            $data_sale_consumptions_detail = array();
                            $data_sale_consumptions_detail['ingredient_id'] = $single_ingredient->ingredient_id;
                            $data_sale_consumptions_detail['consumption'] = $item->item_quantity*$single_ingredient->consumption; 
                            $data_sale_consumptions_detail['sale_consumption_id'] = $sale_consumption_id;
                            $data_sale_consumptions_detail['sales_id'] = $sales_id;
                            $data_sale_consumptions_detail['food_menu_id'] = $item->item_id;
                            $data_sale_consumptions_detail['user_id'] = $this->session->userdata('outlet_id');
                            $data_sale_consumptions_detail['outlet_id'] = $this->session->userdata('outlet_id');
                            $data_sale_consumptions_detail['del_status'] = 'Live'; 
                            $query = $this->db->insert('tbl_sale_consumptions_of_modifiers_of_menus',$data_sale_consumptions_detail);    
                        }

                        $i++;
                    }    
                }
            }
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            echo $sales_id;
            $this->db->trans_commit();
        }
        if($close_order==1){
            $sale_id = $sales_id;
            $paid_amount = $order_details->total_payable;
            $payment_method_id = $this->Sale_model->getCashMethod()->id;
            $this->Sale_model->delete_status_orders_table($sale_id);
            $order_status = array('paid_amount' =>  $paid_amount, 'order_status' => 3,'payment_method_id'=>$payment_method_id,'close_time'=>date('H:i:s'));
            $this->db->where('id', $sale_id);
            $this->db->update('tbl_sales', $order_status);
        }
        
    }
    function get_new_orders_ajax(){
        $data1 = $this->get_new_orders();
        echo json_encode($data1);        
    }
    function get_new_orders(){
        $outlet_id = $this->session->userdata('outlet_id');
        $user_id = $this->session->userdata('user_id');
        $data1 = $this->Sale_model->getNewOrders($outlet_id);
        $i = 0;
        for($i;$i<count($data1);$i++){
            $data1[$i]->total_kitchen_type_items = $this->Sale_model->get_total_kitchen_type_items($data1[$i]->sale_id);
            $data1[$i]->total_kitchen_type_done_items = $this->Sale_model->get_total_kitchen_type_done_items($data1[$i]->sale_id);
            $data1[$i]->total_kitchen_type_started_cooking_items = $this->Sale_model->get_total_kitchen_type_started_cooking_items($data1[$i]->sale_id);
            $data1[$i]->tables_booked = $this->Sale_model->get_all_tables_of_a_sale_items($data1[$i]->sale_id);
            
            $to_time = strtotime(date('Y-m-d H:i:s'));
            $from_time = strtotime($data1[$i]->date_time);
            $minutes = floor(abs($to_time - $from_time) / 60);
            $seconds = abs($to_time - $from_time) % 60;

            $data1[$i]->minute_difference = str_pad(floor($minutes), 2, "0", STR_PAD_LEFT);
            $data1[$i]->second_difference = str_pad(floor($seconds), 2, "0", STR_PAD_LEFT);
        }
        return $data1;
    }
    function get_all_tables_with_new_status_ajax(){
        $outlet_id = $this->session->userdata('outlet_id');
        $tables = $this->Sale_model->getTablesByOutletId($outlet_id);
        $data1 = new \stdClass();
        $data1->table_details = $this->getTablesDetails($tables);
        $data1->table_availability = $this->Sale_model->getTableAvailability($outlet_id);
        // $data1 = $this->Sale_model->getAllTablesWithNewStatus($outlet_id);        
        echo json_encode($data1);
    }
    function get_all_information_of_a_sale_ajax(){
        $sales_id = $this->input->post('sale_id');
        $sale_object = $this->get_all_information_of_a_sale($sales_id);
        echo json_encode($sale_object);
    }
    public function get_all_information_of_a_sale_by_table_id_ajax()
    {
        $table_id = $this->input->post('table_id');
        $sale_info = $this->Sale_model->get_new_sale_by_table_id($table_id);
        $sale_id = $sale_info->id;
        $sale_object = $this->get_all_information_of_a_sale($sale_id);
        echo json_encode($sale_object);
    }
    function get_all_information_of_a_sale($sales_id){
        $sales_information = $this->Sale_model->getSaleBySaleId($sales_id);
        $items_by_sales_id = $this->Sale_model->getAllItemsFromSalesDetailBySalesId($sales_id);
        foreach($items_by_sales_id as $single_item_by_sale_id){
            $modifier_information = $this->Sale_model->getModifiersBySaleAndSaleDetailsId($sales_id,$single_item_by_sale_id->sales_details_id);
            $single_item_by_sale_id->modifiers = $modifier_information;
        }
        $sales_details_objects = $items_by_sales_id;
        $sale_object = $sales_information[0];
        $sale_object->items = $sales_details_objects;
        $sale_object->tables_booked = $this->Sale_model->get_all_tables_of_a_sale_items($sales_id);
        return $sale_object;
    }
    function print_kot($sale_id){
        $data['sale_object'] = $this->get_all_information_of_a_sale($sale_id);
        $this->load->view('sale/print_kot',$data);        
    }
    function print_invoice($sale_id){
        $data['sale_object'] = $this->get_all_information_of_a_sale($sale_id);
        $this->load->view('sale/print_invoice',$data);
    }
    function get_new_hold_number_ajax(){
        $outlet_id = $this->session->userdata('outlet_id');
        $user_id = $this->session->userdata('user_id');
        $number_of_holds_of_this_user_and_outlet = $this->get_current_hold();
        $number_of_holds_of_this_user_and_outlet++;
        echo $number_of_holds_of_this_user_and_outlet;
    }
    function get_current_hold(){
        $outlet_id = $this->session->userdata('outlet_id');
        $user_id = $this->session->userdata('user_id');
        $number_of_holds = $this->Sale_model->getNumberOfHoldsByUserAndOutletId($outlet_id,$user_id);
        return $number_of_holds;
    }
    public function add_hold_by_ajax()
    {
        $order_details = json_decode(json_decode($this->input->post('order')));
        $hold_number = trim($this->input->post('hold_number'));
        // echo "<pre>"; var_dump($order_details->items); echo"</pre>"; exit;
        $data = array();
        $data['customer_id'] = trim($order_details->customer_id);
        $data['total_items'] = trim($order_details->total_items_in_cart);
        $data['sub_total'] = trim($order_details->sub_total);
        $data['vat'] = trim($order_details->total_vat);
        $data['table_id'] = trim($order_details->selected_table);

        $data['total_payable'] = trim($order_details->total_payable);
        $data['total_item_discount_amount'] = trim($order_details->total_item_discount_amount);
        $data['sub_total_with_discount'] = trim($order_details->sub_total_with_discount);
        $data['sub_total_discount_amount'] = trim($order_details->sub_total_discount_amount);
        $data['total_discount_amount'] = trim($order_details->total_discount_amount);
        $data['delivery_charge'] = trim($order_details->delivery_charge);
        $data['sub_total_discount_value'] = trim($order_details->sub_total_discount_value);
        $data['sub_total_discount_type'] = trim($order_details->sub_total_discount_type);
        $data['user_id'] = $this->session->userdata('user_id');
        $data['waiter_id'] = trim($order_details->waiter_id);
        $data['outlet_id'] = $this->session->userdata('outlet_id');
        $data['sale_date'] = date('Y-m-d');
        $data['sale_time'] = date('Y-m-d h:i A');
        $data['order_status'] = trim($order_details->order_status);
        $data['sale_vat_objects'] = json_encode($order_details->sale_vat_objects);
        $data['order_type'] = trim($order_details->order_type);
        $outlet_id = $this->session->userdata('outlet_id');
        if($hold_number===0 || $hold_number===""){
            $current_hold_order = $this->get_current_hold();
            echo "current hold".$current_hold_order."<br/>";
            $hold_number = $current_hold_order+1;
        }
        $data['hold_no'] = $hold_number;
        $query = $this->db->insert('tbl_holds', $data);
        $holds_id = $this->db->insert_id();
        
        if($holds_id>0 && count($order_details->items)>0){
            foreach($order_details->items as $item){
                $item_date = array();
                $item_data['food_menu_id'] = $item->item_id;
                $item_data['menu_name'] = $item->item_name;
                $item_data['qty'] = $item->item_quantity;
                $item_data['menu_price_without_discount'] = $item->item_price_without_discount;
                $item_data['menu_price_with_discount'] = $item->item_price_with_discount;
                $item_data['menu_unit_price'] = $item->item_unit_price;
                // $item_data['menu_vat_percentage'] = $item->item_vat;
                $item_data['menu_taxes'] = json_encode($item->item_vat);
                $item_data['menu_discount_value'] = $item->item_discount;
                $item_data['discount_type'] = $item->discount_type;
                $item_data['menu_note'] = $item->item_note;
                $item_data['discount_amount'] = $item->item_discount_amount;
                $item_data['holds_id'] = $holds_id;
                $item_data['user_id'] = $this->session->userdata('user_id');
                $item_data['outlet_id'] = $this->session->userdata('outlet_id');
                $item_data['del_status'] = 'Live';
                $query = $this->db->insert('tbl_holds_details', $item_data);
                $holds_details_id = $this->db->insert_id();
                
                $modifier_id_array = ($item->modifiers_id!="")?explode(",",$item->modifiers_id):null;
                $modifier_price_array = ($item->modifiers_price!="")?explode(",",$item->modifiers_price):null;

                if(!empty($modifier_id_array)>0){
                    $i = 0;
                    foreach($modifier_id_array as $single_modifier_id){
                        $modifier_data = array();
                        $modifier_data['modifier_id'] =$single_modifier_id; 
                        $modifier_data['modifier_price'] = $modifier_price_array[$i]; 
                        $modifier_data['food_menu_id'] = $item->item_id; 
                        $modifier_data['holds_id'] = $holds_id; 
                        $modifier_data['holds_details_id'] = $holds_details_id; 
                        $modifier_data['user_id'] = $this->session->userdata('user_id');
                        $modifier_data['outlet_id'] = $this->session->userdata('outlet_id'); 
                        $modifier_data['customer_id'] =$order_details->customer_id;
                        $query = $this->db->insert('tbl_holds_details_modifiers', $modifier_data);
                        
                        $i++;
                    }    
                }
            }
        }
        
        echo $holds_id;        
    }
    public function get_all_holds_ajax(){
        $outlet_id = $this->session->userdata('outlet_id');
        $user_id = $this->session->userdata('user_id');
        $holds_information = $this->Sale_model->getHoldsByOutletAndUserId($outlet_id,$user_id);
        echo json_encode($holds_information);
    }
    public function get_last_10_sales_ajax(){
        $outlet_id = $this->session->userdata('outlet_id');
        $user_id = $this->session->userdata('user_id');
        $sales_information = $this->Sale_model->getLastTenSalesByOutletAndUserId($outlet_id);
        foreach($sales_information as $single_sale_information){
            $single_sale_information->tables_booked = $this->Sale_model->get_all_tables_of_a_last_sale($single_sale_information->id);
        }
        echo json_encode($sales_information);
    }
    public function get_single_hold_info_by_ajax()
    {
        $hold_id = $this->input->post('hold_id');
        $hold_information = $this->Sale_model->get_hold_info_by_hold_id($hold_id);
        $items_by_holds_id = $this->Sale_model->getAllItemsFromHoldsDetailByHoldsId($hold_id);
        foreach($items_by_holds_id as $single_item_by_hold_id){
            $modifier_information = $this->Sale_model->getModifiersByHoldAndHoldsDetailsId($hold_id,$single_item_by_hold_id->holds_details_id);
            $single_item_by_hold_id->modifiers = $modifier_information;
        }
        $holds_details_objects = $items_by_holds_id;
        $hold_object = $hold_information[0];
        $hold_object->items = $holds_details_objects;
        echo json_encode($hold_object);

    }
    public function delete_all_information_of_hold_by_ajax()
    {
        $hold_id = $this->input->post('hold_id');
        $this->db->delete('tbl_holds', array('id' => $hold_id));    
        $this->db->delete('tbl_holds_details', array('holds_id' => $hold_id));    
        $this->db->delete('tbl_holds_details_modifiers', array('holds_id' => $hold_id));    
    }
    public function check_customer_address_ajax()
    {
        $customer_id = $this->input->post('customer_id');
        $customer_info = $this->Sale_model->getCustomerInfoById($customer_id);
        echo json_encode($customer_info);
    }
    public function get_customer_ajax()
    {
        $customer_id = $this->input->post('customer_id');
        $customer_info = $this->Sale_model->getCustomerInfoById($customer_id);
        echo json_encode($customer_info);
    }
    public function cancel_particular_order_ajax()
    {
        $sale_id = $this->input->post('sale_id');
        $this->delete_specific_order_by_sale_id($sale_id); 
    }
    public function delete_specific_order_by_sale_id($sale_id){
        $this->db->delete('tbl_sales', array('id' => $sale_id));    
        $this->db->delete('tbl_sales_details', array('sales_id' => $sale_id));    
        $this->db->delete('tbl_sales_details_modifiers', array('sales_id' => $sale_id));
        $this->db->delete('tbl_sale_consumptions', array('sale_id' => $sale_id));    
        $this->db->delete('tbl_sale_consumptions_of_menus', array('sales_id' => $sale_id));
        $this->db->delete('tbl_sale_consumptions_of_modifiers_of_menus', array('sales_id' => $sale_id));
        $this->db->delete('tbl_orders_table', array('sale_id' => $sale_id));
        return true;
    }
    public function update_order_status_ajax()
    {
        $sale_id = $this->input->post('sale_id');
        $close_order = $this->input->post('close_order');
        $paid_amount = $this->input->post('paid_amount');
        $due_amount = $this->input->post('due_amount');
        $payment_method_type = $this->input->post('payment_method_type');
        $is_just_cloase = ($payment_method_type=='0')? true:false;
        if($close_order=='true'){
            $this->Sale_model->delete_status_orders_table($sale_id);
            // $this->db->delete('tbl_orders_table', array('sale_id' => $sale_id));
            if($is_just_cloase){
                $order_status = array('order_status' => 3,'close_time'=>date('H:i:s'));
            }else{
                $order_status = array('paid_amount' =>  $paid_amount, 'due_amount' => $due_amount, 'order_status' => 3,'payment_method_id'=>$payment_method_type,'close_time'=>date('H:i:s'));    
            }
            
        }else{
            $order_status = array('paid_amount' => $paid_amount,'due_amount' => $due_amount,'order_status' => 2,'payment_method_id'=>$payment_method_type);
        }
            
        $this->db->where('id', $sale_id);
        $this->db->update('tbl_sales', $order_status);
        echo $sale_id; 
    }
    public function delete_all_holds_with_information_by_ajax()
    {
        $outlet_id = $this->session->userdata('outlet_id');
        $user_id = $this->session->userdata('user_id');
        $this->db->delete('tbl_holds', array('user_id' => $user_id,'outlet_id' => $outlet_id));
        $this->db->delete('tbl_holds_details', array('user_id' => $user_id,'outlet_id' => $outlet_id));    
        $this->db->delete('tbl_holds_details_modifiers', array('user_id' => $user_id,'outlet_id' => $outlet_id));
        echo 1;
    }
    public function change_date_of_a_sale_ajax()
    {
        $sale_id = $this->input->post('sale_id');
        $change_date = $this->input->post('change_date');
        $data['sale_date'] = date('Y-m-d',strtotime($change_date));
        $data['order_time'] = date("H:i:s");
        $changes = array(
            'sale_date' => date('Y-m-d',strtotime($change_date)), 
            'order_time' => date("H:i:s"),
            'date_time' => date('Y-m-d H:i:s',strtotime($change_date.' '.date("H:i:s")))
        );

        $this->db->where('id', $sale_id);
        $this->db->update('tbl_sales', $changes);
    }
	
	public function getOpeningBalance(){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $date = date('Y-m-d');
        $getOpeningBalance = $this->Sale_model->getOpeningBalance($user_id,$outlet_id,$date);
        return $getOpeningBalance->amount;
    }
    public function getOpeningDateTime(){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $date = date('Y-m-d');
        $getOpeningDateTime = $this->Sale_model->getOpeningDateTime($user_id,$outlet_id,$date);
        return $getOpeningDateTime->opening_date_time;
    }
    public function getClosingDateTime(){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $date = date('Y-m-d');
        $getClosingDateTime = $this->Sale_model->getClosingDateTime($user_id,$outlet_id,$date);
        return $getClosingDateTime->closing_date_time;
    }
    public function getPurchasePaidSum(){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $date = date('Y-m-d');
        $summationOfPaidPurchase = $this->Sale_model->getSummationOfPaidPurchase($user_id,$outlet_id,$date);
        return $summationOfPaidPurchase->purchase_paid;
    }
    public function getSupplierPaymentSum(){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $date = date('Y-m-d');
        $summationOfSupplierPayment = $this->Sale_model->getSummationOfSupplierPayment($user_id,$outlet_id,$date);
        return $summationOfSupplierPayment->payment_amount;
    }
    public function getCustomerDueReceiveAmountSum($date){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $summationOfCustomerDueReceive = $this->Sale_model->getSummationOfCustomerDueReceive($user_id,$outlet_id,$date);
        return $summationOfCustomerDueReceive->receive_amount;
    }
    public function getExpenseAmountSum(){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $date = date('Y-m-d');
        $getExpenseAmountSum = $this->Sale_model->getExpenseAmountSum($user_id,$outlet_id,$date);
        return $getExpenseAmountSum->amount;
    }
    public function getSalePaidSum($date){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $getSalePaidSum = $this->Sale_model->getSalePaidSum($user_id,$outlet_id,$date);
        return $getSalePaidSum->amount;
    }
    public function getSaleDueSum($date){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $getSaleDueSum = $this->Sale_model->getSaleDueSum($user_id,$outlet_id,$date);
        return $getSaleDueSum->amount;
    }
    
    public function getSaleInCashSum($date){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $getSaleInCashSum = $this->Sale_model->getSaleInCashSum($user_id,$outlet_id,$date);
        return $getSaleInCashSum->amount;
    }
    public function getSaleInPaypalSum($date){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $getSaleInPaypalSum = $this->Sale_model->getSaleInPaypalSum($user_id,$outlet_id,$date);
        return $getSaleInPaypalSum->amount;
    }
    public function getSaleInCardSum($date){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $getSaleInCardSum = $this->Sale_model->getSaleInCardSum($user_id,$outlet_id,$date);
        return $getSaleInCardSum->amount;
    }
    public function getSaleInStripeSum(){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $date = date('Y-m-d');
        $getSaleInStripeSum = $this->Sale_model->getSaleInStripeSum($user_id,$outlet_id,$date);
        return $getSaleInStripeSum->amount;
    }
    public function getPayableAomountSum($opening_date_time)
    {
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $getPayableAomountSum = $this->Sale_model->getPayableAomountSum($user_id,$outlet_id,$opening_date_time);
        return $getPayableAomountSum->amount;
    }
    public function registerDetailCalculationToShow(){
        $opening_date_time = $this->getOpeningDateTime();
        $register_detail = array(
            'opening_date_time' => $opening_date_time,
            'closing_date_time' => $this->getClosingDateTime(),
            'opening_balance' => $this->getOpeningBalance(), 
            'sale_total_payable_amount' => $this->getPayableAomountSum($opening_date_time), 
            'sale_paid_amount' => $this->getSalePaidSum($opening_date_time), 
            'sale_due_amount' => $this->getSaleDueSum($opening_date_time), 
            'customer_due_receive' => $this->getCustomerDueReceiveAmountSum($opening_date_time), 
            'sale_in_cash' => $this->getSaleInCashSum($opening_date_time), 
            'sale_in_paypal' => $this->getSaleInPaypalSum($opening_date_time), 
            'sale_in_card' => $this->getSaleInCardSum($opening_date_time)
        );
         
        // array_push($register_detail,$this->getSaleInStripeSum());
        // var_dump($register_detail);
        return $register_detail;   
    }
    public function getBalance(){
        $opening_date_time = $this->getOpeningDateTime();
        $balance = $this->getOpeningBalance()+$this->getSalePaidSum($opening_date_time)+$this->getCustomerDueReceiveAmountSum($opening_date_time);
        return  $balance;
    }
    public function registerDetailCalculationToShowAjax(){
        $all_register_info_values = $this->registerDetailCalculationToShow();
        // return $all_register_info_values;
        echo json_encode($all_register_info_values);
    }
    public function printAllCalculation()
    {
        echo 'opening balance: '.$this->getOpeningBalance().'<br/>';
        echo 'purchase paid sum: '.$this->getPurchasePaidSum().'<br/>';
        echo 'supplier payment sum: '.$this->getSupplierPaymentSum().'<br/>';
        echo 'customer due receive amount sum: '.$this->getCustomerDueReceiveAmountSum().'<br/>';
        echo 'expense amount sum: '.$this->getExpenseAmountSum().'<br/>';
        echo 'sale amount sum: '.$this->getSaleAmountSum().'<br/>';
        echo 'sale in cash sum: '.$this->getSaleInCashSum().'<br/>';
        echo 'sale in paypal sum: '.$this->getSaleInPaypalSum().'<br/>';
        // echo 'sale in paypal sum: '.$this->getSaleInPaypalSum().'<br/>';
        echo 'sale in card sum: '.$this->getSaleInCardSum().'<br/>';
        echo 'sale in stripe sum: '.$this->getSaleInStripeSum().'<br/>';
    }
    public function closeRegister()
    {   
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $opening_date_time = $this->getOpeningDateTime();       
        $payment_method_json = '{';
        $payment_method_json .= '"Cash": '.$this->getSaleInCashSum($opening_date_time).',';
        $payment_method_json .= '"Paypal": '.$this->getSaleInPaypalSum($opening_date_time).',';
        $payment_method_json .= '"Card": '.$this->getSaleInCardSum($opening_date_time).'';
        $payment_method_json .= '}';
        $changes = array(
            'closing_balance' => $this->getBalance(), 
            'closing_balance_date_time' => date("Y-m-d H:i:s"),
            'sale_paid_amount' => $this->getSalePaidSum($opening_date_time),
            'customer_due_receive' => $this->getCustomerDueReceiveAmountSum($opening_date_time),
            'payment_methods_sale' => $payment_method_json,
            'register_status' => 2
        );

        $this->db->where('outlet_id', $outlet_id);
        $this->db->where('user_id', $user_id);
        $this->db->where('opening_balance_date_time', $opening_date_time);
        $this->db->where('register_status', 1);
        $this->db->update('tbl_register', $changes);
    }
    public function get_new_notification()
    {
        $outlet_id = $this->session->userdata('outlet_id');
        $notifications = $this->Sale_model->getNotificationByOutletId($outlet_id);
        return $notifications;
    }
    public function get_new_notifications_ajax()
    {
        echo json_encode($this->get_new_notification());        
    }
    public function remove_notication_ajax()
    {
        $notification_id = $this->input->post('notification_id');
        $this->db->delete('tbl_notifications', array('id' => $notification_id));
        echo $notification_id;        
    }
    public function remove_multiple_notification_ajax()
    {
        $notifications = $this->input->post('notifications');
        $notifications_array = explode(",",$notifications);
        foreach($notifications_array as $single_notification){
            $this->db->delete('tbl_notifications', array('id' => $single_notification));
        } 
    }
    public function add_temp_kot_ajax()
    {
        $order = json_decode($this->input->post('order'));
        $data['temp_kot_info'] = $order;
        $query = $this->db->insert('tbl_temp_kot', $data);
        $temp_kot_id = $this->db->insert_id();
        echo $temp_kot_id;
    }
    public function print_temp_kot($temp_kot_id){
        $data['temp_kot_info'] = $this->Sale_model->get_temp_kot($temp_kot_id);        
        $this->db->delete('tbl_temp_kot', array('id' => $temp_kot_id));         
        $this->load->view('sale/print_kot_temp',$data); 
    }
    public function remove_a_table_booking_ajax()
    {
        $orders_table_id = $this->input->post('orders_table_id');
        $orders_table_single_info = $this->Common_model->getDataById($orders_table_id, "tbl_orders_table");        
        $this->db->delete('tbl_orders_table', array('id' => $orders_table_id));         
        echo json_encode($orders_table_single_info);
    }
    public function get_all_assets_info_by_ajax()
    {
        $outlet_id = $this->session->userdata('outlet_id');
        // echo $outlet_id;
        $assets = $this->Sale_model->get_all_assets($outlet_id);
        $data = new \stdClass();
        $data->assets_info = $this->assets_details($assets);
        echo json_encode($data);
    }
    public function assets_details($assets)     
    {
        foreach($assets as $asset){
            $asset->asset_games = $this->Sale_model->getGamesOfAssetByAssetId($asset->id);
        }
        return $assets;        
    }
    
    
    /* ----------------------Sale End-------------------------- */
}
