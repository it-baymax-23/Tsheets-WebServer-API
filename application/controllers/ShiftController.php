<?php 
	
	class ShiftController extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('shift');
		}

		public function save()
		{
			$data = $this->input->post();
			$result = $this->shift->save($data);
			echo json_encode($result);
		}

		public function delete($id)
		{
			$success = $this->shift->delete($id);
			echo json_encode($success);
		}
	}
	
?>