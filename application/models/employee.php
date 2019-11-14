<?php 
	
	class employee extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function get($id)
		{
			return $this->db->query("select * from user where admin_id = " . $id)->result_array();
		}
	}

?>