<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_apimodel extends CI_Model {

	function check_product_exist($product_name){
		$exist = $this->Common_model->getsingle('product', array('product_name'=>$product_name));
		if($exist){
			return true; //PAE Product Already exist
		}
	}

	function add_product($productData){

		$id = $this->Common_model->insertData('product',$productData);
		$result = $this->Common_model->getsingle('product', array('product_id'=>$id));
		return array('status'=>'PA','product_data'=>$result);
    }

    public function select_product($start,$limit){
    	$this->db->limit($limit, $start);
    	$query = $this->db->get('product')->result();
    	return $query;
    }

    public function getTotalData(){
    	$query=$this->db->get('product');
    	return $query->num_rows();
    }

    function update_product($productData,$id){

    	$update = $this->Common_model->updateFields('product',$productData,array('product_id'=>$id));
    	if($update==true){
    		return true;
    	}else{
    		return false;
    	}
    }

    function delete_product($id){
    	$result = $this->Common_model->deleteData('product',array('product_id'=>$id));
    	if($result==true){
    		return true;
    	}else{
    		return false;
    	}
    }


}