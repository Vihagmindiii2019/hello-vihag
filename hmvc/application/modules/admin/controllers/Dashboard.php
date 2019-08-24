<?php  
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Common_Back_Controller{

    public function __construct(){
    	
    	parent::__construct();
        $this->load->model('Dashboard_Model');
    	if($this->session->userdata('loggedIn')!= true){
    		redirect('/');
    	}
    }

   public function adminDashboard(){
		$this->load->admin_render('dashboard/dashboard');
	}

    public function profileUpdate(){
        $this->form_validation->set_rules('profileName', ' Profile Name', 'trim|required|min_length[5]|alpha_numeric_spaces');

        if($this->form_validation->run()==false){
            $status = false;
            $data['msg'] = validation_errors();
        }
        else{
            // Code for Profile image Update
            if(!empty($_FILES['profileImage']['name'])){            
                $strtotime = strtotime("now");
                $new_name = $strtotime.'_'.$_FILES['profileImage']['name'];
                $config['file_name'] = $new_name;
                $config['upload_path'] = './uploads/profile/';
                $config['allowed_types']= 'gif|jpg|png|jpeg';
                $config['max_size']= 100;
                $config['max_width']= 2048;
                $config['max_height']= 2048;
                $this->load->library('upload', $config);
                if(!$this->upload->do_upload('profileImage')){
                    $status=false;
                    $data['msg'] = $this->upload->display_errors();    
                }
                else{
                   $upload_data = $this->upload->data();
                   $profileData['profile_image'] =  $new_name;
                }         
            }//end image update

            $removeImage  = $this->session->userdata('adminImage');
            $profileData['email']  = $this->session->userdata('email');
            $profileData['username']  = $this->input->post('profileName');
            $result = $this->Dashboard_Model->updateProfile($profileData);
            if($result){
                $this->session->set_userdata('adminName',$result->username);
                if(isset($profileData['profile_image'])){
                    //unlink("uploads/profile/".$removeImage);
                }
                $status=true;
                $data['msg'] = 'Profile Updated';
            }
        }
        $alertType = ($status == true)?'alert-success':'alert-danger';
        $statusHtml = "<p class=\"alert $alertType\" id=\"alert\"></p>";
        $statusMsg =$data['msg'];
        $response = array(
            'status' => $status,
            'message' => $statusMsg,
            'html'=>$statusHtml );
        echo json_encode($response);
        die();
    }

    public function changePassword(){
        $password['old']=$this->input->post('password');
        $password['new']=$this->hash($_POST['confpass']);
        $result = $this->Dashboard_Model->passwordChange($password);
        if($result==true){
            $response['status'] = 'Password Successfully changed.';
            echo json_encode($response);
            exit;
        }
        else{
            $response['status'] = 'Current Password does not matched.';
            echo json_encode($response);
            exit;
        }
    }

    public function hash($password){
       $hash = password_hash($password,PASSWORD_DEFAULT);
       return $hash;
   }

}
?>