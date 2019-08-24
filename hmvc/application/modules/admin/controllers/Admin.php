<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Common_Back_Controller {
    public function __construct(){
    	parent::__construct();    	
    	$this->load->model('AdminModel');
    }
	public function index(){
		if($this->session->userdata('loggedIn')){
	    		redirect('admin/dashboard/adminDashboard');
	    }
	    else{ 
			$this->load->view('login/login');
		}
	}

	public function beforeLogin($page){
		if($this->session->userdata('loggedIn')){
	    		redirect('admin/dashboard/adminDashboard');
	    }
	    else{
			$this->load->view("login/$page");
		}
	}

	public function register(){
		$this->form_validation->set_rules('name', 'FullName', 'trim|required|min_length[5]|alpha_numeric_spaces');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|regex_match[/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/]');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|matches[password]');
		if($this->form_validation->run()==false){
			$this->session->set_flashdata('error', validation_errors());
			redirect('admin/beforeLogin/register');
		}
		else{
			/*$hash = $this->hash($this->post('passconf'));
			$adminData=array(
				'username'=>$this->input->post('name'),
				'email'=>$this->input->post('email'),
				'password'=>$hash);*/
			// Code for Profile image insert
            if(!empty($_FILES['profileImage']['name'])){            
                $strtotime = strtotime("now");
                $new_name = $strtotime.'_'.$_FILES['profileImage']['name'];
                $config['file_name'] = $new_name;
                $config['upload_path'] = './uploads/profile/';
                $config['allowed_types']= 'gif|jpg|png|jpeg';
                $config['max_size']= 1024;
                $config['max_width']= 2048;
                $config['max_height']= 2048;
                $this->load->library('upload', $config);
                if(!$this->upload->do_upload('profileImage')){
                    $this->session->set_flashdata('error', $this->upload->display_errors());
					redirect('admin/beforeLogin/register');    
                }
                else{
                   $upload_data = $this->upload->data();
                   $adminData['profile_image'] =  $new_name;
                }         
            }//end image insert
			
			$adminData['username']=$this->input->post('name');
			$adminData['email']=$this->input->post('email');
			$adminData['password']=$this->hash($this->post('passconf'));

			$result=$this->AdminModel->adminRegister($adminData);
			if($result==true){
				$this->session->set_flashdata('success','User registered Successfully');
				redirect();
			}
			else{
				$this->session->set_flashdata('error','Email user already exists.');
				redirect('admin/beforeLogin/register');
			}
		}
	}

	public function hash($password){
       $hash = password_hash($password,PASSWORD_DEFAULT);
       return $hash;
   }

	public function login(){

		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|regex_match[/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/]');
		if($this->form_validation->run()==false){
			$this->session->set_flashdata('error', validation_errors());
			redirect('/');
		}
		else{
			$adminData=array(
				'email'=>$this->input->post('email'),
				'password'=>$this->input->post('password'));
			$result=$this->AdminModel->adminLogin($adminData);
			
			if(!empty($result)){
				$sessionData=array(
					'adminName'=>$result->username,
					'email'=>$result->email,
					'loggedIn'=> true);
				$this->session->set_userdata($sessionData);
				redirect('admin/Dashboard/adminDashboard');
			}
			else{
				//$error['error']="Wrong username and password.";
				$this->session->set_flashdata('error', "Wrong username and password.");
				redirect('/');
			}
			
		}
	}

	public function logout(){
		 //echo 'abc'; die('123');
		$this->session->sess_destroy();
		$this->session->set_flashdata('success','Logout successfully');
		redirect('/');

	}
}
