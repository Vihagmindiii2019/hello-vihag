<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminModel extends CI_Model {
    
    public function __construct(){
    	parent::__construct();	
    	
    }

	public function adminRegister($data){

		$this->db->select('email');
		$this->db->where('email',$data['email']);
		$query=$this->db->get('Admin');
		if($query->num_rows()==1){
			return false;
		}
		else{
			$this->db->insert('Admin',$data);
			return true;
		}
	}
	public function adminLogin($data){

		$this->db->select('*');
		$this->db->where('email',$data['email']);
		$query=$this->db->get('Admin');
		if($query->num_rows()==1){
			$user=$query->row();
			if(password_verify($data['password'], $user->password)){
        	/*if($this->verifyHash($data['password'], $user->password) == TRUE){*/
            	return $user;
	        } 
	        else {
	            return false;
	        }
    	} 
    	else{
        	return false;
    	}	
	}
	/*public function verifyHash($password,$vpassword){

       if(password_verify($password,$vpassword)){
           return TRUE;
        }
       else{
           return FALSE;
        }
    }*/

    
	
}
