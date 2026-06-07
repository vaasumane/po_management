<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller{

  public function __construct(){
    parent::__construct();
    date_default_timezone_set('Asia/Kolkata');
  }

	public function index(){
		header('location:'.base_url().'User');
  }

  private function _set_flashdata_and_redirect($url,$msg,$class){
    $this->session->set_flashdata('flash_msg',$msg);
    $this->session->set_flashdata('class',$class);
    return header('location:'.base_url().''.$url);
  }


	
/***********************************************************************************************************/
/****************************************  Report ****************************************/
/***********************************************************************************************************/


  /***********************************  Report - po_report1 ********************************/
		public function po_report(){
			$admi_user_data = $this->session->userdata('admi_user_data');
			$admi_role_access = $this->session->userdata('admi_role_access');
			if(empty($admi_user_data) || ( $admi_user_data['role_id'] != 1 && !in_array("dispatch1", $admi_role_access))){ header('location:'.base_url().'User'); }
			$data['role_access'] = $admi_role_access;
			$data['sess_user_data'] = $admi_user_data;
			$data['role_id'] = $admi_user_data['role_id'];


			$this->form_validation->set_rules('from_date', 'Details', 'trim|required');
			if ($this->form_validation->run() != FALSE) {
				$from_date = $_POST['from_date'];
				$to_date = $_POST['to_date'];
				$party_id = $_POST['party_id'];
				$item_id = $_POST['item_id'];
				// $grade_id = $_POST['grade_id'];
				// $process_type_id = $_POST['process_type_id'];

				$data['report'] = TRUE;

				$process_type_list = $this->Master_Model->get_data('admi_process_type','*',['company_id'=>$admi_user_data['company_id']],'`process_type_id` DESC','result');
				$i = 0;
				foreach($process_type_list as $process_type_list1){
					$process_type_id = $process_type_list1->process_type_id;

					// $data['po_report_list'][$i]


					$data['report_list'][$i]['process_type_id'] = $process_type_id;
					$data['report_list'][$i]['process_type_name'] = $process_type_list1->process_type_name;
					$data['report_list'][$i]['po_report_list'] = $this->Transaction_Model->get_po_report($from_date,$to_date,$party_id,$item_id,$process_type_id);
					$i++;
				}

				// $data['po_report_list'] = $this->Transaction_Model->get_po_report($from_date,$to_date,$party_id,$item_id,$grade_id,$process_type_id);

				// print_r($data['po_report_list']);
			}
			
			$data['party_list'] = $this->Master_Model->get_data('admi_party','*',['company_id'=>$admi_user_data['company_id'],'party_group_id'=>'1'],'`party_name` ASC','result');
			$data['grade_list'] = $this->Master_Model->get_data('admi_grade','*',['company_id'=>$admi_user_data['company_id']],'`grade_name` ASC','result');

			// $data['pickup_req_list'] = $this->Master_Model->get_data('qual_pickup_req','*',['company_id'=>$qual_user_data['company_id']],'`pickup_req_id` DESC','result');
			$data['page'] = ' Report';
			$data['main_menu'] = "Report";
			$data['sub_menu'] = " Report";
			$this->load->view('Admin/Include/head', $data);
			$this->load->view('Admin/Include/navbar', $data);
			$this->load->view('Admin/Report/po_report', $data);
			$this->load->view('Admin/Include/footer', $data);
		}




}

?>
