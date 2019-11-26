<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('excel'); //load PHPExcel library 
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->model('Master_model');
        $this->load->model('Register_model');
        $this->load->library('form_validation');
        
        $this->Common_model->setDefaultTimezone();
        
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }

        // $getAccessURL = $this->uri->segment(1);
        // if (!in_array($getAccessURL, $this->session->userdata('menu_access'))) {
        //     redirect('Authentication/userProfile');
        // }

        if($this->Register_model->checkAccess($this->Register_model->getMenuAccessOfThisUser())==false && $this->session->userdata('role')!='POS User'){
            redirect('Authentication/userProfile');
        }
    }
    public function openRegister(){
        $data = array();
        $data['main_content'] = $this->load->view('register/openRegister', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    public function addBalance($encrypted_id = ""){
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('opening_balance', lang('opening_balance'), 'required');
            if ($this->form_validation->run() == TRUE) {
                $register_info = array();
                $register_info['opening_balance'] = htmlspecialchars($this->input->post($this->security->xss_clean('opening_balance')));
                $register_info['closing_balance'] = 0.00;
                $register_info['opening_balance_date_time'] = date('Y-m-d H:i:s');
                $register_info['register_status'] = 1;
                $register_info['user_id'] = $this->session->userdata('user_id');
                $register_info['outlet_id'] = $this->session->userdata('outlet_id');
                $register_info['company_id'] = $this->session->userdata('company_id');
                
                $this->Common_model->insertInformation($register_info, "tbl_register");
                
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
            }else {
                $data = array();
                $data['main_content'] = $this->load->view('register/openRegister', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }
    
    public function checkRegisterAjax()
    {
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $checkRegister = $this->Register_model->checkRegister($user_id,$outlet_id);
        if(!is_null($checkRegister)){
            echo $checkRegister->status;    
        }else{
            echo "";
        }
                
    }


    /* ----------------------Table End-------------------------- */
}
