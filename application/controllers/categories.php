<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->model('categories_model');
    }

	public function index(){
		
		$data['categories'] = $this->categories_model->get_categories();

		$this->load->view('header',array('title'=>'Categories'));
		$this->load->view('categories/index',$data);
		$this->load->view('footer');
	}

	public function create(){
		if (!$this->session->userdata('logged_in')) {
			$this->session->set_flashdata('login_protected','Please login to access this page.');
			redirect('home/login');
		}

		if($this->categories_model->create()){
			$this->session->set_flashdata('category_create','Category added successfully!');
			redirect('categories');
		}else{
			$this->session->set_flashdata('category_create','Title cannot be empty. Please try again.');
			redirect('categories');
		}
	}

	public function delete(){
		$id 			= $this->input->get_post('id');
		$categoryName 	= $this->input->get_post('categoryName');

		//Decode category id
		$id = base64_decode($id);
		if(empty($id) || !is_numeric($id))
			return false;
		//check login
		if (!$this->session->userdata('logged_in')) {
			return false;
		}
		$response = $this->categories_model->delete($id);

		//$this->session->set_flashdata('category_deleted', 'Category - '.$categoryName.' has been deleted.');

		die($response);
	}

	public function edit(){
		//check login
		if (!$this->session->userdata('logged_in')) {
			$this->session->set_flashdata('login_protected','Please login to access this page.');
			redirect('home/login');
		}

		$id 		= base64_decode($this->input->get_post('editCategoryid'));
		$created_by	= $this->session->userdata('user_id');
		if (empty($id) || !is_numeric($id)) {
			$this->session->set_flashdata('category_create','No record found to update. Please try again.');
			redirect('categories');
		}
		$data = array(
				'title'			=>	$this->input->get_post('categoryName'),
				'published'		=>	$this->input->get_post('published'),
				'modified_by'	=>	$this->session->userdata('user_id')
				);
		$this->categories_model->edit($id,$created_by,$data);

		$this->session->set_flashdata('category_create','Record updated successfully!');

		redirect('categories');
	}

	public function blogs($cat_id,$offset = 0){
		$this->load->model('blog_model');
		$limit = 3;
		$data['blogs'] 		= $this->blog_model->search('',$cat_id,$limit,$offset);
		//pagination config
		$config['base_url'] 	= base_url() . 'categories/blogs/'.$cat_id.'/';
		$config['total_rows'] 	= count($data['blogs']);
		$config['per_page'] 	= $limit;
		$config['uri_segment'] 	= 4;
		$config['attributes'] 	= array('class' => 'pagination');

		//init pagination
		$this->pagination->initialize($config);

		$title = 'No records found.';
		if (count($data['blogs'])) {
			$title = 'Blogs for : '.$data['blogs'][0]['category_title'];
		}
		$data['title'] = $title;

		$this->load->view('header',array('title'=>$data['title']));
		$this->load->view('index', $data);
		$this->load->view('footer');
	}

}