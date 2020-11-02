<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index($offset = 0){

		$this->load->model('blog_model');
		//pagination config
		$config['base_url'] 		= base_url() . 'index.php/blogs/index/';
		$config['total_rows'] 		= $this->db->count_all('blogs');
		$config['per_page'] 		= 3;
		$config['uri_segment'] 		= 3;
		$config['attributes'] 		= array('class' => 'pagination-link');

		//init pagination
		$this->pagination->initialize($config);

		$data['title'] = 'Latest Blogs';

		$data['blogs'] = $this->blog_model->get_blogs(FALSE, $config['per_page'], $offset);

		$this->load->view('header',array('title'=>'Welcome to Fitness Blog!'));
		$this->load->view('index', $data);
		$this->load->view('footer');
	}
	public function isLoggedIn(){
		$logged_in = $this->session->userdata('logged_in');
		return $logged_in;
	}
	public function login(){
		$this->load->view('header',array('title'=>'Login'));
		$this->load->view('login');
		$this->load->view('footer');	
	}
	public function signup(){
		$this->load->view('header',array('title'=>'SignUp'));
		$this->load->view('signup');
		$this->load->view('footer');	
	}
	public function signupAuth(){
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|callback_check_email_exists');
		$this->form_validation->set_rules('username', 'Username', 'required|callback_check_username_exists');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('password2', 'Confirm Password', 'matches[password]');

		if($this->form_validation->run() === FALSE){
			$this->load->view('header',array('title'=>'SignUp'));
			$this->load->view('signup');
			$this->load->view('footer');
		} else {
			// Encrypt password
			$enc_password = md5($this->input->post('password'));
			$this->load->model('user');
			if (!$this->user->register($enc_password)) {
				// Set message
				$this->session->set_flashdata('user_registered', 'Some problem occured while creating the account. Please try again.');
				redirect('signup');
			}else{
				$this->session->set_flashdata('user_registered', 'Congratulations! Account created successfully. Please login.');
				redirect('login');
			}
		}
	}

	// Log in user
	public function loginAuth(){
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if($this->form_validation->run() === FALSE){
			$this->load->view('header');
			$this->load->view('login', ['title'=>'Login']);
			$this->load->view('footer');
		} else {
			$this->load->model('user');
			// Get username
			$username = $this->input->post('username');
			// Get and encrypt the password
			$password = md5($this->input->post('password'));
			// Login user
			$user_id = $this->user->login($username, $password);
			if($user_id){
				// Create session
				$user_data = array(
					'user_id' => $user_id,
					'username' => $username,
					'logged_in' => true
				);
				$this->session->set_userdata($user_data);
				// Set message
				redirect('blogs');
			} else {
				// Set message
				$this->session->set_flashdata('user_auth','Login is invalid');
				redirect('login');
			}		
		}
	}

	// Log user out
	public function logout(){
		// Unset user data
		$this->session->unset_userdata('logged_in');
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('username');

		// Set message
		$this->session->set_flashdata('user_loggedout', 'You are now logged out');

		redirect('login');
	}
	//Check if same email-id exists
	public function check_email_exists($email){
		$query = $this->db->get_where('users', array('email' => $email));
		if(empty($query->row_array())){
			return true;
		} else {
			 $this->form_validation->set_message('check_email_exists', 'Sorry, that email address is already taken. Try another?');
			return false;
		}
		
	}
	//Check if same username exists
	public function check_username_exists($username){
		$query = $this->db->get_where('users', array('username' => $username));
		if(empty($query->row_array())){
			return true;
		} else {
			 $this->form_validation->set_message('check_username_exists', 'Sorry, that username\'s taken. Try another?');
			return false;
		}
		
	}
	public function search($offset = 0){
		$this->load->model('blog_model');

		$search_query 		= $this->input->post('search');
		$search_cat 		= $this->input->post('category');
		$limit 				= 3;
		$data['blogs'] 		= $this->blog_model->search($search_query,$search_cat,$limit,$offset); 
		$allBlogs			= count($this->blog_model->search($search_query,$search_cat));
		//pagination config
		$config2['base_url'] 		= base_url() . 'index.php/home/search/';
		$config2['total_rows'] 		= $allBlogs;
		$config2['per_page'] 		= $limit;
		$config2['uri_segment'] 	= 2;
		$config2['attributes'] 		= array('class' => 'pagination-link');

		//init pagination
		$this->pagination->initialize($config2);

		$data['title'] = 'Search Results for : '.$search_query;
		$this->session->set_userdata('search_query',$search_query);
		$this->session->set_userdata('search_cat',$search_cat);

		$this->load->view('header',array('title'=>$data['title']));
		$this->load->view('index', $data);
		$this->load->view('footer');

	}

}
