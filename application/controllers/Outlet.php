<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Outlet extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->model('Outlet_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();
        
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }

        if ($this->session->userdata('role') != 'Admin') {
            redirect('Authentication/index');
        }
    }

    /* -------------------Outlet Start------------------------ */

    public function outlets() {
        //unset outlet data 
        $this->session->unset_userdata('outlet_id');
        $this->session->unset_userdata('outlet_name');
        $this->session->unset_userdata('address');
        $this->session->unset_userdata('collect_vat');
        $this->session->unset_userdata('vat_reg_no');
        $this->session->unset_userdata('invoice_print');
        $this->session->unset_userdata('invoice_footer'); 

        $company_id = $this->session->userdata('company_id');

        $data = array();
        $data['outlets'] = $this->db->query("select * from tbl_outlets where del_status='Live'")->result();
        $data['main_content'] = $this->load->view('outlet/outlets', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    public function deleteOutlet($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $this->Common_model->deleteStatusChange($id, "tbl_outlets");

        $this->session->set_flashdata('exception',lang('delete_success'));
        redirect('Outlet/outlets');
    }

    public function addEditOutlet($encrypted_id = "") {
        $encrypted_id = $encrypted_id;
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');

        $company_id = $this->session->userdata('company_id');
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('outlet_name',lang('outlet_name'), 'required|max_length[50]');
            $this->form_validation->set_rules('address',lang('address'), 'required|max_length[200]');
            $this->form_validation->set_rules('phone', lang('phone'), 'required');
            $this->form_validation->set_rules('collect_vat',lang('collect_vat'), 'required|max_length[10]');
            $this->form_validation->set_rules('pre_or_post_payment', lang('pre_or_post_payment'), 'required|max_length[50]');
            if ($this->input->post('collect_vat') == "Yes") {
                $this->form_validation->set_rules('vat_reg_no', lang('vat_registration_no'), 'required|max_length[50]');
            }             
            $this->form_validation->set_rules('invoice_footer', lang('invoice_footer'), 'max_length[500]');
            if ($this->form_validation->run() == TRUE) {
                $outlet_info = array();
                $outlet_info['outlet_name'] = $this->input->post($this->security->xss_clean('outlet_name'));
                $outlet_info['address'] = $this->input->post($this->security->xss_clean('address'));
                $outlet_info['phone'] = $this->input->post($this->security->xss_clean('phone'));
                $outlet_info['collect_vat'] = $this->input->post($this->security->xss_clean('collect_vat'));
                $outlet_info['vat_reg_no'] = $this->input->post($this->security->xss_clean('vat_reg_no')); 
                $outlet_info['invoice_footer'] = $this->input->post($this->security->xss_clean('invoice_footer'));
                $outlet_info['pre_or_post_payment'] = $this->input->post($this->security->xss_clean('pre_or_post_payment'));
                if ($id == "") {
                    $outlet_info['starting_date'] = date("Y-m-d"); 
                    $outlet_info['user_id'] = $this->session->userdata('user_id');
                    $outlet_info['company_id'] = $this->session->userdata('company_id');
                    $outlet_info['outlet_code'] = $this->Outlet_model->generateOutletCode();
                }

                if ($id == "") {
                    $outlet_id = $this->Common_model->insertInformation($outlet_info, "tbl_outlets");

                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($outlet_info, $id, "tbl_outlets");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                redirect('Outlet/outlets');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('outlet/addOutlet', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['outlet_information'] = $this->Common_model->getDataById($id, "tbl_outlets");
                    $data['main_content'] = $this->load->view('outlet/editOutlet', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('outlet/addOutlet', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['outlet_information'] = $this->Common_model->getDataById($id, "tbl_outlets");
                $data['main_content'] = $this->load->view('outlet/editOutlet', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    public function setOutletSession($encrypted_id) {
        $outlet_id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $outlet_details = $this->Common_model->getDataById($outlet_id, 'tbl_outlets');
        $outlet_session = array();
        $outlet_session['outlet_id'] = $outlet_details->id;
        $outlet_session['outlet_name'] = $outlet_details->outlet_name;
        $outlet_session['address'] = $outlet_details->address;
        $outlet_session['phone'] = $outlet_details->phone;
        $outlet_session['collect_vat'] = $outlet_details->collect_vat;
        $outlet_session['vat_reg_no'] = $outlet_details->vat_reg_no;
        $outlet_session['invoice_print'] = $outlet_details->invoice_print; 
        $outlet_session['invoice_footer'] = $outlet_details->invoice_footer; 
        $outlet_session['pre_or_post_payment'] = $outlet_details->pre_or_post_payment; 
        $this->session->set_userdata($outlet_session);


        if (!$this->session->has_userdata('clicked_controller')) {
            if ($this->session->userdata('role') == 'Admin') {
                redirect('Dashboard/dashboard');
            } else {
                redirect('Authentication/userProfile');
            }
        } else {
            $clicked_controller = $this->session->userdata('clicked_controller');
            $clicked_method = $this->session->userdata('clicked_method');

            $this->session->unset_userdata('clicked_controller');
            $this->session->unset_userdata('clicked_method');
            redirect($clicked_controller . '/' . $clicked_method);
        }
    }

    /* ----------------------Outlet End-------------------------- */
}
