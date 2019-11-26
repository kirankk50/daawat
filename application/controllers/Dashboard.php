<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->model('Dashboard_model');
        $this->load->model('Inventory_model');
        $this->load->model('Report_model');
        $this->Common_model->setDefaultTimezone();
        $this->load->library('form_validation');
        
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }

        if (!$this->session->has_userdata('outlet_id')) {
            $this->session->set_flashdata('exception_2',lang('please_click_green_button'));

            $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
            $this->session->set_userdata("clicked_method", $this->uri->segment(2));
            redirect('Outlet/outlets');
        }

        $getAccessURL = $this->uri->segment(1);
        if (!in_array($getAccessURL, $this->session->userdata('menu_access'))) {
            redirect('Authentication/userProfile');
        }
    }

    /* ----------------------Dashboard Menu Start-------------------------- */

    public function dashboard() { 
        /*        
        if (!$this->session->has_userdata('outlet_id')) {
            redirect('Authentication/index');
        }
        
        $data = array();
        if ($_POST) {
            $month = $this->input->post('month');
        } else {
            $month = date('Y-m');

            $monthOnly = date('m', strtotime($month));
            $finalDayByMonth = $this->Report_model->getLastDayInDateMonth($monthOnly);

            $temp = $month . '-' . $finalDayByMonth;
            $start_date = $month . '-' . '01';
            $end_date = $temp;
        } 

        $data['purchasePaid'] = $this->Dashboard_model->getPurchasePaidAmount($month);
        $data['totalPurchase'] = $this->Dashboard_model->getPurchaseAmount($month);
        $data['DuepaymentAmount'] = $this->Dashboard_model->getSupplierPaidAmount($month);
        $data['totalSale'] = $this->Dashboard_model->getSalePaidAmount($month);
        $data['totalSaleCash'] = $this->Dashboard_model->getSalePaidAmount($month, 1);
        $data['totalSaleCard'] = $this->Dashboard_model->getSalePaidAmount($month, 2);
        $data['totalSaleVat'] = $this->Dashboard_model->getSaleVat($month);
        $data['totalWaste'] = $this->Dashboard_model->getWaste($month);
        $data['totalExpense'] = $this->Dashboard_model->getExpense($month);
        $data['currentInventory'] = $this->Dashboard_model->currentInventory();
        $data['top_ten_food_menu'] = $this->Dashboard_model->top_ten_food_menu($start_date, $end_date);
        $data['top_ten_supplier_payable'] = $this->Dashboard_model->top_ten_supplier_payable();
        */

        $first_day_this_month = date('Y-m-01');  
        $last_day_this_month  = date('Y-m-t');  

        $data['food_menu_count'] = $this->Dashboard_model->countData('tbl_food_menus');
        $data['ingredient_count'] = $this->Dashboard_model->countData('tbl_ingredients');
        $data['customer_count'] = $this->Dashboard_model->countData('tbl_customers');
        $data['employee_count'] = $this->Dashboard_model->countData('tbl_users');

        $data['low_stock_ingredients'] = $this->Inventory_model->getInventoryAlertList(); 
        $data['top_ten_food_menu'] = $this->Dashboard_model->top_ten_food_menu($first_day_this_month, $last_day_this_month);
        $data['top_ten_customer'] = $this->Dashboard_model->top_ten_customer($first_day_this_month, $last_day_this_month);
        $data['customer_receivable'] = $this->Dashboard_model->customer_receivable();  
        $data['supplier_payable'] = $this->Dashboard_model->supplier_payable();   

        $data['dinein_count'] = $this->Dashboard_model->dinein_count($first_day_this_month, $last_day_this_month);  
        $data['take_away_count'] = $this->Dashboard_model->take_away_count($first_day_this_month, $last_day_this_month);     
        $data['delivery_count'] = $this->Dashboard_model->delivery_count($first_day_this_month, $last_day_this_month); 

        $data['purchase_sum'] = $this->Dashboard_model->purchase_sum($first_day_this_month, $last_day_this_month);  
        $data['sale_sum'] = $this->Dashboard_model->sale_sum($first_day_this_month, $last_day_this_month);  
        $data['waste_sum'] = $this->Dashboard_model->waste_sum($first_day_this_month, $last_day_this_month);  
        $data['expense_sum'] = $this->Dashboard_model->expense_sum($first_day_this_month, $last_day_this_month);  
        $data['customer_due_receive_sum'] = $this->Dashboard_model->customer_due_receive_sum($first_day_this_month, $last_day_this_month);  
        $data['supplier_due_payment_sum'] = $this->Dashboard_model->supplier_due_payment_sum($first_day_this_month, $last_day_this_month);   

        $data['main_content'] = $this->load->view('dashboard/dashboard', $data, TRUE);
        $this->load->view('userHome', $data);
    }
    function operation_comparision_by_date_ajax(){
        $from_this_day = $this->input->post('from_this_day');
        $to_this_day = $this->input->post('to_this_day');
        
        $data = array();

        $data['purchase_sum'] = $this->Dashboard_model->purchase_sum($from_this_day, $to_this_day);  
        $data['sale_sum'] = $this->Dashboard_model->sale_sum($from_this_day, $to_this_day);  
        $data['waste_sum'] = $this->Dashboard_model->waste_sum($from_this_day, $to_this_day);  
        $data['expense_sum'] = $this->Dashboard_model->expense_sum($from_this_day, $to_this_day);  
        $data['customer_due_receive_sum'] = $this->Dashboard_model->customer_due_receive_sum($from_this_day, $to_this_day);  
        $data['supplier_due_payment_sum'] = $this->Dashboard_model->supplier_due_payment_sum($from_this_day, $to_this_day);
        $data['from_this_day'] = $from_this_day;
        $data['to_this_day'] = $to_this_day;
        echo json_encode($data);
    }
    function comparison_sale_report_ajax_get() {
        $selectedMonth = $_GET['months'];
        $finalOutput = array();
        for ($i = $selectedMonth - 1; $i >= 0; $i--) {
            $dateCalculate = $i > 0 ? '-' . $i : $i;
            $sqlStartDate = date('Y-m-01', strtotime($dateCalculate . ' month'));
            $sqlEndDate = date('Y-m-31', strtotime($dateCalculate . ' month'));
            $saleAmount = $this->Common_model->comparison_sale_report($sqlStartDate, $sqlEndDate);
            $finalOutput[] = array(
                'month' => date('M-y', strtotime($dateCalculate . ' month')),
                'saleAmount' => !empty($saleAmount) ? $saleAmount->total_amount : 0.0,
            );
        }
        echo json_encode($finalOutput);
    }

    /* ----------------------Dashboard Menu End-------------------------- */
}
