<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction_Model extends CI_Model{

    
/**************************************************************************************************************/
/************************************************** Report ****************************************************/
/**************************************************************************************************************/


	public function get_po_report($from_date,$to_date,$party_id,$item_id,$process_type_id){

		$this->db->select('admi_po_item.*,admi_party.party_name,admi_item.item_casting_drw_no,admi_item.item_finished_drw_no,
		admi_grade.grade_name,admi_process_type.process_type_name,admi_purchase_order.purchase_order_no');
		$this->db->from('admi_po_item');

		if($party_id){
			$this->db->where('admi_po_item.party_id', $party_id);
		}
		if($item_id){
			$this->db->where('admi_po_item.item_id', $item_id);
		}
		// if($grade_id){
		// 	$this->db->where('admi_po_item.grade_id', $grade_id);
		// }
		if($process_type_id){
			$this->db->where('admi_po_item.process_type_id', $process_type_id);
		}

		$this->db->where("str_to_date(admi_po_item.purchase_order_date,'%d-%m-%Y') BETWEEN str_to_date('$from_date','%d-%m-%Y') AND str_to_date('$to_date','%d-%m-%Y')");
		$this->db->join('admi_party','admi_po_item.party_id = admi_party.party_id', 'LEFT');
		$this->db->join('admi_item','admi_po_item.item_id = admi_item.item_id', 'LEFT');
		$this->db->join('admi_grade','admi_po_item.grade_id = admi_grade.grade_id', 'LEFT');
		$this->db->join('admi_process_type','admi_po_item.process_type_id = admi_process_type.process_type_id', 'LEFT');
		
		$this->db->join('admi_purchase_order','admi_po_item.purchase_order_id = admi_purchase_order.purchase_order_id', 'LEFT');
	
		$this->db->order_by('admi_po_item.po_item_id', 'ASC');
		$query = $this->db->get();
		$result = $query->result();
		return $result;
		// return $this->db->last_query();
	}













// /******************************************** Order Report **************************************/
// 	public function get_order_report($from_date, $to_date, $customer_id, $order_status){
// 		$this->db->select('cera_order.*');
// 		$this->db->from('cera_order');
// 		if($customer_id){
// 				$this->db->where('customer_id', $customer_id);
// 		}
// 		if($order_status){
// 			$this->db->where('order_status', $order_status);
// 		}
// 		$this->db->where("str_to_date(order_date,'%d-%m-%Y') BETWEEN str_to_date('$from_date','%d-%m-%Y') AND str_to_date('$to_date','%d-%m-%Y')");
// 		$this->db->order_by('order_id', 'ASC');
// 		$query = $this->db->get();
// 		$result = $query->result();
// 		return $result;
// 		// return $this->db->last_query();
// 	}

/******************************************** Order Report **************************************/
	public function get_enquiry_report($from_date, $to_date){
		$this->db->select('*');
		$this->db->from('satg_enquiry');
		$this->db->where("str_to_date(enquiry_date,'%d-%m-%Y') BETWEEN str_to_date('$from_date','%d-%m-%Y') AND str_to_date('$to_date','%d-%m-%Y')");
		$this->db->order_by('enquiry_id', 'ASC');
		$query = $this->db->get();
		$result = $query->result();
		return $result;
		// return $this->db->last_query();
	}


//     /******************************************** Trade Report **************************************/

//     public function get_trade_report($from_date, $to_date, $client_code){
//         $this->db->select('*');
//         $this->db->from('sgbr_trade');
//         if($client_code){
//             $this->db->where('trade_client_code', $client_code);
//         }
//         $this->db->where("str_to_date(trade_date,'%d-%m-%Y') BETWEEN str_to_date('$from_date','%d-%m-%Y') AND str_to_date('$to_date','%d-%m-%Y')");
//         $query = $this->db->get();
//         $result = $query->result();
//         return $result;
//         // return $this->db->last_query();
//     }


// /******************************************** Profit/Loss Report **************************************/
//     public function get_profit_loss_report($from_date, $to_date, $client_code){
//         $this->db->select('trade_exchange,trade_scrip_code,trade_client_code,trade_client_name,trade_instrument_type,trade_symbol,
//         trade_ser_exp, SUM(trade_buy_qty) as tot_trade_buy_qty, SUM(trade_buy_val) as tot_trade_buy_val, SUM(trade_buy_avg) as tot_trade_buy_avg, 
//         SUM(trade_sell_qty) as tot_trade_sell_qty, SUM(trade_sell_val) as tot_trade_sell_val, SUM(trade_sell_avg) as tot_trade_sell_avg');
//         $this->db->from('sgbr_trade');
//         if($client_code){
//             $this->db->where('trade_client_code', $client_code);
//         }
//         $this->db->where("str_to_date(trade_date,'%d-%m-%Y') BETWEEN str_to_date('$from_date','%d-%m-%Y') AND str_to_date('$to_date','%d-%m-%Y')");
//         $this->db->group_by('trade_scrip_code');
//         $this->db->group_by('trade_client_code');
//         $this->db->order_by('trade_client_code', 'ASC');
//         $query = $this->db->get();
//         $result = $query->result();
//         return $result;
//         // return $this->db->last_query();
//     }


// /******************************************** Ledger Report Report **************************************/
//     public function get_ledger_report($from_date, $to_date, $client_code){
//         $this->db->select('trade_exchange,trade_date, trade_client_code,trade_client_name, trade_instrument_type,trade_symbol,
//         SUM(trade_buy_val) as tot_trade_buy_val, SUM(trade_sell_val) as tot_trade_sell_val');
//         $this->db->from('sgbr_trade');
//         if($client_code){
//             $this->db->where('trade_client_code', $client_code);
//         }
//         $this->db->where("str_to_date(trade_date,'%d-%m-%Y') BETWEEN str_to_date('$from_date','%d-%m-%Y') AND str_to_date('$to_date','%d-%m-%Y')");
//         $this->db->group_by('trade_date');
//         $this->db->group_by('trade_client_code');
//         // $this->db->order_by("str_to_date(trade_date,'%d-%m-%Y')", 'ASC');
//         $query = $this->db->get();
//         $result = $query->result();
//         return $result;
//         // return $this->db->last_query();
//     }









}

?>