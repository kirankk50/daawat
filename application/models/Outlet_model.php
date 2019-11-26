<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Master_model
 *
 * @author user
 */
class Outlet_model extends CI_Model {

    public function generateOutletCode() {
        $count = $this->db->query("SELECT count(id) as count
               FROM tbl_outlets")->row('count');
        $code = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
        return $code;
    }

    public function outlet_count() {
        $this->db->select("*");
        $this->db->from("tbl_outlets");
        $this->db->where("company_id", $this->session->userdata('company_id'));
        $this->db->where("del_status", 'Live');
        return $this->db->get()->num_rows();
    }
    public function getTaxesByOutletId($outlet_id)
    {
        $this->db->select("*");
        $this->db->from("tbl_outlet_taxes");
        $this->db->where("outlet_id", $outlet_id);
        return $this->db->get()->result();   
    }

}

