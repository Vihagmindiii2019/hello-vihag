<?php  
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends Common_Service_Controller{

	function test_get(){
		die('test1234');
	}

	function signup_post(){
		$this->form_validation->set_rules('fullName', 'FullName', 'trim|required|min_length[5]|alpha_numeric_spaces');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|regex_match[/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/]');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|matches[password]');

		// if form validation rule fail set  msg for response
		if($this->form_validation->run()==false){
			$response = array('status'=>FAIL, 'message'=>strip_tags(validation_errors()));
			$this->response($response);
		}

		// Code for Profile image insert
        if(!empty($_FILES['profileImage']['name'])){ 
        	
            $strtotime = strtotime("now");
            $new_name = $strtotime.'_'.$_FILES['profileImage']['name'];
            $config['file_name']     = $new_name;
            $config['upload_path']   = './uploads/userprofile/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']      = 100;
            $config['max_width']     = 2048;
            $config['max_height']    = 2048;
            $this->load->library('upload', $config);

            // if image upload fail set  msg for response
            if(!$this->upload->do_upload('profileImage')){
            	$response = array('status'=>FAIL, 'message'=>strip_tags($this->upload->display_errors()));
				$this->response($response);    
            }
            else{
               $upload_data = $this->upload->data();
               $data['profileImage'] =  $new_name;
            }         
        }//end image insert

        $data['fullName']    = $this->input->post('fullName');
		$data['email']       = $this->input->post('email');
		$data['password']    = $this->hash($this->post('password'));
		$data['deviceToken'] = $this->post('deviceToken');
		$data['deviceType']  = $this->post('deviceType');
		
		//Create new user
		$user_data = $this->service_model->user_signup($data);

		switch ($user_data['status']) {
         	case 'EAE': //email already exist
         		$response=array('status'=>FAIL, 'message'=>get_response_message(110));
         		$this->response($response);
         		break;

         	case 'RS': //registered successfully 
         		$response=array('status'=>SUCCESS, 'message'=>get_response_message(105), 'data'=>$user_data['user_data']);
         		$this->response($response);
         		break;

         	default: //something went wrong
         		$response=array('status'=>FAIL, 'message'=>get_response_message(107));
         		$this->response($response);
         		break;
        }

	}

	function hash($password){
       $hash = password_hash($password,PASSWORD_DEFAULT);
       return $hash;
    }

	function login_post(){
		$this->form_validation->set_rules('email', 'Email Id', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|regex_match[/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/]');

		// if form validation rule fail set  msg for response
		if($this->form_validation->run()=== false){
			$response=array('status'=>FAIL, 'message'=>strip_tags(validation_errors()));
			$this->response($response);
		}
		$data['email']       = $this->post('email');
		$data['password']    = $this->post('password');
		$data['deviceToken'] = $this->post('device_token');
		$data['deviceType']  = $this->post('device_type');
        
		 //check user detail 
        $user_data  = $this->service_model->user_login($data);
        //echo "string"; pr($user_data);
        switch ($user_data['status']) {
         	case 'IE': //invalid email
         		$response=array('status'=>FAIL, 'message'=>get_response_message(153));
         		$this->response($response);
         		break;

         	case 'IP': //invalid password
         		$response=array('status'=>Fail, 'message'=>get_response_message(154));
         		$this->response($response);
         		break;

         	case 'SL': //login success
         		$response=array('status'=>SUCCESS, 'message'=>get_response_message(155), 'data'=>$user_data['user_data']);
         		$this->response($response);
         		break;

         	default: //something went wrong
         		$response=array('status'=>FAIL, 'message'=>get_response_message(107));
         		$this->response($response);
         		break;
        } 
        
	}

}