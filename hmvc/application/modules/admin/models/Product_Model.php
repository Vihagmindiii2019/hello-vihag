<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_Model extends CI_Model {
    
    public function __construct(){
    	parent::__construct();	
    	
    }

    public function checkProductDuplicate($product){
        $this->db->where('product_name',$product);
        $query=$this->db->get('product')->row();
        if($query){
            return true;
        }
        
    }

    public function createProduct($productData){
        $this->db->insert('product',$productData);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
}

    public function selectProduct($limit, $start, $like){
    	if(isset($like)){
    		$this->db->like('product_name',$like, 'after');
    		$this->db->or_like('price',$like, 'after');
    	}
    	$this->db->limit($limit, $start);
    	$query=$this->db->get('product')->result();
    	return $query;

    }
    public function getTotalData($like){
    	if(isset($like)){
    		$this->db->like('product_name',$like, 'after');
    		$this->db->or_like('price',$like, 'after');
    	}
    	$query=$this->db->get('product');
    	return $query->num_rows();

    }

    public function deleteProduct($id){
        $this->db->where('product_id',$id);
        $this->db-> delete('product');
        if ($this->db->affected_rows() > 0) {
                return true;
            }
    }

    public function updateProduct($productData){
        $this->db->where('product_id',$productData['product_id']);
        $this->db->set($productData);
        $this->db-> update('product');
        if ($this->db->affected_rows() > 0) {
                return true;
        }
    }
}