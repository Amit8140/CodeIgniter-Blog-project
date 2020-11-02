<?php 
class Blog_model extends CI_Model{

	function get_blogs($slug = FALSE, $limit = FALSE, $offset = FALSE){
		if ($limit) {
			$this->db->limit($limit, $offset);
		}
		
		if ($slug===FALSE) {
			$this->db->select('b.*,c.title as `category_title`');
			$this->db->order_by('b.id', 'DESC');
			$this->db->join('categories as c', 'c.id = b.category_id');
			$this->db->where('c.published','1');
			$query = $this->db->get('blogs as b');
			return $query->result_array();
		}

		$query = $this->db->get_where('blogs', array('slug' =>  $slug));
		return $query->row_array();
	}

	public function create_blog($post_image){
		$slug = url_title($this->input->post('title'));

		$data = array(
			'title' 		=> $this->input->post('title'),
			'slug' 			=> $slug,
			'description' 	=> $this->input->post('description'),
			'category_id' 	=> $this->input->post('category_id'),
			'created_by' 	=> $this->session->userdata('user_id'),
			'blog_image' 	=> $post_image,
			'created_on'	=> date('Y-m-d H:i:s')
			);

		return $this->db->insert('blogs', $data);
	}

	public function delete_blog($id)
	{
		$image_file_name = $this->db->select('blog_image')->get_where('blogs', array('id' => $id))->row()->blog_image;
		$cwd = getcwd(); // saving the current working directory
		$image_file_path = $cwd."\\application\\assets\\images\\blogs\\";
		//var_dump($cwd,$image_file_path,$image_file_name);die;
		chdir($image_file_path);
		unlink($image_file_name);
		chdir($cwd); // Restore the previous working directory
		$this->db->where('id', $id);
		$this->db->delete('blogs');
		return true;
	}

	public function update_blog()
	{
		$slug = url_title($this->input->post('title'));

		$data = array(
			'title' 		=> $this->input->post('title'),
			'slug' 			=> $slug,
			'description'	=> $this->input->post('description'),
			'category_id' 	=> $this->input->post('category_id'),
			'modified_by'	=> $this->session->userdata('user_id')
		);

		$this->db->where('id', $this->input->post('id'));
		return $this->db->update('blogs', $data);
	}

	public function get_categories()
	{
		$this->db->order_by('title');
		$this->db->where('published','1');
		$query = $this->db->get('categories');

		return $query->result_array();
	}

	public function get_blogs_by_category($category_id){
		$this->db->order_by('blogs.id', 'DESC');
		$this->db->join('categories', 'categories.id = blogs.category_id');
			$query = $this->db->get_where('blogs', array('category_id' => $category_id));
			return $query->result_array();
	}

	public function search($query = '', $cat, $limit = FALSE, $offset = FALSE){
		$this->db->select('b.*,c.title as `category_title`');
		
		if(!empty($query))
			$this->db->like('b.title',$query);
		
		if ($cat != 'AllCategory')
			$this->db->where('c.id',$cat);
		
		$this->db->join('categories as c','c.id = b.category_id','left');
		$this->db->order_by('b.id', 'DESC');
		$this->db->where('c.published','1');
		if ($limit) {
			$this->db->limit($limit, $offset);
		}
		//var_dump($this->db->get_compiled_select('blogs as b'));die;
		$query = $this->db->get('blogs as b');
		return $query->result_array();
	}

}
?>