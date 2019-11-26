<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of KItchen_model
*
* @author user
*/
class Register_model extends CI_Model {
    public function getMenuAccessOfThisUser()
    {
        $user_id = $this->session->userdata('user_id');
        $this->db->select('*');
        $this->db->from('tbl_user_menu_access');
        $this->db->where("user_id", $user_id);
        $this->db->order_by('id', 'ASC');
        return $this->db->get()->result();
    }
    public function checkAccess($records){
        $result = false;
        foreach($records as $single_record){
            if($single_record->menu_id==1 || ($single_record->menu_id>=14 && $single_record->menu_id<=18))
            {
                $result = true;
            }
        }
        return $result;
    }
    public function checkRegister($user_id, $outlet_id)
    {
      $this->db->select("register_status as status");
      $this->db->from('tbl_register');
      $this->db->where("user_id", $user_id);
      $this->db->where("outlet_id", $outlet_id);
      $this->db->order_by('id', 'DESC');
      return $this->db->get()->row(); 
    }
}

