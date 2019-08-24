<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_model extends CI_Model {


	function user_signup($data){
		$exist = $this->Common_model->getsingle(USER, array('email'=>$data['email']));
		if($exist){
			return array('status'=>'EAE'); //EAE email Already exist
		}

		$data['authToken'] = $this->generate_token();
		$result = $this->Common_model->insertData(USER,$data);
		 
		$user_data  = $this->get_user_by_id($result); //echo 12; pr($user_data);
        return array('status'=>'RS','user_data'=>$user_data);
	}

	function user_login($data){
		  // check email exist or not
        $exist = $this->Common_model->getsingle(USER,array('email'=>$data['email']));

        if(!$exist){
        	return array('status'=>'IE'); //IE invalid email or  not exist
        }

        //password verify
        if(!password_verify($data['password'],$exist->password)){ 
        	return array('status'=>'IP'); //IP invalid passwords not exist
        }

        $update_data['authToken']   = $this->generate_token();
        $update_data['deviceToken'] = $data['deviceToken'];
        $update_data['deviceType']  = $data['deviceType'];
        //update divice token and auth token
        $update = $this->Common_model->updateFields(USER,$update_data,array('userId'=>$exist->userId)); 
        $user_data  = $this->get_user_by_id($exist->userId); //echo 12; pr($user_data);
        return array('status'=>'SL','user_data'=>$user_data);
	}

	function generate_token(){
        $this->load->helper('string');
        $new_token = random_string('alnum', 32);  //Generate random string for user auth token
        return $new_token;
    }

    function get_user_by_id($where){
    	$query=$this->db->select('userId,fullName,email,profileImage,authToken,status')->where('userId',$where)->get(USER);
 		 //lq();
    	if($query->num_rows())
            {
               return $query->row();
            }
    }
    
    function isValidToken($authToken){
    	$this->db->select('*');
		$this->db->where('authToken',$authToken);
		if($sql = $this->db->get('users'))
		{
			if($sql->num_rows() > 0)
			{
				return $sql->row();
			}
		}
		return false;
    }



}
