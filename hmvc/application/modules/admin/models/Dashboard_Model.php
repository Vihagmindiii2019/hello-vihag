<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_Model extends CI_Model {
    
    public function __construct(){
    	parent::__construct();	
    }

        
    public function updateProfile($profileData){
    	$this->db->where('email',$profileData['email']);
        $this->db->set($profileData);
        $this->db-> update('Admin');
        if ($this->db->affected_rows() > 0) {
        	$this->db->where('email',$profileData['email']);
        	$query=$this->db->get('Admin')->row();
                if($query){
                	return $query;
                }
        }
    }

    public function passwordChange($password){
		$this->db->where('email',$_SESSION['email']);
		$query=$this->db->get('Admin')->row();
		if(password_verify($password['old'], $query->password)){
        	$this->db->where('email',$_SESSION['email']);
	        $this->db->set('password', $password['new']);
	        $this->db-> update('Admin');
	        if ($this->db->affected_rows() > 0) {
	        	return true;
	        }
        } 
        else {
            return false;
        }
    	
    }
}