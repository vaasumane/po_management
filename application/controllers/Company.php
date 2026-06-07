<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller{
  public function __construct(){
    parent::__construct();
    date_default_timezone_set('Asia/Kolkata');
  }

  private function _set_flashdata_and_redirect($url,$msg,$class){
    $this->session->set_flashdata('flash_msg',$msg);
    $this->session->set_flashdata('class',$class);
    return header('location:'.base_url().''.$url);
  }

/*************************************************************************************************/
/********************************************** Company ******************************************/
/*************************************************************************************************/

  /********************************** Company List - company1 ***********************************/
  public function company_list(){
    $admi_user_data = $this->session->userdata('admi_user_data');
    $admi_role_access = $this->session->userdata('admi_role_access');
    if(empty($admi_user_data) || ( $admi_user_data['role_id'] != 1 && !in_array("company1", $admi_role_access))){ header('location:'.base_url().'User'); }
    $data['role_access'] = $admi_role_access;
    $data['sess_user_data'] = $admi_user_data;
    $data['role_id'] = $admi_user_data['role_id'];

    $data['company_list'] = $this->Master_Model->get_data('company','*',['company_id'=>$admi_user_data['company_id']],'`company_id` ASC','result');
    $data['page'] = 'Company';
    $data['main_menu'] = "Company";
    $data['sub_menu'] = "Company Information";
    $this->load->view('Admin/Include/head', $data);
    $this->load->view('Admin/Include/navbar', $data);
    $this->load->view('Admin/Company/company_list', $data);
    $this->load->view('Admin/Include/footer', $data);
  }


  /********************************* Edit Company - company3 ************************************/
  public function edit_company(){
    $admi_user_data = $this->session->userdata('admi_user_data');
    $admi_role_access = $this->session->userdata('admi_role_access');
    if(empty($admi_user_data) || ( $admi_user_data['role_id'] != 1 && !in_array("company3", $admi_role_access))){ header('location:'.base_url().'User'); }
    $data['role_access'] = $admi_role_access;
    $data['sess_user_data'] = $admi_user_data;
    $data['role_id'] = $admi_user_data['role_id'];

    $this->form_validation->set_rules('company_name', 'company_name', 'trim|required');
    $this->form_validation->set_rules('company_address', 'company_address', 'trim|required');
    if ($this->form_validation->run() != FALSE) {
      $up_data = $_POST;
      unset($up_data['old_company_logo']);
      unset($up_data['old_company_fevicon']);
      $up_data['update_by'] = $admi_user_id;
      $up_data['update_date'] = date('Y-m-d H:i:s');
      $this->Master_Model->update_info('company_id', $admi_user_data['company_id'], 'company', $up_data);

      if($_FILES['company_logo']['name']){
        $time = time();
        $image_name = 'company_logo_'.$admi_user_data['company_id'].'_'.$time;
        $config['upload_path'] = 'assets/images/master/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['file_name'] = $image_name;
        $filename = $_FILES['company_logo']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $this->upload->initialize($config); // if upload library autoloaded
        if ($this->upload->do_upload('company_logo') && $admi_user_data['company_id'] && $image_name && $ext && $filename){
          $company_logo_up['company_logo'] =  $image_name.'.'.$ext;
          $this->Master_Model->update_info('company_id', $admi_user_data['company_id'], 'company', $company_logo_up);
          if($_POST['old_company_logo']){ unlink("assets/images/master/".$_POST['old_company_logo']); }
          $this->session->set_flashdata('flash_msg1','File Uploaded Successfully');
          $this->session->set_flashdata('flash_class1','success');
        }
        else{
          $error = $this->upload->display_errors();
          $this->session->set_flashdata('flash_msg1',$error);
          $this->session->set_flashdata('flash_class1','error');
        }
      }

      if($_FILES['company_fevicon']['name']){
        $time = time();
        $image_name = 'company_fevicon_'.$admi_user_data['company_id'].'_'.$time;
        $config['upload_path'] = 'assets/images/master/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['file_name'] = $image_name;
        $filename = $_FILES['company_fevicon']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $this->upload->initialize($config); // if upload library autoloaded
        if ($this->upload->do_upload('company_fevicon') && $admi_user_data['company_id'] && $image_name && $ext && $filename){
          $company_fevicon_up['company_fevicon'] =  $image_name.'.'.$ext;
          $this->Master_Model->update_info('company_id', $admi_user_data['company_id'], 'company', $company_fevicon_up);
          if($_POST['old_company_fevicon']){ unlink("assets/images/master/".$_POST['old_company_fevicon']); }
          $this->session->set_flashdata('flash_msg2','File Uploaded Successfully');
          $this->session->set_flashdata('flash_class2','success');
        }
        else{
          $error = $this->upload->display_errors();
          $this->session->set_flashdata('flash_msg2',$error);
          $this->session->set_flashdata('flash_class2','error');
        }
      }
      $this->_set_flashdata_and_redirect('Company/company_list','Company Information Updated Successfully','info');
    }

    $company_info = $this->Master_Model->get_data('company','*',['company_id'=>$admi_user_data['company_id']],'`company_id` ASC','row_array');
    if(!$company_info){ header('location:'.base_url().'Company/company_list'); }
    $data['update'] = 'update';
    $data['update_company'] = 'update';
    $data['company_info'] = $company_info;
    $data['act_link'] = base_url().'Company/edit_company/'.$admi_user_data['company_id'];

    $country_id = $company_info['country_id'];
    $state_id = $company_info['state_id'];
    $data['country_list'] = $this->Master_Model->get_data('country','*',['country_id'=>'101'],'`country_name` ASC','result');
    $data['state_list'] = $this->Master_Model->get_data('state','*',['country_id'=>$country_id],'`state_name` ASC','result');
    $data['district_list'] = $this->Master_Model->get_data('district','*',['state_id'=>$state_id],'`district_name` ASC','result');
    $data['city_list'] = $this->Master_Model->get_data('city','*',['state_id'=>$state_id],'`city_name` ASC','result');

    $data['page'] = 'Update Company';
    $data['main_menu'] = "Company";
    $data['sub_menu'] = "Company Information";
    $this->load->view('Admin/Include/head', $data);
    $this->load->view('Admin/Include/navbar', $data);
    $this->load->view('Admin/Company/company_information', $data);
    $this->load->view('Admin/Include/footer', $data);
  }




/**************************************************************************************************/
/**************************************** Role Information ****************************************/
/**************************************************************************************************/


  /*********************************** Add Role - role1 ********************************/

    public function role(){
      $admi_user_data = $this->session->userdata('admi_user_data');
      $admi_role_access = $this->session->userdata('admi_role_access');
      if(empty($admi_user_data) || ( $admi_user_data['role_id'] != 1 && !in_array("role1", $admi_role_access))){ header('location:'.base_url().'User'); }
      $data['role_access'] = $admi_role_access;
      $data['sess_user_data'] = $admi_user_data;
      $data['role_id'] = $admi_user_data['role_id'];

      $this->form_validation->set_rules('role_name', 'Role Name', 'trim|required');
      if ($this->form_validation->run() != FALSE) {
        $role_status = $this->input->post('role_status');
        if(!isset($role_status)){ $role_status = '1'; }

        $role_access = $this->input->post('role_access');
        if(!isset($role_access)){ $role_access = ''; }
        else{ $role_access = implode(',',$role_access); }

        $save_data = $_POST;
        $save_data['role_status'] = $role_status;
        $save_data['role_access'] = $role_access;
        $save_data['company_id'] = $admi_user_data['company_id'];
        $save_data['role_addedby'] = $admi_user_data['user_id'];
        $role_id = $this->Master_Model->save_data('admi_role', $save_data);
        if($role_id){
          $this->_set_flashdata_and_redirect('Company/role','Role Saved Successfully','success');
        } else{
          $this->_set_flashdata_and_redirect('Company/role','Role Not Saved','error');
        }
      }
      $data['role_list'] = $this->Master_Model->get_data('admi_role','*',['company_id'=>$admi_user_data['company_id']],'`role_id` ASC','result');
      
      $data['main_menu'] = "Company";
      $data['sub_menu'] = "Role";
      $data['page'] = 'Role';
      $this->load->view('Admin/Include/head', $data);
      $this->load->view('Admin/Include/navbar', $data);
      $this->load->view('Admin/Company/role', $data);
      $this->load->view('Admin/Include/footer', $data);
    }


  /*********************************** Edit/Update Role - role3 ********************************/

    public function edit_role($role_id){
      $admi_user_data = $this->session->userdata('admi_user_data');
      $admi_role_access = $this->session->userdata('admi_role_access');
      if(empty($admi_user_data) || ( $admi_user_data['role_id'] != 1 && !in_array("role3", $admi_role_access))){ header('location:'.base_url().'User'); }
      $data['role_access'] = $admi_role_access;
      $data['sess_user_data'] = $admi_user_data;
      $data['role_id'] = $admi_user_data['role_id'];

      $this->form_validation->set_rules('role_name', 'Role Name', 'trim|required');
      if ($this->form_validation->run() != FALSE) {
        $role_status = $this->input->post('role_status');
        if(!isset($role_status)){ $role_status = '1'; }
        $update_data = $_POST;

        $role_access = $this->input->post('role_access');
        if(!isset($role_access)){ $role_access = ''; }
        else{ $role_access = implode(',',$role_access); }
        $update_data['role_access'] = $role_access;

        $update_data['role_status'] = $role_status;
				$update_data['role_access'] = $role_access;
        $update_data['role_addedby'] = $admi_user_data['user_id'];
        $this->Master_Model->update_info('role_id', $role_id, 'admi_role', $update_data);

				$this->_set_flashdata_and_redirect('Company/role','Role updated successfully','success');
      }

      $role_info = $this->Master_Model->get_data('admi_role','*',['role_id'=>$role_id],'`role_id` ASC','row_array');
      if(!$role_info){ header('location:'.base_url().'Company/role'); }
      $data['update'] = 'update';
      $data['update_role'] = 'update';
      $data['role_info'] = $role_info;
      $data['act_link'] = base_url().'Company/edit_role/'.$role_id;

      $data['role_list'] = $this->Master_Model->get_data('admi_role','*',['company_id'=>$admi_user_data['company_id']],'`role_id` ASC','result');
      
      $data['main_menu'] = "Company";
      $data['sub_menu'] = "Role";
      $data['page'] = 'Edit Role';
      $this->load->view('Admin/Include/head', $data);
      $this->load->view('Admin/Include/navbar', $data);
      $this->load->view('Admin/Company/role', $data);
      $this->load->view('Admin/Include/footer', $data);
    }


  /*********************************** Delete Role - role4 ********************************/

    public function delete_role($role_id){
      $admi_user_data = $this->session->userdata('admi_user_data');
      $admi_role_access = $this->session->userdata('admi_role_access');
      if(empty($admi_user_data) || ( $admi_user_data['role_id'] != 1 && !in_array("role4", $admi_role_access))){ header('location:'.base_url().'User'); }
      $data['role_access'] = $admi_role_access;
      $data['sess_user_data'] = $admi_user_data;
      $data['role_id'] = $admi_user_data['role_id'];

      $is_delete = $this->Master_Model->delete_info('role_id', $role_id, 'admi_role');
      if ($is_delete['code'] == '1451'){
        $this->_set_flashdata_and_redirect('Company/role','Role information is used, can not delete','error');
      } else{
				$this->_set_flashdata_and_redirect('Company/role','Role deleted successfully','error');
      }
      header('location:'.base_url().'Company/role');
    }



/**************************************************************************************************/
/**************************************** Branch Information ****************************************/
/**************************************************************************************************/


  /*********************************** Add Branch - branch1 ********************************/

  public function branch(){
    $admi_user_data = $this->session->userdata('admi_user_data');
    $admi_role_access = $this->session->userdata('admi_role_access');
    if(empty($admi_user_data) || ( $admi_user_data['role_id'] != 1 && !in_array("branch1", $admi_role_access))){ header('location:'.base_url().'User'); }
    $data['role_access'] = $admi_role_access;
    $data['sess_user_data'] = $admi_user_data;
    $data['role_id'] = $admi_user_data['role_id'];

    $this->form_validation->set_rules('branch_name', 'Branch Name', 'trim|required');
    if ($this->form_validation->run() != FALSE) {
      $branch_status = $this->input->post('branch_status');
      if(!isset($branch_status)){ $branch_status = '1'; }

      $save_data = $_POST;
      $save_data['branch_status'] = $branch_status;
      // $save_data['company_id'] = $admi_user_data['company_id'];
      $save_data['branch_created_at'] = date('Y-m-d H:i:s');
      $save_data['branch_addedby'] = $admi_user_data['user_id'];
      $branch_id = $this->Master_Model->save_data('admi_branch', $save_data);

      if($branch_id){
        $this->_set_flashdata_and_redirect('Company/branch','Branch Saved Successfully','success');
      } else{
        $this->_set_flashdata_and_redirect('Company/branch','Branch Not Saved','error');
      }
    }
    $data['company_list'] = $this->Master_Model->get_data('company','*',['company_id'=>$admi_user_data['company_id']],'`company_name` ASC','result');
    $data['country_list'] = $this->Master_Model->get_data('country','*',['country_id'=>'101'],'`country_name` ASC','result');

    $data['branch_list'] = $this->Master_Model->get_data('admi_branch','*',['company_id'=>$admi_user_data['company_id']],'`branch_id` DESC','result');
    $data['page'] = 'Branch';
    $this->load->view('Admin/Include/head', $data);
    $this->load->view('Admin/Include/navbar', $data);
    $this->load->view('Admin/Company/branch', $data);
    $this->load->view('Admin/Include/footer', $data);
  }


  /*********************************** Edit/Update Branch - branch3 ********************************/

  public function edit_branch($branch_id){
    $admi_user_data = $this->session->userdata('admi_user_data');
    $admi_role_access = $this->session->userdata('admi_role_access');
    if(empty($admi_user_data) || ( $admi_user_data['role_id'] != 1 && !in_array("branch3", $admi_role_access))){ header('location:'.base_url().'User'); }
    $data['role_access'] = $admi_role_access;
    $data['sess_user_data'] = $admi_user_data;
    $data['role_id'] = $admi_user_data['role_id'];

    $this->form_validation->set_rules('branch_name', 'Branch Name', 'trim|required');
    if ($this->form_validation->run() != FALSE) {
      $branch_status = $this->input->post('branch_status');
      if(!isset($branch_status)){ $branch_status = '1'; }

      $update_data = $_POST;
      $update_data['branch_status'] = $branch_status;
      $update_data['branch_updatedby'] = $admi_user_id;
      $update_data['branch_updated_at'] = date('Y-m-d H:i:s');
      $this->Master_Model->update_info('branch_id', $branch_id, 'admi_branch', $update_data);

      $this->session->set_flashdata('update_success','success');
      header('location:'.base_url().'Company/branch');
    }

    $branch_info = $this->Master_Model->get_data('admi_branch','*',['branch_id'=>$branch_id],'`branch_id` ASC','row_array');
    if(!$branch_info){ $this->_set_flashdata_and_redirect('Company/branch','Invalid Branch','error'); }
    $data['update'] = 'update';
    $data['update_branch'] = 'update';
    $data['branch_info'] = $branch_info;
    $data['act_link'] = base_url().'Company/edit_branch/'.$branch_id;

    $country_id = $branch_info['country_id'];
    $state_id = $branch_info['state_id'];
    $data['country_list'] = $this->Master_Model->get_data('country','*',['country_id'=>'101'],'`country_name` ASC','result');
    $data['state_list'] = $this->Master_Model->get_data('state','*',['country_id'=>$country_id],'`state_name` ASC','result');
    $data['city_list'] = $this->Master_Model->get_data('city','*',['state_id'=>$state_id],'`city_name` ASC','result');
    $data['company_list'] = $this->Master_Model->get_data('company','*',['company_id'=>$admi_user_data['company_id']],'`company_name` ASC','result');

    $data['branch_list'] = $this->Master_Model->get_data('admi_branch','*',['company_id'=>$admi_user_data['company_id']],'`branch_id` DESC','result');
    $data['page'] = 'Edit Branch';
    $this->load->view('Admin/Include/head', $data);
    $this->load->view('Admin/Include/navbar', $data);
    $this->load->view('Admin/Company/branch', $data);
    $this->load->view('Admin/Include/footer', $data);
  }


  /*********************************** Delete Branch - branch4 ********************************/

  public function delete_branch($branch_id){
    $admi_user_data = $this->session->userdata('admi_user_data');
    $admi_role_access = $this->session->userdata('admi_role_access');
    if(empty($admi_user_data) || ( $admi_user_data['branch_id'] != 1 && !in_array("branch4", $admi_role_access))){ header('location:'.base_url().'User'); }
    $data['role_access'] = $admi_role_access;
    $data['sess_user_data'] = $admi_user_data;
    $data['branch_id'] = $admi_user_data['branch_id'];

    $is_delete = $this->Master_Model->delete_info('branch_id', $branch_id, 'admi_branch');
    if ($is_delete['code'] == '1451'){
      $this->session->set_flashdata('delete_used','error');
    } else{
      $this->session->set_flashdata('delete_success','success');
    }
    header('location:'.base_url().'Company/branch');
  }




}
