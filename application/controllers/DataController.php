<?php 
	
	class DataController extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model("user");
			$this->load->model("job");
			$this->load->model("shift");
			$this->load->model("timesheet");
			$this->load->model('employee');
		}

		public function get($id){
			$user = $this->user->get_user($id);
			if(count($user) > 0)
			{
				$job = $this->job->get_job($user[0]);
				$timesheet = $this->timesheet->get_timesheet($user[0]);
				$shift = $this->shift->get_shift($user[0]);
				$employee = $this->employee->get($user[0]['id']);
				echo json_encode(array("success"=>true,"job"=>$job,"timesheet"=>$timesheet,"shift"=>$shift,"employee"=>$employee));
			}
			else
			{
				echo json_encode(array("success"=>false));
			}
		}
	}
?>