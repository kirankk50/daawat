<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('excel'); //load PHPExcel library 
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->model('Master_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();
        
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }

        $getAccessURL = $this->uri->segment(1);
        if (!in_array($getAccessURL, $this->session->userdata('menu_access'))) {
            redirect('Authentication/userProfile');
        }
    }

    /* ----------------------Ingredient Category Start-------------------------- */

    public function ingredientCategories() {
        $company_id = $this->session->userdata('company_id');

        $data = array();
        $data['ingredientCategories'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_ingredient_categories");
        $data['main_content'] = $this->load->view('master/ingredientCategory/ingredientCategories', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    public function deleteIngredientCategory($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $this->Common_model->deleteStatusChange($id, "tbl_ingredient_categories");

        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Master/ingredientCategories');
    }

    public function addEditIngredientCategory($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('category_name',lang('category_name'), 'required|max_length[50]');
            $this->form_validation->set_rules('description', lang('description'), 'max_length[50]');
            if ($this->form_validation->run() == TRUE) {
                $igc_info = array();
                $igc_info['category_name'] = htmlspecialchars($this->input->post($this->security->xss_clean('category_name')));
                $igc_info['description'] = $this->input->post($this->security->xss_clean('description'));
                $igc_info['user_id'] = $this->session->userdata('user_id');
                $igc_info['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $this->Common_model->insertInformation($igc_info, "tbl_ingredient_categories");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($igc_info, $id, "tbl_ingredient_categories");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                redirect('Master/ingredientCategories');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('master/ingredientCategory/addIngredientCategory', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['category_information'] = $this->Common_model->getDataById($id, "tbl_ingredient_categories");
                    $data['main_content'] = $this->load->view('master/ingredientCategory/editIngredientCategory', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('master/ingredientCategory/addIngredientCategory', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['category_information'] = $this->Common_model->getDataById($id, "tbl_ingredient_categories");
                $data['main_content'] = $this->load->view('master/ingredientCategory/editIngredientCategory', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    /* ----------------------Ingredient Category End-------------------------- */

    /* ----------------------Food Menu Category Start-------------------------- */

    public function foodMenuCategories() {
        $company_id = $this->session->userdata('company_id');

        $data = array();
        $data['foodMenuCategories'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_food_menu_categories");
        $data['main_content'] = $this->load->view('master/foodMenuCategory/foodMenuCategories', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    public function deleteFoodMenuCategory($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $this->Common_model->deleteStatusChange($id, "tbl_food_menu_categories");

        $this->session->set_flashdata('exception',lang('delete_success'));
        redirect('Master/foodMenuCategories');
    }

    public function addEditFoodMenuCategory($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('category_name', lang('category_name'), 'required|max_length[50]');
            $this->form_validation->set_rules('description', lang('description'), 'max_length[50]');
            if ($this->form_validation->run() == TRUE) {
                $fmc_info = array();
                $fmc_info['category_name'] = htmlspecialchars($this->input->post($this->security->xss_clean('category_name')));
                $fmc_info['description'] = $this->input->post($this->security->xss_clean('description'));
                $fmc_info['user_id'] = $this->session->userdata('user_id');
                $fmc_info['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $this->Common_model->insertInformation($fmc_info, "tbl_food_menu_categories");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($fmc_info, $id, "tbl_food_menu_categories");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                redirect('Master/foodMenuCategories');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('master/foodMenuCategory/addFoodMenuCategory', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['category_information'] = $this->Common_model->getDataById($id, "tbl_food_menu_categories");
                    $data['main_content'] = $this->load->view('master/foodMenuCategory/editFoodMenuCategory', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('master/foodMenuCategory/addFoodMenuCategory', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['category_information'] = $this->Common_model->getDataById($id, "tbl_food_menu_categories");
                $data['main_content'] = $this->load->view('master/foodMenuCategory/editFoodMenuCategory', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    /* ----------------------Food Menu Category End-------------------------- */

    /* ----------------------Customer Start-------------------------- */

    public function customers() {
        $company_id = $this->session->userdata('company_id');

        $data = array();
        $data['customers'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_customers");
        $data['main_content'] = $this->load->view('master/customer/customers', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    public function deleteCustomer($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $this->Common_model->deleteStatusChange($id, "tbl_customers");

        $this->session->set_flashdata('exception',lang('delete_success'));
        redirect('Master/customers');
    }

    public function addEditCustomer($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('name', lang('category_name'), 'required|max_length[50]');
            $this->form_validation->set_rules('phone', lang('phone'), 'required|max_length[50]');
            $this->form_validation->set_rules('email', lang('email_address'), "valid_email");
            if ($this->form_validation->run() == TRUE) {
                $customer_info = array();
                $customer_info['name'] = htmlspecialchars($this->input->post($this->security->xss_clean('name')));
                $customer_info['phone'] = $this->input->post($this->security->xss_clean('phone'));
                $customer_info['email'] = $this->input->post($this->security->xss_clean('email'));
                $customer_info['date_of_birth'] = $this->input->post($this->security->xss_clean('date_of_birth'));
                $customer_info['date_of_anniversary'] = $this->input->post($this->security->xss_clean('date_of_anniversary'));
                $customer_info['address'] = $this->input->post($this->security->xss_clean('address'));
                if(collectGST()=="Yes"){
                    $customer_info['gst_number'] = $this->input->post($this->security->xss_clean('gst_number'));
                }
                $customer_info['user_id'] = $this->session->userdata('user_id');
                $customer_info['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $this->Common_model->insertInformation($customer_info, "tbl_customers");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($customer_info, $id, "tbl_customers");
                    $this->session->set_flashdata('exception',lang('update_success'));
                }
                redirect('Master/customers');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('master/customer/addCustomer', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['customer_information'] = $this->Common_model->getDataById($id, "tbl_customers");
                    $data['main_content'] = $this->load->view('master/customer/editCustomer', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('master/customer/addCustomer', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['customer_information'] = $this->Common_model->getDataById($id, "tbl_customers");
                $data['main_content'] = $this->load->view('master/customer/editCustomer', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    /* ----------------------Customer End-------------------------- */


    /* -------------------Expense Item Start------------------------ */

    public function expenseItems() {
        $company_id = $this->session->userdata('company_id');

        $data = array();
        $data['expenseItems'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_expense_items");
        $data['main_content'] = $this->load->view('master/expenseItem/expenseItems', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    public function deleteExpenseItem($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $this->Common_model->deleteStatusChange($id, "tbl_expense_items");

        $this->session->set_flashdata('exception',lang('delete_success'));
        redirect('Master/expenseItems');
    }

    public function addEditExpenseItem($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('name', lang('category_name'), 'required|max_length[50]');
            $this->form_validation->set_rules('description', lang('description'), 'max_length[50]');
            if ($this->form_validation->run() == TRUE) {
                $fmc_info = array();
                $fmc_info['name'] = htmlspecialchars($this->input->post($this->security->xss_clean('name')));
                $fmc_info['description'] = $this->input->post($this->security->xss_clean('description'));
                $fmc_info['user_id'] = $this->session->userdata('user_id');
                $fmc_info['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $this->Common_model->insertInformation($fmc_info, "tbl_expense_items");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($fmc_info, $id, "tbl_expense_items");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                redirect('Master/expenseItems');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('master/expenseItem/addExpenseItem', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['expense_item_information'] = $this->Common_model->getDataById($id, "tbl_expense_items");
                    $data['main_content'] = $this->load->view('master/expenseItem/editExpenseItem', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('master/expenseItem/addExpenseItem', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['expense_item_information'] = $this->Common_model->getDataById($id, "tbl_expense_items");
                $data['main_content'] = $this->load->view('master/expenseItem/editExpenseItem', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    /* ----------------------Expense Item End-------------------------- */

    /* -------------------Supplier Start------------------------ */

    public function suppliers() {
        $company_id = $this->session->userdata('company_id');

        $data = array();
        $data['suppliers'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_suppliers");
        $data['main_content'] = $this->load->view('master/supplier/suppliers', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    public function deleteSupplier($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $this->Common_model->deleteStatusChange($id, "tbl_suppliers");

        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Master/suppliers');
    }

    public function addEditSupplier($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('name', lang('name'), 'required|max_length[50]');
            $this->form_validation->set_rules('contact_person', lang('contact_person'), 'required|max_length[50]');
            $this->form_validation->set_rules('phone', lang('phone'), 'required|max_length[15]');
            $this->form_validation->set_rules('description',lang('description'), 'max_length[100]');
            $this->form_validation->set_rules('email', lang('email_address'), "valid_email");
            if ($this->form_validation->run() == TRUE) {
                $fmc_info = array();
                $fmc_info['name'] = htmlspecialchars($this->input->post($this->security->xss_clean('name')));
                $fmc_info['contact_person'] = $this->input->post($this->security->xss_clean('contact_person'));
                $fmc_info['phone'] = $this->input->post($this->security->xss_clean('phone'));
                $fmc_info['email'] = $this->input->post($this->security->xss_clean('email'));
                $fmc_info['address'] = $this->input->post($this->security->xss_clean('address'));
                $fmc_info['description'] = $this->input->post($this->security->xss_clean('description'));
                $fmc_info['user_id'] = $this->session->userdata('user_id');
                $fmc_info['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $this->Common_model->insertInformation($fmc_info, "tbl_suppliers");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($fmc_info, $id, "tbl_suppliers");
                    $this->session->set_flashdata('exception',lang('update_success'));
                }
                redirect('Master/suppliers');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('master/supplier/addSupplier', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['supplier_information'] = $this->Common_model->getDataById($id, "tbl_suppliers");
                    $data['main_content'] = $this->load->view('master/supplier/editSupplier', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('master/supplier/addSupplier', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['supplier_information'] = $this->Common_model->getDataById($id, "tbl_suppliers");
                $data['main_content'] = $this->load->view('master/supplier/editSupplier', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    /* ----------------------Supplier End-------------------------- */

    /* -------------------Employee Start------------------------ */

    public function employees() {
        $company_id = $this->session->userdata('company_id');

        $data = array();
        $data['employees'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_users");
        $data['main_content'] = $this->load->view('master/employee/employees', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    public function deleteEmployee($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $this->Common_model->deleteStatusChange($id, "tbl_users");

        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Master/employees');
    }

    public function addEditEmployee($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('name', lang('name'), 'required|max_length[50]');
            $this->form_validation->set_rules('designation', lang('description'), 'required|max_length[50]');
            $this->form_validation->set_rules('phone', lang('phone'), 'required|max_length[15]');
            $this->form_validation->set_rules('description', lang('description'), 'max_length[100]');
            if ($this->form_validation->run() == TRUE) {
                $fmc_info = array();
                $fmc_info['name'] = htmlspecialchars($this->input->post($this->security->xss_clean('name')));
                $fmc_info['designation'] = $this->input->post($this->security->xss_clean('designation'));
                $fmc_info['phone'] = $this->input->post($this->security->xss_clean('phone'));
                $fmc_info['description'] = $this->input->post($this->security->xss_clean('description'));
                $fmc_info['user_id'] = $this->session->userdata('user_id');
                $fmc_info['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $this->Common_model->insertInformation($fmc_info, "tbl_users");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($fmc_info, $id, "tbl_users");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                redirect('Master/employees');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('master/employee/addEmployee', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['employee_information'] = $this->Common_model->getDataById($id, "tbl_users");
                    $data['main_content'] = $this->load->view('master/employee/editEmployee', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('master/employee/addEmployee', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['employee_information'] = $this->Common_model->getDataById($id, "tbl_users");
                $data['main_content'] = $this->load->view('master/employee/editEmployee', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    /* ----------------------Employee End-------------------------- */


    /* -------------------Ingredient Start------------------------ */

    public function ingredients() {
        $company_id = $this->session->userdata('company_id');

        $data = array();
        $data['ingredients'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_ingredients");
        $data['main_content'] = $this->load->view('master/ingredient/ingredients', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    public function uploadingredients() {
        $company_id = $this->session->userdata('company_id');

        $data = array();
        $data['ingredients'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_ingredients");
        $data['main_content'] = $this->load->view('master/ingredient/uploadingredients', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    public function uploadFoodMenu() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['foodMenus'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_food_menus");
        $data['foodMenuCategories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_food_menu_categories");
        $data['main_content'] = $this->load->view('master/foodMenu/uploadsfoodMenus', $data, TRUE);
        $this->load->view('userHome', $data);
    }
    public function uploadFoodMenuIngredients() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['main_content'] = $this->load->view('master/foodMenu/uploadsfoodMenusIngredients', $data, TRUE);
        $this->load->view('userHome', $data);
    }
    public function uploadCustomer()
    {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['main_content'] = $this->load->view('master/customer/uploadsCustomer', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    public function uploadFoodMenuingredient() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['foodMenus'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_food_menus");
        $data['foodMenuCategories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_food_menu_categories");
        $data['main_content'] = $this->load->view('master/foodMenu/uploadsfoodMenusingrediend', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    public function deleteIngredient($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $this->Common_model->deleteStatusChange($id, "tbl_ingredients");

        $this->session->set_flashdata('exception',lang('delete_success'));
        redirect('Master/ingredients');
    }

    public function addEditIngredient($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $company_id = $this->session->userdata('company_id');
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('name', lang('name'), 'required|max_length[50]');
            $this->form_validation->set_rules('category_id', lang('category'), 'required');
            $this->form_validation->set_rules('purchase_price', lang('purchase_price'), 'required|numeric|max_length[15]');
            $this->form_validation->set_rules('alert_quantity',lang('alert_quantity'), 'required|numeric|max_length[15]');
            $this->form_validation->set_rules('unit_id',lang('unit'), 'required');
            if ($this->form_validation->run() == TRUE) {
                $fmc_info = array();
                $fmc_info['name'] = htmlspecialchars($this->input->post($this->security->xss_clean('name')));
                $fmc_info['code'] = htmlspecialchars($this->input->post($this->security->xss_clean('code')));
                $fmc_info['category_id'] = $this->input->post($this->security->xss_clean('category_id'));
                $fmc_info['purchase_price'] = $this->input->post($this->security->xss_clean('purchase_price'));
                $fmc_info['alert_quantity'] = $this->input->post($this->security->xss_clean('alert_quantity'));
                $fmc_info['unit_id'] = $this->input->post($this->security->xss_clean('unit_id'));
                $fmc_info['user_id'] = $this->session->userdata('user_id');
                $fmc_info['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $this->Common_model->insertInformation($fmc_info, "tbl_ingredients");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($fmc_info, $id, "tbl_ingredients");
                    $this->session->set_flashdata('exception',lang('update_success'));
                }
                redirect('Master/ingredients');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['categories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_ingredient_categories');
                    $data['units'] = $this->Common_model->getAllByTable('tbl_units');
                    $data['autoCode'] = $this->Master_model->generateIngredientCode();
                    $data['main_content'] = $this->load->view('master/ingredient/addIngredient', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['categories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_ingredient_categories');
                    $data['autoCode'] = $this->Master_model->generateIngredientCode();
                    $data['units'] = $this->Common_model->getAllByTable('tbl_units');
                    $data['ingredient_information'] = $this->Common_model->getDataById($id, "tbl_ingredients");
                    $data['main_content'] = $this->load->view('master/ingredient/editIngredient', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['categories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_ingredient_categories');
                $data['units'] = $this->Common_model->getAllByTable('tbl_units');
                $data['autoCode'] = $this->Master_model->generateIngredientCode();
                $data['main_content'] = $this->load->view('master/ingredient/addIngredient', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['categories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_ingredient_categories');
                $data['autoCode'] = $this->Master_model->generateIngredientCode();
                $data['units'] = $this->Common_model->getAllByTable('tbl_units');
                $data['ingredient_information'] = $this->Common_model->getDataById($id, "tbl_ingredients");
                $data['main_content'] = $this->load->view('master/ingredient/editIngredient', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    /* ----------------------Ingredient End-------------------------- */


    /* ---------------------- Modifier -------------------------- */

    public function modifiers() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['modifiers'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_modifiers");
        $data['main_content'] = $this->load->view('master/modifier/modifiers', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    public function deleteModifier($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $this->Common_model->deleteStatusChange($id, "tbl_modifiers");

        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Master/modifiers');
    }

    public function addEditModifier($encrypted_id = "") {

        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $company_id = $this->session->userdata('company_id');
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('name', lang('name'), 'required|max_length[50]');
            $this->form_validation->set_rules('description', lang('description'), 'max_length[200]');
            $this->form_validation->set_rules('price', lang('price'), 'required|max_length[50]');
            if ($this->form_validation->run() == TRUE) {

                $modifier_info = array();
                $modifier_info['name'] = htmlspecialchars($this->input->post($this->security->xss_clean('name')));
                $modifier_info['description'] = $this->input->post($this->security->xss_clean('description'));
                $modifier_info['price'] = $this->input->post($this->security->xss_clean('price'));
                $modifier_info['user_id'] = $this->session->userdata('user_id');
                $modifier_info['company_id'] = $this->session->userdata('company_id');

                if ($id == "") {
                    $modifier_id = $this->Common_model->insertInformation($modifier_info, "tbl_modifiers");
                    $this->saveModifierIngredients($_POST['ingredient_id'], $modifier_id, 'tbl_modifier_ingredients');
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($modifier_info, $id, "tbl_modifiers");
                    $this->Common_model->deletingMultipleFormData('modifier_id', $id, 'tbl_modifier_ingredients');
                    $this->saveModifierIngredients($_POST['ingredient_id'], $id, 'tbl_modifier_ingredients');
                    $this->session->set_flashdata('exception',lang('update_success'));
                }

                redirect('Master/modifiers');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('master/modifier/addModifier', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['modifier_details'] = $this->Common_model->getDataById($id, "tbl_modifiers");
                    $data['modifier_ingredients'] = $this->Master_model->getModifierIngredients($data['modifier_details']->id);
                    $data['main_content'] = $this->load->view('master/modifier/editModifier', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['ingredients'] = $this->Master_model->getIngredientListWithUnit($company_id);
                $data['main_content'] = $this->load->view('master/modifier/addModifier', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['ingredients'] = $this->Master_model->getIngredientListWithUnit($company_id);
                $data['modifier_details'] = $this->Common_model->getDataById($id, "tbl_modifiers");
                $data['modifier_ingredients'] = $this->Master_model->getModifierIngredients($data['modifier_details']->id);
                $data['main_content'] = $this->load->view('master/modifier/editModifier', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    public function saveModifierIngredients($modifier_ingredients, $modifier_id_id, $table_name) {
        foreach ($modifier_ingredients as $row => $ingredient_id):
            $fmi = array();
            $fmi['ingredient_id'] = $ingredient_id;
            $fmi['consumption'] = $_POST['consumption'][$row];
            $fmi['modifier_id'] = $modifier_id_id;
            $fmi['user_id'] = $this->session->userdata('user_id');
            $fmi['company_id'] = $this->session->userdata('company_id');
            $this->Common_model->insertInformation($fmi, "tbl_modifier_ingredients");
        endforeach;
    }

    public function modifierDetails($id) {
        $encrypted_id = $id;
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $data = array();
        $data['encrypted_id'] = $encrypted_id;
        $data['food_menu_details'] = $this->Common_model->getDataById($id, "tbl_modifiers");
        $data['main_content'] = $this->load->view('master/modifier/modifierDetails', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /* ----------------------Modifier End-------------------------- */


    /* ----------------------Food Menu Start-------------------------- */

    public function foodMenus() {
        $company_id = $this->session->userdata('company_id');

        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('category_id', lang('category'), 'required|max_length[50]');
            if ($this->form_validation->run() == TRUE) {
                $category_id = $this->input->post($this->security->xss_clean('category_id'));
                $data = array();
                $data['foodMenus'] = $this->Common_model->getAllFoodMenusByCategory($category_id, "tbl_food_menus");
                $data['foodMenuCategories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_food_menu_categories");
                $data['main_content'] = $this->load->view('master/foodMenu/foodMenus', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();

                $data['foodMenus'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_food_menus");
                $data['foodMenuCategories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_food_menu_categories");
                $data['main_content'] = $this->load->view('master/foodMenu/foodMenus', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array(); 
            $data['foodMenus'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_food_menus"); 
            $data['foodMenuCategories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_food_menu_categories");
            $data['main_content'] = $this->load->view('master/foodMenu/foodMenus', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }

    public function deleteFoodMenu($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $this->Common_model->deleteStatusChange($id, "tbl_food_menus");

        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Master/foodMenus');
    }

    public function addEditFoodMenu($encrypted_id = "") {

        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $company_id = $this->session->userdata('company_id');
        $outlet_id = $this->session->userdata('outlet_id');
        if($outlet_id==""){
            $this->session->set_flashdata('exception_1', 'Select an outlet');
            redirect('Outlet/outlets');
        }
        if ($this->input->post('submit')) {
            $tax_information = array();
			if(!empty($_POST['tax_field_percentage'])){
            foreach($this->input->post('tax_field_percentage') as $key=>$value){
                $single_info = array(
                    'tax_field_id' => $this->input->post('tax_field_id')[$key],
                    'tax_field_outlet_id' => $this->input->post('tax_field_outlet_id')[$key],
                    'tax_field_company_id' => $this->input->post('tax_field_company_id')[$key],
                    'tax_field_name' => $this->input->post('tax_field_name')[$key],
                    'tax_field_percentage' => ($this->input->post('tax_field_percentage')[$key]=="")?0:$this->input->post('tax_field_percentage')[$key]
                  );
                array_push($tax_information,$single_info);
            }
			}
            $tax_information = json_encode($tax_information);
            $this->form_validation->set_rules('name', lang('name'), 'required|max_length[50]');
            $this->form_validation->set_rules('category_id', lang('category'), 'required|max_length[50]');
            $this->form_validation->set_rules('veg_item', lang('is_it_veg'), 'required|max_length[50]');
            $this->form_validation->set_rules('beverage_item', lang('is_it_beverage'), 'required|max_length[50]');
            $this->form_validation->set_rules('bar_item',lang('is_it_bar'), 'required|max_length[50]');
            $this->form_validation->set_rules('description', lang('description'), 'max_length[200]');
            $this->form_validation->set_rules('sale_price', lang('sale_price'), 'required|max_length[50]'); 
            if ($_FILES['photo']['name'] != "") {
                $this->form_validation->set_rules('photo', lang('photo'), 'callback_validate_photo');
            }
            if ($this->form_validation->run() == TRUE) { 
                $food_menu_info = array();
                $food_menu_info['name'] = htmlspecialchars($this->input->post($this->security->xss_clean('name')));
                $food_menu_info['code'] = htmlspecialchars($this->input->post($this->security->xss_clean('code')));
                $food_menu_info['category_id'] = $this->input->post($this->security->xss_clean('category_id'));
                $food_menu_info['veg_item'] = $this->input->post($this->security->xss_clean('veg_item'));
                $food_menu_info['beverage_item'] = $this->input->post($this->security->xss_clean('beverage_item'));
                $food_menu_info['bar_item'] = $this->input->post($this->security->xss_clean('bar_item'));
                $food_menu_info['description'] = $this->input->post($this->security->xss_clean('description'));
                $food_menu_info['sale_price'] = $this->input->post($this->security->xss_clean('sale_price'));
                $food_menu_info['tax_information'] = $tax_information;
                $food_menu_info['vat_id'] = $this->input->post($this->security->xss_clean('vat_id'));
                $food_menu_info['user_id'] = $this->session->userdata('user_id');
                $food_menu_info['company_id'] = $this->session->userdata('company_id');
                if ($_FILES['photo']['name'] != "") {  

                    $food_menu_info['photo'] = $this->session->userdata('photo'); 
                    $this->session->unset_userdata('photo'); 
                }

                if ($id == "") {
                    $food_menu_id = $this->Common_model->insertInformation($food_menu_info, "tbl_food_menus"); 
                    $this->saveFoodMenusIngredients($_POST['ingredient_id'], $food_menu_id, 'tbl_food_menus_ingredients');
                    $data['autoCode'] = $this->Master_model->generateFoodMenuCode();
                    $this->session->set_flashdata('exception',lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($food_menu_info, $id, "tbl_food_menus");
                    $this->Common_model->deletingMultipleFormData('food_menu_id', $id, 'tbl_food_menus_ingredients');
                    $data['autoCode'] = $this->Master_model->generateFoodMenuCode();
                    $this->saveFoodMenusIngredients($_POST['ingredient_id'], $id, 'tbl_food_menus_ingredients');
                    $this->session->set_flashdata('exception', lang('update_success'));
                }

                redirect('Master/foodMenus');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['categories'] = $this->Common_model->getAllByCompanyId($company_id, 'tbl_food_menu_categories');
                    $data['autoCode'] = $this->Master_model->generateFoodMenuCode();
                    $data['ingredients'] = $this->Master_model->getIngredientListWithUnit($company_id);
                    $data['vats'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_vats');
                    $data['tax_fields'] = $this->Common_model->getAllByOutletId($outlet_id,'tbl_outlet_taxes');
                    $data['main_content'] = $this->load->view('master/foodMenu/addFoodMenu', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else { 
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['categories'] = $this->Common_model->getAllByCompanyId($company_id, 'tbl_food_menu_categories');
                    $data['autoCode'] = $this->Master_model->generateFoodMenuCode();
                    $data['ingredients'] = $this->Master_model->getIngredientListWithUnit($company_id);
                    $data['vats'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_vats');
                    $data['tax_fields'] = $this->Common_model->getAllByOutletId($outlet_id,'tbl_outlet_taxes');
                    $data['food_menu_details'] = $this->Common_model->getDataById($id, "tbl_food_menus");
                    $data['food_menu_ingredients'] = $this->Master_model->getFoodMenuIngredients($data['food_menu_details']->id); 
                    $data['main_content'] = $this->load->view('master/foodMenu/editFoodMenu', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['categories'] = $this->Common_model->getAllByCompanyId($company_id, 'tbl_food_menu_categories');
                $data['autoCode'] = $this->Master_model->generateFoodMenuCode();
                $data['ingredients'] = $this->Master_model->getIngredientListWithUnit($company_id);
                $data['vats'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_vats');
                $data['tax_fields'] = $this->Common_model->getAllByOutletId($outlet_id,'tbl_outlet_taxes');

                $data['main_content'] = $this->load->view('master/foodMenu/addFoodMenu', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['categories'] = $this->Common_model->getAllByCompanyId($company_id, 'tbl_food_menu_categories');
                $data['ingredients'] = $this->Master_model->getIngredientListWithUnit($company_id);
                $data['vats'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_vats');
                $data['tax_fields'] = $this->Common_model->getAllByOutletId($outlet_id,'tbl_outlet_taxes');
                $data['autoCode'] = $this->Master_model->generateFoodMenuCode();
                $data['food_menu_details'] = $this->Common_model->getDataById($id, "tbl_food_menus");
                $data['food_menu_ingredients'] = $this->Master_model->getFoodMenuIngredients($data['food_menu_details']->id);
                $data['main_content'] = $this->load->view('master/foodMenu/editFoodMenu', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    public function fixFoodMenus(){ /*
        $result = $this->db->query("SELECT * FROM tbl_food_menus")->result();
        $i = 1;
        foreach ($result as $key => $value) { 
            $name = ucwords(strtolower($value->name));
            $this->db->set('code', "0".$i);
            $this->db->set('name', $name);
            $this->db->update('tbl_food_menus');
            $this->db->where('id', $value->id);
            $i++;
        } */

        $result = $this->db->query("SELECT * FROM tbl_food_menus")->result(); 
        foreach ($result as $key => $value) {  
            $this->db->set('veg_item', "Veg No"); 
            $this->db->set('beverage_item', "Beverage No"); 
            $this->db->update('tbl_food_menus');
            $this->db->where('id', $value->id); 
        } 
    }

    public function validate_photo() {

        if ($_FILES['photo']['name'] != "") {
            $config['upload_path'] = './assets/POS/images';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = '2048';
            $config['maintain_ratio'] = TRUE;
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload("photo")) {
                
                $upload_info = $this->upload->data();


                // if ($upload_info['image_width'] != 142 || $upload_info['image_height'] != 80) {
                //     $this->form_validation->set_message('validate_photo', "File height must be 80px and width must be 142px");
                //     return FALSE;
                // }

                $photo = $upload_info['file_name']; 
                
                $config['image_library'] = 'gd2';
                $config['source_image'] = './assets/POS/images/'.$photo;
                // $config['create_thumb'] = TRUE;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 200;
                $config['height'] = 100;

                $this->load->library('image_lib', $config); 

                $this->image_lib->resize();
                $this->session->set_userdata('photo', $upload_info['file_name']);

            } else {
                $this->form_validation->set_message('validate_photo', $this->upload->display_errors());
                return FALSE;
            }
        }
    }

    public function saveFoodMenusIngredients($food_menu_ingredients, $food_menu_id, $table_name) {
        foreach ($food_menu_ingredients as $row => $ingredient_id):
            $fmi = array();
            $fmi['ingredient_id'] = $ingredient_id;
            $fmi['consumption'] = $_POST['consumption'][$row];
            $fmi['food_menu_id'] = $food_menu_id;
            $fmi['user_id'] = $this->session->userdata('user_id');
            $fmi['company_id'] = $this->session->userdata('company_id');
            $this->Common_model->insertInformation($fmi, "tbl_food_menus_ingredients");
        endforeach;
    }

    public function saveFoodMenusModifiers($food_menu_modifiers, $food_menu_id, $table_name) {
        foreach ($food_menu_modifiers as $row => $modifier_id):
            $fmm = array();
            $fmm['modifier_id'] = $modifier_id;
            $fmm['food_menu_id'] = $food_menu_id;
            $fmm['user_id'] = $this->session->userdata('user_id');
            $fmm['company_id'] = $this->session->userdata('company_id');
            $this->Common_model->insertInformation($fmm, "tbl_food_menus_modifiers");
        endforeach;
    }

    public function assignFoodMenuModifier($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $company_id = $this->session->userdata('company_id');
        $food_menu_modifiers = $this->Master_model->getFoodMenuModifiers($id);
        if (!empty($food_menu_modifiers)) {
            foreach ($food_menu_modifiers as $value) {
                $user_menu_modifier_arr[] = $value->modifier_id;
            }
        } else {
            $user_menu_modifier_arr = '';
        }

        if ($this->input->post('submit')) {
            $this->Common_model->deletingMultipleFormData('food_menu_id', $id, 'tbl_food_menus_modifiers');
            $this->saveFoodMenusModifiers($_POST['modifier_id'], $id, 'tbl_food_menus_modifiers');
            $this->session->set_flashdata('exception', 'Information has been updated successfully!');
            redirect('Master/foodMenus');
        } else {
            $data['encrypted_id'] = $encrypted_id;
            $data['modifiers'] = $this->Common_model->getAllModifierByCompanyId($company_id, 'tbl_modifiers');
            $data['food_menu_details'] = $this->Common_model->getDataById($id, "tbl_food_menus");
            $data['food_menu_modifiers'] = $user_menu_modifier_arr;
            $data['main_content'] = $this->load->view('master/foodMenu/assignFoodMenuModifier', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }

    public function foodMenuDetails($id) {
        $encrypted_id = $id;
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $data = array();
        $data['encrypted_id'] = $encrypted_id;
        $data['food_menu_details'] = $this->Common_model->getDataById($id, "tbl_food_menus");
        $data['main_content'] = $this->load->view('master/foodMenu/foodMenuDetails', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /* ----------------------Food Menu End-------------------------- */

    /* -------------------VAT Start------------------------ */

    public function VATs() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['VATs'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_vats");
        $data['main_content'] = $this->load->view('master/VAT/VAT', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    public function deleteVAT($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $this->Common_model->deleteStatusChange($id, "tbl_vats");

        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Master/VATs');
    }

    public function addEditVAT($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('name',lang('vat_name'), 'required|max_length[50]');
            $this->form_validation->set_rules('percentage', lang('percentage'), 'required');
            if ($this->form_validation->run() == TRUE) {
                $vat = array();
                $vat['name'] = htmlspecialchars($this->input->post($this->security->xss_clean('name')));
                $vat['percentage'] = $this->input->post($this->security->xss_clean('percentage'));
                $vat['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $this->Common_model->insertInformation($vat, "tbl_vats");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($vat, $id, "tbl_vats");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                redirect('Master/VATs');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('master/VAT/addEditVAT', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['VATs'] = $this->Common_model->getDataById($id, "tbl_vats");
                    $data['main_content'] = $this->load->view('master/VAT/addEditVAT', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('master/VAT/addEditVAT', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['VATs'] = $this->Common_model->getDataById($id, "tbl_vats");
                $data['main_content'] = $this->load->view('master/VAT/addEditVAT', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    /* ----------------------VAT End-------------------------- */

    /* -------------------Unit Start------------------------ */

    public function Units() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['Units'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_units");
        $data['main_content'] = $this->load->view('master/Unit/Units', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    public function deleteUnit($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $this->Common_model->deleteStatusChange($id, "tbl_units");

        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Master/Units');
    }

    public function addEditUnit($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('unit_name', lang('unit_name'), 'required');
            if ($this->form_validation->run() == TRUE) {
                $vat = array();
                $vat['unit_name'] = htmlspecialchars($this->input->post($this->security->xss_clean('unit_name')));
                $vat['description'] = $this->input->post($this->security->xss_clean('description'));
                $vat['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $this->Common_model->insertInformation($vat, "tbl_units");
                    $this->session->set_flashdata('exception',lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($vat, $id, "tbl_units");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                redirect('Master/Units');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('master/Unit/addEditUnit', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['Units'] = $this->Common_model->getDataById($id, "tbl_units");
                    $data['main_content'] = $this->load->view('master/Unit/addEditUnit', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('master/Unit/addEditUnit', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['Units'] = $this->Common_model->getDataById($id, "tbl_units");
                $data['main_content'] = $this->load->view('master/Unit/addEditUnit', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    /* ----------------------Vat End-------------------------- */

    /* -------------------Payment Method Start------------------------ */

    public function paymentMethods() {
        $company_id = $this->session->userdata('company_id');

        $data = array();
        $data['paymentMethods'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_payment_methods");
        $data['main_content'] = $this->load->view('master/paymentMethod/paymentMethods', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    public function deletePaymentMethod($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $this->Common_model->deleteStatusChange($id, "tbl_payment_methods");

        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Master/paymentMethods');
    }

    public function addEditPaymentMethod($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if($this->input->post('submit')) {
            $this->form_validation->set_rules('name', lang('payment_method_name'), 'required|max_length[50]');
            $this->form_validation->set_rules('description', lang('description'), 'max_length[50]');
            if ($this->form_validation->run() == TRUE) {
                $fmc_info = array();
                $fmc_info['name'] = htmlspecialchars($this->input->post($this->security->xss_clean('name')));
                $fmc_info['description'] = $this->input->post($this->security->xss_clean('description'));
                $fmc_info['user_id'] = $this->session->userdata('user_id');
                $fmc_info['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $this->Common_model->insertInformation($fmc_info, "tbl_payment_methods");
                    $this->session->set_flashdata('exception',lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($fmc_info, $id, "tbl_payment_methods");
                    $this->session->set_flashdata('exception',lang('delete_success'));
                }
                redirect('Master/paymentMethods');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('master/paymentMethod/addPaymentMethod', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['payment_method_information'] = $this->Common_model->getDataById($id, "tbl_payment_methods");
                    $data['main_content'] = $this->load->view('master/paymentMethod/editPaymentMethod', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('master/paymentMethod/addPaymentMethod', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['payment_method_information'] = $this->Common_model->getDataById($id, "tbl_payment_methods");
                $data['main_content'] = $this->load->view('master/paymentMethod/editPaymentMethod', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    /* ----------------------Payment Method End-------------------------- */

    /* ----------------------Table Start-------------------------- */

    public function tables() {
        $company_id = $this->session->userdata('company_id');

        $data = array();
        $data['tables'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_tables");
        $data['main_content'] = $this->load->view('master/table/tables', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    public function deleteTable($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $this->Common_model->deleteStatusChange($id, "tbl_tables");

        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Master/tables');
    }

    public function addEditTable($encrypted_id = "") {
        $company_id = $this->session->userdata('company_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('name',lang('table_name'), 'required|max_length[50]');
            $this->form_validation->set_rules('sit_capacity', lang('seat_capacity'), 'required|max_length[50]');
            $this->form_validation->set_rules('position', lang('position'), 'required|max_length[50]');
            $this->form_validation->set_rules('description',lang('description'), 'max_length[50]');
            if ($this->form_validation->run() == TRUE) {
                $igc_info = array();
                $igc_info['name'] = htmlspecialchars($this->input->post($this->security->xss_clean('name')));
                $igc_info['sit_capacity'] = htmlspecialchars($this->input->post($this->security->xss_clean('sit_capacity')));
                $igc_info['position'] = htmlspecialchars($this->input->post($this->security->xss_clean('position')));
                $igc_info['description'] = $this->input->post($this->security->xss_clean('description'));
                $igc_info['outlet_id'] = $outlet_id;
                $igc_info['user_id'] = $this->session->userdata('user_id');
                $igc_info['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $this->Common_model->insertInformation($igc_info, "tbl_tables");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($igc_info, $id, "tbl_tables");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                redirect('Master/tables');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['outlets'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_outlets');
                    $data['main_content'] = $this->load->view('master/table/addTable', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['outlets'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_outlets');
                    $data['table_information'] = $this->Common_model->getDataById($id, "tbl_tables");
                    $data['main_content'] = $this->load->view('master/table/editTable', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['outlets'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_outlets');
                $data['main_content'] = $this->load->view('master/table/addTable', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['outlets'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_outlets');
                $data['table_information'] = $this->Common_model->getDataById($id, "tbl_tables");
                $data['main_content'] = $this->load->view('master/table/editTable', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }
    public function openRegister(){
        $data = array();
        $data['main_content'] = $this->load->view('master/register/openRegister', $data, TRUE);
        $this->load->view('userHome', $data);
    }
    public function downloadPDF($file = "") {
        // load ci download helder
        $this->load->helper('download');
        $data = file_get_contents("asset/sample/" . $file); // Read the file's 
        $name = $file;
        force_download($name, $data);
    }

    public function get_cat_id($ingredint_category) {
        $company_id = $this->session->userdata('company_id');
        $user_id = $this->session->userdata('user_id');
        $id = $this->db->query("SELECT id FROM tbl_ingredient_categories WHERE user_id=$user_id and company_id=$company_id and category_name='" . $ingredint_category . "'")->row('id');
        if ($id != '') {
            return $id;
        } else {
            $data = array('category_name' => $ingredint_category, 'user_id' => $user_id, 'company_id' => $company_id);
            $query = $this->db->insert('tbl_ingredient_categories', $data);
            $id = $this->db->insert_id();
            return $id;
        }
    }

    public function get_unit_id($ingredint_unit) {
        $company_id = $this->session->userdata('company_id');
        $user_id = $this->session->userdata('user_id');
        $id = $this->db->query("SELECT id FROM tbl_units WHERE company_id=$company_id and unit_name='" . $ingredint_unit . "'")->row('id');
        if ($id != '') {
            return $id;
        } else {
            $data = array('unit_name' => $ingredint_unit, 'company_id' => $company_id);
            $query = $this->db->insert('tbl_units', $data);
            $id = $this->db->insert_id();
            return $id;
        }
    }

    //upload ingredients
    public function ExcelDataAddIngredints() {
        $company_id = $this->session->userdata('company_id');
        if ($_FILES['userfile']['name'] != "") {
            if ($_FILES['userfile']['name'] == "Ingredient_Upload.xlsx") {
                //Path of files were you want to upload on localhost (C:/xampp/htdocs/ProjectName/uploads/excel/)    
                $configUpload['upload_path'] = FCPATH . 'asset/excel/'; 
                $configUpload['allowed_types'] = 'xls|xlsx';
                $configUpload['max_size'] = '5000';
                $this->load->library('upload', $configUpload);
                if ($this->upload->do_upload('userfile')) {
                    $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
                    $file_name = $upload_data['file_name']; //uploded file name
                    $extension = $upload_data['file_ext'];    // uploded file extension
                    //$objReader =PHPExcel_IOFactory::createReader('Excel5');     //For excel 2003 
                    $objReader = PHPExcel_IOFactory::createReader('Excel2007'); // For excel 2007     
                    //Set to read only
                    $objReader->setReadDataOnly(true);
                    //Load excel file
                    $objPHPExcel = $objReader->load(FCPATH . 'asset/excel/' . $file_name);
                    $totalrows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();   //Count Numbe of rows avalable in excel        
                    $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
                    //loop from first data untill last data
                    if ($totalrows > 2 && $totalrows < 54) {
                        $arrayerror = '';
                        for ($i = 4; $i <= $totalrows; $i++) {
                            $ingredint_name = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(0, $i)->getValue()));
                            $ingredint_code = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(1, $i)->getValue())); //Excel Column 1
                            $ingredint_category = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(2, $i)->getValue())); //Excel Column 2
                            $ingredint_unit = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(3, $i)->getValue())); //Excel Column 3
                            $ingredint_alertqty = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(4, $i)->getValue())); //Excel Column 4
                            $ingredint_perchaseprice = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(5, $i)->getValue())); //Excel Column 5

                            if ($ingredint_name == '') {
                                if ($arrayerror == '') {
                                    $arrayerror.=" Row Number $i column A required";
                                } else {
                                    $arrayerror.="<br> Row Number $i column A required";
                                }
                            }

                            if ($ingredint_code == '') {
                                if ($arrayerror == '') {
                                    $arrayerror.="Row Number $i column B required";
                                } else {
                                    $arrayerror.="<br> Row Number $i column B required";
                                }
                            }

                            if ($ingredint_category == '') {
                                if ($arrayerror == '') {
                                    $arrayerror.="Row Number $i column C required";
                                } else {
                                    $arrayerror.="<br> $i Row Number column C required";
                                }
                            }

                            if ($ingredint_unit == '') {
                                if ($arrayerror == '') {
                                    $arrayerror.="Row Number $i column D required";
                                } else {
                                    $arrayerror.="<br> Row Number $i column D required";
                                }
                            }

                            if ($ingredint_alertqty == '' || !is_numeric($ingredint_alertqty)) {
                                if ($arrayerror == '') {
                                    $arrayerror.="Row Number $i column E required or can not be text";
                                } else {
                                    $arrayerror.="<br> Row Number $i column E required  or can not be text";
                                }
                            }

                            if ($ingredint_perchaseprice == '' || !is_numeric($ingredint_perchaseprice)) {
                                if ($arrayerror == '') {
                                    $arrayerror.="Row Number $i column F required or can not be text";
                                } else {
                                    $arrayerror.="<br> Row Number $i column F required or can not be text";
                                }
                            }
                        }
                        if ($arrayerror == '') {
                            if(!is_null($this->input->post('remove_previous'))){
                                $this->db->query("TRUNCATE table `tbl_ingredients`");
                            }
                            for ($i = 4; $i <= $totalrows; $i++) {
                                $ingredint_name = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(0, $i)->getValue()));
                                $ingredint_code = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(1, $i)->getValue())); //Excel Column 1
                                $ingredint_category = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(2, $i)->getValue())); //Excel Column 2
                                $ingredint_unit = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(3, $i)->getValue())); //Excel Column 3
                                $ingredint_alertqty = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(4, $i)->getValue())); //Excel Column 4
                                $ingredint_perchaseprice = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(5, $i)->getValue())); //Excel Column 5

                                $ingredint_unit = $this->get_unit_id($ingredint_unit);
                                $ingredint_category = $this->get_cat_id($ingredint_category);

                                $fmc_info = array();
                                $fmc_info['name'] = $ingredint_name;
                                $fmc_info['code'] = $ingredint_code;
                                $fmc_info['category_id'] = $ingredint_category;
                                $fmc_info['purchase_price'] = $ingredint_perchaseprice;
                                $fmc_info['alert_quantity'] = $ingredint_alertqty;
                                $fmc_info['unit_id'] = $ingredint_unit;
                                $fmc_info['user_id'] = $this->session->userdata('user_id');
                                $fmc_info['company_id'] = $this->session->userdata('company_id');
                                $this->Common_model->insertInformation($fmc_info, "tbl_ingredients");
                            }
                            unlink(FCPATH . 'asset/excel/' . $file_name); //File Deleted After uploading in database .       
                            $this->session->set_flashdata('exception', 'Imported successfully!');
                            redirect('Master/ingredients');
                        } else {
                            unlink(FCPATH . 'asset/excel/' . $file_name); //File Deleted After uploading in database . 
                            $this->session->set_flashdata('exception_err', "Required Data Missing:$arrayerror");
                        }
                    } else {
                        unlink(FCPATH . 'asset/excel/' . $file_name); //File Deleted After uploading in database . 
                        $this->session->set_flashdata('exception_err', "Entry is more than 50 or No entry found.");
                    }
                } else {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('exception_err', "$error");
                }
            } else {
                $this->session->set_flashdata('exception_err', "We can not accept other files, please download the sample file 'Ingredient_Upload.xlsx', fill it up properly and upload it or rename the file name as 'Ingredient_Upload.xlsx' then fill it.");
            }
        } else {
            $this->session->set_flashdata('exception_err', 'File is required');
        }
        redirect('Master/uploadingredients');
    }

    //upload food menu

    public function get_foodmenu_ct_id_byname($category) {
        $company_id = $this->session->userdata('company_id');
        $user_id = $this->session->userdata('user_id');
        $id = $this->db->query("SELECT id FROM tbl_food_menu_categories WHERE company_id=$company_id and user_id=$user_id and category_name='" . $category . "'")->row('id');
        if ($id != '') {
            return $id;
        } else {
            $data = array('category_name' => $category, 'company_id' => $company_id, 'user_id' => $user_id);
            $query = $this->db->insert('tbl_food_menu_categories', $data);
            $id = $this->db->insert_id();
            return $id;
        }
    }

    public function get_foodmenu_vat_id_byname($vat_name, $vat_percent) {
        $company_id = $this->session->userdata('company_id');
        $user_id = $this->session->userdata('user_id');
        $id = $this->db->query("SELECT id FROM tbl_vats WHERE company_id=$company_id and name='" . $vat_name . "'")->row('id'); 
        if ($id) {
            return $id;
        } else {
            $data = array('name' => $vat_name, 'company_id' => $company_id, 'percentage' => $vat_percent);
            $query = $this->db->insert('tbl_vats', $data);
            $id = $this->db->insert_id(); 
            return $id;
        }
    }

    public function ExcelDataAddFoodmenus() {
        $company_id = $this->session->userdata('company_id');
        if ($_FILES['userfile']['name'] != "") {
            if ($_FILES['userfile']['name'] == "Food_Menu_Upload.xlsx") {
                //Path of files were you want to upload on localhost (C:/xampp/htdocs/ProjectName/uploads/excel/)    
                $configUpload['upload_path'] = FCPATH . 'asset/excel/';
                $configUpload['allowed_types'] = 'xls|xlsx';
                $configUpload['max_size'] = '5000';
                $this->load->library('upload', $configUpload);
                if ($this->upload->do_upload('userfile')) {
                    $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
                    $file_name = $upload_data['file_name']; //uploded file name
                    $extension = $upload_data['file_ext'];    // uploded file extension
                    //$objReader =PHPExcel_IOFactory::createReader('Excel5');     //For excel 2003 
                    $objReader = PHPExcel_IOFactory::createReader('Excel2007'); // For excel 2007     
                    //Set to read only
                    $objReader->setReadDataOnly(true);
                    //Load excel file
                    $objPHPExcel = $objReader->load(FCPATH . 'asset/excel/' . $file_name);
                    $totalrows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();   //Count Numbe of rows avalable in excel        
                    $objWorksheet = $objPHPExcel->setActiveSheetIndex(0); 

                    //loop from first data untill last data
                    if ($totalrows > 2 && $totalrows < 54) {
                        $arrayerror = '';
                        for ($i = 4; $i <= $totalrows; $i++) {
                            $name = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(0, $i)->getValue()));
                            $code = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(1, $i)->getValue())); //Excel Column 1
                            $category = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(2, $i)->getValue())); //Excel Column 2
                            $sale_prices = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(3, $i)->getValue())); //Excel Column 3
                            $vat_name = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(4, $i)->getValue())); //Excel Column 4
                            $vat_percent = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(5, $i)->getValue())); //Excel Column 5
                            $description = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(6, $i)->getValue())); //Excel Column 5

                            $isVegItem = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(7, $i)->getValue())); //Excel Column 7
                            $isBeverage = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(8, $i)->getValue())); //Excel Column 8
                            $isBar = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(9, $i)->getValue())); //Excel Column 8

                            if ($name == '') {
                                if ($arrayerror == '') {
                                    $arrayerror.="Row Number $i column A required";
                                } else {
                                    $arrayerror.="<br>Row Number $i column A required";
                                }
                            }

                            if ($code == '') {
                                if ($arrayerror == '') {
                                    $arrayerror.="Row Number $i column B required";
                                } else {
                                    $arrayerror.="<br>Row Number $i column B required";
                                }
                            }

                            if ($category == '') {
                                if ($arrayerror == '') {
                                    $arrayerror.="Row Number $i column C required";
                                } else {
                                    $arrayerror.="<br>Row Number $i column C required";
                                }
                            }

                            if ($sale_prices == '' || !is_numeric($sale_prices)) {
                                if ($arrayerror == '') {
                                    $arrayerror.="Row Number $i column D required or can not be text";
                                } else {
                                    $arrayerror.="<br>Row Number $i column D required or can not be text";
                                }
                            }

                            if ($vat_name == '') {
                                if ($arrayerror == '') {
                                    $arrayerror.="Row Number $i column E required";
                                } else {
                                    $arrayerror.="<br>Row Number $i column E required";
                                }
                            }

                            if ($vat_percent == '' || !is_numeric($vat_percent)) {
                                if ($arrayerror == '') {
                                    $arrayerror.="Row Number $i column F required or can not be text";
                                } else {
                                    $arrayerror.="<br>Row Number $i column F required or can not be text";
                                }
                            } 

                            if (($isVegItem == '')) {
                                if ($arrayerror == '') {
                                    $arrayerror.="Row Number $i column H required";
                                } else {
                                    $arrayerror.="<br>Row Number $i column H required";
                                }
                            }
                            
                            if (($isVegItem != 'Veg Yes') && ($isVegItem != 'Veg No')) {
                                if ($arrayerror == '') {
                                    $arrayerror.="Row Number $i column H required or should be Veg Yes or Veg No";
                                } else {
                                    $arrayerror.="<br>Row Number $i column required H required or should be Veg Yes or Veg No";
                                }
                            } 
                            
                            if (($isBeverage == '')) {
                                if ($arrayerror == '') {
                                    $arrayerror.="Row Number $i column H required";
                                } else {
                                    $arrayerror.="<br>Row Number $i column H required";
                                }
                            }
                            
                            if (($isBeverage != 'Bev Yes') && ($isBeverage != 'Bev No')) {
                                if ($arrayerror == '') {
                                    $arrayerror.="Row Number $i column H required or should be Bev Yes or Bev No";
                                } else {
                                    $arrayerror.="<br>Row Number $i column required H required or should be Bev Yes or Bev No";
                                }
                            } 

                            if (($isBar == '')) {
                                if ($arrayerror == '') {
                                    $arrayerror.="Row Number $i column H required";
                                } else {
                                    $arrayerror.="<br>Row Number $i column H required";
                                }
                            }
                            
                            if (($isBar != 'Bar Yes') && ($isBar != 'Bar No')) {
                                if ($arrayerror == '') {
                                    $arrayerror.="Row Number $i column H required or should be Bar Yes or Bar No";
                                } else {
                                    $arrayerror.="<br>Row Number $i column required H required or should be Bar Yes or Bar No";
                                }
                            }  
                        }
                        if ($arrayerror == '') {
                            if(!is_null($this->input->post('remove_previous'))){
                                $this->db->query("TRUNCATE table `tbl_food_menus`");
                            }
                            for ($i = 4; $i <= $totalrows; $i++) {
                                $name = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(0, $i)->getValue()));
                                $code = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(1, $i)->getValue())); //Excel Column 1
                                $category = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(2, $i)->getValue())); //Excel Column 2
                                $sale_prices = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(3, $i)->getValue())); //Excel Column 3 
                                $vat_name = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(4, $i)->getValue())); //Excel Column 4 
                                $vat_percent = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(5, $i)->getValue())); //Excel Column 5
                                $description = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(6, $i)->getValue())); //Excel Column 5
                                $isVegItem = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(7, $i)->getValue())); //Excel Column 5
                                $isBeverage = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(8, $i)->getValue())); //Excel Column 5
                                $isBar = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(9, $i)->getValue())); //Excel Column 5

                                $ct_id = $this->get_foodmenu_ct_id_byname($category);
                                $vt_id = $this->get_foodmenu_vat_id_byname($vat_name, $vat_percent);
                                $fmc_info = array();
                                $fmc_info['name'] = $name;
                                $fmc_info['code'] = $code;
                                $fmc_info['category_id'] = $ct_id;
                                $fmc_info['sale_price'] = $sale_prices;
                                $fmc_info['vat_id'] = $vt_id;
                                $fmc_info['description'] = $description;
                                $fmc_info['veg_item'] = $isVegItem;
                                $fmc_info['beverage_item'] = $isBeverage;
                                $fmc_info['bar_item'] = $isBar;
                                $fmc_info['user_id'] = $this->session->userdata('user_id');
                                $fmc_info['company_id'] = $this->session->userdata('company_id');
                                $this->Common_model->insertInformation($fmc_info, "tbl_food_menus");
                            }
                            unlink(FCPATH . 'asset/excel/' . $file_name); //File Deleted After uploading in database .       
                            $this->session->set_flashdata('exception', 'Imported successfully!');
                            redirect('Master/foodMenus');
                        } else {
                            unlink(FCPATH . 'asset/excel/' . $file_name); //File Deleted After uploading in database . 
                            $this->session->set_flashdata('exception_err', "Required Data Missing:$arrayerror");
                        }
                    } else {
                        unlink(FCPATH . 'asset/excel/' . $file_name); //File Deleted After uploading in database . 
                        $this->session->set_flashdata('exception_err', "Entry is more than 50 or No entry found.");
                    }
                } else {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('exception_err', "$error");
                }
            } else {
                $this->session->set_flashdata('exception_err', "We can not accept other files, please download the sample file 'Ingredient_Upload.xlsx', fill it up properly and upload it or rename the file name as 'Ingredient_Upload.xlsx' then fill it.");
            }
        } else {
            $this->session->set_flashdata('exception_err', 'File is required');
        }
        redirect('Master/uploadFoodMenu');
    }

    public function get_food_menu_id($foodingredints) {

        $company_id = $this->session->userdata('company_id');
        $user_id = $this->session->userdata('user_id');
        $id = $this->db->query("SELECT id FROM tbl_food_menus WHERE company_id=$company_id and user_id=$user_id and name='" . $foodingredints . "'")->row('id');
        if ($id) {
            return $id;
        } else {
            $id = 0;
            return $id;
        }
    }

    public function get_foodmenu_ingredient_id($foodingredints) {

        $company_id = $this->session->userdata('company_id');
        $user_id = $this->session->userdata('user_id');
        $id = $this->db->query("SELECT id FROM tbl_ingredients WHERE company_id=$company_id and user_id=$user_id and name='" . $foodingredints . "'")->row('id');
        if ($id) {
            return $id;
        } else {
            $id = 0;
            return $id;
        }
    }

    public function ExcelDataAddFoodmenusingredient() {
        echo "hello";
        exit;
        $company_id = $this->session->userdata('company_id');
        if ($_FILES['userfile']['name'] != "") {
            if ($_FILES['userfile']['name'] == "Food_Menu_Ingredients_Upload.xlsx") {
                //Path of files were you want to upload on localhost (C:/xampp/htdocs/ProjectName/uploads/excel/)    
                $configUpload['upload_path'] = FCPATH . 'asset/excel/';
                $configUpload['allowed_types'] = 'xls|xlsx';
                $configUpload['max_size'] = '5000';
                $this->load->library('upload', $configUpload);
                if ($this->upload->do_upload('userfile')) {
                    $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
                    $file_name = $upload_data['file_name']; //uploded file name
                    $extension = $upload_data['file_ext'];    // uploded file extension
                    //$objReader =PHPExcel_IOFactory::createReader('Excel5');     //For excel 2003 
                    $objReader = PHPExcel_IOFactory::createReader('Excel2007'); // For excel 2007     
                    //Set to read only
                    $objReader->setReadDataOnly(true);
                    //Load excel file
                    $objPHPExcel = $objReader->load(FCPATH . 'asset/excel/' . $file_name);
                    $totalrows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();   //Count Numbe of rows avalable in excel     

                    $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
                    //loop from first data untill last data
                    if ($totalrows > 2 && $totalrows < 120) {
                        $arrayerror = '';
                        for ($i = 3; $i <= $totalrows; $i++) {

                            $name = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(0, $i)->getValue()));
                            $foodingredints = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(1, $i)->getValue())); //Excel Column 1
                            $consumption = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(2, $i)->getValue())); //Excel Column 2


                            $arrer = array();
                            if ($name == 'FM') {
                                $food_menu_id = $this->get_food_menu_id($foodingredints);

                                if ($food_menu_id == 0) {
                                    if ($arrayerror == '') {
                                        $arrayerror.=" $i Row Number column B required or not found in db";
                                    } else {
                                        $arrayerror.="<br> $i Row Number column B required not found in db";
                                    }
                                }
                            } else {
                                $food_menuingredient_id = $this->get_foodmenu_ingredient_id($name);

                                if ($food_menuingredient_id == 0) {
                                    if ($arrayerror == '') {
                                        $arrayerror.=" $i Row Number column A required or not found in db";
                                    } else {
                                        $arrayerror.="<br> $i Row Number column A required not found in db";
                                    }
                                }
                                if ($consumption == '' || !is_numeric($consumption)) {
                                    if ($arrayerror == '') {
                                        $arrayerror.=" $i Row Number column C required";
                                    } else {
                                        $arrayerror.="<br> $i Row Number column C required";
                                    }
                                }
                            }
                        }
                        if ($arrayerror == '') {
                            for ($i = 3; $i <= $totalrows; $i++) {

                                $name = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(0, $i)->getValue()));
                                $foodingredints = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(1, $i)->getValue())); //Excel Column 1
                                $consumption = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(2, $i)->getValue())); //Excel Column 2

                                $arrer = array();
                                if ($name == 'FM') {
                                    $food_menu_id = $this->get_food_menu_id($foodingredints);
                                    $this->session->set_userdata('food_menu_id', $food_menu_id);
                                } else {
                                    $food_menuingredient_id = $this->get_foodmenu_ingredient_id($name);
                                    $food_menu_id = $this->session->userdata('food_menu_id');
                                    $fmc_info = array();
                                    $fmc_info['ingredient_id'] = $food_menuingredient_id;
                                    $fmc_info['food_menu_id'] = $food_menu_id;
                                    $fmc_info['consumption'] = $consumption;
                                    $fmc_info['user_id'] = $this->session->userdata('user_id');
                                    $fmc_info['company_id'] = $this->session->userdata('company_id');
                                    $this->Common_model->insertInformation($fmc_info, "tbl_food_menus_ingredients");
                                }
                            }
                            unlink(FCPATH . 'asset/excel/' . $file_name); //File Deleted After uploading in database .       
                            $this->session->set_flashdata('exception', 'Imported successfully!');
                            redirect('Master/foodMenus');
                        } else {
                            unlink(FCPATH . 'asset/excel/' . $file_name); //File Deleted After uploading in database . 
                            $this->session->set_flashdata('exception_err', "Required Data Missing:$arrayerror");
                        }
                    } else {
                        unlink(FCPATH . 'asset/excel/' . $file_name); //File Deleted After uploading in database . 
                        $this->session->set_flashdata('exception_err', "Entry is more than 50 or No entry found.");
                    }
                } else {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('exception_err', "$error");
                }
            } else {
                $this->session->set_flashdata('exception_err', "We can not accept other files, please download the sample file 'Ingredient_Upload.xlsx', fill it up properly and upload it or rename the file name as 'Ingredient_Upload.xlsx' then fill it.");
            }
        } else {
            $this->session->set_flashdata('exception_err', 'File is required');
        }
        redirect('Master/uploadFoodMenuingredient');
    }
    public function ExcelDataAddCustomers()
    {   
        $company_id = $this->session->userdata('company_id');
        if ($_FILES['userfile']['name'] != "") {
            if ($_FILES['userfile']['name'] == "Customer_Upload.xlsx") {
                //Path of files were you want to upload on localhost (C:/xampp/htdocs/ProjectName/uploads/excel/)    
                $configUpload['upload_path'] = FCPATH . 'asset/excel/';
                $configUpload['allowed_types'] = 'xls|xlsx';
                $configUpload['max_size'] = '5000';
                $this->load->library('upload', $configUpload);
                if ($this->upload->do_upload('userfile')) {
                    $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
                    $file_name = $upload_data['file_name']; //uploded file name
                    $extension = $upload_data['file_ext'];    // uploded file extension
                    //$objReader =PHPExcel_IOFactory::createReader('Excel5');     //For excel 2003 
                    $objReader = PHPExcel_IOFactory::createReader('Excel2007'); // For excel 2007     
                    //Set to read only
                    $objReader->setReadDataOnly(true);
                    //Load excel file
                    $objPHPExcel = $objReader->load(FCPATH . 'asset/excel/' . $file_name);
                    $totalrows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();   //Count Numbe of rows avalable in excel        
                    $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
                    //loop from first data untill last data
                    if ($totalrows < 54) {
                        $arrayerror = '';
                        for ($i = 4; $i <= $totalrows; $i++) {
                            $name = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(0, $i)->getValue()));
                            $phone = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(1, $i)->getValue()));
                            $email = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(2, $i)->getValue()));
                            $dob = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(3, $i)->getValue()));
                            $doa = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(4, $i)->getValue()));
                            $delivery_address = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(5, $i)->getValue()));

                            if ($name == '') {
                                if ($arrayerror == '') {
                                    $arrayerror.="Row Number $i column A required";
                                } else {
                                    $arrayerror.="<br>Row Number $i column A required";
                                }
                            }

                            if ($phone == '') {
                                if ($arrayerror == '') {
                                    $arrayerror.="Row Number $i column B required";
                                } else {
                                    $arrayerror.="<br>Row Number $i column B required";
                                }
                            }

                            if ($email != '' && $this->validateEmail($email)==false) {
                                if ($arrayerror == '') {
                                    $arrayerror.="Row Number $i column C should be valid email";
                                } else {
                                    $arrayerror.="<br>Row Number $i column C should be valid email";
                                }
                            }

                            if ($dob != '' && $this->isValidDate($dob)==false) {
                                if ($arrayerror == '') {
                                    $arrayerror.="Row Number $i column D should be in YYYY-MM-DD format";
                                } else {
                                    $arrayerror.="<br>Row Number $i column D should be in YYYY-MM-DD format";
                                }
                            }

                            if ($doa != '' && $this->isValidDate($doa)==false) {
                                if ($arrayerror == '') {
                                    $arrayerror.="Row Number $i column E should be in YYYY-MM-DD format";
                                } else {
                                    $arrayerror.="<br>Row Number $i column E should be in YYYY-MM-DD format";
                                }
                            }
                        }
                        if ($arrayerror == '') {
                            if(!is_null($this->input->post('remove_previous'))){
                                $this->db->query("TRUNCATE table `tbl_customers`");
                            }
                            for ($i = 4; $i <= $totalrows; $i++) {
                                $name = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(0, $i)->getValue()));
                                $phone = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(1, $i)->getValue()));
                                $email = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(2, $i)->getValue()));
                                $dob = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(3, $i)->getValue()));
                                $doa = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(4, $i)->getValue()));
                                $delivery_address = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(5, $i)->getValue()));


                                $customer_info = array();
                                $customer_info['name'] = $name;
                                $customer_info['phone'] = $phone;
                                $customer_info['email'] = $email;
                                $customer_info['date_of_birth'] = $dob;
                                $customer_info['date_of_anniversary'] = $doa;
                                $customer_info['address'] = $delivery_address;
                                $customer_info['user_id'] = $this->session->userdata('user_id');
                                $customer_info['company_id'] = $this->session->userdata('company_id');
                                $this->Common_model->insertInformation($customer_info, "tbl_customers");
                            }
                            unlink(FCPATH . 'asset/excel/' . $file_name); //File Deleted After uploading in database .       
                            $this->session->set_flashdata('exception', 'Imported successfully!');
                            redirect('Master/customers');
                        } else {
                            unlink(FCPATH . 'asset/excel/' . $file_name); //File Deleted After uploading in database . 
                            $this->session->set_flashdata('exception_err', "Required Data Missing:$arrayerror");
                        }
                    } else {
                        unlink(FCPATH . 'asset/excel/' . $file_name); //File Deleted After uploading in database . 
                        $this->session->set_flashdata('exception_err', "Entry is more than 50 or No entry found.");
                    }
                } else {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('exception_err', "$error");
                }
            } else {
                $this->session->set_flashdata('exception_err', "We can not accept other files, please download the sample file 'Customer_Upload.xlsx', fill it up properly and upload it or rename the file name as 'Customer_Upload.xlsx' then fill it.");
            }
        } else {
            $this->session->set_flashdata('exception_err', 'File is required');
        }
        redirect('Master/uploadCustomer');   
    }
    public function ExcelDataAddFoodmenusIngredients()
    {    
        $company_id = $this->session->userdata('company_id');
        $user_id = $this->session->userdata('user_id');
        if ($_FILES['userfile']['name'] != "") {
            if ($_FILES['userfile']['name'] == "Food_Menu_Ingredients_Upload.xlsx") {
                //Path of files were you want to upload on localhost (C:/xampp/htdocs/ProjectName/uploads/excel/)    
                $configUpload['upload_path'] = FCPATH . 'asset/excel/';
                $configUpload['allowed_types'] = 'xls|xlsx';
                $configUpload['max_size'] = '5000';
                $this->load->library('upload', $configUpload);
                if ($this->upload->do_upload('userfile')) {
                    $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
                    $file_name = $upload_data['file_name']; //uploded file name
                    $extension = $upload_data['file_ext'];    // uploded file extension
                    //$objReader =PHPExcel_IOFactory::createReader('Excel5');     //For excel 2003 
                    $objReader = PHPExcel_IOFactory::createReader('Excel2007'); // For excel 2007     
                    //Set to read only
                    $objReader->setReadDataOnly(true);
                    //Load excel file
                    $objPHPExcel = $objReader->load(FCPATH . 'asset/excel/' . $file_name);
                    $totalrows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();   //Count Numbe of rows avalable in excel    
                    $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
                    //loop from first data untill last data
                    $totalFoodMenuToUpload = 0;
                    
                    if ($totalrows > 2) {
                        $arrayerror = '';
                        for ($i = 3; $i <= $totalrows; $i++) {
                            $menuOrIngredient = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(0, $i)->getValue()));
                            //it counts total number of food menus
                            if($menuOrIngredient=='FM'){
                                $totalFoodMenuToUpload++;
                            }
                        }
                        if($totalFoodMenuToUpload<10){
                            for ($i = 3; $i <= $totalrows; $i++) {
                                $menuOrIngredient = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(0, $i)->getValue()));
                                $menuOrIngredientName = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(1, $i)->getValue()));
                                $consumption = null; 
                                
                                $currentRowFor = ''; //it hold current row wether menu or ingredient
                                //it counts total number of food menus
                                if($menuOrIngredient=='FM'){
                                    $totalFoodMenuToUpload++;
                                    $record = $this->Common_model->getMenuByMenuName($menuOrIngredientName);
                                    $currentRowFor = 'Menu';
                                }else{
                                    $consumption = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(2, $i)->getValue()));
                                    $record = $this->Common_model->getIngredientByIngredientName($menuOrIngredientName);
                                    $currentRowFor = 'Ingredient';
                                }

                                //get next menu or ingredient
                                $isNextMenuOrIngredient = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(0, $i+1)->getValue()));
                                
                                // if any record is not found then set this message
                                if ($record==NULL) {
                                    if ($arrayerror == '') {
                                        $arrayerror.="Row Number $i column B required & must be valid menu or ingredient name";
                                    } else {
                                        $arrayerror.="<br>Row Number $i column B required & must be valid menu or ingredient name";
                                    }
                                }                            


                                // //it sets message when it's not menu and ingredient as well
                                if ($menuOrIngredient!="FM" && $menuOrIngredient!="IG") {
                                    if ($arrayerror == '') {
                                        $arrayerror.="Row Number $i column A required & must be 'FM' or 'IG'";
                                    } else {
                                        $arrayerror.="<br>Row Number $i column A required & must be 'FM' or 'IG'";
                                    }
                                }

                                if ($menuOrIngredient == 'IG' && ($consumption == null || $consumption == '' || !is_numeric($consumption))) {
                                    if ($arrayerror == '') {
                                        $arrayerror.=" $i Row Number column C required, it must be numeric";
                                    } else {
                                        $arrayerror.="<br> $i Row Number column C required, it must be numeric";
                                    }
                                }

                                //it sets message when food menu number is greater than 10
                                if ($totalFoodMenuToUpload>10) {
                                    if ($arrayerror == '') {
                                        $arrayerror.="You can not upload more than 10 food menus at a time.";
                                    } else {
                                        $arrayerror.="<br>You can not upload more than 10 food menus at a time.";
                                    }
                                }

                                //it checks next one is food menu or ingredient. if current one is food menu and next one 
                                //is food menu then it means current food menu doesn't have ingredients
                                if($menuOrIngredient=='FM' && $isNextMenuOrIngredient=='FM'){
                                    if ($arrayerror == '') {
                                        $arrayerror.="row number $i is a Food Menu, no ingredient found for $menuOrIngredientName";
                                    } else {
                                        $arrayerror.="<br>row number $i is a Food Menu, no ingredient found for $menuOrIngredientName";
                                    }
                                }
                            }
                            if ($arrayerror == '') {
                                if(!is_null($this->input->post('remove_previous'))){
                                    $this->db->query("TRUNCATE table `tbl_food_menus_ingredients`");
                                }
                                for ($i = 3; $i <= $totalrows; $i++) {
                                    $menuOrIngredient = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(0, $i)->getValue()));
                                    $menuOrIngredientName = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(1, $i)->getValue()));
                                    $consumption = null; 
                                    
                                    if($menuOrIngredient=='FM'){
                                        $food_menu_record = $this->Common_model->getMenuByMenuName($menuOrIngredientName);
                                    }else{
                                        $ingredient_record = $this->Common_model->getIngredientByIngredientName($menuOrIngredientName);
                                        $consumption = htmlspecialchars(trim($objWorksheet->getCellByColumnAndRow(2, $i)->getValue()));
                                        
                                        $food_menu_ingredient_info = array();
                                        $food_menu_ingredient_info['ingredient_id'] = $ingredient_record->id;
                                        $food_menu_ingredient_info['consumption'] = $consumption;
                                        $food_menu_ingredient_info['food_menu_id'] = $food_menu_record->id;
                                        $food_menu_ingredient_info['user_id'] = $this->session->userdata('user_id');
                                        $food_menu_ingredient_info['company_id'] = $this->session->userdata('company_id');
                                        $food_menu_ingredient_info['del_status'] = 'Live';
                                        
                                        $this->Common_model->insertInformation($food_menu_ingredient_info, "tbl_food_menus_ingredients");
                                    }

                                }
                                unlink(FCPATH . 'asset/excel/' . $file_name); //File Deleted After uploading in database .       
                                $this->session->set_flashdata('exception', 'Imported successfully!');
                                redirect('Master/foodMenus');
                            } else {
                                unlink(FCPATH . 'asset/excel/' . $file_name); //File Deleted After uploading in database . 
                                $this->session->set_flashdata('exception_err', "Required Data Missing:$arrayerror");
                            }
                        }else{
                            unlink(FCPATH . 'asset/excel/' . $file_name); //File Deleted After uploading in database . 
                            $this->session->set_flashdata('exception_err', "You can not upload more than 10 food menus at a time.");
                        }
                        
                    } else {
                        unlink(FCPATH . 'asset/excel/' . $file_name); //File Deleted After uploading in database . 
                        $this->session->set_flashdata('exception_err', "No entry found.");
                    }
                } else {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('exception_err', "$error");
                }
            } else {
                $this->session->set_flashdata('exception_err', "We can not accept other files, please download the sample file 'Food_Menu_Ingredients_Upload.xlsx', fill it up properly and upload it or rename the file name as 'Food_Menu_Ingredients_Upload.xlsx' then fill it.");
            }
        } else {
            $this->session->set_flashdata('exception_err', 'File is required');
        }
        redirect('Master/uploadFoodMenuIngredients');   
    }
    function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    function isValidDate($date){
        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) {
            return true;
        } else {
            return false;
        }
    }
    //this function returns all purchases amount of current outlet, user of current date
    public function getAllPurchasesOfCurrentDate()
    {
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');

        $total_purchase_amount_of_this_user = $this->Common_model->getPurchaseAmountByUserAndOutletId($user_id,$outlet_id);
        return $total_purchase_amount_of_this_user->total_purchase_amount;
    }
    
    
    /* ----------------------Table End-------------------------- */
}
