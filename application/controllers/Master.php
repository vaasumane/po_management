<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
	}

	private function _set_flashdata_and_redirect($url, $msg, $class)
	{
		$this->session->set_flashdata('flash_msg', $msg);
		$this->session->set_flashdata('class', $class);
		return header('location:' . base_url() . '' . $url);
	}



	/***********************************************************************************************************/
	/**************************************** Slider Information ****************************************/
	/***********************************************************************************************************/


	/*********************************** Add Slider - slider1 ********************************/

	public function slider()
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("slider1", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$this->form_validation->set_rules('slider_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$slider_status = $this->input->post('slider_status');
			if (!isset($slider_status)) {
				$slider_status = '1';
			}

			$save_data = $_POST;
			$save_data['slider_status'] = $slider_status;
			$save_data['company_id'] = $admi_user_data['company_id'];
			$save_data['slider_addedby'] = $admi_user_data['user_id'];
			$save_data['slider_created_at'] = date('Y-m-d H:i:s');

			$check_dup = $this->Master_Model->get_data('admi_slider', 'slider_id', ['company_id' => $admi_user_data['company_id'], 'slider_name' => $_POST['slider_name']], '`slider_id` ASC', 'row_array');

			if (empty($check_dup)) {
				$slider_id = $this->Master_Model->save_data('admi_slider', $save_data);
				if ($slider_id) {
					// Upload Slider Image...
					if (isset($_FILES['slider_image']['name']) && $_FILES['slider_image']['name']) {
						$time = time();
						$image_name = 'slider_image_' . $slider_id . '_' . $time;
						$config['upload_path'] = 'assets/images/slider/';
						$config['allowed_types'] = 'jpg|jpeg|png|PNG|gif';
						$config['file_name'] = $image_name;
						$filename = $_FILES['slider_image']['name'];
						$ext = pathinfo($filename, PATHINFO_EXTENSION);
						$this->upload->initialize($config); // if upload library autoloaded
						if ($this->upload->do_upload('slider_image') && $slider_id && $image_name && $ext && $filename) {
							$slider_image_up['slider_image'] =  $image_name . '.' . $ext;
							$this->Master_Model->update_info('slider_id', $slider_id, 'admi_slider', $slider_image_up);
							$this->session->set_flashdata(['flash_msg2' => 'Slider Image Uploaded Successfully', 'flash_class2' => 'success']);
						} else {
							$error = $this->upload->display_errors();
							$this->session->set_flashdata(['flash_msg2' => $error, 'flash_class2' => 'error']);
						}
					} else {
						$this->session->set_flashdata(['flash_msg1' => 'Slider image not selected', 'flash_class1' => 'error']);
					}
					$this->_set_flashdata_and_redirect('Master/slider', 'Slider Saved Successfully', 'success');
				} else {
					$this->_set_flashdata_and_redirect('Master/slider', 'Slider Not Saved', 'error');
				}
			} else {
				$this->_set_flashdata_and_redirect('Master/slider', 'This Slider Exist', 'error');
			}
		}
		$data['slider_list'] = $this->Master_Model->get_data('admi_slider', '*', ['company_id' => $admi_user_data['company_id']], '`slider_id` DESC', 'result');
		$data['page'] = 'Slider';
		$data['main_menu'] = "Master";
		$data['sub_menu'] = "Slider";
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/slider', $data);
		$this->load->view('Admin/Include/footer', $data);
	}


	/*********************************** Edit/Update Slider - slider3 ********************************/

	public function edit_slider($slider_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("slider3", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$slider_info = $this->Master_Model->get_info_arr('slider_id', $slider_id, 'admi_slider');
		if (!$slider_info) {
			header('location:' . base_url() . 'Master/slider');
		}

		$this->form_validation->set_rules('slider_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$slider_status = $this->input->post('slider_status');
			if (!isset($slider_status)) {
				$slider_status = '1';
			}
			$update_data = $_POST;
			unset($update_data['old_slider_image']);
			$update_data['slider_status'] = $slider_status;
			$update_data['slider_updatedby'] = $admi_user_data['user_id'];
			$update_data['slider_updated_at'] = date('Y-m-d H:i:s');

			$check_dup = $this->Master_Model->get_data('admi_slider', 'slider_id', ['company_id' => $admi_user_data['company_id'], 'slider_name' => $_POST['slider_name']], '`slider_id` ASC', 'row_array');

			if ($check_dup && $_POST['slider_name'] != $slider_info[0]['slider_name']) {
				$this->_set_flashdata_and_redirect('Master/slider', 'This Slider Exist', 'error');
			} else {
				$this->Master_Model->update_info('slider_id', $slider_id, 'admi_slider', $update_data);
				// Upload Slider Image...
				if (isset($_FILES['slider_image']['name']) && $_FILES['slider_image']['name']) {
					$time = time();
					$image_name = 'slider_image_' . $slider_id . '_' . $time;
					$config['upload_path'] = 'assets/images/slider/';
					$config['allowed_types'] = 'jpg|jpeg|png|PNG|gif';
					$config['file_name'] = $image_name;
					$filename = $_FILES['slider_image']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					$this->upload->initialize($config); // if upload library autoloaded
					if ($this->upload->do_upload('slider_image') && $slider_id && $image_name && $ext && $filename) {
						$slider_image_up['slider_image'] =  $image_name . '.' . $ext;
						$this->Master_Model->update_info('slider_id', $slider_id, 'admi_slider', $slider_image_up);
						// Delete old image...
						if ($_POST['old_slider_image']) {
							unlink("assets/images/slider/" . $_POST['old_slider_image']);
						}
						$this->session->set_flashdata(['flash_msg2' => 'Slider Image Uploaded Successfully', 'flash_class2' => 'success']);
					} else {
						$error = $this->upload->display_errors();
						$this->session->set_flashdata(['flash_msg2' => $error, 'flash_class2' => 'error']);
					}
				}
			}
			$this->_set_flashdata_and_redirect('Master/slider', 'Slider Information Updated Successfully', 'info');
		}
		$data['update'] = 'update';
		$data['update_slider'] = 'update';
		$data['slider_info'] = $slider_info[0];
		$data['act_link'] = base_url() . 'Master/edit_slider/' . $slider_id;

		$data['slider_list'] = $this->Master_Model->get_data('admi_slider', '*', ['company_id' => $admi_user_data['company_id']], '`slider_id` DESC', 'result');
		$data['page'] = 'Edit Slider';
		$data['main_menu'] = "Master";
		$data['sub_menu'] = "Slider";
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/slider', $data);
		$this->load->view('Admin/Include/footer', $data);
	}


	/*********************************** Delete Slider - slider4 ********************************/

	public function delete_slider($slider_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("slider4", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$slider_info = $this->Master_Model->get_data('admi_slider', 'slider_image, slider_id', ['slider_id' => $slider_id], '`slider_id` ASC', 'row_array');

		$is_delete = $this->Master_Model->delete_info('slider_id', $slider_id, 'admi_slider');
		if ($is_delete['code'] == '1451') {
			$this->_set_flashdata_and_redirect('Master/slider', 'Can not delete, Slider information is used', 'error');
		} else {
			if ($slider_info) {
				$slider_image = $slider_info['slider_image'];
				if ($slider_image) {
					unlink("assets/images/slider/" . $slider_image);
				}
			}
			$this->_set_flashdata_and_redirect('Master/slider', 'Slider Information Deleted Successfully', 'error');
		}
	}


	/**************************************************************************************************/
	/********************************************** Tax Rate ********************************************/
	/**************************************************************************************************/

	/*********************************** Add Tax Rate - tax_rate1 ********************************/
	public function tax_rate()
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("tax_rate1", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$this->form_validation->set_rules('tax_rate_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$tax_rate_status = $this->input->post('tax_rate_status');
			if (!isset($tax_rate_status)) {
				$tax_rate_status = '1';
			}

			$save_data = $_POST;
			$save_data['tax_rate_status'] = $tax_rate_status;
			$save_data['company_id'] = $admi_user_data['company_id'];
			$save_data['tax_rate_addedby'] = $admi_user_data['user_id'];
			$save_data['tax_rate_created_at'] = date('Y-m-d H:i:s');
			$tax_rate_id = $this->Master_Model->save_data('admi_tax_rate', $save_data);

			if ($tax_rate_id) {
				$this->_set_flashdata_and_redirect('Master/tax_rate', 'Tax Rate Saved Successfully', 'success');
			} else {
				$this->_set_flashdata_and_redirect('Master/tax_rate', 'Tax Rate Not Saved', 'error');
			}
		}

		$data['tax_rate_list'] = $this->Master_Model->get_data('admi_tax_rate', '*', ['company_id' => $admi_user_data['company_id']], '`tax_rate_id` DESC', 'result');
		$data['main_menu'] = "Master";
		$data['sub_menu'] = "Tax Rate";
		$data['page'] = 'Tax Rate';
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/tax_rate', $data);
		$this->load->view('Admin/Include/footer', $data);
	}


	/*********************************** Edit/Update Tax Rate - tax_rate3 ********************************/
	public function edit_tax_rate($tax_rate_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("tax_rate3", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$this->form_validation->set_rules('tax_rate_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$tax_rate_status = $this->input->post('tax_rate_status');
			if (!isset($tax_rate_status)) {
				$tax_rate_status = '1';
			}
			$update_data = $_POST;
			$update_data['tax_rate_status'] = $tax_rate_status;
			$update_data['tax_rate_updatedby'] = $admi_user_data['user_id'];
			$update_data['tax_rate_updated_at'] = date('Y-m-d H:i:s');
			$this->Master_Model->update_info('tax_rate_id', $tax_rate_id, 'admi_tax_rate', $update_data);

			$this->_set_flashdata_and_redirect('Master/tax_rate', 'Tax Rate Information Updated Successfully', 'info');
		}

		$tax_rate_info = $this->Master_Model->get_data('admi_tax_rate', '*', ['company_id' => $admi_user_data['company_id'], 'tax_rate_id' => $tax_rate_id], '`tax_rate_id` DESC', 'row_array');
		if (!$tax_rate_info) {
			$this->_set_flashdata_and_redirect('Master/tax_rate', 'Invalid Tax Rate', 'error');
		}
		$data['update'] = 'update';
		$data['tax_rate_info'] = $tax_rate_info;

		$data['tax_rate_list'] = $this->Master_Model->get_data('admi_tax_rate', '*', ['company_id' => $admi_user_data['company_id']], '`tax_rate_id` DESC', 'result');
		$data['main_menu'] = "Master";
		$data['sub_menu'] = "Tax Rate";
		$data['page'] = 'Edit Tax Rate';
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/tax_rate', $data);
		$this->load->view('Admin/Include/footer', $data);
	}

	/*********************************** Delete Tax Rate - tax_rate4 ********************************/
	public function delete_tax_rate($tax_rate_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("tax_rate4", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$is_delete = $this->Master_Model->delete_info('tax_rate_id', $tax_rate_id, 'admi_tax_rate');
		if ($is_delete['code'] == '1451') {
			$this->_set_flashdata_and_redirect('Master/tax_rate', 'Can not delete, Tax Rate information is used', 'error');
		} else {
			$this->_set_flashdata_and_redirect('Master/tax_rate', 'Tax Rate Information Deleted Successfully', 'error');
		}
	}


	/**************************************************************************************************/
	/********************************************** Unit ********************************************/
	/**************************************************************************************************/

	/*********************************** Add Unit - unit1 ********************************/
	public function unit()
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("unit1", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$this->form_validation->set_rules('unit_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$unit_status = $this->input->post('unit_status');
			if (!isset($unit_status)) {
				$unit_status = '1';
			}

			$save_data = $_POST;
			$save_data['unit_status'] = $unit_status;
			$save_data['company_id'] = $admi_user_data['company_id'];
			$save_data['unit_addedby'] = $admi_user_data['user_id'];
			$save_data['unit_created_at'] = date('Y-m-d H:i:s');
			$unit_id = $this->Master_Model->save_data('admi_unit', $save_data);

			if ($unit_id) {
				$this->_set_flashdata_and_redirect('Master/unit', 'Unit Saved Successfully', 'success');
			} else {
				$this->_set_flashdata_and_redirect('Master/unit', 'Unit Not Saved', 'error');
			}
		}

		$data['unit_list'] = $this->Master_Model->get_data('admi_unit', '*', ['company_id' => $admi_user_data['company_id']], '`unit_id` DESC', 'result');
		$data['main_menu'] = "Master";
		$data['sub_menu'] = "Unit";
		$data['page'] = 'Unit';
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/unit', $data);
		$this->load->view('Admin/Include/footer', $data);
	}


	/*********************************** Edit/Update Unit - unit3 ********************************/
	public function edit_unit($unit_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("unit3", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$this->form_validation->set_rules('unit_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$unit_status = $this->input->post('unit_status');
			if (!isset($unit_status)) {
				$unit_status = '1';
			}
			$update_data = $_POST;
			$update_data['unit_status'] = $unit_status;
			$update_data['unit_updatedby'] = $admi_user_data['user_id'];
			$update_data['unit_updated_at'] = date('Y-m-d H:i:s');
			$this->Master_Model->update_info('unit_id', $unit_id, 'admi_unit', $update_data);

			$this->_set_flashdata_and_redirect('Master/unit', 'Unit Information Updated Successfully', 'info');
		}

		$unit_info = $this->Master_Model->get_data('admi_unit', '*', ['company_id' => $admi_user_data['company_id'], 'unit_id' => $unit_id], '`unit_id` DESC', 'row_array');
		if (!$unit_info) {
			$this->_set_flashdata_and_redirect('Master/unit', 'Invalid Unit', 'error');
		}
		$data['update'] = 'update';
		$data['unit_info'] = $unit_info;

		$data['unit_list'] = $this->Master_Model->get_data('admi_unit', '*', ['company_id' => $admi_user_data['company_id']], '`unit_id` DESC', 'result');
		$data['main_menu'] = "Master";
		$data['sub_menu'] = "Unit";
		$data['page'] = 'Edit Unit';
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/unit', $data);
		$this->load->view('Admin/Include/footer', $data);
	}

	/*********************************** Delete Unit - unit4 ********************************/
	public function delete_unit($unit_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("unit4", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$is_delete = $this->Master_Model->delete_info('unit_id', $unit_id, 'admi_unit');
		if ($is_delete['code'] == '1451') {
			$this->_set_flashdata_and_redirect('Master/unit', 'Can not delete, Unit information is used', 'error');
		} else {
			$this->_set_flashdata_and_redirect('Master/unit', 'Unit Information Deleted Successfully', 'error');
		}
	}



	/**************************************************************************************************/
	/********************************************** Grade ********************************************/
	/**************************************************************************************************/

	/*********************************** Add Grade - grade1 ********************************/
	public function grade()
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("grade1", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$this->form_validation->set_rules('grade_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$grade_status = $this->input->post('grade_status');
			if (!isset($grade_status)) {
				$grade_status = '1';
			}

			$save_data = $_POST;
			$save_data['grade_status'] = $grade_status;
			$save_data['company_id'] = $admi_user_data['company_id'];
			$save_data['grade_addedby'] = $admi_user_data['user_id'];
			$save_data['grade_created_at'] = date('Y-m-d H:i:s');

			$check_dup = $this->Master_Model->get_data('admi_grade', 'grade_id', ['company_id' => $admi_user_data['company_id'], 'grade_name' => $_POST['grade_name']], '`grade_id` ASC', 'row_array');
			if (empty($check_dup)) {
				$grade_id = $this->Master_Model->save_data('admi_grade', $save_data);
				if ($grade_id) {
					$this->_set_flashdata_and_redirect('Master/grade', 'Grade Saved Successfully', 'success');
				} else {
					$this->_set_flashdata_and_redirect('Master/grade', 'Grade Not Saved', 'error');
				}
			} else {
				$this->_set_flashdata_and_redirect('Master/grade', 'Grade name exist, Not Saved', 'error');
			}
		}

		$data['grade_list'] = $this->Master_Model->get_data('admi_grade', '*', ['company_id' => $admi_user_data['company_id']], '`grade_id` DESC', 'result');
		$data['main_menu'] = "Master";
		$data['sub_menu'] = "Grade";
		$data['page'] = 'Grade';
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/grade', $data);
		$this->load->view('Admin/Include/footer', $data);
	}


	/*********************************** Edit/Update Grade - grade3 ********************************/
	public function edit_grade($grade_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("grade3", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$grade_info = $this->Master_Model->get_data('admi_grade', '*', ['company_id' => $admi_user_data['company_id'], 'grade_id' => $grade_id], '`grade_id` DESC', 'row_array');
		if (!$grade_info) {
			$this->_set_flashdata_and_redirect('Master/grade', 'Invalid Grade', 'error');
		}

		$this->form_validation->set_rules('grade_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$grade_status = $this->input->post('grade_status');
			if (!isset($grade_status)) {
				$grade_status = '1';
			}
			$update_data = $_POST;
			$update_data['grade_status'] = $grade_status;
			$update_data['grade_updatedby'] = $admi_user_data['user_id'];
			$update_data['grade_updated_at'] = date('Y-m-d H:i:s');

			$check_dup = $this->Master_Model->get_data('admi_grade', 'grade_id', ['company_id' => $admi_user_data['company_id'], 'grade_name' => $_POST['grade_name']], '`grade_id` ASC', 'row_array');

			if ($check_dup && $_POST['grade_name'] != $grade_info['grade_name']) {
				$this->_set_flashdata_and_redirect('Master/grade', 'Grade name exist, Not Saved', 'error');
			} else {
				$this->Master_Model->update_info('grade_id', $grade_id, 'admi_grade', $update_data);
				$this->_set_flashdata_and_redirect('Master/grade', 'Grade Information Updated Successfully', 'info');
			}
		}


		$data['update'] = 'update';
		$data['grade_info'] = $grade_info;

		$data['grade_list'] = $this->Master_Model->get_data('admi_grade', '*', ['company_id' => $admi_user_data['company_id']], '`grade_id` DESC', 'result');
		$data['main_menu'] = "Master";
		$data['sub_menu'] = "Grade";
		$data['page'] = 'Edit Grade';
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/grade', $data);
		$this->load->view('Admin/Include/footer', $data);
	}

	/*********************************** Delete Grade - grade4 ********************************/
	public function delete_grade($grade_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("grade4", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$is_delete = $this->Master_Model->delete_info('grade_id', $grade_id, 'admi_grade');
		if ($is_delete['code'] == '1451') {
			$this->_set_flashdata_and_redirect('Master/grade', 'Can not delete, Grade information is used', 'error');
		} else {
			$this->_set_flashdata_and_redirect('Master/grade', 'Grade Information Deleted Successfully', 'error');
		}
	}




	/**************************************************************************************************/
	/********************************************** Item Group ********************************************/
	/**************************************************************************************************/

	/*********************************** Add Item Group - item_group1 ********************************/
	public function item_group()
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("item_group1", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$this->form_validation->set_rules('item_group_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$item_group_status = $this->input->post('item_group_status');
			if (!isset($item_group_status)) {
				$item_group_status = '1';
			}

			$save_data = $_POST;
			$save_data['item_group_status'] = $item_group_status;
			$save_data['company_id'] = $admi_user_data['company_id'];
			$save_data['item_group_addedby'] = $admi_user_data['user_id'];
			$save_data['item_group_created_at'] = date('Y-m-d H:i:s');

			$check_dup = $this->Master_Model->get_data('admi_item_group', 'item_group_id', ['company_id' => $admi_user_data['company_id'], 'item_group_name' => $_POST['item_group_name']], '`item_group_id` ASC', 'row_array');
			if (empty($check_dup)) {
				$item_group_id = $this->Master_Model->save_data('admi_item_group', $save_data);
				if ($item_group_id) {
					$this->_set_flashdata_and_redirect('Master/item_group', 'Item Group Saved Successfully', 'success');
				} else {
					$this->_set_flashdata_and_redirect('Master/item_group', 'Item Group Not Saved', 'error');
				}
			} else {
				$this->_set_flashdata_and_redirect('Master/item_group', 'Item Group name exist, Not Saved', 'error');
			}
		}

		$data['item_group_list'] = $this->Master_Model->get_data('admi_item_group', '*', ['company_id' => $admi_user_data['company_id']], '`item_group_id` DESC', 'result');
		$data['main_menu'] = "Master";
		$data['sub_menu'] = "Item Group";
		$data['page'] = 'Item Group';
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/item_group', $data);
		$this->load->view('Admin/Include/footer', $data);
	}


	/*********************************** Edit/Update Item Group - item_group3 ********************************/
	public function edit_item_group($item_group_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("item_group3", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$item_group_info = $this->Master_Model->get_data('admi_item_group', '*', ['company_id' => $admi_user_data['company_id'], 'item_group_id' => $item_group_id], '`item_group_id` DESC', 'row_array');
		if (!$item_group_info) {
			$this->_set_flashdata_and_redirect('Master/item_group', 'Invalid Item Group', 'error');
		}

		$this->form_validation->set_rules('item_group_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$item_group_status = $this->input->post('item_group_status');
			if (!isset($item_group_status)) {
				$item_group_status = '1';
			}
			$update_data = $_POST;
			$update_data['item_group_status'] = $item_group_status;
			$update_data['item_group_updatedby'] = $admi_user_data['user_id'];
			$update_data['item_group_updated_at'] = date('Y-m-d H:i:s');

			$check_dup = $this->Master_Model->get_data('admi_item_group', 'item_group_id', ['company_id' => $admi_user_data['company_id'], 'item_group_name' => $_POST['item_group_name']], '`item_group_id` ASC', 'row_array');

			if ($check_dup && $_POST['item_group_name'] != $item_group_info['item_group_name']) {
				$this->_set_flashdata_and_redirect('Master/item_group', 'Item Group name exist, Not Saved', 'error');
			} else {
				$this->Master_Model->update_info('item_group_id', $item_group_id, 'admi_item_group', $update_data);
				$this->_set_flashdata_and_redirect('Master/item_group', 'Item Group Information Updated Successfully', 'info');
			}
		}


		$data['update'] = 'update';
		$data['item_group_info'] = $item_group_info;

		$data['item_group_list'] = $this->Master_Model->get_data('admi_item_group', '*', ['company_id' => $admi_user_data['company_id']], '`item_group_id` DESC', 'result');
		$data['main_menu'] = "Master";
		$data['sub_menu'] = "Item Group";
		$data['page'] = 'Edit Item Group';
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/item_group', $data);
		$this->load->view('Admin/Include/footer', $data);
	}

	/*********************************** Delete Item Group - item_group4 ********************************/
	public function delete_item_group($item_group_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("item_group4", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$is_delete = $this->Master_Model->delete_info('item_group_id', $item_group_id, 'admi_item_group');
		if ($is_delete['code'] == '1451') {
			$this->_set_flashdata_and_redirect('Master/item_group', 'Can not delete, Item Group information is used', 'error');
		} else {
			$this->_set_flashdata_and_redirect('Master/item_group', 'Item Group Information Deleted Successfully', 'error');
		}
	}


	/***********************************************************************************************************/
	/**************************************** Manufacturer Information ****************************************/
	/***********************************************************************************************************/

	/*********************************** Add Manufacturer - manufacturer1 ********************************/
	public function manufacturer()
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("manufacturer1", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$this->form_validation->set_rules('manufacturer_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$manufacturer_status = $this->input->post('manufacturer_status');
			if (!isset($manufacturer_status)) {
				$manufacturer_status = '1';
			}

			$save_data = $_POST;
			$save_data['manufacturer_status'] = $manufacturer_status;
			$save_data['company_id'] = $admi_user_data['company_id'];
			$save_data['manufacturer_addedby'] = $admi_user_data['user_id'];
			$save_data['manufacturer_created_at'] = date('Y-m-d H:i:s');

			$check_dup = $this->Master_Model->get_data('admi_manufacturer', 'manufacturer_id', ['company_id' => $admi_user_data['company_id'], 'manufacturer_name' => $_POST['manufacturer_name']], '`manufacturer_id` ASC', 'row_array');

			if (empty($check_dup)) {
				$manufacturer_id = $this->Master_Model->save_data('admi_manufacturer', $save_data);
				if ($manufacturer_id) {
					// Upload Manufacturer Image...
					if (isset($_FILES['manufacturer_image']['name']) && $_FILES['manufacturer_image']['name']) {
						$time = time();
						$image_name = 'manufacturer_image_' . $manufacturer_id . '_' . $time;
						$config['upload_path'] = 'assets/images/manufacturer/';
						$config['allowed_types'] = 'jpg|jpeg|png|PNG|gif';
						$config['file_name'] = $image_name;
						$filename = $_FILES['manufacturer_image']['name'];
						$ext = pathinfo($filename, PATHINFO_EXTENSION);
						$this->upload->initialize($config); // if upload library autoloaded
						if ($this->upload->do_upload('manufacturer_image') && $manufacturer_id && $image_name && $ext && $filename) {
							$manufacturer_image_up['manufacturer_image'] =  $image_name . '.' . $ext;
							$this->Master_Model->update_info('manufacturer_id', $manufacturer_id, 'admi_manufacturer', $manufacturer_image_up);
							$this->session->set_flashdata(['flash_msg2' => 'Manufacturer Image Uploaded Successfully', 'flash_class2' => 'success']);
						} else {
							$error = $this->upload->display_errors();
							$this->session->set_flashdata(['flash_msg2' => $error, 'flash_class2' => 'error']);
						}
					} else {
						$this->session->set_flashdata(['flash_msg1' => 'Manufacturer image not selected', 'flash_class1' => 'error']);
					}
					$this->_set_flashdata_and_redirect('Master/manufacturer', 'Manufacturer Saved Successfully', 'success');
				} else {
					$this->_set_flashdata_and_redirect('Master/manufacturer', 'Manufacturer Not Saved', 'error');
				}
			} else {
				$this->_set_flashdata_and_redirect('Master/manufacturer', 'This Manufacturer Exist', 'error');
			}
		}

		$data['manufacturer_list'] = $this->Master_Model->get_data('admi_manufacturer', '*', ['company_id' => $admi_user_data['company_id']], '`manufacturer_id` DESC', 'result');
		$data['page'] = 'Manufacturer';
		$data['main_menu'] = "Master";
		$data['sub_menu'] = "Manufacturer";
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/manufacturer', $data);
		$this->load->view('Admin/Include/footer', $data);
	}


	/*********************************** Edit/Update Manufacturer - manufacturer3 ********************************/

	public function edit_manufacturer($manufacturer_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("manufacturer3", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$manufacturer_info = $this->Master_Model->get_info_arr('manufacturer_id', $manufacturer_id, 'admi_manufacturer');
		if (!$manufacturer_info) {
			header('location:' . base_url() . 'Master/manufacturer');
		}

		$this->form_validation->set_rules('manufacturer_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$manufacturer_status = $this->input->post('manufacturer_status');
			if (!isset($manufacturer_status)) {
				$manufacturer_status = '1';
			}
			$update_data = $_POST;
			unset($update_data['old_manufacturer_image']);
			$update_data['manufacturer_status'] = $manufacturer_status;
			$update_data['manufacturer_updatedby'] = $admi_user_data['user_id'];
			$update_data['manufacturer_updated_at'] = date('Y-m-d H:i:s');

			$check_dup = $this->Master_Model->get_data('admi_manufacturer', 'manufacturer_id', ['company_id' => $admi_user_data['company_id'], 'manufacturer_name' => $_POST['manufacturer_name']], '`manufacturer_id` ASC', 'row_array');

			if ($check_dup && $_POST['manufacturer_name'] != $manufacturer_info[0]['manufacturer_name']) {
				$this->_set_flashdata_and_redirect('Master/manufacturer', 'This Manufacturer Exist', 'error');
			} else {
				$this->Master_Model->update_info('manufacturer_id', $manufacturer_id, 'admi_manufacturer', $update_data);
				// Upload Manufacturer Image...
				if (isset($_FILES['manufacturer_image']['name']) && $_FILES['manufacturer_image']['name']) {
					$time = time();
					$image_name = 'manufacturer_image_' . $manufacturer_id . '_' . $time;
					$config['upload_path'] = 'assets/images/manufacturer/';
					$config['allowed_types'] = 'jpg|jpeg|png|PNG|gif';
					$config['file_name'] = $image_name;
					$filename = $_FILES['manufacturer_image']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					$this->upload->initialize($config); // if upload library autoloaded
					if ($this->upload->do_upload('manufacturer_image') && $manufacturer_id && $image_name && $ext && $filename) {
						$manufacturer_image_up['manufacturer_image'] =  $image_name . '.' . $ext;
						$this->Master_Model->update_info('manufacturer_id', $manufacturer_id, 'admi_manufacturer', $manufacturer_image_up);
						// Delete old image...
						if ($_POST['old_manufacturer_image']) {
							unlink("assets/images/manufacturer/" . $_POST['old_manufacturer_image']);
						}
						$this->session->set_flashdata(['flash_msg2' => 'Manufacturer Image Uploaded Successfully', 'flash_class2' => 'success']);
					} else {
						$error = $this->upload->display_errors();
						$this->session->set_flashdata(['flash_msg2' => $error, 'flash_class2' => 'error']);
					}
				}
			}



			$this->_set_flashdata_and_redirect('Master/manufacturer', 'Manufacturer Information Updated Successfully', 'info');
		}


		$data['update'] = 'update';
		$data['update_manufacturer'] = 'update';
		$data['manufacturer_info'] = $manufacturer_info[0];
		$data['act_link'] = base_url() . 'Master/edit_manufacturer/' . $manufacturer_id;

		$data['manufacturer_list'] = $this->Master_Model->get_data('admi_manufacturer', '*', ['company_id' => $admi_user_data['company_id']], '`manufacturer_id` DESC', 'result');
		$data['page'] = 'Edit Manufacturer';
		$data['main_menu'] = "Master";
		$data['sub_menu'] = "Manufacturer";
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/manufacturer', $data);
		$this->load->view('Admin/Include/footer', $data);
	}


	/*********************************** Delete User - manufacturer4 ********************************/

	public function delete_manufacturer($manufacturer_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("manufacturer4", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$manufacturer_info = $this->Master_Model->get_data('admi_manufacturer', 'manufacturer_image, manufacturer_id', ['manufacturer_id' => $manufacturer_id], '`manufacturer_id` ASC', 'row_array');

		$is_delete = $this->Master_Model->delete_info('manufacturer_id', $manufacturer_id, 'admi_manufacturer');
		if ($is_delete['code'] == '1451') {
			$this->_set_flashdata_and_redirect('Master/manufacturer', 'Can not delete, Manufacturer information is used', 'error');
		} else {
			if ($manufacturer_info) {
				$manufacturer_image = $manufacturer_info['manufacturer_image'];
				if ($manufacturer_image && file_exists(FCPATH . "assets/images/manufacturer/$manufacturer_image")) {
					unlink("assets/images/manufacturer/" . $manufacturer_image);
				}
			}
			$this->_set_flashdata_and_redirect('Master/manufacturer', 'Manufacturer Information Deleted Successfully', 'error');
		}
	}


	/***********************************************************************************************************/
	/**************************************** Party Information ****************************************/
	/***********************************************************************************************************/


	/*********************************** Add Party - party1 ********************************/

	public function party()
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("party1", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$this->form_validation->set_rules('party_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$party_status = $this->input->post('party_status');
			if (!isset($party_status)) {
				$party_status = '1';
			}

			$save_data = $_POST;
			$save_data['party_status'] = $party_status;
			$save_data['company_id'] = $admi_user_data['company_id'];
			$save_data['party_addedby'] = $admi_user_data['user_id'];
			$save_data['party_created_at'] = date('Y-m-d H:i:s');

			// if(isset($_POST['party_category_id'])){
			// 	$party_category_id = $_POST['party_category_id'];
			// 	$party_category_id = implode(',', $party_category_id);
			// 	$save_data['party_category_id'] = $party_category_id;
			// }

			$party_id = $this->Master_Model->save_data('admi_party', $save_data);

			if ($party_id) {

				// Upload Party Image...
				if (isset($_FILES['party_image']['name']) && $_FILES['party_image']['name']) {
					$time = time();
					$image_name = 'party_image_' . $party_id . '_' . $time;
					$config['upload_path'] = 'assets/images/party/';
					$config['allowed_types'] = 'jpg|jpeg|png|PNG|gif';
					$config['file_name'] = $image_name;
					$filename = $_FILES['party_image']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					$this->upload->initialize($config); // if upload library autoloaded
					if ($this->upload->do_upload('party_image') && $party_id && $image_name && $ext && $filename) {
						$party_image_up['party_image'] =  $image_name . '.' . $ext;
						$this->Master_Model->update_info('party_id', $party_id, 'admi_party', $party_image_up);
						$this->session->set_flashdata(['flash_msg2' => 'Party Image Uploaded Successfully', 'flash_class2' => 'success']);
					} else {
						$error = $this->upload->display_errors();
						$this->session->set_flashdata(['flash_msg2' => $error, 'flash_class2' => 'error']);
					}
				} else {
					$this->session->set_flashdata(['flash_msg1' => 'Party image not selected', 'flash_class1' => 'error']);
				}
				$this->_set_flashdata_and_redirect('Master/party', 'Party Saved Successfully', 'success');
			} else {
				$this->_set_flashdata_and_redirect('Master/party', 'Party Not Saved', 'error');
			}
		}
		$data['country_list'] = $this->Master_Model->get_data('country', '*', ['country_id' => '101'], '`country_name` ASC', 'result');
		$data['state_list'] = $this->Master_Model->get_data('state', '*', ['country_id' => '101'], '`state_name` ASC', 'result');

		$data['party_list'] = $this->Master_Model->get_data('admi_party', '*', ['company_id' => $admi_user_data['company_id']], '`party_id` DESC', 'result');
		$data['page'] = 'Party';
		$data['main_menu'] = "Master";
		$data['sub_menu'] = "Party";
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/party', $data);
		$this->load->view('Admin/Include/footer', $data);
	}


	/*********************************** Edit/Update Party - party3 ********************************/

	public function edit_party($party_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("party3", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$this->form_validation->set_rules('party_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$party_status = $this->input->post('party_status');
			if (!isset($party_status)) {
				$party_status = '1';
			}
			$update_data = $_POST;
			unset($update_data['old_party_image']);
			$update_data['party_status'] = $party_status;
			$update_data['party_updatedby'] = $admi_user_data['user_id'];
			$update_data['party_updated_at'] = date('Y-m-d H:i:s');

			if (isset($_POST['party_category_id'])) {
				$party_category_id = $_POST['party_category_id'];
				$party_category_id = implode(',', $party_category_id);
				$update_data['party_category_id'] = $party_category_id;
			}

			$this->Master_Model->update_info('party_id', $party_id, 'admi_party', $update_data);

			// Upload Party Image...
			if (isset($_FILES['party_image']['name']) && $_FILES['party_image']['name']) {
				$time = time();
				$image_name = 'party_image_' . $party_id . '_' . $time;
				$config['upload_path'] = 'assets/images/party/';
				$config['allowed_types'] = 'jpg|jpeg|png|PNG|gif';
				$config['file_name'] = $image_name;
				$filename = $_FILES['party_image']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$this->upload->initialize($config); // if upload library autoloaded
				if ($this->upload->do_upload('party_image') && $party_id && $image_name && $ext && $filename) {
					$party_image_up['party_image'] =  $image_name . '.' . $ext;
					$this->Master_Model->update_info('party_id', $party_id, 'admi_party', $party_image_up);
					// Delete old image...
					if ($_POST['old_party_image']) {
						unlink("assets/images/party/" . $_POST['old_party_image']);
					}
					$this->session->set_flashdata(['flash_msg2' => 'Party Image Uploaded Successfully', 'flash_class2' => 'success']);
				} else {
					$error = $this->upload->display_errors();
					$this->session->set_flashdata(['flash_msg2' => $error, 'flash_class2' => 'error']);
				}
			}

			$this->_set_flashdata_and_redirect('Master/party', 'Party Information Updated Successfully', 'info');
		}

		$party_info = $this->Master_Model->get_data('admi_party', '*', ['party_id' => $party_id], '`party_id` ASC', 'row_array');
		if (!$party_info) {
			header('location:' . base_url() . 'Master/party');
		}
		$data['update'] = 'update';
		$data['update_party'] = 'update';
		$data['party_info'] = $party_info;
		$data['act_link'] = base_url() . 'Master/edit_party/' . $party_id;
		$state_id = $party_info['state_id'];

		$data['country_list'] = $this->Master_Model->get_data('country', '*', ['country_id' => '101'], '`country_name` ASC', 'result');
		$data['state_list'] = $this->Master_Model->get_data('state', '*', ['country_id' => '101'], '`state_name` ASC', 'result');
		$data['city_list'] = $this->Master_Model->get_data('city', '*', ['state_id' => $state_id], '`city_name` ASC', 'result');

		$data['party_list'] = $this->Master_Model->get_data('admi_party', '*', ['company_id' => $admi_user_data['company_id']], '`party_id` DESC', 'result');
		$data['page'] = 'Edit Party';
		$data['main_menu'] = "Master";
		$data['sub_menu'] = "Party";
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/party', $data);
		$this->load->view('Admin/Include/footer', $data);
	}


	/*********************************** Delete Party - party4 ********************************/

	public function delete_party($party_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("party4", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$party_info = $this->Master_Model->get_data('admi_party', 'party_image, party_id', ['party_id' => $party_id], '`party_id` ASC', 'row_array');
		if ($party_info) {
			$party_image = $party_info['party_image'];
			if ($party_image) {
				unlink("assets/images/master/" . $party_image);
			}
		}

		$is_delete = $this->Master_Model->delete_info('party_id', $party_id, 'admi_party');
		if ($is_delete['code'] == '1451') {
			$this->_set_flashdata_and_redirect('Master/party', 'Can not delete, Party information is used', 'error');
		} else {
			$this->_set_flashdata_and_redirect('Master/party', 'Party Information Deleted Successfully', 'error');
		}
	}





	/**************************************************************************************************/
	/********************************************** Remark ********************************************/
	/**************************************************************************************************/

	/*********************************** Add Remark - remark1 ********************************/
	public function remark()
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("remark1", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$this->form_validation->set_rules('remark_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$remark_status = $this->input->post('remark_status');
			if (!isset($remark_status)) {
				$remark_status = '1';
			}

			$save_data = $_POST;
			$save_data['remark_status'] = $remark_status;
			$save_data['company_id'] = $admi_user_data['company_id'];
			$save_data['remark_addedby'] = $admi_user_data['user_id'];
			$save_data['remark_created_at'] = date('Y-m-d H:i:s');

			$check_dup = $this->Master_Model->get_data('admi_remark', 'remark_id', ['company_id' => $admi_user_data['company_id'], 'remark_name' => $_POST['remark_name']], '`remark_id` ASC', 'row_array');
			if (empty($check_dup)) {
				$remark_id = $this->Master_Model->save_data('admi_remark', $save_data);
				if ($remark_id) {
					$this->_set_flashdata_and_redirect('Master/remark', 'Remark Saved Successfully', 'success');
				} else {
					$this->_set_flashdata_and_redirect('Master/remark', 'Remark Not Saved', 'error');
				}
			} else {
				$this->_set_flashdata_and_redirect('Master/remark', 'Remark name exist, Not Saved', 'error');
			}
		}

		$data['remark_list'] = $this->Master_Model->get_data('admi_remark', '*', ['company_id' => $admi_user_data['company_id']], '`remark_id` DESC', 'result');
		$data['main_menu'] = "Master";
		$data['sub_menu'] = "Remark";
		$data['page'] = 'Remark';
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/remark', $data);
		$this->load->view('Admin/Include/footer', $data);
	}


	/*********************************** Edit/Update Remark - remark3 ********************************/
	public function edit_remark($remark_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("remark3", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$remark_info = $this->Master_Model->get_data('admi_remark', '*', ['company_id' => $admi_user_data['company_id'], 'remark_id' => $remark_id], '`remark_id` DESC', 'row_array');
		if (!$remark_info) {
			$this->_set_flashdata_and_redirect('Master/remark', 'Invalid Remark', 'error');
		}

		$this->form_validation->set_rules('remark_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$remark_status = $this->input->post('remark_status');
			if (!isset($remark_status)) {
				$remark_status = '1';
			}
			$update_data = $_POST;
			$update_data['remark_status'] = $remark_status;
			$update_data['remark_updatedby'] = $admi_user_data['user_id'];
			$update_data['remark_updated_at'] = date('Y-m-d H:i:s');

			$check_dup = $this->Master_Model->get_data('admi_remark', 'remark_id', ['company_id' => $admi_user_data['company_id'], 'remark_name' => $_POST['remark_name']], '`remark_id` ASC', 'row_array');

			if ($check_dup && $_POST['remark_name'] != $remark_info['remark_name']) {
				$this->_set_flashdata_and_redirect('Master/remark', 'Remark name exist, Not Saved', 'error');
			} else {
				$this->Master_Model->update_info('remark_id', $remark_id, 'admi_remark', $update_data);
				$this->_set_flashdata_and_redirect('Master/remark', 'Remark Information Updated Successfully', 'info');
			}
		}


		$data['update'] = 'update';
		$data['remark_info'] = $remark_info;

		$data['remark_list'] = $this->Master_Model->get_data('admi_remark', '*', ['company_id' => $admi_user_data['company_id']], '`remark_id` DESC', 'result');
		$data['main_menu'] = "Master";
		$data['sub_menu'] = "Remark";
		$data['page'] = 'Edit Remark';
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/remark', $data);
		$this->load->view('Admin/Include/footer', $data);
	}

	/*********************************** Delete Remark - remark4 ********************************/
	public function delete_remark($remark_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("remark4", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$is_delete = $this->Master_Model->delete_info('remark_id', $remark_id, 'admi_remark');
		if ($is_delete['code'] == '1451') {
			$this->_set_flashdata_and_redirect('Master/remark', 'Can not delete, Remark information is used', 'error');
		} else {
			$this->_set_flashdata_and_redirect('Master/remark', 'Remark Information Deleted Successfully', 'error');
		}
	}










	/**************************************************************************************************/
	/********************************************** Process Type ********************************************/
	/**************************************************************************************************/

	/*********************************** Add Process Type - item_group1 ********************************/
	public function process_type()
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("process_type1", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$this->form_validation->set_rules('process_type_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$process_type_status = $this->input->post('process_type_status');
			if (!isset($process_type_status)) {
				$process_type_status = '1';
			}

			$save_data = $_POST;
			$save_data['process_type_status'] = $process_type_status;
			$save_data['company_id'] = $admi_user_data['company_id'];
			$save_data['process_type_addedby'] = $admi_user_data['user_id'];
			$save_data['process_type_created_at'] = date('Y-m-d H:i:s');

			$check_dup = $this->Master_Model->get_data('admi_process_type', 'process_type_id', ['company_id' => $admi_user_data['company_id'], 'process_type_name' => $_POST['process_type_name']], '`process_type_id` ASC', 'row_array');
			if (empty($check_dup)) {
				$process_type_id = $this->Master_Model->save_data('admi_process_type', $save_data);
				if ($process_type_id) {
					$this->_set_flashdata_and_redirect('Master/process_type', 'Process Type Saved Successfully', 'success');
				} else {
					$this->_set_flashdata_and_redirect('Master/process_type', 'Process Type Not Saved', 'error');
				}
			} else {
				$this->_set_flashdata_and_redirect('Master/process_type', 'Process Type name exist, Not Saved', 'error');
			}
		}

		$data['process_type_list'] = $this->Master_Model->get_data('admi_process_type', '*', ['company_id' => $admi_user_data['company_id']], '`process_type_id` DESC', 'result');
		$data['main_menu'] = "Master";
		$data['sub_menu'] = "Process Type";
		$data['page'] = 'Process Type';
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/process_type', $data);
		$this->load->view('Admin/Include/footer', $data);
	}


	/*********************************** Edit/Update Process Type - process_type3 ********************************/
	public function edit_process_type($process_type_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("process_type3", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$process_type_info = $this->Master_Model->get_data('admi_process_type', '*', ['company_id' => $admi_user_data['company_id'], 'process_type_id' => $process_type_id], '`process_type_id` DESC', 'row_array');
		if (!$process_type_info) {
			$this->_set_flashdata_and_redirect('Master/process_type', 'Invalid Process Type', 'error');
		}

		$this->form_validation->set_rules('process_type_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$process_type_status = $this->input->post('process_type_status');
			if (!isset($process_type_status)) {
				$process_type_status = '1';
			}
			$update_data = $_POST;
			$update_data['process_type_status'] = $process_type_status;
			$update_data['process_type_updatedby'] = $admi_user_data['user_id'];
			$update_data['process_type_updated_at'] = date('Y-m-d H:i:s');

			$check_dup = $this->Master_Model->get_data('admi_process_type', 'process_type_id', ['company_id' => $admi_user_data['company_id'], 'process_type_name' => $_POST['process_type_name']], '`process_type_id` ASC', 'row_array');

			if ($check_dup && $_POST['process_type_name'] != $process_type_info['process_type_name']) {
				$this->_set_flashdata_and_redirect('Master/process_type', 'Process Type name exist, Not Saved', 'error');
			} else {
				$this->Master_Model->update_info('process_type_id', $process_type_id, 'admi_process_type', $update_data);
				$this->_set_flashdata_and_redirect('Master/process_type', 'Process Type Information Updated Successfully', 'info');
			}
		}


		$data['update'] = 'update';
		$data['process_type_info'] = $process_type_info;

		$data['process_type_list'] = $this->Master_Model->get_data('admi_process_type', '*', ['company_id' => $admi_user_data['company_id']], '`process_type_id` DESC', 'result');
		$data['main_menu'] = "Master";
		$data['sub_menu'] = "Process Type";
		$data['page'] = 'Edit Process Type';
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/process_type', $data);
		$this->load->view('Admin/Include/footer', $data);
	}

	/*********************************** Delete Process Type - process_type4 ********************************/
	public function delete_process_type($process_type_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("process_type4", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$is_delete = $this->Master_Model->delete_info('process_type_id', $process_type_id, 'admi_process_type');
		if ($is_delete['code'] == '1451') {
			$this->_set_flashdata_and_redirect('Master/process_type', 'Can not delete, Process Type information is used', 'error');
		} else {
			$this->_set_flashdata_and_redirect('Master/process_type', 'Process Type Information Deleted Successfully', 'error');
		}
	}

	/**************************************************************************************************/
	/********************************************** Department ********************************************/
	/**************************************************************************************************/

	/*********************************** Add Department - department1 ********************************/
	public function department()
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("department1", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$this->form_validation->set_rules('department_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$department_status = $this->input->post('department_status');
			if (!isset($department_status)) {
				$department_status = '1';
			}

			$save_data = $_POST;
			$save_data['department_status'] = $department_status;
			$save_data['company_id'] = $admi_user_data['company_id'];
			$save_data['department_addedby'] = $admi_user_data['user_id'];
			$save_data['department_created_at'] = date('Y-m-d H:i:s');

			$check_dup = $this->Master_Model->get_data('admi_department', 'department_id', ['company_id' => $admi_user_data['company_id'], 'department_name' => $_POST['department_name']], '`department_id` ASC', 'row_array');
			// if(empty($check_dup)){
			$department_id = $this->Master_Model->save_data('admi_department', $save_data);
			if ($department_id) {
				$this->_set_flashdata_and_redirect('Master/department', 'Department Saved Successfully', 'success');
			} else {
				$this->_set_flashdata_and_redirect('Master/department', 'Department Not Saved', 'error');
			}
			// } else{
			// 	$this->_set_flashdata_and_redirect('Master/department','Department name exist, Not Saved','error');
			// }				
		}
		$data['process_type_list'] = $this->Master_Model->get_data('admi_process_type', '*', ['company_id' => $admi_user_data['company_id']], '`process_type_name` ASC', 'result');

		$data['department_list'] = $this->Master_Model->get_data('admi_department', '*', ['company_id' => $admi_user_data['company_id']], '`department_id` DESC', 'result');
		$data['main_menu'] = "Master";
		$data['sub_menu'] = "Department";
		$data['page'] = 'Department';
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/department', $data);
		$this->load->view('Admin/Include/footer', $data);
	}


	/*********************************** Edit/Update Department - department3 ********************************/
	public function edit_department($department_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("department3", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$department_info = $this->Master_Model->get_data('admi_department', '*', ['company_id' => $admi_user_data['company_id'], 'department_id' => $department_id], '`department_id` DESC', 'row_array');
		if (!$department_info) {
			$this->_set_flashdata_and_redirect('Master/department', 'Invalid Department', 'error');
		}

		$this->form_validation->set_rules('department_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$department_status = $this->input->post('department_status');
			if (!isset($department_status)) {
				$department_status = '1';
			}
			$update_data = $_POST;
			$update_data['department_status'] = $department_status;
			$update_data['department_updatedby'] = $admi_user_data['user_id'];
			$update_data['department_updated_at'] = date('Y-m-d H:i:s');

			$check_dup = $this->Master_Model->get_data('admi_department', 'department_id', ['company_id' => $admi_user_data['company_id'], 'department_name' => $_POST['department_name']], '`department_id` ASC', 'row_array');

			// if($check_dup && $_POST['department_name'] != $department_info['department_name']){
			// 	$this->_set_flashdata_and_redirect('Master/department','Department name exist, Not Saved','error');
			// } else{
			$this->Master_Model->update_info('department_id', $department_id, 'admi_department', $update_data);
			$this->_set_flashdata_and_redirect('Master/department', 'Department Information Updated Successfully', 'info');
			// }				
		}

		$data['update'] = 'update';
		$data['department_info'] = $department_info;
		$data['process_type_list'] = $this->Master_Model->get_data('admi_process_type', '*', ['company_id' => $admi_user_data['company_id']], '`process_type_name` ASC', 'result');

		$data['department_list'] = $this->Master_Model->get_data('admi_department', '*', ['company_id' => $admi_user_data['company_id']], '`department_id` DESC', 'result');
		$data['main_menu'] = "Master";
		$data['sub_menu'] = "Department";
		$data['page'] = 'Edit Department';
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/department', $data);
		$this->load->view('Admin/Include/footer', $data);
	}

	/*********************************** Delete Department - department4 ********************************/
	public function delete_department($department_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("department4", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$is_delete = $this->Master_Model->delete_info('department_id', $department_id, 'admi_department');
		if ($is_delete['code'] == '1451') {
			$this->_set_flashdata_and_redirect('Master/department', 'Can not delete, Department information is used', 'error');
		} else {
			$this->_set_flashdata_and_redirect('Master/department', 'Department Information Deleted Successfully', 'error');
		}
	}





	/**************************************************************************************************/
	/********************************************** Process ********************************************/
	/**************************************************************************************************/

	/*********************************** Add Process - process1 ********************************/
	public function process()
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("process1", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$this->form_validation->set_rules('process_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$process_status = $this->input->post('process_status');
			if (!isset($process_status)) {
				$process_status = '1';
			}

			$save_data = $_POST;
			$save_data['process_status'] = $process_status;
			$save_data['company_id'] = $admi_user_data['company_id'];
			$save_data['process_addedby'] = $admi_user_data['user_id'];
			$save_data['process_created_at'] = date('Y-m-d H:i:s');

			// $check_dup = $this->Master_Model->get_data('admi_process','process_id',['company_id'=>$admi_user_data['company_id'],'process_name'=>$_POST['process_name']],'`process_id` ASC','row_array');
			// if(empty($check_dup)){
			$process_id = $this->Master_Model->save_data('admi_process', $save_data);
			if ($process_id) {
				$this->_set_flashdata_and_redirect('Master/process', 'Process Saved Successfully', 'success');
			} else {
				$this->_set_flashdata_and_redirect('Master/process', 'Process Not Saved', 'error');
			}
			// } else{
			// 	$this->_set_flashdata_and_redirect('Master/process','Process name exist, Not Saved','error');
			// }				
		}
		$data['process_type_list'] = $this->Master_Model->get_data('admi_process_type', '*', ['company_id' => $admi_user_data['company_id']], '`process_type_name` ASC', 'result');

		$data['process_list'] = $this->Master_Model->get_data('admi_process', '*', ['company_id' => $admi_user_data['company_id']], '`process_id` DESC', 'result');
		$data['main_menu'] = "Master";
		$data['sub_menu'] = "Process";
		$data['page'] = 'Process';
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/process', $data);
		$this->load->view('Admin/Include/footer', $data);
	}


	/*********************************** Edit/Update Process - process3 ********************************/
	public function edit_process($process_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("process3", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$process_info = $this->Master_Model->get_data('admi_process', '*', ['company_id' => $admi_user_data['company_id'], 'process_id' => $process_id], '`process_id` DESC', 'row_array');
		if (!$process_info) {
			$this->_set_flashdata_and_redirect('Master/process', 'Invalid Process', 'error');
		}

		$this->form_validation->set_rules('process_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$process_status = $this->input->post('process_status');
			if (!isset($process_status)) {
				$process_status = '1';
			}
			$update_data = $_POST;
			$update_data['process_status'] = $process_status;
			$update_data['process_updatedby'] = $admi_user_data['user_id'];
			$update_data['process_updated_at'] = date('Y-m-d H:i:s');

			// $check_dup = $this->Master_Model->get_data('admi_process','process_id',['company_id'=>$admi_user_data['company_id'],'process_name'=>$_POST['process_name']],'`process_id` ASC','row_array');

			// if($check_dup && $_POST['process_name'] != $process_info['process_name']){
			// 	$this->_set_flashdata_and_redirect('Master/process','Process name exist, Not Saved','error');
			// } else{
			$this->Master_Model->update_info('process_id', $process_id, 'admi_process', $update_data);
			$this->_set_flashdata_and_redirect('Master/process', 'Process Information Updated Successfully', 'info');
			// }				
		}

		$data['update'] = 'update';
		$data['process_info'] = $process_info;
		$process_type_id = $process_info['process_type_id'];
		$data['process_type_list'] = $this->Master_Model->get_data('admi_process_type', '*', ['company_id' => $admi_user_data['company_id']], '`process_type_name` ASC', 'result');
		$data['department_list'] = $this->Master_Model->get_data('admi_department', '*', ['company_id' => $admi_user_data['company_id'], 'process_type_id' => $process_type_id], '`department_name` ASC', 'result');

		$data['process_list'] = $this->Master_Model->get_data('admi_process', '*', ['company_id' => $admi_user_data['company_id']], '`process_id` DESC', 'result');
		$data['main_menu'] = "Master";
		$data['sub_menu'] = "Process";
		$data['page'] = 'Edit Process';
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/process', $data);
		$this->load->view('Admin/Include/footer', $data);
	}

	/*********************************** Delete Process - process4 ********************************/
	public function delete_process($process_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("process4", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$is_delete = $this->Master_Model->delete_info('process_id', $process_id, 'admi_process');
		if ($is_delete['code'] == '1451') {
			$this->_set_flashdata_and_redirect('Master/process', 'Can not delete, Process information is used', 'error');
		} else {
			$this->_set_flashdata_and_redirect('Master/process', 'Process Information Deleted Successfully', 'error');
		}
	}





	/**************************************************************************************************/
	/********************************************** Item ********************************************/
	/**************************************************************************************************/

	/*********************************** Add Item - item1 ********************************/
	public function item()
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("item1", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$this->form_validation->set_rules('party_id', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$item_status = $this->input->post('item_status');
			if (!isset($item_status)) {
				$item_status = '1';
			}

			$save_data = $_POST;
			$save_data['item_status'] = $item_status;
			$save_data['company_id'] = $admi_user_data['company_id'];
			$save_data['item_addedby'] = $admi_user_data['user_id'];
			$save_data['item_created_at'] = date('Y-m-d H:i:s');

			// $check_dup = $this->Master_Model->get_data('admi_item','item_id',['company_id'=>$admi_user_data['company_id'],'item_name'=>$_POST['item_name']],'`item_id` ASC','row_array');
			// if(empty($check_dup)){
			$item_id = $this->Master_Model->save_data('admi_item', $save_data);
			if ($item_id) {
				$this->_set_flashdata_and_redirect('Master/item', 'Item Saved Successfully', 'success');
			} else {
				$this->_set_flashdata_and_redirect('Master/item', 'Item Not Saved', 'error');
			}
			// } else{
			// 	$this->_set_flashdata_and_redirect('Master/item','Item name exist, Not Saved','error');
			// }				
		}
		$data['party_list'] = $this->Master_Model->get_data('admi_party', '*', ['company_id' => $admi_user_data['company_id']], '`party_name` ASC', 'result');
		$data['item_group_list'] = $this->Master_Model->get_data('admi_item_group', '*', ['company_id' => $admi_user_data['company_id']], '`item_group_name` ASC', 'result');
		$data['process_type_list'] = $this->Master_Model->get_data('admi_process_type', '*', ['company_id' => $admi_user_data['company_id']], '`process_type_name` ASC', 'result');
		$data['grade_list'] = $this->Master_Model->get_data('admi_grade', '*', ['company_id' => $admi_user_data['company_id']], '`grade_name` ASC', 'result');
		$data['unit_list'] = $this->Master_Model->get_data('admi_unit', '*', ['company_id' => $admi_user_data['company_id']], '`unit_name` ASC', 'result');
		$data['tax_rate_list'] = $this->Master_Model->get_data('admi_tax_rate', '*', ['company_id' => $admi_user_data['company_id']], '`tax_rate_per` ASC', 'result');

		$data['item_list'] = $this->Master_Model->get_data('admi_item', '*', ['company_id' => $admi_user_data['company_id']], '`item_id` DESC', 'result');
		$data['main_menu'] = "Master";
		$data['sub_menu'] = "Item";
		$data['page'] = 'Item';
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/item', $data);
		$this->load->view('Admin/Include/footer', $data);
	}


	/*********************************** Edit/Update Item - item3 ********************************/
	public function edit_item($item_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("item3", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$item_info = $this->Master_Model->get_data('admi_item', '*', ['company_id' => $admi_user_data['company_id'], 'item_id' => $item_id], '`item_id` DESC', 'row_array');
		if (!$item_info) {
			$this->_set_flashdata_and_redirect('Master/item', 'Invalid Item', 'error');
		}

		$this->form_validation->set_rules('party_id', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$item_status = $this->input->post('item_status');
			if (!isset($item_status)) {
				$item_status = '1';
			}
			$update_data = $_POST;
			$update_data['item_status'] = $item_status;
			$update_data['item_updatedby'] = $admi_user_data['user_id'];
			$update_data['item_updated_at'] = date('Y-m-d H:i:s');

			// $check_dup = $this->Master_Model->get_data('admi_item','item_id',['company_id'=>$admi_user_data['company_id'],'item_name'=>$_POST['item_name']],'`item_id` ASC','row_array');

			// if($check_dup && $_POST['item_name'] != $item_info['item_name']){
			// 	$this->_set_flashdata_and_redirect('Master/item','Item name exist, Not Saved','error');
			// } else{
			$this->Master_Model->update_info('item_id', $item_id, 'admi_item', $update_data);
			$this->_set_flashdata_and_redirect('Master/item', 'Item Information Updated Successfully', 'info');
			// }				
		}

		$data['update'] = 'update';
		$data['item_info'] = $item_info;
		$data['party_list'] = $this->Master_Model->get_data('admi_party', '*', ['company_id' => $admi_user_data['company_id']], '`party_name` ASC', 'result');
		$data['item_group_list'] = $this->Master_Model->get_data('admi_item_group', '*', ['company_id' => $admi_user_data['company_id']], '`item_group_name` ASC', 'result');
		$data['process_type_list'] = $this->Master_Model->get_data('admi_process_type', '*', ['company_id' => $admi_user_data['company_id']], '`process_type_name` ASC', 'result');
		$data['grade_list'] = $this->Master_Model->get_data('admi_grade', '*', ['company_id' => $admi_user_data['company_id']], '`grade_name` ASC', 'result');
		$data['unit_list'] = $this->Master_Model->get_data('admi_unit', '*', ['company_id' => $admi_user_data['company_id']], '`unit_name` ASC', 'result');
		$data['tax_rate_list'] = $this->Master_Model->get_data('admi_tax_rate', '*', ['company_id' => $admi_user_data['company_id']], '`tax_rate_per` ASC', 'result');

		$data['item_list'] = $this->Master_Model->get_data('admi_item', '*', ['company_id' => $admi_user_data['company_id']], '`item_id` DESC', 'result');
		$data['main_menu'] = "Master";
		$data['sub_menu'] = "Item";
		$data['page'] = 'Edit Item';
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/item', $data);
		$this->load->view('Admin/Include/footer', $data);
	}

	/*********************************** Delete Item - item4 ********************************/
	public function delete_item($item_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("item4", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$is_delete = $this->Master_Model->delete_info('item_id', $item_id, 'admi_item');
		if ($is_delete['code'] == '1451') {
			$this->_set_flashdata_and_redirect('Master/item', 'Can not delete, Item information is used', 'error');
		} else {
			$this->_set_flashdata_and_redirect('Master/item', 'Item Information Deleted Successfully', 'error');
		}
	}

































	/***********************************************************************************************************/
	/**************************************** Item Category Information ****************************************/
	/***********************************************************************************************************/


	/*********************************** Add Product Category - product_category1 ********************************/

	public function product_category()
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("product_category1", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$this->form_validation->set_rules('product_category_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$product_category_status = $this->input->post('product_category_status');
			if (!isset($product_category_status)) {
				$product_category_status = '1';
			}

			$save_data = $_POST;
			$save_data['product_category_status'] = $product_category_status;
			$save_data['company_id'] = $admi_user_data['company_id'];
			$save_data['product_category_addedby'] = $admi_user_data['user_id'];
			$save_data['product_category_created_at'] = date('Y-m-d H:i:s');

			$main_product_category_id = $this->input->post('main_product_category_id');
			if ($main_product_category_id == '-1') {
				$save_data['is_main'] = 1;
				$save_data['main_product_category_id'] = 0;
			} else {
				$save_data['is_main'] = 0;
			}

			$product_category_id = $this->Master_Model->save_data('admi_product_category', $save_data);


			if ($product_category_id) {
				// // Upload Product Category Icon...
				// if(isset($_FILES['product_category_icon']['name']) && $_FILES['product_category_icon']['name']){
				// 	$time = time();
				// 	$image_name = 'product_category_icon_'.$product_category_id.'_'.$time;
				// 	$config['upload_path'] = 'assets/images/product_category/';
				// 	$config['allowed_types'] = 'jpg|jpeg|png|gif';
				// 	$config['file_name'] = $image_name;
				// 	$filename = $_FILES['product_category_icon']['name'];
				// 	$ext = pathinfo($filename, PATHINFO_EXTENSION);
				// 	$this->upload->initialize($config); // if upload library autoloaded
				// 	if ($this->upload->do_upload('product_category_icon') && $product_category_id && $image_name && $ext && $filename){
				// 		$product_category_icon_up['product_category_icon'] =  $image_name.'.'.$ext;
				// 		$this->Master_Model->update_info('product_category_id', $product_category_id, 'admi_product_category', $product_category_icon_up);
				// 		$this->session->set_flashdata(['flash_msg1'=>'Product Category Icon Uploaded Successfully', 'flash_class1'=>'success']);
				// 	}
				// 	else{
				// 		$error = $this->upload->display_errors();
				// 		$this->session->set_flashdata(['flash_msg1'=>$error, 'flash_class1'=>'error']);
				// 	}
				// } else{
				// 	$this->session->set_flashdata(['flash_msg1'=>'Product Category icon not selected', 'flash_class1'=>'error']);
				// }

				// Upload Product Category Image...
				if (isset($_FILES['product_category_image']['name']) && $_FILES['product_category_image']['name']) {
					$time = time();
					$image_name = 'product_category_image_' . $product_category_id . '_' . $time;
					$config['upload_path'] = 'assets/images/product_category/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif';
					$config['file_name'] = $image_name;
					$filename = $_FILES['product_category_image']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					$this->upload->initialize($config); // if upload library autoloaded
					if ($this->upload->do_upload('product_category_image') && $product_category_id && $image_name && $ext && $filename) {
						$product_category_image_up['product_category_image'] =  $image_name . '.' . $ext;
						$this->Master_Model->update_info('product_category_id', $product_category_id, 'admi_product_category', $product_category_image_up);
						// $this->session->set_flashdata(['flash_msg2'=>'Product Category Image Uploaded Successfully', 'flash_class2'=>'success']);
					} else {
						$error = $this->upload->display_errors();
						// $this->session->set_flashdata(['flash_msg2'=>$error, 'flash_class2'=>'error']);
					}
				} else {
					// $this->session->set_flashdata(['flash_msg1'=>'Product Category image not selected', 'flash_class1'=>'error']);
				}

				$this->_set_flashdata_and_redirect('Master/product_category', 'Product Category Saved Successfully', 'success');
			} else {
				$this->_set_flashdata_and_redirect('Master/product_category', 'Product Category Not Saved', 'error');
			}
		}
		$data['main_product_category_list'] = $this->Master_Model->get_data('admi_product_category', '*', ['company_id' => $admi_user_data['company_id'], 'is_main' => '1'], '`product_category_name` ASC', 'result');

		$data['product_category_list'] = $this->Master_Model->get_data('admi_product_category', '*', ['company_id' => $admi_user_data['company_id']], '`product_category_id` DESC', 'result');
		$data['page'] = 'Product Category';
		$data['main_menu'] = "Product";
		$data['sub_menu'] = "Product Category";
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/product_category', $data);
		$this->load->view('Admin/Include/footer', $data);
	}


	/*********************************** Edit/Update Product Category - product_category3 ********************************/

	public function edit_product_category($product_category_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("product_category3", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$this->form_validation->set_rules('product_category_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$product_category_status = $this->input->post('product_category_status');
			if (!isset($product_category_status)) {
				$product_category_status = '1';
			}
			$update_data = $_POST;
			unset($update_data['old_product_category_icon']);
			unset($update_data['old_product_category_image']);
			$update_data['product_category_status'] = $product_category_status;
			$update_data['product_category_updatedby'] = $admi_user_data['user_id'];
			$update_data['product_category_updated_at'] = date('Y-m-d H:i:s');

			$main_product_category_id = $this->input->post('main_product_category_id');
			if ($main_product_category_id == '-1') {
				$update_data['is_main'] = 1;
				$update_data['main_product_category_id'] = 0;
			} else {
				$update_data['is_main'] = 0;
			}

			$this->Master_Model->update_info('product_category_id', $product_category_id, 'admi_product_category', $update_data);

			// // Upload Product Category Icon...
			// if(isset($_FILES['product_category_icon']['name']) && $_FILES['product_category_icon']['name']){
			// 	$time = time();
			// 	$image_name = 'product_category_icon_'.$product_category_id.'_'.$time;
			// 	$config['upload_path'] = 'assets/images/product_category/';
			// 	$config['allowed_types'] = 'jpg|jpeg|png|gif';
			// 	$config['file_name'] = $image_name;
			// 	$filename = $_FILES['product_category_icon']['name'];
			// 	$ext = pathinfo($filename, PATHINFO_EXTENSION);
			// 	$this->upload->initialize($config); // if upload library autoloaded
			// 	if ($this->upload->do_upload('product_category_icon') && $product_category_id && $image_name && $ext && $filename){
			// 		$product_category_icon_up['product_category_icon'] =  $image_name.'.'.$ext;
			// 		$this->Master_Model->update_info('product_category_id', $product_category_id, 'admi_product_category', $product_category_icon_up);
			// 		// Delete old image...
			// 		if($_POST['old_product_category_icon']){ unlink("assets/images/product_category/".$_POST['old_product_category_icon']); }
			// 		$this->session->set_flashdata(['flash_msg1'=>'Product Category Icon Uploaded Successfully', 'flash_class1'=>'success']);
			// 	}
			// 	else{
			// 		$error = $this->upload->display_errors();
			// 		$this->session->set_flashdata(['flash_msg1'=>$error, 'flash_class1'=>'error']);
			// 	}
			// } 

			// Upload Product Category Image...
			if (isset($_FILES['product_category_image']['name']) && $_FILES['product_category_image']['name']) {
				$time = time();
				$image_name = 'product_category_image_' . $product_category_id . '_' . $time;
				$config['upload_path'] = 'assets/images/product_category/';
				$config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['file_name'] = $image_name;
				$filename = $_FILES['product_category_image']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$this->upload->initialize($config); // if upload library autoloaded
				if ($this->upload->do_upload('product_category_image') && $product_category_id && $image_name && $ext && $filename) {
					$product_category_image_up['product_category_image'] =  $image_name . '.' . $ext;
					$this->Master_Model->update_info('product_category_id', $product_category_id, 'admi_product_category', $product_category_image_up);
					// Delete old image...
					if ($_POST['old_product_category_image']) {
						unlink("assets/images/product_category/" . $_POST['old_product_category_image']);
					}
					// $this->session->set_flashdata(['flash_msg2'=>'Product Category Image Uploaded Successfully', 'flash_class2'=>'success']);
				} else {
					$error = $this->upload->display_errors();
					// $this->session->set_flashdata(['flash_msg2'=>$error, 'flash_class2'=>'error']);
				}
			}

			$this->_set_flashdata_and_redirect('Master/product_category', 'Product Category Information Updated Successfully', 'info');
		}

		$product_category_info = $this->Master_Model->get_info_arr('product_category_id', $product_category_id, 'admi_product_category');
		if (!$product_category_info) {
			header('location:' . base_url() . 'Master/product_category');
		}
		$data['update'] = 'update';
		$data['update_product_category'] = 'update';
		$data['product_category_info'] = $product_category_info[0];
		$data['act_link'] = base_url() . 'Master/edit_product_category/' . $product_category_id;

		$data['main_product_category_list'] = $this->Master_Model->get_data('admi_product_category', '*', ['company_id' => $admi_user_data['company_id'], 'is_main' => '1'], '`product_category_name` ASC', 'result');

		$data['product_category_list'] = $this->Master_Model->get_data('admi_product_category', '*', ['company_id' => $admi_user_data['company_id']], '`product_category_id` DESC', 'result');
		$data['page'] = 'Edit Product Category';
		$data['main_menu'] = "Product";
		$data['sub_menu'] = "Product Category";
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/product_category', $data);
		$this->load->view('Admin/Include/footer', $data);
	}


	/*********************************** Delete User - product_category4 ********************************/

	public function delete_product_category($product_category_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("product_category4", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		// $user_info = $this->Master_Model->get_data('admi_user','user_image, user_id',['user_id'=>$user_id],'`user_id` ASC','row_array');
		// if($user_info){
		//   $user_image = $user_info['user_image'];
		//   if($user_image){ unlink("assets/images/master/".$user_image); }
		// }
		$is_delete = $this->Master_Model->delete_info('product_category_id', $product_category_id, 'admi_product_category');
		if ($is_delete['code'] == '1451') {
			$this->_set_flashdata_and_redirect('Master/product_category', 'Can not delete, Product Category information is used', 'error');
		} else {
			$this->_set_flashdata_and_redirect('Master/product_category', 'Product Category Information Deleted Successfully', 'error');
		}
	}








	/***********************************************************************************************************/
	/**************************************** Product Information ****************************************/
	/***********************************************************************************************************/


	/*********************************** Add Product - product1 ********************************/

	public function product()
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("product1", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$this->form_validation->set_rules('product_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$product_status = $this->input->post('product_status');
			if (!isset($product_status)) {
				$product_status = '1';
			}

			$save_data = $_POST;
			unset($save_data['input']);
			$product_name = trim($_POST['product_name']);
			$save_data['product_name'] = $product_name;
			$save_data['product_status'] = $product_status;
			$save_data['company_id'] = $admi_user_data['company_id'];
			$save_data['product_addedby'] = $admi_user_data['user_id'];
			$save_data['product_created_at'] = date('Y-m-d H:i:s');
			$product_id = $this->Master_Model->save_data('admi_product', $save_data);

			if ($product_id) {
				// Upload Product Image...
				if (isset($_FILES['product_image']['name']) && $_FILES['product_image']['name']) {
					$time = time();
					$image_name = 'product_image_' . $product_id . '_' . $time;
					$config['upload_path'] = 'assets/images/product/';
					$config['allowed_types'] = 'jpg|jpeg|png|PNG|gif';
					$config['file_name'] = $image_name;
					$filename = $_FILES['product_image']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					$this->upload->initialize($config); // if upload library autoloaded
					if ($this->upload->do_upload('product_image') && $product_id && $image_name && $ext && $filename) {
						$product_image_up['product_image'] =  $image_name . '.' . $ext;
						$this->Master_Model->update_info('product_id', $product_id, 'admi_product', $product_image_up);
						// $this->session->set_flashdata(['flash_msg2'=>'Product Image Uploaded Successfully', 'flash_class2'=>'success']);
					} else {
						$error = $this->upload->display_errors();
						$this->session->set_flashdata(['flash_msg2' => $error, 'flash_class2' => 'error']);
					}
				}
				// else{
				// 	$this->session->set_flashdata(['flash_msg1'=>'Product image not selected', 'flash_class1'=>'error']);
				// }

				// Add Product Attribute...
				foreach ($_POST['input'] as $multi_data) {
					$multi_data['product_id'] = $product_id;
					$multi_data['company_id'] = $admi_user_data['company_id'];
					$multi_data['product_attr_addedby'] = $admi_user_data['user_id'];
					$multi_data['product_attr_created_at'] = date('Y-m-d H:i:s');
					$this->db->insert('admi_product_attr', $multi_data);
				}

				$this->_set_flashdata_and_redirect('Master/product', 'Product Saved Successfully', 'success');
			} else {
				$this->_set_flashdata_and_redirect('Master/product', 'Product Not Saved', 'error');
			}
		}
		$data['manufacturer_list'] = $this->Master_Model->get_data('admi_manufacturer', '*', ['company_id' => $admi_user_data['company_id']], '`manufacturer_name` ASC', 'result');
		$data['main_category_list'] = $this->Master_Model->get_data('admi_product_category', '*', ['company_id' => $admi_user_data['company_id'], 'is_main' => '1'], '`product_category_name` ASC', 'result');
		$data['unit_list'] = $this->Master_Model->get_data('admi_unit', '*', ['company_id' => $admi_user_data['company_id']], '`unit_name` ASC', 'result');
		$data['tax_rate_list'] = $this->Master_Model->get_data('admi_tax_rate', '*', ['company_id' => $admi_user_data['company_id']], '`tax_rate_per` ASC', 'result');

		$data['product_list'] = $this->Master_Model->get_data('admi_product', '*', ['company_id' => $admi_user_data['company_id']], '`product_id` DESC', 'result');
		$data['page'] = 'Product';
		$data['main_menu'] = "Product";
		$data['sub_menu'] = "Product";
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/product', $data);
		$this->load->view('Admin/Include/footer', $data);
	}


	/*********************************** Edit/Update Product - product3 ********************************/

	public function edit_product($product_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("product3", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$this->form_validation->set_rules('product_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$product_status = $this->input->post('product_status');
			if (!isset($product_status)) {
				$product_status = '1';
			}
			$update_data = $_POST;
			unset($update_data['input']);
			unset($update_data['old_product_image']);
			$product_name = trim($_POST['product_name']);
			$update_data['product_name'] = $product_name;
			$update_data['product_status'] = $product_status;
			$update_data['product_updatedby'] = $admi_user_data['user_id'];
			$update_data['product_updated_at'] = date('Y-m-d H:i:s');

			$this->Master_Model->update_info('product_id', $product_id, 'admi_product', $update_data);

			// Upload Product Image...
			if (isset($_FILES['product_image']['name']) && $_FILES['product_image']['name']) {
				$time = time();
				$image_name = 'product_image_' . $product_id . '_' . $time;
				$config['upload_path'] = 'assets/images/product/';
				$config['allowed_types'] = 'jpg|jpeg|png|PNG|gif';
				$config['file_name'] = $image_name;
				$filename = $_FILES['product_image']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$this->upload->initialize($config); // if upload library autoloaded
				if ($this->upload->do_upload('product_image') && $product_id && $image_name && $ext && $filename) {
					$product_image_up['product_image'] =  $image_name . '.' . $ext;
					$this->Master_Model->update_info('product_id', $product_id, 'admi_product', $product_image_up);
					// Delete old image...
					if ($_POST['old_product_image']) {
						unlink("assets/images/product/" . $_POST['old_product_image']);
					}
					// $this->session->set_flashdata(['flash_msg2'=>'Product Image Uploaded Successfully', 'flash_class2'=>'success']);
				} else {
					$error = $this->upload->display_errors();
					$this->session->set_flashdata(['flash_msg2' => $error, 'flash_class2' => 'error']);
				}
			}

			// Update Product Attribute...
			foreach ($_POST['input'] as $multi_data) {
				if (isset($multi_data['product_attr_id'])) {
					$product_attr_id = $multi_data['product_attr_id'];
					if (!isset($multi_data['product_attr_value'])) {
						$this->Master_Model->delete_info('product_attr_id', $product_attr_id, 'admi_product_attr');
					} else {
						$multi_data['product_attr_updatedby'] = $admi_user_data['user_id'];
						$multi_data['product_attr_updated_at'] = date('Y-m-d H:i:s');
						$this->Master_Model->update_info('product_attr_id', $product_attr_id, 'admi_product_attr', $multi_data);
					}
				} else {
					$multi_data['product_id'] = $product_id;
					$multi_data['company_id'] = $admi_user_data['company_id'];
					$multi_data['product_attr_addedby'] = $admi_user_data['user_id'];
					$multi_data['product_attr_created_at'] = date('Y-m-d H:i:s');
					$this->db->insert('admi_product_attr', $multi_data);
				}
			}

			$this->_set_flashdata_and_redirect('Master/product', 'Product Information Updated Successfully', 'info');
		}

		$product_info = $this->Master_Model->get_info_arr('product_id', $product_id, 'admi_product');
		if (!$product_info) {
			header('location:' . base_url() . 'Master/product');
		}
		$data['update'] = 'update';
		$data['update_product'] = 'update';
		$data['product_info'] = $product_info[0];
		$data['act_link'] = base_url() . 'Master/edit_product/' . $product_id;
		$main_category_id = $product_info[0]['main_category_id'];
		$sub_category_id = $product_info[0]['sub_category_id'];
		// $sub_category_two_id = $product_info[0]['sub_category_two_id'];

		$data['manufacturer_list'] = $this->Master_Model->get_data('admi_manufacturer', '*', ['company_id' => $admi_user_data['company_id']], '`manufacturer_name` ASC', 'result');
		$data['unit_list'] = $this->Master_Model->get_data('admi_unit', '*', ['company_id' => $admi_user_data['company_id']], '`unit_name` ASC', 'result');
		$data['tax_rate_list'] = $this->Master_Model->get_data('admi_tax_rate', '*', ['company_id' => $admi_user_data['company_id']], '`tax_rate_per` ASC', 'result');

		$data['main_category_list'] = $this->Master_Model->get_data('admi_product_category', '*', ['company_id' => $admi_user_data['company_id'], 'is_main' => '1'], '`product_category_name` ASC', 'result');
		$data['sub_category_list'] = $this->Master_Model->get_data('admi_product_category', '*', ['company_id' => $admi_user_data['company_id'], 'is_main' => '0', 'main_product_category_id' => $main_category_id], '`product_category_name` ASC', 'result');

		$data['product_attr_list'] = $this->Master_Model->get_data('admi_product_attr', '*', ['company_id' => $admi_user_data['company_id'], 'product_id' => $product_id], '`product_attr_id` ASC', 'result');
		$data['product_list'] = $this->Master_Model->get_data('admi_product', '*', ['company_id' => $admi_user_data['company_id']], '`product_id` DESC', 'result');
		$data['page'] = 'Edit Product';
		$data['main_menu'] = "Product";
		$data['sub_menu'] = "Product";
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/product', $data);
		$this->load->view('Admin/Include/footer', $data);
	}


	/*********************************** Delete Product - product4 ********************************/

	public function delete_product($product_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("product4", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		// $user_info = $this->Master_Model->get_data('admi_user','user_image, user_id',['user_id'=>$user_id],'`user_id` ASC','row_array');
		// if($user_info){
		//   $user_image = $user_info['user_image'];
		//   if($user_image){ unlink("assets/images/master/".$user_image); }
		// }
		$is_delete = $this->Master_Model->delete_info('product_id', $product_id, 'admi_product');
		if ($is_delete['code'] == '1451') {
			$this->Master_Model->delete_info('product_id', $product_id, 'admi_product_attr');
			$this->_set_flashdata_and_redirect('Master/product', 'Can not delete, Product information is used', 'error');
		} else {
			$this->_set_flashdata_and_redirect('Master/product', 'Product Information Deleted Successfully', 'error');
		}
	}


	/*********************************** Product Gallery - product_gallery1 ********************************/

	public function product_gallery($product_id = null)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("product_gallery1", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$this->form_validation->set_rules('product_id', 'product_id', 'trim|required');
		if ($this->form_validation->run() != FALSE) {

			$i = 0;
			$img_count = 0;
			foreach ($_POST['input'] as $multi_data) {
				$i++;
				$gallery_image_name = $multi_data['gallery_image_name'];
				// Upload File...
				if (isset($_FILES['' . $gallery_image_name . '']['name']) && $_FILES['' . $gallery_image_name . '']['name']) {
					$multi_data['product_id'] = $product_id;
					$multi_data['company_id'] = $admi_user_data['company_id'];
					$multi_data['product_gallery_addedby'] = $admi_user_data['user_id'];
					$multi_data['product_gallery_created_at'] = date('Y-m-d H:i:s');
					unset($multi_data['gallery_image_name']);

					$time = time();
					$image_name = 'product_gallery_' . $product_id . '_' . $i . '_' . $time;
					$config['upload_path'] = 'assets/images/product/';
					$config['allowed_types'] = 'jpg|jpeg|png|PNG|gif';
					$config['file_name'] = $image_name;
					$filename = $_FILES['' . $gallery_image_name . '']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					$this->upload->initialize($config); // if upload library autoloaded
					if ($this->upload->do_upload('' . $gallery_image_name . '') && $product_id && $image_name && $ext && $filename) {
						$multi_data['product_gallery_image'] =  $image_name . '.' . $ext;
						$product_gallery_id = $this->Master_Model->save_data('admi_product_gallery', $multi_data);
						$img_count++;
					}
				}
			}

			$this->_set_flashdata_and_redirect('Master/product', $img_count . ' Product image/s uploaded', 'success');
		}
		$product_info = $this->Master_Model->get_info_arr('product_id', $product_id, 'admi_product');
		if (!$product_info) {
			header('location:' . base_url() . 'Master/product');
		}
		$data['product_info'] = $product_info[0];
		$data['product_id'] = $product_id;

		$data['product_gallery_list'] = $this->Master_Model->get_data('admi_product_gallery', '*', ['product_id' => $product_id], '`product_gallery_id` ASC', 'result');
		$data['page'] = 'Product Gallery';
		$data['main_menu'] = "Product";
		$data['sub_menu'] = "Product Gallery";
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/product_gallery', $data);
		$this->load->view('Admin/Include/footer', $data);
	}

	/*********************************** Delete Product Gallery Image - product_gallery3 ********************************/

	public function delete_product_gallery($product_gallery_id = null)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("product_gallery3", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$product_gallery_info = $this->Master_Model->get_data('admi_product_gallery', '*', ['product_gallery_id' => $product_gallery_id], '`product_gallery_id` DESC', 'row_array');
		if (!$product_gallery_info) {
			header('location:' . base_url() . 'Master/product');
		} else {
			$product_id = $product_gallery_info['product_id'];
			$product_gallery_image = $product_gallery_info['product_gallery_image'];

			if ($product_gallery_image && file_exists('assets/images/product/' . $product_gallery_image)) {
				unlink("assets/images/product/" . $product_gallery_image);
			}

			$is_delete = $this->Master_Model->delete_info('product_gallery_id', $product_gallery_id, 'admi_product_gallery');
			$this->_set_flashdata_and_redirect('Master/product_gallery/' . $product_id, 'Image deleted successfully', 'error');
		}
	}





	/***********************************************************************************************************/
	/**************************************** Customer Information ****************************************/
	/***********************************************************************************************************/


	/*********************************** Add Customer - customer1 ********************************/

	public function customer()
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("customer1", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$this->form_validation->set_rules('customer_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$customer_status = $this->input->post('customer_status');
			if (!isset($customer_status)) {
				$customer_status = '1';
			}

			$save_data = $_POST;
			$save_data['customer_status'] = $customer_status;
			$save_data['company_id'] = $admi_user_data['company_id'];
			$save_data['customer_addedby'] = $admi_user_data['user_id'];
			$save_data['customer_created_at'] = date('Y-m-d H:i:s');

			// if(isset($_POST['customer_category_id'])){
			// 	$customer_category_id = $_POST['customer_category_id'];
			// 	$customer_category_id = implode(',', $customer_category_id);
			// 	$save_data['customer_category_id'] = $customer_category_id;
			// }

			$customer_id = $this->Master_Model->save_data('admi_customer', $save_data);

			if ($customer_id) {

				// Upload Customer Image...
				if (isset($_FILES['customer_image']['name']) && $_FILES['customer_image']['name']) {
					$time = time();
					$image_name = 'customer_image_' . $customer_id . '_' . $time;
					$config['upload_path'] = 'assets/images/customer/';
					$config['allowed_types'] = 'jpg|jpeg|png|PNG|gif';
					$config['file_name'] = $image_name;
					$filename = $_FILES['customer_image']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					$this->upload->initialize($config); // if upload library autoloaded
					if ($this->upload->do_upload('customer_image') && $customer_id && $image_name && $ext && $filename) {
						$customer_image_up['customer_image'] =  $image_name . '.' . $ext;
						$this->Master_Model->update_info('customer_id', $customer_id, 'admi_customer', $customer_image_up);
						$this->session->set_flashdata(['flash_msg2' => 'Customer Image Uploaded Successfully', 'flash_class2' => 'success']);
					} else {
						$error = $this->upload->display_errors();
						$this->session->set_flashdata(['flash_msg2' => $error, 'flash_class2' => 'error']);
					}
				} else {
					$this->session->set_flashdata(['flash_msg1' => 'Customer image not selected', 'flash_class1' => 'error']);
				}
				$this->_set_flashdata_and_redirect('Master/customer', 'Customer Saved Successfully', 'success');
			} else {
				$this->_set_flashdata_and_redirect('Master/customer', 'Customer Not Saved', 'error');
			}
		}
		$data['state_list'] = $this->Master_Model->get_data('state', '*', ['country_id' => '101'], '`state_name` ASC', 'result');

		$data['customer_list'] = $this->Master_Model->get_data('admi_customer', '*', ['company_id' => $admi_user_data['company_id']], '`customer_id` DESC', 'result');
		$data['page'] = 'Customer';
		$data['main_menu'] = "Master";
		$data['sub_menu'] = "Customer";
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/customer', $data);
		$this->load->view('Admin/Include/footer', $data);
	}


	/*********************************** Edit/Update Customer - customer3 ********************************/

	public function edit_customer($customer_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("customer3", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$this->form_validation->set_rules('customer_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$customer_status = $this->input->post('customer_status');
			if (!isset($customer_status)) {
				$customer_status = '1';
			}
			$update_data = $_POST;
			unset($update_data['old_customer_image']);
			$update_data['customer_status'] = $customer_status;
			$update_data['customer_updatedby'] = $admi_user_data['user_id'];
			$update_data['customer_updated_at'] = date('Y-m-d H:i:s');

			if (isset($_POST['customer_category_id'])) {
				$customer_category_id = $_POST['customer_category_id'];
				$customer_category_id = implode(',', $customer_category_id);
				$update_data['customer_category_id'] = $customer_category_id;
			}

			$this->Master_Model->update_info('customer_id', $customer_id, 'admi_customer', $update_data);

			// Upload Customer Image...
			if (isset($_FILES['customer_image']['name']) && $_FILES['customer_image']['name']) {
				$time = time();
				$image_name = 'customer_image_' . $customer_id . '_' . $time;
				$config['upload_path'] = 'assets/images/customer/';
				$config['allowed_types'] = 'jpg|jpeg|png|PNG|gif';
				$config['file_name'] = $image_name;
				$filename = $_FILES['customer_image']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$this->upload->initialize($config); // if upload library autoloaded
				if ($this->upload->do_upload('customer_image') && $customer_id && $image_name && $ext && $filename) {
					$customer_image_up['customer_image'] =  $image_name . '.' . $ext;
					$this->Master_Model->update_info('customer_id', $customer_id, 'admi_customer', $customer_image_up);
					// Delete old image...
					if ($_POST['old_customer_image']) {
						unlink("assets/images/customer/" . $_POST['old_customer_image']);
					}
					$this->session->set_flashdata(['flash_msg2' => 'Customer Image Uploaded Successfully', 'flash_class2' => 'success']);
				} else {
					$error = $this->upload->display_errors();
					$this->session->set_flashdata(['flash_msg2' => $error, 'flash_class2' => 'error']);
				}
			}

			$this->_set_flashdata_and_redirect('Master/customer', 'Customer Information Updated Successfully', 'info');
		}

		$customer_info = $this->Master_Model->get_info_arr('customer_id', $customer_id, 'admi_customer');
		if (!$customer_info) {
			header('location:' . base_url() . 'Master/customer');
		}
		$data['update'] = 'update';
		$data['update_customer'] = 'update';
		$data['customer_info'] = $customer_info[0];
		$data['act_link'] = base_url() . 'Master/edit_customer/' . $customer_id;
		$state_id = $customer_info[0]['state_id'];

		$data['state_list'] = $this->Master_Model->get_data('state', '*', ['country_id' => '101'], '`state_name` ASC', 'result');
		$data['city_list'] = $this->Master_Model->get_data('city', '*', ['state_id' => $state_id], '`city_name` ASC', 'result');

		$data['customer_list'] = $this->Master_Model->get_data('admi_customer', '*', ['company_id' => $admi_user_data['company_id']], '`customer_id` DESC', 'result');
		$data['page'] = 'Edit Customer';
		$data['main_menu'] = "Master";
		$data['sub_menu'] = "Customer";
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/customer', $data);
		$this->load->view('Admin/Include/footer', $data);
	}


	/*********************************** Delete Customer - customer4 ********************************/

	public function delete_customer($customer_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("customer4", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		// $user_info = $this->Master_Model->get_data('admi_user','user_image, user_id',['user_id'=>$user_id],'`user_id` ASC','row_array');
		// if($user_info){
		//   $user_image = $user_info['user_image'];
		//   if($user_image){ unlink("assets/images/master/".$user_image); }
		// }
		$is_delete = $this->Master_Model->delete_info('customer_id', $customer_id, 'admi_customer');
		if ($is_delete['code'] == '1451') {
			$this->_set_flashdata_and_redirect('Master/customer', 'Can not delete, Customer information is used', 'error');
		} else {
			$this->_set_flashdata_and_redirect('Master/customer', 'Customer Information Deleted Successfully', 'error');
		}
	}


	/**************************************************************************************************/
	/********************************************** Enquiry ********************************************/
	/**************************************************************************************************/

	/*********************************** Enquiry List - enquiry1 ********************************/
	public function enquiry()
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("enquiry1", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$this->form_validation->set_rules('from_date', 'First Name', 'trim|required');
		$this->form_validation->set_rules('to_date', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$from_date = $_POST['from_date'];
			$to_date = $_POST['to_date'];

			$data['from_date'] = $from_date;
			$data['to_date'] = $to_date;
			$data['enquiry_list'] = $this->Transaction_Model->get_enquiry_report($from_date, $to_date);
		}

		// $data['enquiry_list'] = $this->Master_Model->get_data('admi_enquiry','*','','`enquiry_id` DESC','result');
		$data['main_menu'] = "Enquiry";
		$data['sub_menu'] = "Enquiry";
		$data['page'] = 'Enquiry';
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/enquiry', $data);
		$this->load->view('Admin/Include/footer', $data);
	}








	/***********************************************************************************************************/
	/**************************************** Service Information ****************************************/
	/***********************************************************************************************************/


	/*********************************** Add Service - service1 ********************************/

	public function service()
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("service1", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$this->form_validation->set_rules('service_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$service_status = $this->input->post('service_status');
			if (!isset($service_status)) {
				$service_status = '1';
			}

			$save_data = $_POST;
			$save_data['service_status'] = $service_status;
			$save_data['company_id'] = $admi_user_data['company_id'];
			$save_data['service_addedby'] = $admi_user_data['user_id'];
			$save_data['service_created_at'] = date('Y-m-d H:i:s');

			$check_dup = $this->Master_Model->get_data('admi_service', 'service_id', ['company_id' => $admi_user_data['company_id'], 'service_name' => $_POST['service_name']], '`service_id` ASC', 'row_array');

			if (empty($check_dup)) {
				$service_id = $this->Master_Model->save_data('admi_service', $save_data);
				if ($service_id) {
					// Upload Service Image...
					if (isset($_FILES['service_image']['name']) && $_FILES['service_image']['name']) {
						$time = time();
						$image_name = 'service_image_' . $service_id . '_' . $time;
						$config['upload_path'] = 'assets/images/service/';
						$config['allowed_types'] = 'jpg|jpeg|png|PNG|gif';
						$config['file_name'] = $image_name;
						$filename = $_FILES['service_image']['name'];
						$ext = pathinfo($filename, PATHINFO_EXTENSION);
						$this->upload->initialize($config); // if upload library autoloaded
						if ($this->upload->do_upload('service_image') && $service_id && $image_name && $ext && $filename) {
							$service_image_up['service_image'] =  $image_name . '.' . $ext;
							$this->Master_Model->update_info('service_id', $service_id, 'admi_service', $service_image_up);
							$this->session->set_flashdata(['flash_msg2' => 'Service Image Uploaded Successfully', 'flash_class2' => 'success']);
						} else {
							$error = $this->upload->display_errors();
							$this->session->set_flashdata(['flash_msg2' => $error, 'flash_class2' => 'error']);
						}
					} else {
						$this->session->set_flashdata(['flash_msg1' => 'Service image not selected', 'flash_class1' => 'error']);
					}
					$this->_set_flashdata_and_redirect('Master/service', 'Service Saved Successfully', 'success');
				} else {
					$this->_set_flashdata_and_redirect('Master/service', 'Service Not Saved', 'error');
				}
			} else {
				$this->_set_flashdata_and_redirect('Master/service', 'This Service Exist', 'error');
			}
		}

		$data['service_list'] = $this->Master_Model->get_data('admi_service', '*', ['company_id' => $admi_user_data['company_id']], '`service_id` DESC', 'result');
		$data['page'] = 'Service';
		$data['main_menu'] = "Master";
		$data['sub_menu'] = "Service";
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/service', $data);
		$this->load->view('Admin/Include/footer', $data);
	}


	/*********************************** Edit/Update Service - service3 ********************************/

	public function edit_service($service_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("service3", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$service_info = $this->Master_Model->get_info_arr('service_id', $service_id, 'admi_service');
		if (!$service_info) {
			header('location:' . base_url() . 'Master/service');
		}

		$this->form_validation->set_rules('service_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$service_status = $this->input->post('service_status');
			if (!isset($service_status)) {
				$service_status = '1';
			}
			$update_data = $_POST;
			unset($update_data['old_service_image']);
			$update_data['service_status'] = $service_status;
			$update_data['service_updatedby'] = $admi_user_data['user_id'];
			$update_data['service_updated_at'] = date('Y-m-d H:i:s');

			$check_dup = $this->Master_Model->get_data('admi_service', 'service_id', ['company_id' => $admi_user_data['company_id'], 'service_name' => $_POST['service_name']], '`service_id` ASC', 'row_array');

			if ($check_dup && $_POST['service_name'] != $service_info[0]['service_name']) {
				$this->_set_flashdata_and_redirect('Master/service', 'This Service Exist', 'error');
			} else {
				$this->Master_Model->update_info('service_id', $service_id, 'admi_service', $update_data);
				// Upload Service Image...
				if (isset($_FILES['service_image']['name']) && $_FILES['service_image']['name']) {
					$time = time();
					$image_name = 'service_image_' . $service_id . '_' . $time;
					$config['upload_path'] = 'assets/images/service/';
					$config['allowed_types'] = 'jpg|jpeg|png|PNG|gif';
					$config['file_name'] = $image_name;
					$filename = $_FILES['service_image']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					$this->upload->initialize($config); // if upload library autoloaded
					if ($this->upload->do_upload('service_image') && $service_id && $image_name && $ext && $filename) {
						$service_image_up['service_image'] =  $image_name . '.' . $ext;
						$this->Master_Model->update_info('service_id', $service_id, 'admi_service', $service_image_up);
						// Delete old image...
						if ($_POST['old_service_image']) {
							unlink("assets/images/service/" . $_POST['old_service_image']);
						}
						$this->session->set_flashdata(['flash_msg2' => 'Service Image Uploaded Successfully', 'flash_class2' => 'success']);
					} else {
						$error = $this->upload->display_errors();
						$this->session->set_flashdata(['flash_msg2' => $error, 'flash_class2' => 'error']);
					}
				}
			}



			$this->_set_flashdata_and_redirect('Master/service', 'Service Information Updated Successfully', 'info');
		}


		$data['update'] = 'update';
		$data['update_service'] = 'update';
		$data['service_info'] = $service_info[0];
		$data['act_link'] = base_url() . 'Master/edit_service/' . $service_id;

		$data['service_list'] = $this->Master_Model->get_data('admi_service', '*', ['company_id' => $admi_user_data['company_id']], '`service_id` DESC', 'result');
		$data['page'] = 'Edit Service';
		$data['main_menu'] = "Master";
		$data['sub_menu'] = "Service";
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/service', $data);
		$this->load->view('Admin/Include/footer', $data);
	}


	/*********************************** Delete User - service4 ********************************/

	public function delete_service($service_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("service4", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		// $user_info = $this->Master_Model->get_data('admi_user','user_image, user_id',['user_id'=>$user_id],'`user_id` ASC','row_array');
		// if($user_info){
		//   $user_image = $user_info['user_image'];
		//   if($user_image){ unlink("assets/images/master/".$user_image); }
		// }
		$is_delete = $this->Master_Model->delete_info('service_id', $service_id, 'admi_service');
		if ($is_delete['code'] == '1451') {
			$this->_set_flashdata_and_redirect('Master/service', 'Can not delete, Service information is used', 'error');
		} else {
			$this->_set_flashdata_and_redirect('Master/service', 'Service Information Deleted Successfully', 'error');
		}
	}




	/***********************************************************************************************************/
	/**************************************** Gallery Information ****************************************/
	/***********************************************************************************************************/


	/*********************************** Add Gallery - gallery1 ********************************/

	public function gallery()
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("gallery1", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$this->form_validation->set_rules('gallery_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$gallery_status = $this->input->post('gallery_status');
			if (!isset($gallery_status)) {
				$gallery_status = '1';
			}

			$save_data = $_POST;
			$save_data['gallery_status'] = $gallery_status;
			$save_data['company_id'] = $admi_user_data['company_id'];
			$save_data['gallery_addedby'] = $admi_user_data['user_id'];
			$save_data['gallery_created_at'] = date('Y-m-d H:i:s');

			$check_dup = $this->Master_Model->get_data('admi_gallery', 'gallery_id', ['company_id' => $admi_user_data['company_id'], 'gallery_name' => $_POST['gallery_name']], '`gallery_id` ASC', 'row_array');

			if (empty($check_dup)) {
				$gallery_id = $this->Master_Model->save_data('admi_gallery', $save_data);
				if ($gallery_id) {
					// Upload Gallery Image...
					if (isset($_FILES['gallery_image']['name']) && $_FILES['gallery_image']['name']) {
						$time = time();
						$image_name = 'gallery_image_' . $gallery_id . '_' . $time;
						$config['upload_path'] = 'assets/images/gallery/';
						$config['allowed_types'] = 'jpg|jpeg|png|PNG|gif';
						$config['file_name'] = $image_name;
						$filename = $_FILES['gallery_image']['name'];
						$ext = pathinfo($filename, PATHINFO_EXTENSION);
						$this->upload->initialize($config); // if upload library autoloaded
						if ($this->upload->do_upload('gallery_image') && $gallery_id && $image_name && $ext && $filename) {
							$gallery_image_up['gallery_image'] =  $image_name . '.' . $ext;
							$this->Master_Model->update_info('gallery_id', $gallery_id, 'admi_gallery', $gallery_image_up);
							$this->session->set_flashdata(['flash_msg2' => 'Gallery Image Uploaded Successfully', 'flash_class2' => 'success']);
						} else {
							$error = $this->upload->display_errors();
							$this->session->set_flashdata(['flash_msg2' => $error, 'flash_class2' => 'error']);
						}
					} else {
						$this->session->set_flashdata(['flash_msg1' => 'Gallery image not selected', 'flash_class1' => 'error']);
					}
					$this->_set_flashdata_and_redirect('Master/gallery', 'Gallery Saved Successfully', 'success');
				} else {
					$this->_set_flashdata_and_redirect('Master/gallery', 'Gallery Not Saved', 'error');
				}
			} else {
				$this->_set_flashdata_and_redirect('Master/gallery', 'This Gallery Exist', 'error');
			}
		}

		$data['gallery_list'] = $this->Master_Model->get_data('admi_gallery', '*', ['company_id' => $admi_user_data['company_id']], '`gallery_id` DESC', 'result');
		$data['page'] = 'Gallery';
		$data['main_menu'] = "Master";
		$data['sub_menu'] = "Gallery";
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/gallery', $data);
		$this->load->view('Admin/Include/footer', $data);
	}


	/*********************************** Edit/Update Gallery - gallery3 ********************************/

	public function edit_gallery($gallery_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("gallery3", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$gallery_info = $this->Master_Model->get_info_arr('gallery_id', $gallery_id, 'admi_gallery');
		if (!$gallery_info) {
			header('location:' . base_url() . 'Master/gallery');
		}

		$this->form_validation->set_rules('gallery_name', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$gallery_status = $this->input->post('gallery_status');
			if (!isset($gallery_status)) {
				$gallery_status = '1';
			}
			$update_data = $_POST;
			unset($update_data['old_gallery_image']);
			$update_data['gallery_status'] = $gallery_status;
			$update_data['gallery_updatedby'] = $admi_user_data['user_id'];
			$update_data['gallery_updated_at'] = date('Y-m-d H:i:s');

			$check_dup = $this->Master_Model->get_data('admi_gallery', 'gallery_id', ['company_id' => $admi_user_data['company_id'], 'gallery_name' => $_POST['gallery_name']], '`gallery_id` ASC', 'row_array');

			if ($check_dup && $_POST['gallery_name'] != $gallery_info[0]['gallery_name']) {
				$this->_set_flashdata_and_redirect('Master/gallery', 'This Gallery Exist', 'error');
			} else {
				$this->Master_Model->update_info('gallery_id', $gallery_id, 'admi_gallery', $update_data);
				// Upload Gallery Image...
				if (isset($_FILES['gallery_image']['name']) && $_FILES['gallery_image']['name']) {
					$time = time();
					$image_name = 'gallery_image_' . $gallery_id . '_' . $time;
					$config['upload_path'] = 'assets/images/gallery/';
					$config['allowed_types'] = 'jpg|jpeg|png|PNG|gif';
					$config['file_name'] = $image_name;
					$filename = $_FILES['gallery_image']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					$this->upload->initialize($config); // if upload library autoloaded
					if ($this->upload->do_upload('gallery_image') && $gallery_id && $image_name && $ext && $filename) {
						$gallery_image_up['gallery_image'] =  $image_name . '.' . $ext;
						$this->Master_Model->update_info('gallery_id', $gallery_id, 'admi_gallery', $gallery_image_up);
						// Delete old image...
						if ($_POST['old_gallery_image']) {
							unlink("assets/images/gallery/" . $_POST['old_gallery_image']);
						}
						$this->session->set_flashdata(['flash_msg2' => 'Gallery Image Uploaded Successfully', 'flash_class2' => 'success']);
					} else {
						$error = $this->upload->display_errors();
						$this->session->set_flashdata(['flash_msg2' => $error, 'flash_class2' => 'error']);
					}
				}
			}



			$this->_set_flashdata_and_redirect('Master/gallery', 'Gallery Information Updated Successfully', 'info');
		}


		$data['update'] = 'update';
		$data['update_gallery'] = 'update';
		$data['gallery_info'] = $gallery_info[0];
		$data['act_link'] = base_url() . 'Master/edit_gallery/' . $gallery_id;

		$data['gallery_list'] = $this->Master_Model->get_data('admi_gallery', '*', ['company_id' => $admi_user_data['company_id']], '`gallery_id` DESC', 'result');
		$data['page'] = 'Edit Gallery';
		$data['main_menu'] = "Master";
		$data['sub_menu'] = "Gallery";
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Master/gallery', $data);
		$this->load->view('Admin/Include/footer', $data);
	}


	/*********************************** Delete User - gallery4 ********************************/

	public function delete_gallery($gallery_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("gallery4", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		// $user_info = $this->Master_Model->get_data('admi_user','user_image, user_id',['user_id'=>$user_id],'`user_id` ASC','row_array');
		// if($user_info){
		//   $user_image = $user_info['user_image'];
		//   if($user_image){ unlink("assets/images/master/".$user_image); }
		// }
		$is_delete = $this->Master_Model->delete_info('gallery_id', $gallery_id, 'admi_gallery');
		if ($is_delete['code'] == '1451') {
			$this->_set_flashdata_and_redirect('Master/gallery', 'Can not delete, Gallery information is used', 'error');
		} else {
			$this->_set_flashdata_and_redirect('Master/gallery', 'Gallery Information Deleted Successfully', 'error');
		}
	}





















	/*****************************************************************************************/
	// Check Duplication
	public function check_duplication()
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$column_name = $this->input->post('column_name');
		$column_val = $this->input->post('column_val');
		$table_name = $this->input->post('table_name');
		// $company_id = '';
		$cnt = $this->Master_Model->get_data($table_name, $column_name, [$column_name => $column_val], '', 'num_rows');
		echo $cnt;
	}

	// get_state_by_country
	public function get_state_by_country()
	{
		$country_id = $this->input->post('country_id');
		$state_list = $this->Master_Model->get_list_by_id3('', 'country_id', $country_id, '', '', '', '', 'state_name', 'ASC', 'state');
		echo "<option value='' selected >Select State</option>";
		foreach ($state_list as $list) {
			echo "<option value='" . $list->state_id . "'> " . $list->state_name . " </option>";
		}
	}

	// get_city_by_state
	public function get_city_by_state()
	{
		$state_id = $this->input->post('state_id');
		$city_list = $this->Master_Model->get_list_by_id3('', 'state_id', $state_id, '', '', '', '', 'city_name', 'ASC', 'city');
		echo "<option value='' selected >Select City</option>";
		foreach ($city_list as $list) {
			echo "<option value='" . $list->city_id . "'> " . $list->city_name . " </option>";
		}
	}


	// get_department_by_process_type
	public function get_department_by_process_type()
	{
		$process_type_id = $this->input->post('process_type_id');
		// $department_list = $this->Master_Model->get_data('admi_department','*',['process_type_id'=>$process_type_id],'`department_name` ASC','result');
		$this->db->select('*');
		$this->db->from('admi_department');
		$this->db->where_in('process_type_id', $process_type_id);
		$this->db->order_by('department_name', 'ASC');
		$department_list = $this->db->get()->result();
		
		echo "<option value='' selected >Select Main Category</option>";
		foreach ($department_list as $list) {
			echo "<option value='" . $list->department_id . "' > " . $list->department_name . " </option>";
		}
	}

	// get_department_by_process_type_user
	public function get_department_by_process_type_user()
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$process_type_id = $this->input->post('process_type_id');
		if ($admi_user_data['role_id'] == '1') {
			$department_list = $this->Master_Model->get_data('admi_department', '*', ['process_type_id' => $process_type_id], '`department_name` ASC', 'result');
		} else {
			$department_list = $this->Master_Model->get_data('admi_department', '*', ['process_type_id' => $process_type_id, 'department_id' => $admi_user_data['department_id']], '`department_name` ASC', 'result');
		}

		echo "<option value='' selected >Select Main Category</option>";
		foreach ($department_list as $list) {
			echo "<option value='" . $list->department_id . "' > " . $list->department_name . " </option>";
		}
	}

	// get_item_list_by_party
	public function get_item_list_by_party()
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$party_id = $this->input->post('party_id');

		// print_r($admi_user_data);

		if ($admi_user_data['role_id'] == '1') {
			$item_list = $this->Master_Model->get_data('admi_item', '*', ['party_id' => $party_id], '`item_id` ASC', 'result');
		} else {
			$item_list = $this->Master_Model->get_data('admi_item', '*', ['party_id' => $party_id, 'process_type_id' => $admi_user_data['process_type_id']], '`item_id` ASC', 'result');
		}

		echo "<option value='' selected >Select Drawing No</option>";
		foreach ($item_list as $list) {
			echo "<option value='" . $list->item_id . "'> " . $list->item_finished_drw_no . " </option>";
		}
	}

	// get_process_type_list_by_item
	public function get_process_type_list_by_item()
	{
		$item_id = $this->input->post('item_id');
		$item_data = $this->Master_Model->get_data('admi_item', '*', ['item_id' => $item_id], '`item_id` ASC', 'row_array');

		$process_type_list = $this->Master_Model->get_data('admi_process_type', '*', ['process_type_id' => $item_data['process_type_id']], '`process_type_id` ASC', 'result');

		echo "<option value='' >Select Process Type</option>";
		foreach ($process_type_list as $list) {
			echo "<option value='" . $list->process_type_id . "' selected po_item_descr='" . $item_data['item_descr'] . "' po_item_casting_drg_no='" . $item_data['item_casting_drw_no'] . "'  > " . $list->process_type_name . " </option>";
			// echo "<option value='".$list->process_type_id."' po_item_descr='".$item_data['item_descr']."' po_item_casting_drg_no='".$item_data['item_casting_drw_no']."'  selected> ".$list->process_type_name." </option>";
		}
	}

	// get_process_type_list_by_item2
	public function get_process_type_list_by_item2()
	{
		$item_id = $this->input->post('item_id');
		$item_data = $this->Master_Model->get_data('admi_item', '*', ['item_id' => $item_id], '`item_id` ASC', 'row_array');

		$process_type_list = $this->Master_Model->get_data('admi_process_type', '*', ['process_type_id' => $item_data['process_type_id']], '`process_type_id` ASC', 'result');

		echo "<option value='' >Select Process Type</option>";
		foreach ($process_type_list as $list) {
			// echo "<option value='".$list->process_type_id."' selected po_item_descr='".$item_data['item_descr']."' po_item_casting_drg_no='".$item_data['item_casting_drw_no']."'  > ".$list->process_type_name." </option>";
			echo "<option value='" . $list->process_type_id . "' po_item_descr='" . $item_data['item_descr'] . "' po_item_casting_drg_no='" . $item_data['item_casting_drw_no'] . "' > " . $list->process_type_name . " </option>";
		}
	}


	// get_purchase_order_list_by_item
	public function get_purchase_order_list_by_item()
	{
		$item_id = $this->input->post('item_id');
		$party_id = $this->input->post('party_id');

		$po_item_list = $this->Master_Model->get_data('admi_po_item', '*', ['item_id' => $item_id, 'party_id' => $party_id], '`po_item_id` ASC', 'result');

		echo "<option value='' selected >Select Process Type</option>";
		foreach ($po_item_list as $list) {
			$purchase_order_id = $list->purchase_order_id;
			$purchase_order_data = $this->Master_Model->get_data('admi_purchase_order', 'purchase_order_no', ['purchase_order_id' => $purchase_order_id], '`purchase_order_id` ASC', 'row_array');

			echo "<option value='" . $list->po_item_id . "'> " . $purchase_order_data['purchase_order_no'] . " </option>";
		}
	}


	// get_purchase_order_list_by_item2
	public function get_purchase_order_list_by_item2()
	{
		$item_id = $this->input->post('item_id');
		$party_id = $this->input->post('party_id');

		$po_item_list =  $this->Master_Model->get_data2('admi_po_item', '*', ['item_id' => $item_id, 'party_id' => $party_id], 'purchase_order_id', '`purchase_order_id` ASC', '', 'result');
		// $this->Master_Model->get_data('admi_po_item','*',['item_id'=>$item_id, 'party_id'=>$party_id ],'`po_item_id` ASC','result');


		echo "<option value='' selected >Select Process Type</option>";
		foreach ($po_item_list as $list) {
			$purchase_order_id = $list->purchase_order_id;

			$purchase_order_data = $this->Master_Model->get_data('admi_purchase_order', 'purchase_order_no', ['purchase_order_id' => $purchase_order_id], '`purchase_order_id` ASC', 'row_array');

			echo "<option value='" . $list->purchase_order_id . "' data-qty='" . $list->po_item_add_qty . "'> " . $purchase_order_data['purchase_order_no'] . " </option>";
		}
	}

	// get_grade_list_by_item
	public function get_grade_list_by_item()
	{
		$item_id = $this->input->post('item_id');
		$item_info = $this->Master_Model->get_data('admi_item', 'item_id,grade_id', ['item_id' => $item_id], '`item_id` ASC', 'row_array');

		$grade_list = $this->Master_Model->get_data('admi_grade', '*', ['grade_id' => $item_info['grade_id']], '`grade_id` ASC', 'result');

		echo "<option value='' selected >Select Grade</option>";
		foreach ($grade_list as $list) {
			echo "<option value='" . $list->grade_id . "' selected> " . $list->grade_name . " </option>";
		}
	}







	// // get_main_category_by_type
	// public function get_main_category_by_type(){
	//   $product_type = $this->input->post('product_type');
	//   $main_category_list = $this->Master_Model->get_data('admi_category','*',['product_type'=>$product_type, 'is_main'=>'1'],'`category_name` ASC','result');

	//   echo "<option value='' selected >Select Main Category</option>";
	//   foreach ($main_category_list as $list) {
	//     echo "<option value='".$list->category_id."'> ".$list->category_name." </option>";
	//   }
	// }

	// // get_sub_category_by_main
	// public function get_sub_category_by_main(){
	//   $main_category_id = $this->input->post('main_category_id');
	//   $sub_category_list = $this->Master_Model->get_data('admi_product_category','*',['main_product_category_id'=>$main_category_id, 'is_main'=>'0'],'`product_category_name` ASC','result');

	//   echo "<option value='' selected >Select Sub Category</option>";
	//   foreach ($sub_category_list as $list) {
	//     echo "<option value='".$list->product_category_id."'> ".$list->product_category_name." </option>";
	//   }
	// }

	// // get_product_by_sub_category
	// public function get_product_by_sub_category(){
	//   $sub_category_id = $this->input->post('sub_category_id');
	//   $product_list = $this->Master_Model->get_data('admi_product','*',['sub_category_id'=>$sub_category_id],'`product_name` ASC','result');

	//   echo "<option value='' selected >Select Product</option>";
	//   foreach ($product_list as $list) {
	//     echo "<option value='".$list->product_id."'> ".$list->product_name." </option>";
	//   }
	// }

	// // get_product_by_main_category
	// public function get_product_by_main_category(){
	//   $main_category_id = $this->input->post('main_category_id');
	//   $product_list = $this->Master_Model->get_data('admi_product','*',['main_category_id'=>$main_category_id],'`product_name` ASC','result');

	//   echo "<option value='' selected >Select Product</option>";
	//   foreach ($product_list as $list) {
	//     echo "<option value='".$list->product_id."'> ".$list->product_name." </option>";
	//   }
	// }










}
