<?php 
class User extends CI_Model{

	public function register($enc_password){
		$data = array(
				'name' 			=> $this->input->post('name'),
				'email' 		=> $this->input->post('email'),
				'username' 		=> $this->input->post('username'),
				'password' 		=> $enc_password,
				'created_on'	=> date('Y-m-d H"i:s')
			);

		//insert user
		return $this->db->insert('users', $data);
		
	}
	//login user
	public function login($username,$password){
		$this->db->where('username',$username);
		$this->db->where('password',$password);

		$result = $this->db->get('users');

		if ($result->num_rows() == 1) {
			return $result->row(0)->id;
		} else {
			return false;
		}
	}
}

?>