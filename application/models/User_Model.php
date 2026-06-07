<?php
class User_Model extends CI_Model{

  function check_login($mobile, $password){
    $this->db->select('*');
    $this->db->where('user_mobile', $mobile);
    $this->db->where('user_password', $password);
    $this->db->where('user_status', '1');
    $this->db->from('akc_user');
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
  }

}
?>
