<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends Common_Back_Controller {

    public function __construct(){
    	parent::__construct();
    	if($this->session->userdata('loggedIn')!= true){
    		redirect('/');
    	}
    	$this->load->model('Product_Model');
    }

    public function addProductPage(){
    	
    	$this->load->admin_render("product/create_product");
    }

    public function addProduct(){
    	$this->form_validation->set_rules('productName', 'Product Name', 'trim|required|min_length[5]|alpha_numeric_spaces');
    	$this->form_validation->set_rules('price', 'Product price', 'trim|required|numeric');

        if(!empty($_FILES['productImage']['name'])){

        }

        if($this->form_validation->run()==FALSE){
            $this->session->set_flashdata('error', validation_errors());
            $this->load->admin_render('product/create_product');   
        }
        else{
            $productData['product_name']  = $this->input->post('productName');
            $productData['price']         = $this->input->post('price');
            $check = $this->Product_Model->checkProductDuplicate($_POST['productName']);

            if($check==true){
                $this->session->set_flashdata('error', 'Product already created.');
                redirect('admin/Products/addProductPage');
            }
            else{
                $strtotime = strtotime("now");
                $new_name = $strtotime.'_'.$_FILES['productImage']['name'];
                $config['file_name'] = $new_name;
                $config['upload_path'] = './uploads/';
                $config['allowed_types']= 'gif|jpg|png|jpeg';
                $config['max_size']= 2048;
                $config['max_width']= 2048;
                $config['max_height']= 2048;
                $this->load->library('upload', $config);
                if(!$this->upload->do_upload('productImage')){
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('admin/Products/addProductPage');
                }
                else{
                    $upload_data = $this->upload->data();
                    $productData['product_image'] = $new_name; 
                    $result = $this->Product_Model->createProduct($productData);
                    if($result==true){
                        $this->session->set_flashdata('success', 'Product created sucessfully.');
                        redirect('admin/Products/showItem');
                    }
                    else{
                        $this->session->set_flashdata('error', 'Product not created.');
                        redirect('admin/Products/addProductPage');
                    }
                }    
        	}
        }
    }

	public function showItem(){
		$this->load->admin_render('product/show_item');		
	}

	public function itemList(){
		//die('abc');
      	$this->load->library('Ajax_Pagination');
      	$like = (isset($_POST['search']) ? $_POST['search'] : NULL);
        $total = $this->Product_Model->getTotalData($like);
        $config['base_url'] = base_url().'admin/Products/itemList/';
        $config['total_rows'] = $total;
        $config['uri_segment'] =4;
        $config['per_page'] = 10;
        $config['num_links'] = 5;
        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin cs-no-mr">';
        $config['full_tag_close'] = '</ul>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['anchor_class'] = 'class="paginationlink" ';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $page = $this->uri->segment(4);
        $limit = $config['per_page'];
        $start = $page>0?$page:0;
        $this->ajax_pagination->initialize($config);

        $data['records'] = $this->Product_Model->selectProduct($limit, $start, $like);
        $data['pages']= $page; 
        $data['pagination'] =$this->ajax_pagination->create_links();
        $data['startFrom'] = $start + 1; 
        $this->load->view('product/item_list',$data);
     
	}

    public function deleteProduct(){
        $id=$this->input->post("product_id");
        $product_image=$this->input->post("productImage");
        $result=$this->Product_Model->deleteProduct($id);
        if($result==true){
            unlink("./uploads/productimage/".$product_image);
            $response['status'] = 'Item Deleted';
            echo $response;
            exit;
        }
    }

    public function updateProduct(){
        $this->form_validation->set_rules('productName', 'Product Name', 'trim|required|min_length[5]|alpha_numeric_spaces');
        $this->form_validation->set_rules('price', 'Product price', 'trim|required|numeric');

        if($this->form_validation->run()==FALSE){
            $status = false;
            $data['msg'] = validation_errors();   
        }
        else{

            // Code for product image Update
            if(!empty($_FILES['productImage']['name'])){            
                $strtotime = strtotime("now");
                $new_name = $strtotime.'_'.$_FILES['productImage']['name'];
                $config['file_name'] = $new_name;
                $config['upload_path'] = './uploads/productimage/';
                $config['allowed_types']= 'gif|jpg|png|jpeg';
                $config['max_size']= 2048;
                $config['max_width']= 2048;
                $config['max_height']= 2048;
                $this->load->library('upload', $config);
                if(!$this->upload->do_upload('productImage')){
                    $status=false;
                    $data['msg'] = $this->upload->display_errors();    
                }
                else{
                   $upload_data = $this->upload->data();
                   $productData['product_image'] =  $new_name;
                }         
            }//end image update

            $removeImage  = $this->input->post('oldImage');
            $productData['product_id']  = $this->input->post('product_id');
            $productData['product_name']  = $this->input->post('productName');
            $productData['price']         = $this->input->post('price');
            $result = $this->Product_Model->updateProduct($productData);
            if($result == true){
                if(isset($productData['product_image'])){
                    unlink("./uploads/productimage/".$removeImage);
                }
                $status=true;
                $data['msg'] = 'Item Updated';
            } 
            else{
                $status=false;
                $data['msg'] = 'Item not Updated';
            }
        }

        $alertType = ($status == true)?'alert-success':'alert-danger';
        $statusHtml = "<p class=\"alert $alertType\" id=\"alertproduct\"></p>";
        $statusMsg =$data['msg'];
        $response = array(
            'status' => $status,
            'message' => $statusMsg,
            'html'=>$statusHtml );
        echo json_encode($response);
        die();   
    }
    
}
