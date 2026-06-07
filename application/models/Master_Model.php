<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master_Model extends CI_Model{

  // Send SMS....  
  public function send_sms($mobile_no, $msg, $template_id){

    $username="Anujk650";
    $password="@Abcd1234";
    $message = $msg;
    $sender="NEEDSO"; //ex:INVITE
    $mobile_number=$mobile_no;
    $template_id=$template_id;

    $url="http://api.bulksmsgateway.in/sendmessage.php?user=".urlencode($username)."&password=".urlencode($password)."&mobile=".urlencode($mobile_number)."&message=".urlencode($message)."&sender=".urlencode($sender)."&type=".urlencode('3')."&template_id=".urlencode($template_id);

    // $url="http://api.bulksmsgateway.in/sendmessage.php?user=".$username."&password=".$password."&mobile=".$mobile_number."&message=".$message."&sender=".$sender."&type=3&template_id=".$template_id;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    $data[0] = $url;
    $data[1] = $result;
    return $data;
    // return $result;    
  }

  /********************************************* New Functions ****************************************/

  // Insert Data...
  public function insert_data($table,$post){
      $this->db->insert($table,$post);
      $insert_id = $this->db->insert_id();
      // return $this->db->last_query();
      return  $insert_id;
  }
  // Update Data...
  public function update_data($table,$post,$where){
    $res = $this->db->update($table,$post,$where);
    return $res;
    // return $this->db->last_query();
  }

  // Delete Data...
  public function delete_data($table,$where){
    return $this->db->delete($table,$where);
  }

  // Get Data All...
  public function get_data($tbl_name,$fields,$where,$order,$result_type){
    $this->db->select($fields);
    if($where != ''){
      $this->db->where($where);
    }
    if($order){
      $this->db->order_by($order);
    }
    $this->db->from($tbl_name);
    $query = $this->db->get();
    if($result_type == 'result'){
      $result = $query->result();
    }
    if($result_type == 'result_array'){
      $result = $query->result_array();
    }
  
    if($result_type == 'row_array'){
      $result = $query->row_array();
    }
    if($result_type == 'last_query'){
      $result = $this->db->last_query();
    }
    if($result_type == 'num_rows'){
      $result = $query->num_rows();
    }
    return $result;
  }

  // Get Data 2 All...
  public function get_data2($tbl_name,$fields,$where,$group_by,$order,$limit,$result_type){
    $this->db->select($fields);
    if($where != ''){
      $this->db->where($where);
    }
    if($group_by != ''){
      $this->db->group_by($group_by);
    }
    if($limit != ''){
      $this->db->limit($limit);
    }
    if($order){
      $this->db->order_by($order);
    }
    $this->db->from($tbl_name);
    $query = $this->db->get();
    if($result_type == 'result'){
      $result = $query->result();
    }
    if($result_type == 'result_array'){
      $result = $query->result_array();
    }
    if($result_type == 'row_array'){
      $result = $query->row_array();
    }
    if($result_type == 'last_query'){
      $result = $this->db->last_query();
    }
    if($result_type == 'num_rows'){
      $result = $query->num_rows();
    }
    return $result;
  }

/*******************************************************************************************/

  // Save Data...
  public function save_data($tbl_name, $data){
    $this->db->insert($tbl_name, $data);
    $insert_id = $this->db->insert_id();
    return  $insert_id;
    // return $this->db->last_query();
  }
  // Update Data...
  public function update_info($id_type, $id, $tbl_name, $data){
    $this->db->where($id_type, $id)
    ->update($tbl_name, $data);
    // return $this->db->last_query();
  }
  // Delete Data...
  public function delete_info($id_type, $id, $tbl_name){
    $this->db->where($id_type, $id)
    ->delete($tbl_name);
    return $this->db->error();
    // if ($this->db->error()){
    //   return false;
    // } else{
    //   return true;
    // }
  }

  /************************* Get List ***************************/

  // Get List.. Company Id... Order...
  public function get_list($company_id,$id,$order,$tbl_name){
    $this->db->select('*');
    if($company_id != ''){
      $this->db->where('company_id', $company_id);
    }
    $this->db->order_by($id, $order);
    $this->db->from($tbl_name);
    $query = $this->db->get();
    $result = $query->result();
    return $result;
  }

  // Get List.. Company Id... 2 check fields... Order...
  public function get_list_by_id2($company_id,$col_name1,$col_val1,$col_name2,$col_val2,$order_col,$order,$tbl_name){
    $this->db->select('*');
    if($company_id != ''){
      $this->db->where('company_id', $company_id);
    }
    if($col_name1 != ''){
      $this->db->where($col_name1,$col_val1);
    }
    if($col_name2 != ''){
      $this->db->where($col_name2,$col_val2);
    }
    if($order_col != ''){
      $this->db->order_by($order_col, $order);
    }
    $this->db->from($tbl_name);
    $query = $this->db->get();
    $result = $query->result();
    return $result;
  }

  // Get List.. Company Id... 3 check fields... Order...
  public function get_list_by_id3($company_id,$col_name1,$col_val1,$col_name2,$col_val2,$col_name3,$col_val3,$order_col,$order,$tbl_name){
    $this->db->select('*');
    if($company_id != ''){
      $this->db->where('company_id', $company_id);
    }
    if($col_name1 != ''){
      $this->db->where($col_name1,$col_val1);
    }
    if($col_name2 != ''){
      $this->db->where($col_name2,$col_val2);
    }
    if($col_name3 != ''){
      $this->db->where($col_name3,$col_val3);
    }
    if($order_col != ''){
      $this->db->order_by($order_col, $order);
    }
    $this->db->from($tbl_name);
    $query = $this->db->get();
    $result = $query->result();
    return $result;
    // $q = $this->db->last_query();
    // return $q;
  }

/****************************************** Get Information ***************************/

  // get Info List...
  public function get_info($id_type, $id, $tbl_name){
    $this->db->select('*');
    $this->db->where($id_type, $id);
    $this->db->from($tbl_name);
    $query = $this->db->get();
    $result = $query->result();
    return $result;
  }

  public function get_info_fields3($fields, $company_id, $col_name1, $val1, $col_name2, $val2, $col_name3, $val3, $tbl_name){
    $this->db->select($fields);
    if($company_id != ''){
      $this->db->where('company_id', $company_id);
    }
    if($col_name1 != ''){
      $this->db->where($col_name1, $val1);
    }
    if($col_name2 != ''){
      $this->db->where($col_name2, $val2);
    }
    if($col_name3 != ''){
      $this->db->where($col_name3, $val3);
    }
    $this->db->from($tbl_name);
    $query = $this->db->get();
    $result = $query->result();
    return $result;
    // $q = $this->db->last_query();
    // return $q;
  }

  public function get_info_fields4($fields, $company_id, $col_name1, $val1, $col_name2, $val2, $col_name3, $val3, $col_name4, $val4, $order_col, $order, $tbl_name){
    $this->db->select($fields);
    if($company_id != ''){
      $this->db->where('company_id', $company_id);
    }
    if($col_name1 != ''){
      $this->db->where($col_name1, $val1);
    }
    if($col_name2 != ''){
      $this->db->where($col_name2, $val2);
    }
    if($col_name3 != ''){
      $this->db->where($col_name3, $val3);
    }
    if($col_name4 != ''){
      $this->db->where($col_name4,$col_val4);
    }
    if($order_col != ''){
      $this->db->order_by($order_col, $order);
    }
    $this->db->from($tbl_name);
    $query = $this->db->get();
    $result = $query->result();
    return $result;
    // $q = $this->db->last_query();
    // return $q;
  }
  /**************************** Get Array Info ***********************************/
  public function get_info_arr($id_type, $id, $tbl_name){
    $this->db->select('*');
    $this->db->where($id_type, $id);
    $this->db->from($tbl_name);
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
  }

  public function get_info_arr_fields($fields,$id_type, $id, $tbl_name){
    $this->db->select($fields);
    $this->db->where($id_type, $id);
    $this->db->from($tbl_name);
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
  }

  public function get_info_arr_fields3($fields, $company_id, $col_name1, $val1, $col_name2, $val2, $col_name3, $val3, $tbl_name){
    $this->db->select($fields);
    if($company_id != ''){
      $this->db->where('company_id', $company_id);
    }
    if($col_name1 != ''){
      $this->db->where($col_name1, $val1);
    }
    if($col_name2 != ''){
      $this->db->where($col_name2, $val2);
    }
    if($col_name3 != ''){
      $this->db->where($col_name3, $val3);
    }
    $this->db->from($tbl_name);
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
    // $q = $this->db->last_query();
    // return $q;
  }

/******************************* Check Duplicate *****************************/
  public function check_duplication($company_id,$value,$field_name,$table_name){
    $this->db->select($field_name);
    if($company_id != ''){
      $this->db->where('company_id', $company_id);
    }
    $this->db->where($field_name,$value);
    $this->db->from($table_name);
    $query = $this->db->get();
    $result = $query->num_rows();
    return $result;
  }

/****************************** Get Count ******************************/
  // Get Count...
  public function get_count($id_type,$company_id,$col1,$val1,$col2,$val2,$col3,$val3,$tbl_name){
    $this->db->select($id_type);
    if($company_id != ''){
      $this->db->where('company_id', $company_id);
    }
    if($col1 != ''){
      $this->db->where($col1, $val1);
    }
    if($col2 != ''){
      $this->db->where($col2, $val2);
    }
    if($col3 != ''){
      $this->db->where($col3, $val3);
    }

    $this->db->from($tbl_name);
    $query =  $this->db->get();
    $result = $query->num_rows();
    return $result;
  }

/****************************** Get Sum ******************************/
  public function get_sum($company_id,$tot_field_name,$col1,$val1,$col2,$val2,$col3,$val3,$tbl_name){
    $this->db->select('SUM('.$tot_field_name.') as total');
    if($company_id != ''){
      $this->db->where('company_id', $company_id);
    }
    if($col1 != ''){
      $this->db->where($col1, $val1);
    }
    if($col2 != ''){
      $this->db->where($col2, $val2);
    }
    if($col3 != ''){
      $this->db->where($col3, $val3);
    }
    $this->db->from($tbl_name);
    $query =  $this->db->get();
    $result = $query->result_array();
    if($result){ $total = $result[0]['total']; }
    else{ $total = 0;  }
    return $total;
  }



/********************************************************/
  public function get_count_no($field_name, $where, $tbl_name){
    $this->db->select('MAX('.$field_name.') as num');
    if($where != ''){
      $this->db->where($where);
    }
    $this->db->from($tbl_name);
    $query = $this->db->get();
    $result =  $query->result_array();
    if($result){
      $old_num = $result[0]['num'];
    } else{
      $old_num = 0;
    }
    $value = $old_num + 1;
    return $value;
  }

/****************************************** Transaction ********************************/
  public function product_list(){
    $this->db->select('nirali_product.*, nirali_unit.unit_short_name, nirali_tax_rate.tax_rate_per');
    $this->db->join('nirali_unit', 'nirali_product.unit_id = nirali_unit.unit_id', 'left');
    $this->db->join('nirali_tax_rate', 'nirali_product.tax_rate_id = nirali_tax_rate.tax_rate_id', 'left');
    $this->db->from('nirali_product');
    $query =  $this->db->get();
    $result = $query->result();
    return $result;
  }


/**************************************** Report ***********************************/

  public function product_purchase($product_id, $stock_date){
    $this->db->select('SUM(purchase_item_qty) as total_purchase_item');
    $this->db->from('nirali_purchase_item');
    $this->db->where("str_to_date(purchase_date,'%d-%m-%Y') <= str_to_date('$stock_date','%d-%m-%Y')");
    $query =  $this->db->get();
    $result = $query->result_array();
    if($result){ $total = $result[0]['total_purchase_item']; }
    else{ $total = 0;  }
    return $total;
  }

  public function product_sale($product_id, $stock_date){
    $this->db->select('SUM(sale_item_qty) as total_sale_item');
    $this->db->from('nirali_sale_item');
    $this->db->where("str_to_date(sale_date,'%d-%m-%Y') <= str_to_date('$stock_date','%d-%m-%Y')");
    $query =  $this->db->get();
    $result = $query->result_array();
    if($result){ $total = $result[0]['total_sale_item']; }
    else{ $total = 0;  }
    return $total;
  }


  public function get_sale_report_list($from_date, $to_date){
    $this->db->select('*');
    $this->db->from('nirali_sale');
    $this->db->where("str_to_date(sale_invoice_date,'%d-%m-%Y') BETWEEN str_to_date('$from_date','%d-%m-%Y') AND str_to_date('$to_date','%d-%m-%Y')");
    $query =  $this->db->get();
    $result = $query->result();
    // if($result){ $total = $result[0]['total_sale_item']; }
    // else{ $total = 0;  }
    return $result;
  }

}
?>
