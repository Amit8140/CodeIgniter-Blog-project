<?php 
class Categories_model extends CI_Model{

	public function get_categories(){
		$this->db->select('c.*,u.name');
		$this->db->order_by('title');
		$this->db->join('users as u','u.id = c.created_by');
		$query = $this->db->get('categories as c');

		return $query->result_array();
	}

	public function get_published_cat(){
		$this->db->select('c.*');
		$this->db->order_by('title');
		$this->db->where('c.published','1');
		$query = $this->db->get('categories as c');

		return $query->result_array();	
	}

	public function create(){
		$title	=	 $this->input->post('categoryName');
		if ( empty( trim( $title ) ) ) {
			return false;
		}

		$data['title']			= $title;
		$data['created_by']		= $this->session->userdata('user_id');
		$data['created_on']		= date('Y-m-d H:i:s');
		$data['published']		= '1';

		return $this->db->insert('categories', $data);

	} 

	public function delete($id){
		$this->db->where('id', $id);
		$this->db->delete('categories');
		return true;
	}
	public function edit($id,$created_by,$data){
		$this->db->set($data);
		$this->db->where(array('id'=> $id,'created_by'=>$created_by));
		return $this->db->update('categories');
	}

}
