<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function getUsers()
	{
		$query = $this->db->get('users');
		return $query->result_array();
	}
	
	public function getUser($id)
	{
		$query = $this->db->get_where('users', array("id"=>$id));
		//return $query->row_array();
		return $query->result_array();
	}
}
