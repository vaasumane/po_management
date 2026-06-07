<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    date_default_timezone_set('Asia/Kolkata');
  }

  public function logout()
  {
    // $this->session->sess_destroy();
    $this->session->unset_userdata('admi_user_data');
    $this->session->unset_userdata('admi_role_access');
    $this->_set_flashdata_and_redirect('User', 'Logout Successful', 'success');
  }

  private function _set_flashdata_and_redirect($url, $msg, $class)
  {
    $this->session->set_flashdata('flash_msg', $msg);
    $this->session->set_flashdata('class', $class);
    return header('location:' . base_url() . '' . $url);
  }


  /*********************************** Login ***************************************/
  public function index()
  {
    $admi_user_data = $this->session->userdata('admi_user_data');
    if (empty($admi_user_data)) {
      $this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required');
      $this->form_validation->set_rules('password', 'Password', 'trim|required');
      if ($this->form_validation->run() == FALSE) {
        $this->load->view('Admin/User/login');
      } else {
        $mobile = $this->input->post('mobile');
        $password = $this->input->post('password');
        $login = $this->Master_Model->get_data('admi_user', 'company_id,user_id,role_id,user_name,user_lastname,user_image,user_mobile,user_email,process_type_id,department_id,user_status', ['user_mobile' => $mobile, 'user_password' => $password], '', 'row_array');
        print_r($login);
        if (!empty($login)) {
          if ($login['user_status'] != '1') {
            $this->_set_flashdata_and_redirect('User', 'Your account is inactive', 'error');
          } else {
            $this->session->set_userdata('admi_user_data', $login);
            $this->_set_flashdata_and_redirect('User/dashboard', 'Login Successful', 'success');
          }
        } else {
          $this->_set_flashdata_and_redirect('User', 'Invalid Mobile Number or Password', 'error');
        }
      }
    } else {
      $this->_set_flashdata_and_redirect('User/dashboard', 'You are already loged in', 'info');
    }
  }



  /************************************** Dashboard ************************************/
  public function dashboard()
  {
    $admi_user_data = $this->session->userdata('admi_user_data');
    // if(empty($admi_user_data)){ header('location:'.base_url().'User'); }

    $login = $this->Master_Model->get_data('admi_user', 'company_id,user_id,role_id,user_name,user_lastname,user_image,user_mobile,user_email,process_type_id,department_id,user_status', ['user_id' => $admi_user_data['user_id'], 'user_status' => '1'], '', 'row_array');
    if (empty($login)) {
      $this->_set_flashdata_and_redirect('User/logout', 'Invalid User Details', 'error');
    } else {
      $this->session->set_userdata('admi_user_data', $login);
    }

    $admi_user_data = $this->session->userdata('admi_user_data');
    if (empty($admi_user_data)) {
      header('location:' . base_url() . 'User');
    }

    $role_info = $this->Master_Model->get_data('admi_role', 'role_access', ['role_id' => $admi_user_data['role_id']], '', 'row_array');
    $admi_role_access = explode(',', $role_info['role_access']);
    $this->session->set_userdata('admi_role_access', $admi_role_access);
    $data['role_access'] = $admi_role_access;
    $data['sess_user_data'] = $admi_user_data;
    $data['role_id'] = $admi_user_data['role_id'];

    $data['user_cnt'] = $this->Master_Model->get_data('admi_user', 'user_id', ['company_id' => $admi_user_data['company_id'], 'is_admin' => '0'], '`user_id` ASC', 'num_rows');
    $data['party_cnt'] = $this->Master_Model->get_data('admi_party', 'party_id', ['company_id' => $admi_user_data['company_id']], '`party_id` ASC', 'num_rows');
    $data['department_cnt'] = $this->Master_Model->get_data('admi_department', 'department_id', ['company_id' => $admi_user_data['company_id']], '`department_id` ASC', 'num_rows');
    $data['process_type_cnt'] = $this->Master_Model->get_data('admi_process_type', 'process_type_id', ['company_id' => $admi_user_data['company_id']], '`process_type_id` ASC', 'num_rows');
    $data['item_cnt'] = $this->Master_Model->get_data('admi_item', 'item_id', ['company_id' => $admi_user_data['company_id']], '`item_id` ASC', 'num_rows');

    $data['dispatch_cnt'] = $this->Master_Model->get_data('admi_dispatch', 'dispatch_id', ['company_id' => $admi_user_data['company_id']], '`dispatch_id` ASC', 'num_rows');
    if ($admi_user_data['role_id'] == '1') {
      $data['job_process_cnt'] = $this->Master_Model->get_data('admi_job_process', 'job_process_id', ['company_id' => $admi_user_data['company_id']], '`job_process_id` ASC', 'num_rows');
    } else {
      $data['job_process_cnt'] = $this->Master_Model->get_data('admi_job_process', 'job_process_id', ['company_id' => $admi_user_data['company_id'], 'job_process_addedby' => $admi_user_data['user_id']], '`job_process_id` ASC', 'num_rows');
    }

    $data['purchase_order_cnt'] = $this->Master_Model->get_data('admi_purchase_order', 'purchase_order_id', ['company_id' => $admi_user_data['company_id']], '`purchase_order_id` ASC', 'num_rows');


    $data['main_menu'] = "Dashboard";
    $data['sub_menu'] = "Dashboard";
    $data['page'] = 'Admin Dashboard';
    $this->load->view('Admin/Include/head', $data);
    $this->load->view('Admin/Include/navbar', $data);
    $this->load->view('Admin/User/dashboard', $data);
    $this->load->view('Admin/Include/footer', $data);
  }

  /**************************************************************************************************/
  /**************************************** User Information ****************************************/
  /**************************************************************************************************/


  /*********************************** Add User - user1 ********************************/

  public function user_information()
  {
    $admi_user_data = $this->session->userdata('admi_user_data');
    $admi_role_access = $this->session->userdata('admi_role_access');
    if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("user1", $admi_role_access))) {
      header('location:' . base_url() . 'User');
    }
    $data['role_access'] = $admi_role_access;
    $data['sess_user_data'] = $admi_user_data;
    $data['role_id'] = $admi_user_data['role_id'];

    $this->form_validation->set_rules('user_name', 'First Name', 'trim|required');
    if ($this->form_validation->run() != FALSE) {
      $user_status = $this->input->post('user_status');
      if (!isset($user_status)) {
        $user_status = '1';
      }
      $save_data = $_POST;
      $user_name = $_POST['user_name'];
      $user_name = trim($user_name);
      $user_name = ucwords($user_name);
      $save_data['user_name'] = $user_name;
      $save_data['user_status'] = $user_status;
      $save_data['company_id'] = $admi_user_data['company_id'];
      $save_data['user_addedby'] = $admi_user_data['user_id'];
      $save_data['user_created_at'] = date('Y-m-d H:i:s');
      $save_data['process_type_id'] = "";
      $save_data['department_id'] = "";

      $check_mob = $this->Master_Model->get_data('admi_user', 'user_id', ['company_id' => $admi_user_data['company_id'], 'user_mobile' => $_POST['user_mobile']], '`user_id` ASC', 'row_array');


      if (empty($check_mob)) {
        $user_id = $this->Master_Model->save_data('admi_user', $save_data);
        foreach ($_POST['process_type_id'] as $key => $value) {
          $dataProcee['user_id'] = $user_id;
          $dataProcee['process_type_id'] = $value;
          $this->Master_Model->save_data('user_process_type', $dataProcee);
        }

        foreach ($_POST['department_id'] as $key => $value) {
          $dataProceedata['user_id'] = $user_id;
          $dataProceedata['department_id'] = $value;
          $this->Master_Model->save_data('user_dept', $dataProceedata);
        }

        // Upload Image...
        if ($_FILES['user_image']['name']) {
          $time = time();
          $image_name = 'user_' . $user_id . '_' . $time;
          $config['upload_path'] = 'assets/images/master/';
          $config['allowed_types'] = 'jpg|jpeg|png|PNG|gif';
          $config['file_name'] = $image_name;
          $filename = $_FILES['user_image']['name'];
          $ext = pathinfo($filename, PATHINFO_EXTENSION);
          $this->upload->initialize($config); // if upload library autoloaded
          if ($this->upload->do_upload('user_image') && $user_id && $image_name && $ext && $filename) {
            $user_image_up['user_image'] =  $image_name . '.' . $ext;
            $this->Master_Model->update_info('user_id', $user_id, 'admi_user', $user_image_up);
            $this->session->set_flashdata('flash_msg2', 'User Image Uploaded Successfully');
            $this->session->set_flashdata('flash_class2', 'success');
          } else {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('flash_msg2', $error);
            $this->session->set_flashdata('flash_class2', 'error');
          }
        }
        $this->_set_flashdata_and_redirect('User/user_information', 'User Information Saved Successfully', 'success');
      } else {
        $this->_set_flashdata_and_redirect('User/user_information', 'Mobile number exist. User Information Not Saved', 'error');
      }

      // echo $user_id;
    }

    $data['role_list'] = $this->Master_Model->get_data('admi_role', '*', '', '`role_id` ASC', 'result');
    // $data['country_list'] = $this->Master_Model->get_data('country','*','','`country_name` ASC','result');
    // $data['state_list'] = $this->Master_Model->get_data('state','*','','`state_name` ASC','result');
    // $data['district_list'] = $this->Master_Model->get_data('district','*','','`district_name` ASC','result');
    // $data['city_list'] = $this->Master_Model->get_data('city','*','','`city_name` ASC','result');

    $data['user_list'] = $this->Master_Model->get_data('admi_user', '*', ['company_id' => $admi_user_data['company_id'], 'is_admin' => '0'], '`user_id` ASC', 'result');
    $data['process_type_list'] = $this->Master_Model->get_data('admi_process_type', '*', ['company_id' => $admi_user_data['company_id']], '`process_type_name` ASC', 'result');

    $data['main_menu'] = "Company";
    $data['sub_menu'] = "User";
    $data['page'] = 'User';
    $this->load->view('Admin/Include/head', $data);
    $this->load->view('Admin/Include/navbar', $data);
    $this->load->view('Admin/User/user_information', $data);
    $this->load->view('Admin/Include/footer', $data);
  }


  /*********************************** Edit/Update User - user3 ********************************/

  public function edit_user($user_id)
  {
    $admi_user_data = $this->session->userdata('admi_user_data');
    $admi_role_access = $this->session->userdata('admi_role_access');
    if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("user3", $admi_role_access))) {
      header('location:' . base_url() . 'User');
    }
    $data['role_access'] = $admi_role_access;
    $data['sess_user_data'] = $admi_user_data;
    $data['role_id'] = $admi_user_data['role_id'];

    $user_info = $this->Master_Model->get_info_arr('user_id', $user_id, 'admi_user');
    if (!$user_info) {
      header('location:' . base_url() . 'User/user_information');
    }

    $this->form_validation->set_rules('user_name', 'First Name', 'trim|required');
    if ($this->form_validation->run() != FALSE) {
      $user_status = $this->input->post('user_status');
      if (!isset($user_status)) {
        $user_status = '1';
      }
      $update_data = $_POST;
      $user_name = $_POST['user_name'];
      $user_name = trim($user_name);
      $user_name = ucwords($user_name);
      $update_data['user_name'] = $user_name;
      unset($update_data['old_user_image']);
      $update_data['user_status'] = $user_status;
      $update_data['user_updatedby'] = $admi_user_data['user_id'];
      $update_data['user_updated_at'] = date('Y-m-d H:i:s');
      $update_data['process_type_id'] = "";
      $update_data['user_updated_at'] = "";

      $check_mob = $this->Master_Model->get_data('admi_user', 'user_id', ['company_id' => $admi_user_data['company_id'], 'user_mobile' => $_POST['user_mobile']], '`user_id` ASC', 'row_array');

      if ($check_mob && $_POST['user_mobile'] != $user_info[0]['user_mobile']) {
        $this->_set_flashdata_and_redirect('User/user_information', 'Mobile number exist, Record not saved', 'error');
      } else {
        $this->Master_Model->update_info('user_id', $user_id, 'admi_user', $update_data);
        $current_process = $this->db
          ->select('process_type_id')
          ->where('user_id', $user_id)
          ->get('user_process_type')
          ->result_array();

        $current_process = array_column($current_process, 'process_type_id');
        $new_process = $this->input->post('process_type_id');

        // New IDs to insert
        $insert_process = array_diff($new_process, $current_process);

        // IDs to delete
        $delete_process = array_diff($current_process, $new_process);

        // Insert new
        foreach ($insert_process as $process_id) {
          $this->Master_Model->save_data('user_process_type', [
            'user_id' => $user_id,
            'process_type_id' => $process_id
          ]);
        }

        // Delete removed
        if (!empty($delete_process)) {
          $this->db->where('user_id', $user_id);
          $this->db->where_in('process_type_id', $delete_process);
          $this->db->delete('user_process_type');
        }
       

        $current_dept = $this->db
    ->select('department_id')
    ->where('user_id', $user_id)
    ->get('user_dept')
    ->result_array();

$current_dept = array_column($current_dept, 'department_id');
$new_dept = $this->input->post('department_id');

// New IDs to insert
$insert_dept = array_diff($new_dept, $current_dept);

// IDs to delete
$delete_dept = array_diff($current_dept, $new_dept);

// Insert new
foreach ($insert_dept as $dept_id) {
    $this->Master_Model->save_data('user_dept', [
        'user_id' => $user_id,
        'department_id' => $dept_id
    ]);
}

// Delete removed
if (!empty($delete_dept)) {
    $this->db->where('user_id', $user_id);
    $this->db->where_in('department_id', $delete_dept);
    $this->db->delete('user_dept');
}

        // Image Upload...
        if ($_FILES['user_image']['name']) {
          $time = time();
          $image_name = 'user_' . $user_id . '_' . $time;
          $config['upload_path'] = 'assets/images/master/';
          $config['allowed_types'] = 'jpg|jpeg|png|PNG|gif';
          $config['file_name'] = $image_name;
          $filename = $_FILES['user_image']['name'];
          $ext = pathinfo($filename, PATHINFO_EXTENSION);
          $this->upload->initialize($config); // if upload library autoloaded
          if ($this->upload->do_upload('user_image') && $user_id && $image_name && $ext && $filename) {
            $user_image_up['user_image'] =  $image_name . '.' . $ext;
            $this->Master_Model->update_info('user_id', $user_id, 'admi_user', $user_image_up);
            if ($_POST['old_user_img']) {
              unlink("assets/images/master/" . $_POST['old_user_img']);
            }
            $this->session->set_flashdata('flash_msg2', 'User Image Uploaded Successfully');
            $this->session->set_flashdata('flash_class2', 'success');
          } else {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('flash_msg2', $error);
            $this->session->set_flashdata('flash_class2', 'error');
          }
        }
        $this->_set_flashdata_and_redirect('User/user_information', 'User Information Updated Successfully', 'info');
      }
    }


    $data['update'] = 'update';
    $data['update_user'] = 'update';
    $data['user_info'] = $user_info[0];
    $data['act_link'] = base_url() . 'User/edit_user/' . $user_id;

    $process_type_id = $user_info[0]['process_type_id'];

    $data['role_list'] = $this->Master_Model->get_data('admi_role', '*', '', '`role_id` ASC', 'result');
    // $data['country_list'] = $this->Master_Model->get_data('country','*','','`country_name` ASC','result');
    // $data['state_list'] = $this->Master_Model->get_data('state','*','','`state_name` ASC','result');
    // $data['district_list'] = $this->Master_Model->get_data('district','*','','`district_name` ASC','result');
    // $data['city_list'] = $this->Master_Model->get_data('city','*','','`city_name` ASC','result');

    $data['user_list'] = $this->Master_Model->get_data('admi_user', '*', ['company_id' => $admi_user_data['company_id'], 'is_admin' => '0'], '`user_id` ASC', 'result');
    $data['process_type_list'] = $this->Master_Model->get_data('admi_process_type', '*', ['company_id' => $admi_user_data['company_id']], '`process_type_name` ASC', 'result');
    // $data['department_list'] = $this->Master_Model->get_data('admi_department','*',['company_id'=>$admi_user_data['company_id'], 'process_type_id'=>$process_type_id],'`department_name` ASC','result');
    $data['user_department_list'] = $this->Master_Model->get_data('user_dept', 'department_id', ['user_id' => $user_id], '`id` ASC', 'result');


    $data['user_process_list'] = $this->Master_Model->get_data('user_process_type', 'process_type_id', ['user_id' => $user_id], '`id` ASC', 'result');
    $selected_process = array_column($data['user_process_list'], 'process_type_id');
    $selected_department = array_column($data['user_department_list'], 'department_id');

    $data['selected_process'] = $selected_process;
    $this->db->select('*');
    $this->db->from('admi_department');
    $this->db->where_in('process_type_id', $selected_process);
    $this->db->order_by('department_name', 'ASC');
    $data['department_list'] = $this->db->get()->result();

    $data['selected_department'] = $selected_department;
    $data['main_menu'] = "Company";
    $data['sub_menu'] = "User";
    $data['page'] = 'Edit User';
    $this->load->view('Admin/Include/head', $data);
    $this->load->view('Admin/Include/navbar', $data);
    $this->load->view('Admin/User/user_information', $data);
    $this->load->view('Admin/Include/footer', $data);
  }


  /*********************************** Delete User - user4 ********************************/

  public function delete_user($user_id)
  {
    $admi_user_data = $this->session->userdata('admi_user_data');
    $admi_role_access = $this->session->userdata('admi_role_access');
    if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("user4", $admi_role_access))) {
      header('location:' . base_url() . 'User');
    }
    $data['role_access'] = $admi_role_access;
    $data['sess_user_data'] = $admi_user_data;
    $data['role_id'] = $admi_user_data['role_id'];

    $user_info = $this->Master_Model->get_data('admi_user', 'user_image, user_id', ['user_id' => $user_id], '`user_id` ASC', 'row_array');
    if ($user_info) {
      $user_image = $user_info['user_image'];
      if ($user_image) {
        unlink("assets/images/master/" . $user_image);
      }
    }
    $is_delete = $this->Master_Model->delete_info('user_id', $user_id, 'admi_user');
    if ($is_delete['code'] == '1451') {
      $this->_set_flashdata_and_redirect('User/user_information', 'Can not delete, User information is used', 'error');
    } else {
      $this->_set_flashdata_and_redirect('User/user_information', 'User Information Deleted Successfully', 'error');
    }
  }


  /*********************************** User Profile - user5 ********************************/

  public function user_profile()
  {
    $admi_user_data = $this->session->userdata('admi_user_data');
    $admi_role_access = $this->session->userdata('admi_role_access');
    if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("user5", $admi_role_access))) {
      header('location:' . base_url() . 'User');
    }
    $data['role_access'] = $admi_role_access;
    $data['sess_user_data'] = $admi_user_data;
    $data['role_id'] = $admi_user_data['role_id'];

    $user_id = $admi_user_data['user_id'];

    $user_info = $this->Master_Model->get_data('admi_user', '*', ['user_id' => $user_id], '`user_id` ASC', 'row_array');
    if (!$user_info) {
      $this->_set_flashdata_and_redirect('User/dashboard', 'Invalid User', 'error');
    }

    $this->form_validation->set_rules('user_name', 'First Name', 'trim|required');
    if ($this->form_validation->run() != FALSE) {
      $update_data = $_POST;
      unset($update_data['old_user_image']);
      $update_data['user_updatedby'] = $admi_user_data['user_id'];
      $update_data['user_updated_at'] = date('Y-m-d H:i:s');

      $check_mob = $this->Master_Model->get_data('admi_user', 'user_id', ['company_id' => $admi_user_data['company_id'], 'user_mobile' => $_POST['user_mobile']], '`user_id` ASC', 'row_array');

      if ($check_mob && $_POST['user_mobile'] != $user_info['user_mobile']) {
        $this->_set_flashdata_and_redirect('User/user_profile', 'Mobile number exist, Information not saved', 'error');
      } else {
        $this->Master_Model->update_info('user_id', $user_id, 'admi_user', $update_data);
        // Upload Image...
        if ($_FILES['user_image']['name']) {
          $time = time();
          $image_name = 'user_' . $user_id . '_' . $time;
          $config['upload_path'] = 'assets/images/master/';
          $config['allowed_types'] = 'jpg|jpeg|png|PNG|gif';
          $config['file_name'] = $image_name;
          $filename = $_FILES['user_image']['name'];
          $ext = pathinfo($filename, PATHINFO_EXTENSION);
          $this->upload->initialize($config); // if upload library autoloaded
          if ($this->upload->do_upload('user_image') && $user_id && $image_name && $ext && $filename) {
            $user_image_up['user_image'] =  $image_name . '.' . $ext;
            $this->Master_Model->update_info('user_id', $user_id, 'admi_user', $user_image_up);
            if ($_POST['old_user_img']) {
              unlink("assets/images/master/" . $_POST['old_user_img']);
            }
            $this->session->set_flashdata('flash_msg1', 'User Image Uploaded Successfully');
            $this->session->set_flashdata('flash_class1', 'success');
          } else {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('flash_msg1', $error);
            $this->session->set_flashdata('flash_class1', 'error');
          }
        }
      }
      $this->_set_flashdata_and_redirect('User/dashboard', 'Profile Information Updated Successfully', 'info');
    }


    $data['update'] = 'update';
    $data['user_info'] = $user_info;

    $data['role_list'] = $this->Master_Model->get_data('admi_role', '*', '', '`role_id` ASC', 'result');
    // $data['country_list'] = $this->Master_Model->get_data('country','*','','`country_name` ASC','result');
    // $data['state_list'] = $this->Master_Model->get_data('state','*','','`state_name` ASC','result');
    // $data['district_list'] = $this->Master_Model->get_data('district','*','','`district_name` ASC','result');
    // $data['city_list'] = $this->Master_Model->get_data('city','*','','`city_name` ASC','result');

    $data['page'] = 'Edit Profile';
    $data['main_menu'] = "Company";
    $data['sub_menu'] = "User";
    $this->load->view('Admin/Include/head', $data);
    $this->load->view('Admin/Include/navbar', $data);
    $this->load->view('Admin/User/user_profile', $data);
    $this->load->view('Admin/Include/footer', $data);
  }


  /**************************************************************************************************/

  public function forgot_password()
  {
    $this->load->view('Admin/User/forgot_password');
  }
}
