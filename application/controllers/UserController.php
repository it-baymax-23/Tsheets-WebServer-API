<?php 
	
	class UserController extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('user');
		}

		public function get()
		{
			echo json_encode($this->user->get());
		}

		public function delete($user_id)
		{
			$this->user->deletetimesheet($user_id);
		}
	}
?>