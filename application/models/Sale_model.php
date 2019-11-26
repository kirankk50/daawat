<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sale_model
 *
 * @author user
 */
class Sale_model extends CI_Model {

    public function getSaleList($outlet_id) {
        $result = $this->db->query("SELECT s.*,u.full_name,c.name as customer_name,m.name
          FROM tbl_sales s
          INNER JOIN tbl_customers c ON(s.customer_id=c.id)
          LEFT JOIN tbl_users u ON(s.user_id=u.id)
          LEFT JOIN tbl_payment_methods m ON(s.payment_method_id=m.id) 
          WHERE s.order_status = '3' AND s.del_status = 'Live' AND s.outlet_id=$outlet_id ORDER BY s.id DESC")->result();
        return $result;
    }

    public function getItemMenuCategories($company_id) {
        $result = $this->db->query("SELECT * 
          FROM tbl_ingredient_categories 
          WHERE company_id=$company_id AND del_status = 'Live'  
          ORDER BY category_name")->result();
        return $result;
    }

    public function getItemMenus($outlet_id) {
        $result = $this->db->query("SELECT * 
          FROM tbl_ingredients 
          WHERE outlet_id=$outlet_id AND del_status = 'Live'  
          ORDER BY name")->result();
        return $result;
    }

    public function getItemListWithUnit($outlet_id) {
        $result = $this->db->query("SELECT tbl_ingredients.id, tbl_ingredients.name, tbl_units.unit_name 
          FROM tbl_ingredients 
          JOIN tbl_units ON tbl_ingredients.unit_id = tbl_units.id
          WHERE outlet_id=$outlet_id AND tbl_ingredients.del_status = 'Live'  
          ORDER BY tbl_ingredients.name ASC")->result();
        return $result;
    }

    public function getFoodMenuIngredients($id) {
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->select("*");
        $this->db->from("tbl_food_menus_ingredients");
        $this->db->order_by('id', 'ASC');
        $this->db->where("food_menu_id", $id);
        $this->db->where("del_status", 'Live');
        return $this->db->get()->result();
    }

    public function getItemMenuItems($id) {
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->select("*");
        $this->db->from("tbl_ingredients_items");
        $this->db->order_by('id', 'ASC');
        $this->db->where("ingredient_id", $id);
        $this->db->where("outlet_id", $outlet_id);
        $this->db->where("del_status", 'Live');
        return $this->db->get()->result();
    }

    public function getAllItemmenus() {
        $company_id = $this->session->userdata('company_id');
        $result = $this->db->query("SELECT tbl_food_menus.id, tbl_food_menus.code, tbl_food_menus.name, tbl_food_menus.sale_price, tbl_food_menus.photo, tbl_food_menu_categories.category_name, tbl_vats.percentage
          FROM tbl_food_menus 
          LEFT JOIN tbl_food_menu_categories ON tbl_food_menus.category_id = tbl_food_menu_categories.id
          LEFT JOIN tbl_vats ON tbl_food_menus.vat_id = tbl_vats.id
          WHERE tbl_food_menus.company_id=$company_id AND tbl_food_menus.del_status = 'Live'  
          ORDER BY tbl_food_menus.name ASC")->result();
        return $result;
    }

    public function getFoodMenuCategories($company_id) {
        $result = $this->db->query("SELECT * 
          FROM tbl_food_menu_categories 
          WHERE company_id=$company_id AND del_status = 'Live'  
          ORDER BY category_name")->result();
        return $result;
    }

    public function getSaleInfo($sales_id) {
        $outlet_id = $this->session->userdata('outlet_id');
        $result = $this->db->query("SELECT s.*,u.full_name,c.name as customer_name,m.name,tbl.name as table_name
          FROM tbl_sales s
          INNER JOIN tbl_customers c ON(s.customer_id=c.id)
          LEFT JOIN tbl_users u ON(s.user_id=u.id)
          LEFT JOIN tbl_payment_methods m ON(s.payment_method_id=m.id)
          LEFT JOIN tbl_tables tbl ON(s.table_id=tbl.id) 
          WHERE s.id=$sales_id AND s.del_status = 'Live' AND s.outlet_id=$outlet_id")->row();
        //print_r($result); exit();
        return $result;
    }

    public function getSaleDetails($sales_id) {
        $outlet_id = $this->session->userdata('outlet_id');
        $result = $this->db->query("SELECT sd.*,fm.code
          FROM tbl_sales_details sd
          LEFT JOIN tbl_food_menus fm ON(sd.food_menu_id=fm.id)
          WHERE sd.sales_id=$sales_id AND sd.outlet_id=$outlet_id AND sd.del_status = 'Live'  
          ORDER BY sd.id ASC")->result();
        return $result;
    }

    public function generateToken_no($outlet_id) {
        $year = date('ymd', strtotime('today'));
        $sale_count = $this->db->query("SELECT count(id) as sale_count
               FROM tbl_sales where outlet_id=$outlet_id")->row('sale_count');
        $token_no = $year . str_pad($sale_count + 1, 2, '0', STR_PAD_LEFT);
        return $token_no;
    }
    /**
     * added by arif 
     * added date: 06-11-18
     * updated date: 06-11-18
     * This method get all the records of tbl_food_menus table
     */
    public function getAllFoodMenus(){
/*      $this->db->select("tbl_food_menus.*,tbl_food_menu_categories.category_name,tbl_vats.percentage,COUNT(tbl_sales_details.food_menu_id) as item_sold");
      $this->db->from("tbl_food_menus");
      $this->db->join('tbl_food_menu_categories', 'tbl_food_menu_categories.id = tbl_food_menus.category_id', 'left');
      $this->db->join('tbl_vats', 'tbl_vats.id = tbl_food_menus.vat_id', 'left');
      $this->db->join('tbl_sales_details', 'tbl_sales_details.food_menu_id = tbl_food_menus.id', 'left');
      $this->db->group_by('tbl_sales_details.food_menu_id');
      $this->db->order_by('category_id', 'ASC');
      return $this->db->get()->result();  */


      $this->db->select("tbl_food_menus.*,tbl_food_menu_categories.category_name,tbl_vats.percentage,COUNT(tbl_sales_details.food_menu_id) as item_sold");
      $this->db->from("tbl_food_menus");
      $this->db->join('tbl_food_menu_categories', 'tbl_food_menu_categories.id = tbl_food_menus.category_id', 'left');
      $this->db->join('tbl_vats', 'tbl_vats.id = tbl_food_menus.vat_id', 'left');
      $this->db->join('tbl_sales_details', 'tbl_sales_details.food_menu_id = tbl_food_menus.id', 'left');
      $this->db->where("tbl_food_menus.del_status", 'Live');
      $this->db->group_by('tbl_food_menus.id');
      $this->db->order_by('item_sold', 'DESC');
      $result = $this->db->get()->result(); 
      return $result;        
    }

    /**
     * added by arif
     * added date: 06-11-18
     * updated date: 06-11-18
     * This method get all the menu categories from tbl_food_menu_categories
     */
    public function getAllMenuCategories(){
      $this->db->select("*");
      $this->db->from("tbl_food_menu_categories");
      $this->db->where("del_status", 'Live');
      $this->db->order_by('id', 'ASC');
      return $this->db->get()->result();      
    }
    /**
     * added by arif
     * added date: 07-11-18
     * updated date: 07-11-18
     * This method get all the menu modifiers from tbl_food_menus_modifiers
     */
    public function getAllMenuModifiers(){
      $this->db->select("tbl_food_menus_modifiers.*,tbl_modifiers.name,tbl_modifiers.price");
      $this->db->from("tbl_food_menus_modifiers");
      $this->db->join('tbl_modifiers', 'tbl_modifiers.id = tbl_food_menus_modifiers.modifier_id', 'left');
      $this->db->where("tbl_food_menus_modifiers.del_status", 'Live');
      $this->db->order_by('id', 'ASC');
      return $this->db->get()->result();
    }
    /**
     * added by arif
     * added date: 13-11-18
     * updated date: 13-11-18
     * This method get all waiters based on company id from tbl_users
     */
    public function getWaitersForThisCompany($company_id,$table){
      $this->db->select("*");
      $this->db->from($table);
      $this->db->where("company_id", $company_id);
      $this->db->where("designation", 'Waiter');
      $this->db->where("del_status", 'Live');
      $this->db->order_by('full_name', 'ASC');
      return $this->db->get()->result();
      
    } 

    /**
     * added by arif
     * added date: 13-11-18
     * updated date: 13-11-18
     * This method get all new orders based on user,outlet id & order status from tbl_sales
     */
    public function getNewOrders($outlet_id){
      $this->db->select("*,tbl_sales.id as sale_id,tbl_customers.name as customer_name, tbl_sales.id as sales_id,tbl_users.full_name as waiter_name,tbl_tables.name as table_name");
      $this->db->from('tbl_sales');
      $this->db->where("tbl_sales.outlet_id", $outlet_id);
      $this->db->where("(order_status='1' OR order_status='2')");
      $this->db->join('tbl_tables', 'tbl_tables.id = tbl_sales.table_id', 'left');
      $this->db->join('tbl_users', 'tbl_users.id = tbl_sales.waiter_id', 'left');
      $this->db->join('tbl_customers', 'tbl_customers.id = tbl_sales.customer_id', 'left');
      $this->db->order_by('tbl_sales.id', 'ASC');
      return $this->db->get()->result();
      
    }

    /**
     * added by arif
     * added date: 13-11-18
     * updated date: 13-11-18
     * This method get all new orders based on user,outlet id & order status from tbl_sales
     */
    public function getAllTablesWithNewStatus($outlet_id){
      $this->db->select("*");
      $this->db->from('tbl_sales');
      $this->db->where("(order_status='1' OR order_status='2')");
      $this->db->where("outlet_id", $outlet_id);
      $this->db->order_by('id', 'ASC');
      return $this->db->get()->result();
    }

    /**
     * added by arif
     * added date: 17-11-18
     * updated date: 17-11-18
     * This method get single sale record base on sales_id  from tbl_sales
     */
    public function getSaleBySaleId($sales_id){
      $this->db->select("tbl_sales.*,w.full_name as waiter_name,tbl_customers.name as customer_name,tbl_tables.name as table_name,tbl_users.full_name as user_name,tbl_outlets.invoice_footer as invoice_footer");
      $this->db->from('tbl_sales');
      $this->db->join('tbl_customers', 'tbl_customers.id = tbl_sales.customer_id', 'left');
      $this->db->join('tbl_users', 'tbl_users.id = tbl_sales.user_id', 'left');
      $this->db->join('tbl_tables', 'tbl_tables.id = tbl_sales.table_id', 'left');
      $this->db->join('tbl_outlets', 'tbl_outlets.id = tbl_sales.outlet_id', 'left');
      $this->db->join('tbl_users w', 'w.id = tbl_sales.waiter_id', 'left');
      $this->db->where("tbl_sales.id", $sales_id);
      $this->db->order_by('tbl_sales.id', 'ASC');
      return $this->db->get()->result();
    }
    /**
     * added by arif
     * added date: 19-11-18
     * updated date: 19-11-18
     * This method get all hold records based on outlet_id and user_id from tbl_holds
     */
    public function getHoldsByOutletAndUserId($outlet_id,$user_id){
      $this->db->select("tbl_holds.*,tbl_customers.name as customer_name,tbl_tables.name as table_name");
      $this->db->from('tbl_holds');
      $this->db->join('tbl_customers', 'tbl_customers.id = tbl_holds.customer_id', 'left');
      $this->db->join('tbl_tables', 'tbl_tables.id = tbl_holds.table_id', 'left');
      $this->db->where("tbl_holds.outlet_id", $outlet_id);
      $this->db->where("tbl_holds.user_id", $user_id);
      $this->db->where("tbl_holds.del_status", "Live");
      $this->db->order_by('tbl_holds.id', 'ASC');
      return $this->db->get()->result();
    }
    /**
     * added by arif
     * added date: 24-11-18
     * updated date: 24-11-18
     * This method get last 10 sales based on outlet_id and user_id from tbl_sales
     */
    public function getLastTenSalesByOutletAndUserId($outlet_id){
      $this->db->select("tbl_sales.*,tbl_customers.name as customer_name,tbl_tables.name as table_name");
      $this->db->from('tbl_sales');
      $this->db->join('tbl_customers', 'tbl_customers.id = tbl_sales.customer_id', 'left');
      $this->db->join('tbl_tables', 'tbl_tables.id = tbl_sales.table_id', 'left');
      $this->db->where("tbl_sales.outlet_id", $outlet_id);
      $this->db->where("tbl_sales.del_status", "Live");
      $this->db->where("(order_status='2' OR order_status='3')");
      $this->db->limit(10);
      $this->db->order_by('tbl_sales.id', 'DESC');
      return $this->db->get()->result();
    }
    /**
     * added by arif
     * added date: 17-11-18
     * updated date: 17-11-18
     * This method get all sales details items based on sales_id  from tbl_sales_details
     */
    public function getAllItemsFromSalesDetailBySalesId($sales_id){
      $this->db->select("tbl_sales_details.*,tbl_sales_details.id as sales_details_id,tbl_food_menus.code as code");
      $this->db->from('tbl_sales_details');
      $this->db->join('tbl_food_menus', 'tbl_food_menus.id = tbl_sales_details.food_menu_id', 'left');
      $this->db->where("sales_id", $sales_id);
      $this->db->order_by('tbl_sales_details.id', 'ASC');
      return $this->db->get()->result(); 
    }
    /**
     * added by arif
     * added date: 17-11-18
     * updated date: 17-11-18
     * This method get all sales details modifiers based on sales_id and sale_detail_id from tbl_sales_details_modifiers
     */
    public function getModifiersBySaleAndSaleDetailsId($sales_id,$sale_details_id){
      $this->db->select("tbl_sales_details_modifiers.*,tbl_modifiers.name");
      $this->db->from('tbl_sales_details_modifiers');
      $this->db->join('tbl_modifiers', 'tbl_modifiers.id = tbl_sales_details_modifiers.modifier_id', 'left');
      $this->db->where("tbl_sales_details_modifiers.sales_id", $sales_id);
      $this->db->where("tbl_sales_details_modifiers.sales_details_id", $sale_details_id);
      $this->db->order_by('tbl_sales_details_modifiers.id', 'ASC');
      return $this->db->get()->result(); 
    }
    /**
     * added by arif
     * added date: 19-11-18
     * updated date: 19-11-18
     * This method get numbers of hold based on outlet_id and user_id from tbl_holds
     */
    public function getNumberOfHoldsByUserAndOutletId($outlet_id,$user_id)
    {
      $this->db->select('id');
      $this->db->from('tbl_holds');
      $this->db->where("outlet_id", $outlet_id);
      $this->db->where("user_id", $user_id);
      return $this->db->get()->num_rows();
    }
    public function get_new_sale_by_table_id($table_id)
    {
      $this->db->select("*");
      $this->db->from('tbl_sales');
      $this->db->where("table_id", $table_id);
      $this->db->where("order_status", 1);
      return $this->db->get()->row();   
    }
    /**
     * added by arif
     * added date: 20-11-18
     * updated date: 20-11-18
     * This method get hold information based on hold_id from tbl_holds
     */
    public function get_hold_info_by_hold_id($hold_id)
    {
      $this->db->select("tbl_holds.*,tbl_users.full_name as waiter_name,tbl_customers.name as customer_name,tbl_tables.name as table_name");
      $this->db->from('tbl_holds');
      $this->db->join('tbl_customers', 'tbl_customers.id = tbl_holds.customer_id', 'left');
      $this->db->join('tbl_users', 'tbl_users.id = tbl_holds.waiter_id', 'left');
      $this->db->join('tbl_tables', 'tbl_tables.id = tbl_holds.table_id', 'left');
      $this->db->where("tbl_holds.id", $hold_id);
      $this->db->order_by('tbl_holds.id', 'ASC');
      return $this->db->get()->result();
    }
    /**
     * added by arif
     * added date: 20-11-18
     * updated date: 20-11-18
     * This method get all items of hold based on hold_id from tbl_holds_details
     */
    public function getAllItemsFromHoldsDetailByHoldsId($hold_id)
    {
      $this->db->select("tbl_holds_details.*,tbl_holds_details.id as holds_details_id");
      $this->db->from('tbl_holds_details');
      $this->db->join('tbl_food_menus', 'tbl_food_menus.id = tbl_holds_details.food_menu_id', 'left');
      $this->db->where("holds_id", $hold_id);
      $this->db->order_by('tbl_holds_details.id', 'ASC');
      return $this->db->get()->result();       
    }
    /**
     * added by arif
     * added date: 20-11-18
     * updated date: 20-11-18
     * This method get all modifiers of hold based on hold_id and holds_details_id from tbl_holds_details_modifiers
     */
    public function getModifiersByHoldAndHoldsDetailsId($hold_id,$holds_details_id)
    {
      $this->db->select("tbl_holds_details_modifiers.*,tbl_modifiers.name");
      $this->db->from('tbl_holds_details_modifiers');
      $this->db->join('tbl_modifiers', 'tbl_modifiers.id = tbl_holds_details_modifiers.modifier_id', 'left');
      $this->db->where("tbl_holds_details_modifiers.holds_id", $hold_id);
      $this->db->where("tbl_holds_details_modifiers.holds_details_id", $holds_details_id);
      $this->db->order_by('tbl_holds_details_modifiers.id', 'ASC');
      return $this->db->get()->result();
    }

    public function getCustomerInfoById($customer_id)
    {
      $this->db->select("*");
      $this->db->from('tbl_customers');
      $this->db->where("id", $customer_id);
      $this->db->order_by('id', 'ASC');
      return $this->db->get()->row();      
    }
    /**
     * added by arif
     * added date: 26-11-18
     * updated date: 26-11-18
     * This method get numbers of hold based on outlet_id and user_id from tbl_holds
     */
    public function getAllPaymentMethods()
    {
      $this->db->select('*');
      $this->db->from('tbl_payment_methods');
      $this->db->where("del_status", 'Live');
      return $this->db->get()->result();
    }
	
	public function getSummationOfPaidPurchase($user_id, $outlet_id, $date)
    {
      $this->db->select("SUM(paid) as purchase_paid");
      $this->db->from('tbl_purchase');
      $this->db->where("user_id", $user_id);
      $this->db->where("outlet_id", $outlet_id);
      $this->db->where("date", $date);
      return $this->db->get()->row(); 
    }
    public function getSummationOfSupplierPayment($user_id, $outlet_id, $date)
    {
      $this->db->select("SUM(amount) as payment_amount");
      $this->db->from('tbl_supplier_payments');
      $this->db->where("user_id", $user_id);
      $this->db->where("outlet_id", $outlet_id);
      $this->db->where("date", $date);
      return $this->db->get()->row(); 
    }
    public function getSummationOfCustomerDueReceive($user_id, $outlet_id, $date)
    {
      $this->db->select("SUM(amount) as receive_amount");
      $this->db->from('tbl_customer_due_receives');
      $this->db->where("user_id", $user_id);
      $this->db->where("outlet_id", $outlet_id);
      $this->db->where("date>=", $date);
      $this->db->where("date<=", date('Y-m-d H:i:s'));
      return $this->db->get()->row(); 
    }
    public function getExpenseAmountSum($user_id, $outlet_id, $date)
    {
      $this->db->select("SUM(amount) as amount");
      $this->db->from('tbl_expenses');
      $this->db->where("user_id", $user_id);
      $this->db->where("outlet_id", $outlet_id);
      $this->db->where("date", $date);
      return $this->db->get()->row(); 
    }
    public function getSalePaidSum($user_id, $outlet_id, $date)
    {
      $this->db->select("SUM(paid_amount) as amount");
      $this->db->from('tbl_sales');
      $this->db->where("user_id", $user_id);
      $this->db->where("outlet_id", $outlet_id);
      $this->db->where("date_time>=", $date);
      $this->db->where("date_time<=", date('Y-m-d H:i:s'));
      return $this->db->get()->row(); 
    }
    public function getSaleDueSum($user_id, $outlet_id, $date)
    {
      $this->db->select("SUM(due_amount) as amount");
      $this->db->from('tbl_sales');
      $this->db->where("user_id", $user_id);
      $this->db->where("outlet_id", $outlet_id);
      $this->db->where("date_time>=", $date);
      $this->db->where("date_time<=", date('Y-m-d H:i:s'));
      return $this->db->get()->row(); 
    }
    public function getPayableAomountSum($user_id,$outlet_id, $date)
    {
      $this->db->select("SUM(total_payable) as amount");
      $this->db->from('tbl_sales');
      $this->db->where("user_id", $user_id);
      $this->db->where("outlet_id", $outlet_id);
      $this->db->where("date_time>=", $date);
      $this->db->where("date_time<=", date('Y-m-d H:i:s'));
      return $this->db->get()->row(); 
    }
    public function getSaleInCashSum($user_id, $outlet_id, $date)
    {
      $this->db->select("SUM(paid_amount) as amount");
      $this->db->from('tbl_sales');
      $this->db->where("user_id", $user_id);
      $this->db->where("outlet_id", $outlet_id);
      $this->db->where("date_time>=", $date);
      $this->db->where("date_time<=", date('Y-m-d H:i:s'));
      $this->db->where("payment_method_id", 3);
      return $this->db->get()->row(); 
    }
    public function getSaleInPaypalSum($user_id, $outlet_id, $date)
    {
      $this->db->select("SUM(paid_amount) as amount");
      $this->db->from('tbl_sales');
      $this->db->where("user_id", $user_id);
      $this->db->where("outlet_id", $outlet_id);
      $this->db->where("date_time>=", $date);
      $this->db->where("date_time<=", date('Y-m-d H:i:s'));
      $this->db->where("payment_method_id", 5);
      return $this->db->get()->row(); 
    }
    public function getSaleInCardSum($user_id, $outlet_id, $date)
    {
      $this->db->select("SUM(paid_amount) as amount");
      $this->db->from('tbl_sales');
      $this->db->where("user_id", $user_id);
      $this->db->where("outlet_id", $outlet_id);
      $this->db->where("date_time>=", $date);
      $this->db->where("date_time<=", date('Y-m-d H:i:s'));
      $this->db->where("payment_method_id", 4);
      return $this->db->get()->row(); 
    }
    public function getSaleInStripeSum($user_id, $outlet_id, $date)
    {
      $this->db->select("SUM(paid_amount) as amount");
      $this->db->from('tbl_sales');
      $this->db->where("user_id", $user_id);
      $this->db->where("outlet_id", $outlet_id);
      $this->db->where("sale_date", $date);
      $this->db->where("payment_method_id", null);
      return $this->db->get()->row(); 
    }
    public function getOpeningBalance($user_id, $outlet_id, $date)
    {
      $this->db->select("opening_balance as amount");
      $this->db->from('tbl_register');
      $this->db->where("user_id", $user_id);
      $this->db->where("outlet_id", $outlet_id);
      $this->db->where("DATE(opening_balance_date_time)", $date);
      $this->db->order_by('id', 'DESC');
      return $this->db->get()->row(); 
    }
    public function getOpeningDateTime($user_id, $outlet_id, $date)
    {
      $this->db->select("opening_balance_date_time as opening_date_time");
      $this->db->from('tbl_register');
      $this->db->where("user_id", $user_id);
      $this->db->where("outlet_id", $outlet_id);
      $this->db->where("register_status", 1);
      $this->db->order_by('id', 'DESC');
      // $this->db->where("DATE(opening_balance_date_time)", $date);
      return $this->db->get()->row(); 
    }
    public function getClosingDateTime($user_id, $outlet_id, $date)
    {
      $this->db->select("closing_balance_date_time as closing_date_time");
      $this->db->from('tbl_register');
      $this->db->where("user_id", $user_id);
      $this->db->where("outlet_id", $outlet_id);
      $this->db->where("register_status", 1);
      $this->db->order_by('id', 'DESC');
      $this->db->where("DATE(opening_balance_date_time)", $date);
      return $this->db->get()->row(); 
    }
    public function getItemType($item_id)
    {
      $this->db->select('bar_item as item_type');
      $this->db->from('tbl_food_menus');
      $this->db->where('id',$item_id);
      return $this->db->get()->row();      
    }
    public function get_total_kitchen_type_items($sale_id)
    {
        $this->db->select('id');
        $this->db->from('tbl_sales_details');
        $this->db->where("sales_id", $sale_id);
        return $this->db->get()->num_rows();    
    }
    public function get_total_kitchen_type_done_items($sale_id)
    {
        $this->db->select('id');
        $this->db->from('tbl_sales_details');
        $this->db->where("sales_id", $sale_id);
        $this->db->where("cooking_status", "Done");
        return $this->db->get()->num_rows();    
    }
    public function get_total_kitchen_type_started_cooking_items($sale_id)
    {
        $this->db->select('id');
        $this->db->from('tbl_sales_details');
        $this->db->where("sales_id", $sale_id);
        $this->db->where("cooking_status", "Started Cooking");
        return $this->db->get()->num_rows();    
    }
    public function getNotificationByOutletId($outlet_id)
    {
      $this->db->select('*');
      $this->db->from('tbl_notifications');
      $this->db->where("outlet_id", $outlet_id);
      $this->db->order_by('id', 'ASC');
      return $this->db->get()->result(); 
    }
    public function get_temp_kot($id)
    {
      $this->db->select('*');
      $this->db->from('tbl_temp_kot');
      $this->db->where("id", $id);
      return $this->db->get()->row(); 
    }
    public function getTablesByOutletId($outlet_id) {
      $this->db->select('*');
      $this->db->from('tbl_tables');
      $this->db->where("outlet_id", $outlet_id);
      $this->db->order_by('id', 'ASC');
      $this->db->where("del_status", "Live");

      return $this->db->get()->result();
    }
    public function getOrdersOfTableByTableId($table_id)
    {
      $this->db->select('*');
      $this->db->from('tbl_orders_table');
      $this->db->where("table_id", $table_id);
      $this->db->where("del_status", "Live");

      return $this->db->get()->result();
    }
    public function getTableAvailability($outlet_id)
    {
      $this->db->select('SUM(persons) as persons_number,table_id');
      $this->db->from('tbl_orders_table');
      $this->db->where("outlet_id", $outlet_id);
      $this->db->where("del_status", "Live");
      $this->db->group_by('table_id');

      return $this->db->get()->result();
    }
    public function get_all_assets($outlet_id)
    {
      $this->db->select('*');
      $this->db->from('tbl_assets');
      $this->db->where("outlet_id", $outlet_id);
      $this->db->where("del_status", 'Live');
      return $this->db->get()->result();
    }
    public function getGamesOfAssetByAssetId($asset_id)
    {
      $this->db->select('*,tbl_games.name');
      $this->db->from('tbl_assets_games');
      $this->db->join('tbl_games', 'tbl_games.id = tbl_assets_games.game_id', 'left');
      $this->db->where("asset_id", $asset_id);

      return $this->db->get()->result();
    }
    public function getFirstUserInformationBy($outlet_id,$user_type)
    {
      $this->db->select('*');
      $this->db->from('tbl_users');
      $this->db->where("outlet_id", $outlet_id);
      $this->db->where("role", $user_type);
      $this->db->where("del_status", 'Live');
      $this->db->order_by('id', 'ASC');
      $this->db->limit(1);
      return $this->db->get()->row();
    }
    public function get_all_tables_of_a_sale_items($sale_id)
    {
      $this->db->select('tbl_tables.name as table_name');
      $this->db->from('tbl_orders_table');
      $this->db->join('tbl_tables', 'tbl_tables.id = tbl_orders_table.table_id', 'left');
      $this->db->where("sale_id", $sale_id);
      // $this->db->where("tbl_orders_table.del_status", 'Live');
      return $this->db->get()->result();
      
    }
    public function get_all_tables_of_a_last_sale($sale_id)
    {
      $this->db->select('tbl_tables.name as table_name');
      $this->db->from('tbl_orders_table');
      $this->db->join('tbl_tables', 'tbl_tables.id = tbl_orders_table.table_id', 'left');
      $this->db->where("sale_id", $sale_id);
      return $this->db->get()->result();
      
    }
    public function delete_status_orders_table($sale_id)
    {
        $this->db->set('del_status', "Deleted");
        $this->db->where('sale_id', $sale_id);
        $this->db->update('tbl_orders_table');
    }
    public function getCashMethod()
    {
      $this->db->select('*');
      $this->db->from('tbl_payment_methods');
      $this->db->where("name", 'Cash');
      return $this->db->get()->row();
    }
    
}

