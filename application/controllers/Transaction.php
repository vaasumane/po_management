<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaction extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
		$this->load->library('pagination');
	}

	public function index()
	{
		header('location:' . base_url() . 'User');
	}

	private function _set_flashdata_and_redirect($url, $msg, $class)
	{
		$this->session->set_flashdata('flash_msg', $msg);
		$this->session->set_flashdata('class', $class);
		return header('location:' . base_url() . '' . $url);
	}

	/***************************************************************************************************************/
	/**************************************************************************************************/
	/********************************************** Purchase Order ********************************************/
	/**************************************************************************************************/

	/*********************************** Add Purchase Order - purchase_order1 ********************************/
	public function purchase_order()
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("purchase_order1", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$this->form_validation->set_rules('party_id', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {

			$save_data = $_POST;
			unset($save_data['input']);
			$save_data['company_id'] = $admi_user_data['company_id'];
			$save_data['purchase_order_addedby'] = $admi_user_data['user_id'];
			$save_data['purchase_order_created_at'] = date('Y-m-d H:i:s');

			$purchase_order_id = $this->Master_Model->save_data('admi_purchase_order', $save_data);

			// echo $purchase_order_id;

			if ($purchase_order_id) {
				foreach ($_POST['input'] as $multi_data) {
					$multi_data['purchase_order_id'] = $purchase_order_id;
					$multi_data['purchase_order_date'] = $_POST['purchase_order_date'];
					$multi_data['party_id'] = $_POST['party_id'];
					$multi_data['company_id'] = $admi_user_data['company_id'];
					$multi_data['po_item_addedby'] = $admi_user_data['user_id'];
					$multi_data['po_item_created_at'] = date('Y-m-d H:i:s');
					$this->db->insert('admi_po_item', $multi_data);
				}

				$this->_set_flashdata_and_redirect('Transaction/purchase_order', 'Purchase Order Saved Successfully', 'success');
			} else {
				$this->_set_flashdata_and_redirect('Transaction/purchase_order', 'Purchase Order Not Saved', 'error');
			}
		}
		$data['party_list'] = $this->Master_Model->get_data('admi_party', '*', ['company_id' => $admi_user_data['company_id'], 'party_group_id' => '1'], '`party_name` ASC', 'result');
		$data['item_group_list'] = $this->Master_Model->get_data('admi_item_group', '*', ['company_id' => $admi_user_data['company_id']], '`item_group_name` ASC', 'result');
		// $data['process_type_list'] = $this->Master_Model->get_data('admi_process_type','*',['company_id'=>$admi_user_data['company_id']],'`process_type_name` ASC','result');
		// $data['grade_list'] = $this->Master_Model->get_data('admi_grade','*',['company_id'=>$admi_user_data['company_id']],'`grade_name` ASC','result');

		$data['purchase_order_list'] = $this->Master_Model->get_data('admi_purchase_order', '*', ['company_id' => $admi_user_data['company_id']], '`purchase_order_id` DESC', 'result');
		$data['main_menu'] = "Transaction";
		$data['sub_menu'] = "Purchase Order";
		$data['page'] = 'Purchase Order';
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Transaction/purchase_order', $data);
		$this->load->view('Admin/Include/footer', $data);
	}


	/*********************************** Edit/Update Purchase Order - purchase_order3 ********************************/
	public function edit_purchase_order($purchase_order_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("purchase_order3", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$purchase_order_info = $this->Master_Model->get_data('admi_purchase_order', '*', ['company_id' => $admi_user_data['company_id'], 'purchase_order_id' => $purchase_order_id], '`purchase_order_id` DESC', 'row_array');
		if (!$purchase_order_info) {
			$this->_set_flashdata_and_redirect('Transaction/purchase_order', 'Invalid Purchase Order', 'error');
		}


		$this->form_validation->set_rules('party_id', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$update_data = $_POST;
			unset($update_data['input']);
			// $update_data['purchase_order_status'] = $purchase_order_status;
			$update_data['purchase_order_updatedby'] = $admi_user_data['user_id'];
			$update_data['purchase_order_updated_at'] = date('Y-m-d H:i:s');
			$this->Master_Model->update_info('purchase_order_id', $purchase_order_id, 'admi_purchase_order', $update_data);

			foreach ($_POST['input'] as $multi_data) {
				if (isset($multi_data['po_item_id'])) {
					$po_item_id = $multi_data['po_item_id'];
					if (!isset($multi_data['item_id'])) {
						$this->Master_Model->delete_info('po_item_id', $po_item_id, 'admi_po_item');
					} else {
						$multi_data['purchase_order_date'] = $_POST['purchase_order_date'];
						$multi_data['party_id'] = $_POST['party_id'];
						$multi_data['po_item_updatedby'] = $admi_user_data['user_id'];
						$multi_data['po_item_updated_at'] = date('Y-m-d H:i:s');
						$this->Master_Model->update_info('po_item_id', $po_item_id, 'admi_po_item', $multi_data);
					}
				} else {
					$multi_data['purchase_order_id'] = $purchase_order_id;
					$multi_data['purchase_order_date'] = $_POST['purchase_order_date'];
					$multi_data['party_id'] = $_POST['party_id'];
					$multi_data['company_id'] = $admi_user_data['company_id'];
					$multi_data['po_item_addedby'] = $admi_user_data['user_id'];
					$multi_data['po_item_created_at'] = date('Y-m-d H:i:s');
					$this->db->insert('admi_po_item', $multi_data);
				}
			}

			$this->_set_flashdata_and_redirect('Transaction/purchase_order', 'Purchase Order Information Updated Successfully', 'info');
		}


		$data['update'] = 'update';
		$data['purchase_order_info'] = $purchase_order_info;
		$party_id = $purchase_order_info['party_id'];


		$data['party_list'] = $this->Master_Model->get_data('admi_party', '*', ['company_id' => $admi_user_data['company_id'], 'party_group_id' => '1'], '`party_name` ASC', 'result');
		// $data['grade_list'] = $this->Master_Model->get_data('admi_grade','*',['company_id'=>$admi_user_data['company_id']],'`grade_name` ASC','result');
		$data['item_list'] = $this->Master_Model->get_data('admi_item', '*', ['company_id' => $admi_user_data['company_id'], 'party_id' => $party_id], '`item_id` ASC', 'result');

		$data['po_item_list'] = $this->Master_Model->get_data('admi_po_item', '*', ['company_id' => $admi_user_data['company_id'], 'purchase_order_id' => $purchase_order_id], '`po_item_id` ASC', 'result');

		$data['purchase_order_list'] = $this->Master_Model->get_data('admi_purchase_order', '*', ['company_id' => $admi_user_data['company_id']], '`purchase_order_id` DESC', 'result');
		$data['main_menu'] = "Transaction";
		$data['sub_menu'] = "Purchase Order";
		$data['page'] = 'Edit Purchase Order';
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Transaction/purchase_order', $data);
		$this->load->view('Admin/Include/footer', $data);
	}

	/*********************************** Delete Purchase Order - purchase_order4 ********************************/
	public function delete_purchase_order($purchase_order_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("purchase_order4", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$is_delete = $this->Master_Model->delete_info('purchase_order_id', $purchase_order_id, 'admi_purchase_order');
		if ($is_delete['code'] == '1451') {
			$this->_set_flashdata_and_redirect('Transaction/purchase_order', 'Can not delete, Purchase Order information is used', 'error');
		} else {
			// Delete child rows...
			$this->Master_Model->delete_info('purchase_order_id', $purchase_order_id, 'admi_po_item');
			$this->_set_flashdata_and_redirect('Transaction/purchase_order', 'Purchase Order Information Deleted Successfully', 'error');
		}
	}





	/**************************************************************************************************/
	/********************************************** Job Process ********************************************/
	/**************************************************************************************************/

	/*********************************** Add Job Process - job_process1 ********************************/
	public function job_process()
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("job_process1", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$this->form_validation->set_rules('party_id', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {

			$save_data = $_POST;
			unset($save_data['input']);
			$remark_id = implode(", ", $_POST['remark_id']);
			$save_data['remark_id'] = $remark_id;
			$save_data['company_id'] = $admi_user_data['company_id'];
			$save_data['job_process_addedby'] = $admi_user_data['user_id'];
			$save_data['job_process_created_at'] = date('Y-m-d H:i:s');

			$job_process_id = $this->Master_Model->save_data('admi_job_process', $save_data);

			// echo $job_process_id;

			if ($job_process_id) {
				foreach ($_POST['input'] as $multi_data) {
					$multi_data['job_process_id'] = $job_process_id;
					$multi_data['job_process_date'] = $_POST['job_process_date'];
					$multi_data['party_id'] = $_POST['party_id'];
					$multi_data['item_id'] = $_POST['item_id'];
					$multi_data['company_id'] = $admi_user_data['company_id'];
					$multi_data['job_item_addedby'] = $admi_user_data['user_id'];
					$multi_data['job_item_created_at'] = date('Y-m-d H:i:s');
					// $this->db->insert('admi_job_item', $multi_data);
					$job_item_id = $this->Master_Model->save_data('admi_job_item', $multi_data);

					$dep_qty_info = $this->Master_Model->get_data('admi_dep_qty', '*', ['department_id' => $multi_data['department_id'], 'po_item_id' => $multi_data['po_item_id'], 'dep_qty_entry_type' => '1'], '`dep_qty_id` DESC', 'result');


					if (empty($dep_qty_info)) {
						// Add Main Qty..
						$main_add['company_id'] = $admi_user_data['company_id'];
						$main_add['po_item_id'] = $multi_data['po_item_id'];
						$main_add['job_process_id'] = $job_process_id;
						$main_add['job_item_id'] = $job_item_id;
						$main_add['item_id'] = $_POST['item_id'];
						$main_add['dep_qty_entry_type'] = '1';
						$main_add['dep_qty_type'] = '1';
						$main_add['department_id'] = $multi_data['department_id'];
						$main_add['dep_qty'] = $multi_data['job_item_total_qty'];
						$this->Master_Model->save_data('admi_dep_qty', $main_add);
					}

					// Add OK Qty..
					if ($multi_data['ok_department_id'] && $multi_data['job_item_ok_qty']) {
						$ok_add['company_id'] = $admi_user_data['company_id'];
						$ok_add['po_item_id'] = $multi_data['po_item_id'];
						$ok_add['job_process_id'] = $job_process_id;
						$ok_add['job_item_id'] = $job_item_id;
						$ok_add['item_id'] = $_POST['item_id'];
						$ok_add['dep_qty_entry_type'] = '1';
						$ok_add['dep_qty_type'] = '2';
						$ok_add['department_id'] = $multi_data['ok_department_id'];
						$ok_add['dep_qty'] = $multi_data['job_item_ok_qty'];
						$this->Master_Model->save_data('admi_dep_qty', $ok_add);
					}

					// Add Reject Qty..
					if ($multi_data['rejected_department_id'] && $multi_data['job_item_reject_qty']) {
						$reject_add['company_id'] = $admi_user_data['company_id'];
						$reject_add['po_item_id'] = $multi_data['po_item_id'];
						$reject_add['job_process_id'] = $job_process_id;
						$reject_add['job_item_id'] = $job_item_id;
						$reject_add['item_id'] = $_POST['item_id'];
						$reject_add['dep_qty_entry_type'] = '1';
						$reject_add['dep_qty_type'] = '4';
						$reject_add['department_id'] = $multi_data['rejected_department_id'];
						$reject_add['dep_qty'] = $multi_data['job_item_reject_qty'];
						$this->Master_Model->save_data('admi_dep_qty', $reject_add);
					}

					// Add Rework Qty..
					if ($multi_data['rework_department_id'] && $multi_data['job_item_rework_qty']) {
						$rework_add['company_id'] = $admi_user_data['company_id'];
						$rework_add['po_item_id'] = $multi_data['po_item_id'];
						$rework_add['job_process_id'] = $job_process_id;
						$rework_add['job_item_id'] = $job_item_id;
						$rework_add['item_id'] = $_POST['item_id'];
						$rework_add['dep_qty_entry_type'] = '1';
						$rework_add['dep_qty_type'] = '4';
						$rework_add['department_id'] = $multi_data['rework_department_id'];
						$rework_add['dep_qty'] = $multi_data['job_item_rework_qty'];
						$this->Master_Model->save_data('admi_dep_qty', $rework_add);
					}

					// Used Qty..
					$used_add['company_id'] = $admi_user_data['company_id'];
					$used_add['po_item_id'] = $multi_data['po_item_id'];
					$used_add['job_process_id'] = $job_process_id;
					$used_add['job_item_id'] = $job_item_id;
					$used_add['item_id'] = $_POST['item_id'];
					$used_add['dep_qty_entry_type'] = '2';
					$used_add['dep_qty_type'] = '0';
					$used_add['department_id'] = $multi_data['department_id'];
					$used_add['dep_qty'] = $multi_data['job_item_ok_qty'] + $multi_data['job_item_reject_qty'] + $multi_data['job_item_rework_qty'];
					$this->Master_Model->save_data('admi_dep_qty', $used_add);
				}

				$this->_set_flashdata_and_redirect('Transaction/job_process', 'Job Process Saved Successfully', 'success');
			} else {
				$this->_set_flashdata_and_redirect('Transaction/job_process', 'Job Process Not Saved', 'error');
			}
		}
		$data['job_process_no'] = $this->Master_Model->get_count_no('job_process_no', ['company_id' => $admi_user_data['company_id']], 'admi_job_process');

		$data['party_list'] = $this->Master_Model->get_data('admi_party', '*', ['company_id' => $admi_user_data['company_id'], 'party_group_id' => '1'], '`party_name` ASC', 'result');
		$data['item_group_list'] = $this->Master_Model->get_data('admi_item_group', '*', ['company_id' => $admi_user_data['company_id']], '`item_group_name` ASC', 'result');
		// $data['process_type_list'] = $this->Master_Model->get_data('admi_process_type','*',['company_id'=>$admi_user_data['company_id']],'`process_type_name` ASC','result');
		$data['grade_list'] = $this->Master_Model->get_data('admi_grade', '*', ['company_id' => $admi_user_data['company_id']], '`grade_name` ASC', 'result');
		$data['remark_list'] = $this->Master_Model->get_data('admi_remark', '*', ['company_id' => $admi_user_data['company_id']], '`remark_name` ASC', 'result');
		if ($admi_user_data['role_id'] == '1') {
			$data['job_process_list'] = $this->Master_Model->get_data('admi_job_process', '*', ['company_id' => $admi_user_data['company_id'], 'tran_type' => '1'], '`job_process_id` DESC', 'result');
		} else {
			$data['job_process_list'] = $this->Master_Model->get_data('admi_job_process', '*', ['company_id' => $admi_user_data['company_id'], 'job_process_addedby' => $admi_user_data['user_id'], 'tran_type' => '1'], '`job_process_id` DESC', 'result');
		}
		$data['main_menu'] = "Transaction";
		$data['sub_menu'] = "Job Process";
		$data['page'] = 'Job Process';
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Transaction/job_process', $data);
		$this->load->view('Admin/Include/footer', $data);
	}


	/*********************************** Edit/Update Job Process - job_process3 ********************************/
	public function edit_job_process($job_process_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("job_process3", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$job_process_info = $this->Master_Model->get_data('admi_job_process', '*', ['company_id' => $admi_user_data['company_id'], 'job_process_id' => $job_process_id], '`job_process_id` DESC', 'row_array');
		if (!$job_process_info) {
			$this->_set_flashdata_and_redirect('Transaction/job_process', 'Invalid Job Process', 'error');
		}


		$this->form_validation->set_rules('party_id', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {

			$update_data = $_POST;
			unset($update_data['input']);
			$remark_id = implode(", ", $_POST['remark_id']);
			$update_data['remark_id'] = $remark_id;
			// $update_data['job_process_status'] = $job_process_status;
			$update_data['job_process_updatedby'] = $admi_user_data['user_id'];
			$update_data['job_process_updated_at'] = date('Y-m-d H:i:s');
			$this->Master_Model->update_info('job_process_id', $job_process_id, 'admi_job_process', $update_data);

			foreach ($_POST['input'] as $multi_data) {
				if (isset($multi_data['job_item_id'])) {
					$job_item_id = $multi_data['job_item_id'];
					if (!isset($multi_data['po_item_id'])) {
						$this->Master_Model->delete_info('job_item_id', $job_item_id, 'admi_job_item');
						$this->Master_Model->delete_info('job_item_id', $job_item_id, 'admi_dep_qty'); // Delete Qty.
					} else {
						$multi_data['job_process_date'] = $_POST['job_process_date'];
						$multi_data['party_id'] = $_POST['party_id'];
						$multi_data['item_id'] = $_POST['item_id'];
						$multi_data['job_item_updatedby'] = $admi_user_data['user_id'];
						$multi_data['job_item_updated_at'] = date('Y-m-d H:i:s');
						$this->Master_Model->update_info('job_item_id', $job_item_id, 'admi_job_item', $multi_data);

						$this->Master_Model->delete_info('job_item_id', $job_item_id, 'admi_dep_qty'); // Delete Qty.

						// Add Qty...

						$dep_qty_info = $this->Master_Model->get_data('admi_dep_qty', '*', ['department_id' => $multi_data['department_id'], 'po_item_id' => $multi_data['po_item_id'], 'dep_qty_entry_type' => '1'], '`dep_qty_id` DESC', 'result');

						if (empty($dep_qty_info)) {
							// Add Main Qty..
							$main_add['company_id'] = $admi_user_data['company_id'];
							$main_add['po_item_id'] = $multi_data['po_item_id'];
							$main_add['job_process_id'] = $job_process_id;
							$main_add['job_item_id'] = $job_item_id;
							$main_add['item_id'] = $_POST['item_id'];
							$main_add['dep_qty_entry_type'] = '1';
							$main_add['dep_qty_type'] = '1';
							$main_add['department_id'] = $multi_data['department_id'];
							$main_add['dep_qty'] = $multi_data['job_item_total_qty'];
							$this->Master_Model->save_data('admi_dep_qty', $main_add);
						}

						// Add OK Qty..
						if ($multi_data['ok_department_id'] && $multi_data['job_item_ok_qty']) {
							$ok_add['company_id'] = $admi_user_data['company_id'];
							$ok_add['po_item_id'] = $multi_data['po_item_id'];
							$ok_add['job_process_id'] = $job_process_id;
							$ok_add['job_item_id'] = $job_item_id;
							$ok_add['item_id'] = $_POST['item_id'];
							$ok_add['dep_qty_entry_type'] = '1';
							$ok_add['dep_qty_type'] = '2';
							$ok_add['department_id'] = $multi_data['ok_department_id'];
							$ok_add['dep_qty'] = $multi_data['job_item_ok_qty'];
							$this->Master_Model->save_data('admi_dep_qty', $ok_add);
						}

						// Add Reject Qty..
						if ($multi_data['rejected_department_id'] && $multi_data['job_item_reject_qty']) {
							$reject_add['company_id'] = $admi_user_data['company_id'];
							$reject_add['po_item_id'] = $multi_data['po_item_id'];
							$reject_add['job_process_id'] = $job_process_id;
							$reject_add['job_item_id'] = $job_item_id;
							$reject_add['item_id'] = $_POST['item_id'];
							$reject_add['dep_qty_entry_type'] = '1';
							$reject_add['dep_qty_type'] = '4';
							$reject_add['department_id'] = $multi_data['rejected_department_id'];
							$reject_add['dep_qty'] = $multi_data['job_item_reject_qty'];
							$this->Master_Model->save_data('admi_dep_qty', $reject_add);
						}

						// Add Rework Qty..
						if ($multi_data['rework_department_id'] && $multi_data['job_item_rework_qty']) {
							$rework_add['company_id'] = $admi_user_data['company_id'];
							$rework_add['po_item_id'] = $multi_data['po_item_id'];
							$rework_add['job_process_id'] = $job_process_id;
							$rework_add['job_item_id'] = $job_item_id;
							$rework_add['item_id'] = $_POST['item_id'];
							$rework_add['dep_qty_entry_type'] = '1';
							$rework_add['dep_qty_type'] = '4';
							$rework_add['department_id'] = $multi_data['rework_department_id'];
							$rework_add['dep_qty'] = $multi_data['job_item_rework_qty'];
							$this->Master_Model->save_data('admi_dep_qty', $rework_add);
						}

						// Used Qty..
						$used_add['company_id'] = $admi_user_data['company_id'];
						$used_add['po_item_id'] = $multi_data['po_item_id'];
						$used_add['job_process_id'] = $job_process_id;
						$used_add['job_item_id'] = $job_item_id;
						$used_add['item_id'] = $_POST['item_id'];
						$used_add['dep_qty_entry_type'] = '2';
						$used_add['dep_qty_type'] = '0';
						$used_add['department_id'] = $multi_data['department_id'];
						$used_add['dep_qty'] = $multi_data['job_item_ok_qty'] + $multi_data['job_item_reject_qty'] + $multi_data['job_item_rework_qty'];
						$this->Master_Model->save_data('admi_dep_qty', $used_add);
					}
				} else {
					$multi_data['job_process_id'] = $job_process_id;
					$multi_data['job_process_date'] = $_POST['job_process_date'];
					$multi_data['party_id'] = $_POST['party_id'];
					$multi_data['item_id'] = $_POST['item_id'];
					$multi_data['company_id'] = $admi_user_data['company_id'];

					$multi_data['job_item_addedby'] = $admi_user_data['user_id'];
					$multi_data['job_item_created_at'] = date('Y-m-d H:i:s');
					$job_item_id = $this->Master_Model->save_data('admi_job_item', $multi_data);

					// Add Main Qty..
					$main_add['job_process_id'] = $job_process_id;
					$main_add['job_item_id'] = $job_item_id;
					$main_add['item_id'] = $_POST['item_id'];
					$main_add['dep_qty_entry_type'] = '1';
					$main_add['dep_qty_type'] = '1';
					$main_add['department_id'] = $multi_data['department_id'];
					$main_add['dep_qty'] = $multi_data['job_item_po_qty'];
					$this->Master_Model->save_data('admi_dep_qty', $main_add);

					// Add OK Qty..
					$ok_add['job_process_id'] = $job_process_id;
					$ok_add['job_item_id'] = $job_item_id;
					$ok_add['item_id'] = $_POST['item_id'];
					$ok_add['dep_qty_entry_type'] = '1';
					$ok_add['dep_qty_type'] = '2';
					$ok_add['department_id'] = $multi_data['ok_department_id'];
					$ok_add['dep_qty'] = $multi_data['job_item_ok_qty'];
					$this->Master_Model->save_data('admi_dep_qty', $ok_add);

					// Add Reject Qty..
					$reject_add['job_process_id'] = $job_process_id;
					$reject_add['job_item_id'] = $job_item_id;
					$reject_add['item_id'] = $_POST['item_id'];
					$reject_add['dep_qty_entry_type'] = '1';
					$reject_add['dep_qty_type'] = '4';
					$reject_add['department_id'] = $multi_data['rejected_department_id'];
					$reject_add['dep_qty'] = $multi_data['job_item_reject_qty'];
					$this->Master_Model->save_data('admi_dep_qty', $reject_add);

					// Add Rework Qty..
					$rework_add['job_process_id'] = $job_process_id;
					$rework_add['job_item_id'] = $job_item_id;
					$rework_add['item_id'] = $_POST['item_id'];
					$rework_add['dep_qty_entry_type'] = '1';
					$rework_add['dep_qty_type'] = '4';
					$rework_add['department_id'] = $multi_data['rework_department_id'];
					$rework_add['dep_qty'] = $multi_data['job_item_rework_qty'];
					$this->Master_Model->save_data('admi_dep_qty', $rework_add);

					// Used Qty..
					$used_add['job_process_id'] = $job_process_id;
					$used_add['job_item_id'] = $job_item_id;
					$used_add['item_id'] = $_POST['item_id'];
					$used_add['dep_qty_entry_type'] = '2';
					$used_add['dep_qty_type'] = '0';
					$used_add['department_id'] = $multi_data['department_id'];
					$used_add['dep_qty'] = $multi_data['job_item_ok_qty'] + $multi_data['job_item_reject_qty'] + $multi_data['job_item_rework_qty'];
					$this->Master_Model->save_data('admi_dep_qty', $used_add);
				}
			}
			if ($job_process_info['tran_type'] == '1') {
				$this->_set_flashdata_and_redirect('Transaction/job_process', 'Job Process Information Updated Successfully', 'info');
			} else {
				$this->_set_flashdata_and_redirect('Transaction/transaction_entry', 'Job Process Information Updated Successfully', 'info');
			}
		}


		$data['update'] = 'update';
		$data['job_process_info'] = $job_process_info;
		$party_id = $job_process_info['party_id'];


		$data['party_list'] = $this->Master_Model->get_data('admi_party', '*', ['company_id' => $admi_user_data['company_id'], 'party_group_id' => '1'], '`party_name` ASC', 'result');
		$data['grade_list'] = $this->Master_Model->get_data('admi_grade', '*', ['company_id' => $admi_user_data['company_id']], '`grade_name` ASC', 'result');
		$data['item_list'] = $this->Master_Model->get_data('admi_item', '*', ['company_id' => $admi_user_data['company_id'], 'party_id' => $party_id], '`item_id` ASC', 'result');

		$data['remark_list'] = $this->Master_Model->get_data('admi_remark', '*', ['company_id' => $admi_user_data['company_id']], '`remark_name` ASC', 'result');

		$data['job_item_list'] = $this->Master_Model->get_data('admi_job_item', '*', ['company_id' => $admi_user_data['company_id'], 'job_process_id' => $job_process_id], '`job_item_id` ASC', 'result');

		if ($admi_user_data['role_id'] == '1') {
			$data['job_process_list'] = $this->Master_Model->get_data('admi_job_process', '*', ['company_id' => $admi_user_data['company_id']], '`job_process_id` DESC', 'result');
		} else {
			$data['job_process_list'] = $this->Master_Model->get_data('admi_job_process', '*', ['company_id' => $admi_user_data['company_id'], 'job_process_addedby' => $admi_user_data['user_id']], '`job_process_id` DESC', 'result');
		}
		$data['main_menu'] = "Transaction";
		$data['sub_menu'] = "Job Process";
		$data['page'] = 'Edit Job Process';
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		if ($job_process_info['tran_type'] == '1') {

			$this->load->view('Admin/Transaction/job_process', $data);
		} else {
			$this->load->view('Admin/Transaction/transaction_entry', $data);
		}
		$this->load->view('Admin/Include/footer', $data);
	}

	/*********************************** Delete Job Process - job_process4 ********************************/
	public function delete_job_process($job_process_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("job_process4", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$job_process_info = $this->Master_Model->get_data('admi_job_process', '*', ['job_process_id' => $job_process_id], '`job_process_id` DESC', 'row_array');



		$is_delete = $this->Master_Model->delete_info('job_process_id', $job_process_id, 'admi_job_process');



		if ($is_delete['code'] == '1451') {
			if ($job_process_info['tran_type'] == '1') {

				$this->_set_flashdata_and_redirect('Transaction/job_process', 'Can not delete, Job Process information is used', 'error');
			} else {
				$this->_set_flashdata_and_redirect('Transaction/transaction_entry', 'Can not delete, Job Process information is used', 'error');
			}
		} else {
			// Delete child rows...
			$this->Master_Model->delete_info('job_process_id', $job_process_id, 'admi_job_item');
			$this->Master_Model->delete_info('job_process_id', $job_process_id, 'admi_dep_qty');
			if ($job_process_info['tran_type'] == '1') {
				$this->_set_flashdata_and_redirect('Transaction/job_process', 'Job Process Information Deleted Successfully', 'error');
			} else {
				$this->_set_flashdata_and_redirect('Transaction/transaction_entry', 'Job Process Information Deleted Successfully', 'error');
			}
		}
	}




	/***************************************************************************************************************/
	/**************************************************************************************************/
	/********************************************** Dispatch Entry ********************************************/
	/**************************************************************************************************/

	/*********************************** Add Dispatch Entry - dispatch1 ********************************/
	public function dispatch()
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("dispatch1", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$this->form_validation->set_rules('party_id', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {

			$save_data = $_POST;
			unset($save_data['input']);
			$save_data['company_id'] = $admi_user_data['company_id'];
			$save_data['dispatch_addedby'] = $admi_user_data['user_id'];
			$save_data['dispatch_created_at'] = date('Y-m-d H:i:s');

			$dispatch_id = $this->Master_Model->save_data('admi_dispatch', $save_data);
			
			if ($dispatch_id) {
				foreach ($_POST['input'] as $multi_data) {
					$multi_data['dispatch_id'] = $dispatch_id;
					$multi_data['dispatch_date'] = $_POST['dispatch_date'];
					$multi_data['party_id'] = $_POST['party_id'];
					$multi_data['item_id'] = $_POST['item_id'];
					$multi_data['purchase_order_id'] = $_POST['purchase_order_id'];
					$multi_data['company_id'] = $admi_user_data['company_id'];
					$multi_data['dispatch_item_addedby'] = $admi_user_data['user_id'];
					$multi_data['dispatch_item_created_at'] = date('Y-m-d H:i:s');
					$this->db->insert('admi_dispatch_item', $multi_data);
				}

				$this->_set_flashdata_and_redirect('Transaction/dispatch', 'Dispatch Entry Saved Successfully', 'success');
			} else {
				$this->_set_flashdata_and_redirect('Transaction/dispatch', 'Dispatch Entry Not Saved', 'error');
			}
		}
		$data['party_list'] = $this->Master_Model->get_data('admi_party', '*', ['company_id' => $admi_user_data['company_id'], 'party_group_id' => '1'], '`party_name` ASC', 'result');
		$data['remark_list'] = $this->Master_Model->get_data('admi_remark', '*', ['company_id' => $admi_user_data['company_id']], '`remark_name` ASC', 'result');

		$data['dispatch_list'] = $this->Master_Model->get_data('admi_dispatch', '*', ['company_id' => $admi_user_data['company_id']], '`dispatch_id` DESC', 'result');
		$data['main_menu'] = "Transaction";
		$data['sub_menu'] = "Dispatch Entry";
		$data['page'] = 'Dispatch Entry';
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Transaction/dispatch', $data);
		$this->load->view('Admin/Include/footer', $data);
	}


	/*********************************** Edit/Update Dispatch Entry - dispatch3 ********************************/
	public function edit_dispatch($dispatch_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("dispatch3", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$dispatch_info = $this->Master_Model->get_data('admi_dispatch', '*', ['company_id' => $admi_user_data['company_id'], 'dispatch_id' => $dispatch_id], '`dispatch_id` DESC', 'row_array');
		if (!$dispatch_info) {
			$this->_set_flashdata_and_redirect('Transaction/dispatch', 'Invalid Dispatch Entry', 'error');
		}


		$this->form_validation->set_rules('party_id', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			$update_data = $_POST;
			unset($update_data['input']);
			// $update_data['dispatch_status'] = $dispatch_status;
			$update_data['dispatch_updatedby'] = $admi_user_data['user_id'];
			$update_data['dispatch_updated_at'] = date('Y-m-d H:i:s');
			$this->Master_Model->update_info('dispatch_id', $dispatch_id, 'admi_dispatch', $update_data);

			foreach ($_POST['input'] as $multi_data) {
				if (isset($multi_data['dispatch_item_id'])) {
					$dispatch_item_id = $multi_data['dispatch_item_id'];
					if (!isset($multi_data['dispatch_item_qty'])) {
						$this->Master_Model->delete_info('dispatch_item_id', $dispatch_item_id, 'admi_dispatch_item');
					} else {
						$multi_data['dispatch_date'] = $_POST['dispatch_date'];
						$multi_data['party_id'] = $_POST['party_id'];
						$multi_data['item_id'] = $_POST['item_id'];
						$multi_data['purchase_order_id'] = $_POST['purchase_order_id'];
						$multi_data['dispatch_item_updatedby'] = $admi_user_data['user_id'];
						$multi_data['dispatch_item_updated_at'] = date('Y-m-d H:i:s');
						$this->Master_Model->update_info('dispatch_item_id', $dispatch_item_id, 'admi_dispatch_item', $multi_data);
					}
				} else {
					$multi_data['dispatch_id'] = $dispatch_id;
					$multi_data['dispatch_date'] = $_POST['dispatch_date'];
					$multi_data['party_id'] = $_POST['party_id'];
					$multi_data['item_id'] = $_POST['item_id'];
					$multi_data['purchase_order_id'] = $_POST['purchase_order_id'];
					$multi_data['company_id'] = $admi_user_data['company_id'];
					$multi_data['dispatch_item_addedby'] = $admi_user_data['user_id'];
					$multi_data['dispatch_item_created_at'] = date('Y-m-d H:i:s');
					$this->db->insert('admi_dispatch_item', $multi_data);
				}
			}

			$this->_set_flashdata_and_redirect('Transaction/dispatch', 'Dispatch Entry Updated Successfully', 'info');
		}


		$data['update'] = 'update';
		$data['dispatch_info'] = $dispatch_info;
		$party_id = $dispatch_info['party_id'];
		$item_id = $dispatch_info['item_id'];

		$data['party_list'] = $this->Master_Model->get_data('admi_party', '*', ['company_id' => $admi_user_data['company_id'], 'party_group_id' => '1'], '`party_name` ASC', 'result');
		$data['item_list'] = $this->Master_Model->get_data('admi_item', '*', ['company_id' => $admi_user_data['company_id'], 'party_id' => $party_id], '`item_id` ASC', 'result');

		$purchase_order_list =  $this->Master_Model->get_data2('admi_po_item', '*', ['item_id' => $item_id, 'party_id' => $party_id], 'purchase_order_id', '`purchase_order_id` ASC', '', 'result');
		foreach ($purchase_order_list as $list) {
			$purchase_order_id = $list->purchase_order_id;
			$purchase_order_data = $this->Master_Model->get_data('admi_purchase_order', 'purchase_order_no,purchase_order_status', ['purchase_order_id' => $purchase_order_id], '`purchase_order_id` ASC', 'row_array');
			$list->purchase_order_no = $purchase_order_data['purchase_order_no'];
			$list->purchase_order_status = $purchase_order_data['purchase_order_status'];
		}
		$data['purchase_order_list'] = $purchase_order_list;
		$data['remark_list'] = $this->Master_Model->get_data('admi_remark', '*', ['company_id' => $admi_user_data['company_id']], '`remark_name` ASC', 'result');

		$data['dispatch_item_list'] = $this->Master_Model->get_data('admi_dispatch_item', '*', ['company_id' => $admi_user_data['company_id'], 'dispatch_id' => $dispatch_id], '`dispatch_item_id` ASC', 'result');
		$data['dispatch_list'] = $this->Master_Model->get_data('admi_dispatch', '*', ['company_id' => $admi_user_data['company_id']], '`dispatch_id` DESC', 'result');
		$data['main_menu'] = "Transaction";
		$data['sub_menu'] = "Dispatch Entry";
		$data['page'] = 'Edit Dispatch Entry';
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Transaction/dispatch', $data);
		$this->load->view('Admin/Include/footer', $data);
	}

	/*********************************** Delete Dispatch Entry - dispatch4 ********************************/
	public function delete_dispatch($dispatch_id)
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("dispatch4", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$is_delete = $this->Master_Model->delete_info('dispatch_id', $dispatch_id, 'admi_dispatch');
		if ($is_delete['code'] == '1451') {
			$this->_set_flashdata_and_redirect('Transaction/dispatch', 'Can not delete, Dispatch Entry information is used', 'error');
		} else {
			// Delete child rows...
			$this->Master_Model->delete_info('dispatch_id', $dispatch_id, 'admi_dispatch_item');
			$this->_set_flashdata_and_redirect('Transaction/dispatch', 'Dispatch Entry Deleted Successfully', 'error');
		}
	}















	/***********************************************************************************************************/



	// get_po_details_by_po_item_id
	public function get_po_details_by_po_item_id()
	{
		$po_item_id = $this->input->post('po_item_id');
		$po_item_info = $this->Master_Model->get_data('admi_po_item', '*', ['po_item_id' => $po_item_id], '`po_item_id` ASC', 'row_array');

		$purchase_order_info = $this->Master_Model->get_data('admi_purchase_order', '*', ['purchase_order_id' => $po_item_info['purchase_order_id']], '`purchase_order_id` ASC', 'row_array');

		$data['po_item_info'] = $po_item_info;
		$data['purchase_order_info'] = $purchase_order_info;

		echo json_encode($data);
	}

	// get_total_bal_by_department
	public function get_total_bal_by_department()
	{
		$department_id = $this->input->post('department_id');
		$item_id = $this->input->post('item_id');
		$job_item_id = $this->input->post('job_item_id');
		$po_item_id = $this->input->post('po_item_id');

		$tot_added_qty = 0;
		$tot_used_qty = 0;

		if ($job_item_id > 0) {
			$tot_added = $this->Master_Model->get_data('admi_dep_qty', 'SUM(dep_qty) as tot_added_qty', ['department_id' => $department_id, 'item_id' => $item_id, 'job_item_id !=' => $job_item_id, 'dep_qty_entry_type' => '1', 'po_item_id' => $po_item_id], '`dep_qty_id` ASC', 'row_array');
			$tot_used = $this->Master_Model->get_data('admi_dep_qty', 'SUM(dep_qty) as tot_used_qty', ['department_id' => $department_id, 'item_id' => $item_id, 'job_item_id !=' => $job_item_id, 'dep_qty_entry_type' => '2', 'po_item_id' => $po_item_id], '`dep_qty_id` ASC', 'row_array');

			$is_exist = $this->Master_Model->get_data('admi_dep_qty', 'dep_qty', ['item_id' => $item_id, 'job_item_id !=' => $job_item_id, 'po_item_id' => $po_item_id], '`dep_qty_id` ASC', 'row_array');
		} else {
			$tot_added = $this->Master_Model->get_data('admi_dep_qty', 'SUM(dep_qty) as tot_added_qty', ['department_id' => $department_id, 'item_id' => $item_id, 'dep_qty_entry_type' => '1', 'po_item_id' => $po_item_id], '`dep_qty_id` ASC', 'row_array');
			$tot_used = $this->Master_Model->get_data('admi_dep_qty', 'SUM(dep_qty) as tot_used_qty', ['department_id' => $department_id, 'item_id' => $item_id, 'dep_qty_entry_type' => '2', 'po_item_id' => $po_item_id], '`dep_qty_id` ASC', 'row_array');

			$is_exist = $this->Master_Model->get_data('admi_dep_qty', 'dep_qty', ['item_id' => $item_id, 'po_item_id' => $po_item_id], '`dep_qty_id` ASC', 'row_array');
		}
		if ($tot_added && $tot_added['tot_added_qty'] > 0) {
			$tot_added_qty = $tot_added['tot_added_qty'];
		}
		if ($tot_used && $tot_used['tot_used_qty'] > 0) {
			$tot_used_qty = $tot_used['tot_used_qty'];
		}


		if ($is_exist) {
			$exist = '1';
		} else {
			$exist = '0';
		}

		$tot_balance_qty = $tot_added_qty - $tot_used_qty;

		$data['exist'] = $exist;
		$data['tot_balance_qty'] = $tot_balance_qty;
		echo json_encode($data);
		// print_r($tot_added);
		// echo $tot_balance_qty;
	}
	public function transaction_entry()
	{
		$admi_user_data = $this->session->userdata('admi_user_data');
		$admi_role_access = $this->session->userdata('admi_role_access');
		if (empty($admi_user_data) || ($admi_user_data['role_id'] != 1 && !in_array("job_process1", $admi_role_access))) {
			header('location:' . base_url() . 'User');
		}
		$data['role_access'] = $admi_role_access;
		$data['sess_user_data'] = $admi_user_data;
		$data['role_id'] = $admi_user_data['role_id'];

		$this->form_validation->set_rules('party_id', 'First Name', 'trim|required');
		if ($this->form_validation->run() != FALSE) {

			$save_data = $_POST;


			unset($save_data['input']);
			$remark_id = implode(", ", $_POST['remark_id']);
			$save_data['remark_id'] = $remark_id;
			$save_data['company_id'] = $admi_user_data['company_id'];
			$save_data['job_process_addedby'] = $admi_user_data['user_id'];
			$save_data['job_process_created_at'] = date('Y-m-d H:i:s');

			$job_process_id = $this->Master_Model->save_data('admi_job_process', $save_data);

			// echo $job_process_id;

			if ($job_process_id) {
				foreach ($_POST['input'] as $multi_data) {
					$multi_data['job_process_id'] = $job_process_id;
					$multi_data['job_process_date'] = $_POST['job_process_date'];
					$multi_data['party_id'] = $_POST['party_id'];
					$multi_data['item_id'] = $_POST['item_id'];
					$multi_data['company_id'] = $admi_user_data['company_id'];
					$multi_data['job_item_addedby'] = $admi_user_data['user_id'];
					$multi_data['job_item_created_at'] = date('Y-m-d H:i:s');
					// $this->db->insert('admi_job_item', $multi_data);
					$job_item_id = $this->Master_Model->save_data('admi_job_item', $multi_data);

					$dep_qty_info = $this->Master_Model->get_data('admi_dep_qty', '*', ['department_id' => $multi_data['department_id'], 'po_item_id' => $multi_data['po_item_id'], 'dep_qty_entry_type' => '1'], '`dep_qty_id` DESC', 'result');

					if (empty($dep_qty_info)) {
						// Add Main Qty..
						$main_add['company_id'] = $admi_user_data['company_id'];
						$main_add['po_item_id'] = $multi_data['po_item_id'];
						$main_add['job_process_id'] = $job_process_id;
						$main_add['job_item_id'] = $job_item_id;
						$main_add['item_id'] = $_POST['item_id'];
						$main_add['dep_qty_entry_type'] = '1';
						$main_add['dep_qty_type'] = '1';
						$main_add['department_id'] = $multi_data['department_id'];
						$main_add['dep_qty'] = $multi_data['job_item_total_qty'];
						$this->Master_Model->save_data('admi_dep_qty', $main_add);
					}

					// Add OK Qty..
					if ($multi_data['ok_department_id'] && $multi_data['job_item_ok_qty']) {
						$ok_add['company_id'] = $admi_user_data['company_id'];
						$ok_add['po_item_id'] = $multi_data['po_item_id'];
						$ok_add['job_process_id'] = $job_process_id;
						$ok_add['job_item_id'] = $job_item_id;
						$ok_add['item_id'] = $_POST['item_id'];
						$ok_add['dep_qty_entry_type'] = '1';
						$ok_add['dep_qty_type'] = '2';
						$ok_add['department_id'] = $multi_data['ok_department_id'];
						$ok_add['dep_qty'] = $multi_data['job_item_ok_qty'];
						$this->Master_Model->save_data('admi_dep_qty', $ok_add);
					}

					// Add Reject Qty..
					if ($multi_data['rejected_department_id'] && $multi_data['job_item_reject_qty']) {
						$reject_add['company_id'] = $admi_user_data['company_id'];
						$reject_add['po_item_id'] = $multi_data['po_item_id'];
						$reject_add['job_process_id'] = $job_process_id;
						$reject_add['job_item_id'] = $job_item_id;
						$reject_add['item_id'] = $_POST['item_id'];
						$reject_add['dep_qty_entry_type'] = '1';
						$reject_add['dep_qty_type'] = '4';
						$reject_add['department_id'] = $multi_data['rejected_department_id'];
						$reject_add['dep_qty'] = $multi_data['job_item_reject_qty'];
						$this->Master_Model->save_data('admi_dep_qty', $reject_add);
					}

					// Add Rework Qty..
					if ($multi_data['rework_department_id'] && $multi_data['job_item_rework_qty']) {
						$rework_add['company_id'] = $admi_user_data['company_id'];
						$rework_add['po_item_id'] = $multi_data['po_item_id'];
						$rework_add['job_process_id'] = $job_process_id;
						$rework_add['job_item_id'] = $job_item_id;
						$rework_add['item_id'] = $_POST['item_id'];
						$rework_add['dep_qty_entry_type'] = '1';
						$rework_add['dep_qty_type'] = '4';
						$rework_add['department_id'] = $multi_data['rework_department_id'];
						$rework_add['dep_qty'] = $multi_data['job_item_rework_qty'];
						$this->Master_Model->save_data('admi_dep_qty', $rework_add);
					}

					// Used Qty..
					$used_add['company_id'] = $admi_user_data['company_id'];
					$used_add['po_item_id'] = $multi_data['po_item_id'];
					$used_add['job_process_id'] = $job_process_id;
					$used_add['job_item_id'] = $job_item_id;
					$used_add['item_id'] = $_POST['item_id'];
					$used_add['dep_qty_entry_type'] = '2';
					$used_add['dep_qty_type'] = '0';
					$used_add['department_id'] = $multi_data['department_id'];
					$used_add['dep_qty'] = $multi_data['job_item_ok_qty'] + $multi_data['job_item_reject_qty'] + $multi_data['job_item_rework_qty'];
					$this->Master_Model->save_data('admi_dep_qty', $used_add);
				}

				$this->_set_flashdata_and_redirect('Transaction/transaction_entry', 'Job Process Saved Successfully', 'success');
			} else {
				$this->_set_flashdata_and_redirect('Transaction/transaction_entry', 'Job Process Not Saved', 'error');
			}
		}
		$data['job_process_no'] = $this->Master_Model->get_count_no('job_process_no', ['company_id' => $admi_user_data['company_id']], 'admi_job_process');

		$data['party_list'] = $this->Master_Model->get_data('admi_party', '*', ['company_id' => $admi_user_data['company_id'], 'party_group_id' => '1'], '`party_name` ASC', 'result');
		$data['item_group_list'] = $this->Master_Model->get_data('admi_item_group', '*', ['company_id' => $admi_user_data['company_id']], '`item_group_name` ASC', 'result');
		// $data['process_type_list'] = $this->Master_Model->get_data('admi_process_type','*',['company_id'=>$admi_user_data['company_id']],'`process_type_name` ASC','result');
		$data['grade_list'] = $this->Master_Model->get_data('admi_grade', '*', ['company_id' => $admi_user_data['company_id']], '`grade_name` ASC', 'result');
		$data['remark_list'] = $this->Master_Model->get_data('admi_remark', '*', ['company_id' => $admi_user_data['company_id']], '`remark_name` ASC', 'result');
		if ($admi_user_data['role_id'] == '1') {
			$data['job_process_list'] = $this->Master_Model->get_data('admi_job_process', '*', ['company_id' => $admi_user_data['company_id'], 'tran_type' => '2'], '`job_process_id` DESC', 'result');
		} else {
			$data['job_process_list'] = $this->Master_Model->get_data('admi_job_process', '*', ['company_id' => $admi_user_data['company_id'], 'job_process_addedby' => $admi_user_data['user_id'], 'tran_type' => '2'], '`job_process_id` DESC', 'result');
		}
		$data['main_menu'] = "Transaction";
		$data['sub_menu'] = "Transaction Entry";
		$data['page'] = 'Transaction Entry';
		$this->load->view('Admin/Include/head', $data);
		$this->load->view('Admin/Include/navbar', $data);
		$this->load->view('Admin/Transaction/transaction_entry', $data);
		$this->load->view('Admin/Include/footer', $data);
	}
}
