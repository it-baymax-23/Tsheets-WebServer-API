<?php 
	
	class JobController extends CI_Controller
	{
		public function __construct(){
			parent::__construct();
			$this->load->model('job');
		}

		public function add()
		{
			$data = $this->input->post();
			$json = $this->job->save($data);
			echo json_encode(array('job'=>$json));
		}
	}

?>