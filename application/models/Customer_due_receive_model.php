<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Customer_due_receive_model
 *
 * @author user
 */
class Customer_due_receive_model extends CI_Model {


    public function getCustomerDue($customer_id) {
        $outlet_id = $this->session->userdata('outlet_id');

        $customer_due = $this->db->query("SELECT SUM(due_amount) as due FROM tbl_sales WHERE customer_id=$customer_id and outlet_id=$outlet_id and del_status='Live'")->row(); 
 
        $customer_payment = $this->db->query("SELECT SUM(amount) as amount FROM tbl_customer_due_receives WHERE customer_id=$customer_id and outlet_id=$outlet_id and del_status='Live'")->row();

        $remaining_due = $customer_due->due - $customer_payment->amount;

        return $remaining_due;
 
    }
    public function generateReferenceNo($outlet_id) {
        $reference_no = $this->db->query("SELECT count(id) as reference_no
               FROM tbl_customer_due_receives where outlet_id=$outlet_id")->row('reference_no');
        $reference_no = str_pad($reference_no + 1, 6, '0', STR_PAD_LEFT);
        return $reference_no;
    }

}

