<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class API_Model extends CI_Model{


/****************************** Cart List *************************************/	
	public function cart_list($customer_id){
		$this->db->select('cera_cart.cart_id,cera_cart.cart_date,cera_cart.product_id,cera_cart.product_attr_id,cera_cart.cart_quantity,cera_cart.cart_quantity,
		cera_product.product_name, cera_product.tax_rate_id, cera_product.product_image, 
		cera_product_attr.product_attr_value, cera_product_attr.unit_id,cera_product_attr.product_attr_mrp,cera_product_attr.product_attr_price,
		cera_tax_rate.tax_rate_per,
		cera_unit.unit_short_name,');
		$this->db->from('cera_cart');

		$this->db->join('cera_product', 'cera_product.product_id = cera_cart.product_id', 'left');
		$this->db->join('cera_product_attr', 'cera_product_attr.product_attr_id = cera_cart.product_attr_id', 'left');		
		$this->db->join('cera_tax_rate', 'cera_tax_rate.tax_rate_id = cera_product.tax_rate_id', 'left');	
		$this->db->join('cera_unit', 'cera_unit.unit_id = cera_product_attr.unit_id', 'left');
		$this->db->where("cera_cart.customer_id", $customer_id);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
		// return $this->db->last_query();
	}




}
?>
