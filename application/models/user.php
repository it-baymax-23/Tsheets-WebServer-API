<?php 
	
	class user extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function get()
		{
			return $this->db->get_where('user',array())->result_array();
		}

		public function get_user($id)
		{
			return $this->db->get_where("user",array("id"=>$id))->result_array();
		}

		public function deletetimesheet($user)
		{
			$this->db->query('Delete from timesheet where userid = ' . $user . ' and state = "clockin"');
		}
	}
?>