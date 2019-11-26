<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Restaurant_setting extends CI_Controller {

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

    public function setting($id = '') {
        $encrypted_id = $id = $outlet_id = $this->session->userdata('outlet_id');
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        
        
        if ($this->input->post('submit')) {
            // dd($this->input->post());
            $this->form_validation->set_rules('outlet_name', 'Outlet Name', 'required|max_length[50]');
            $this->form_validation->set_rules('address', 'Address', 'required|max_length[200]');
            $this->form_validation->set_rules('phone', 'Phone', 'required');
            $this->form_validation->set_rules('collect_tax', 'Collect Tax', 'required|max_length[10]');
            if ($this->input->post('collect_tax') == "Yes") {
                $this->form_validation->set_rules('tax_title', 'Tax Title', 'required|max_length[50]');
                $this->form_validation->set_rules('tax_registration_no', 'Tax Registration No', 'required|max_length[50]');
                $this->form_validation->set_rules('tax_is_gst', 'Tax is GST', 'required|max_length[50]');
                if ($this->input->post('tax_is_gst') == "Yes") {
                    $this->form_validation->set_rules('state_code', 'State Code', 'required|max_length[50]');

                }
                $this->form_validation->set_rules('taxes[]', 'Taxes', 'required|max_length[10]');
            } 
            
            $this->form_validation->set_rules('pre_or_post_payment', 'Pre or Post Payment', 'required|max_length[50]');
            $this->form_validation->set_rules('invoice_footer', 'Invoice Footer', 'max_length[500]');
            if ($this->form_validation->run() == TRUE) {
                $outlet_info = array();
                $outlet_info['outlet_name'] = $this->input->post($this->security->xss_clean('outlet_name'));
                $outlet_info['address'] = $this->input->post($this->security->xss_clean('address'));
                $outlet_info['phone'] = $this->input->post($this->security->xss_clean('phone'));
                $outlet_info['collect_tax'] = $this->input->post($this->security->xss_clean('collect_tax'));
                if ($this->input->post('collect_tax') == "Yes") {
                    $outlet_info['tax_title'] = $this->input->post($this->security->xss_clean('collect_tax'));
                    $outlet_info['tax_registration_no'] = $this->input->post($this->security->xss_clean('collect_tax'));
                    $outlet_info['tax_is_gst'] = $this->input->post($this->security->xss_clean('collect_tax'));
                    if ($this->input->post('collect_tax') == "Yes") {
                        $outlet_info['state_code'] = $this->input->post($this->security->xss_clean('state_code'));
                    }
                } 
                $outlet_info['tax_title'] = $this->input->post($this->security->xss_clean('tax_title'));
                $outlet_info['tax_registration_no'] = $this->input->post($this->security->xss_clean('tax_registration_no'));
                $outlet_info['tax_is_gst'] = $this->input->post($this->security->xss_clean('tax_is_gst'));
                $outlet_info['state_code'] = $this->input->post($this->security->xss_clean('state_code'));
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
					if(!empty($_POST['taxes'])){
						$this->saveOutletTaxes($_POST['taxes'], $outlet_id, 'tbl_outlet_taxes');
					}
                    $this->session->set_flashdata('exception', 'Information has been added successfully!');
                } else {

                    $this->Common_model->updateInformation($outlet_info, $id, "tbl_outlets");
                    $this->Common_model->deletingMultipleFormData('outlet_id', $id, 'tbl_outlet_taxes');
					if(!empty($_POST['taxes'])){
						$this->saveOutletTaxes($_POST['taxes'], $id, 'tbl_outlet_taxes');
					}
                    $this->session->set_flashdata('exception', 'Information has been updated successfully!');
                }
                redirect('Restaurant_setting/setting');
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['outlet_information'] = $this->Common_model->getDataById($id, "tbl_outlets");
                $data['outlet_taxes'] = $this->Outlet_model->getTaxesByOutletId($id);
                $data['main_content'] = $this->load->view('restaurant_setting/editOutlet', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array();
            $data['encrypted_id'] = $encrypted_id;
            $data['outlet_information'] = $this->Common_model->getDataById($id, "tbl_outlets");
            $data['outlet_taxes'] = $this->Outlet_model->getTaxesByOutletId($id);
            $data['main_content'] = $this->load->view('restaurant_setting/editOutlet', $data, TRUE);
            $this->load->view('userHome', $data);
        }
        
    }
    public function saveOutletTaxes($outlet_taxes, $outlet_id, $table_name)
    {
        foreach($outlet_taxes as $single_tax){
            $oti = array();
            $oti['tax'] = $single_tax;
            $oti['outlet_id'] = $outlet_id;
            $oti['user_id'] = $this->session->userdata('user_id');
            $oti['company_id'] = $this->session->userdata('company_id');
            $this->Common_model->insertInformation($oti, "tbl_outlet_taxes");
        }
    }
}
