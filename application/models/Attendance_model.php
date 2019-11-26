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
class Attendance_model extends CI_Model {
 
    public function generateReferenceNo() {
        $reference_no = $this->db->query("SELECT count(id) as reference_no
               FROM tbl_attendance")->row('reference_no');
        $reference_no = str_pad($reference_no + 1, 6, '0', STR_PAD_LEFT);
        return $reference_no;
    }

}

