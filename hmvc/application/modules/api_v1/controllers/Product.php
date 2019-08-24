<?php  
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends Common_Service_Controller{

	public function __construct(){
		parent::__construct();
		$this->check_service_auth();
		$this->load->model('Product_apimodel');
	}
   
    function addProduct_post(){
    	$this->form_validation->set_rules('productName', 'Product Name', 'trim|required|min_length[4]');
    	$this->form_validation->set_rules('price', 'Price', 'trim|required|numeric');

    	if($this->form_validation->run()===false){
    		$response=array('status'=>FAIL, 'message'=>strip_tags(validation_errors()));
    		$this->response($response);
    	}

    	//check Product already exist or not...
        $exist = $this->Product_apimodel->check_product_exist($this->post('productName'));
    	if($exist){ //Product already exist
    		$response=array('status'=>FAIL, 'message'=>get_response_message(110));
         	$this->response($response);
    	}
    	// Code for Product image         	
        $strtotime = strtotime("now");
        $new_name = $strtotime.'_'.$_FILES['productImage']['name'];
        //echo $new_name; die();
        $config['file_name']     = $new_name;
        $config['upload_path']   = './uploads/productimage/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = 1000;
        $config['max_width']     = 2048;
        $config['max_height']    = 2048;
        $this->load->library('upload', $config);

        // if image upload fail set  msg for response
        if(!$this->upload->do_upload('productImage')){
        	$response = array('status'=>FAIL, 'message'=>strip_tags($this->upload->display_errors()));
			$this->response($response);    
        }
        $upload_data = $this->upload->data();
        $productData['product_image'] =  $new_name;
        //end image insert

        $productData['product_name'] =  $this->post('productName');
        $productData['price']        =  $this->post('price');
        $result = $this->Product_apimodel->add_product($productData);

        switch ($result['status']) {
            case 'PA': //Product Added successfully
     			$response=array('status'=>SUCCESS, 'message'=>get_response_message(122), 'data'=>$result['product_data']);
     			$this->response($response);
     		break;

     		default: //something went wrong
         		$response=array('status'=>FAIL, 'message'=>get_response_message(107));
         		$this->response($response);
         		break;
        }
           
    }

    function showProduct_get(){

    	$start = (null !== $this->get('start') ? $this->get('start') : 0);
    	$limit = (null !== $this->get('dataLimit') ? $this->get('dataLimit') : 10);
    	
    	$total = $this->Product_apimodel->getTotalData();
    	$productList = $this->Product_apimodel->select_product($start,$limit);
    	if($productList){
    		$response=array('status'=>SUCCESS, 'total'=>$total, 'data'=>$productList);
     		$this->response($response);
     	}
     	$response=array('status'=>FAIL, 'message'=>get_response_message(106));
    	$this->response($response);

    }

    function updateProduct_post(){
    	$this->form_validation->set_rules('productName', 'Product Name', 'trim|required|min_length[4]');
    	$this->form_validation->set_rules('price', 'Price', 'trim|required|numeric');

    	if($this->form_validation->run()===false){
    		$response=array('status'=>FAIL, 'message'=>strip_tags(validation_errors()));
    		$this->response($response);
    	}

    	//check Product already exist or not...
        $exist = $this->Product_apimodel->check_product_exist($this->post('productName'));
    	if(!$exist){ //Product not exist
    		$productData['product_name'] =  $this->post('productName');
    		/*$response=array('status'=>FAIL, 'message'=>get_response_message(110));
         	$this->response($response);*/
    	}

    	// Code for Update Product image         	
    	if(!empty($_FILES['productImage']['name'])){
            $strtotime = strtotime("now");
            $new_name = $strtotime.'_'.$_FILES['productImage']['name'];
            //echo $new_name; die();
            $config['file_name']     = $new_name;
            $config['upload_path']   = './uploads/productimage/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']      = 1000;
            $config['max_width']     = 2048;
            $config['max_height']    = 2048;
            $this->load->library('upload', $config);

            // if image upload fail set  msg for response
            if(!$this->upload->do_upload('productImage')){
            	$response = array('status'=>FAIL, 'message'=>strip_tags($this->upload->display_errors()));
				$this->response($response);    
            }
           $upload_data = $this->upload->data();
           $productData['product_image'] =  $new_name;
    	}//end image insert

    	$id =  $this->post('productId');
    	$removeImage  = $this->input->post('oldImage');
        $productData['price']        =  $this->post('price');
        $status = $this->Product_apimodel->update_product($productData,$id);
        if($status==false){
    		$response=array('status'=>FAIL, 'message'=>get_response_message(107));
         	$this->response($response);
    	}

    	if(isset($productData['product_image'])){
            unlink("./uploads/productimage/".$removeImage);
        }
    	$response=array('status'=>SUCCESS, 'message'=>get_response_message(123));
        $this->response($response);
    }

    function deleteProduct_post(){
    	$id =  $this->post('productId');
    	$product_image = $this->post("productImage");
    	$status = $this->Product_apimodel->delete_product($id);
    	if($status==false){
    		$response=array('status'=>FAIL, 'message'=>get_response_message(107));
         	$this->response($response);
    	}
    	unlink("./uploads/productimage/".$product_image);
    	$response=array('status'=>SUCCESS, 'message'=>get_response_message(124));
        $this->response($response);
    }

}