<?php 

class EmployeeController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("employee");
	}

	public function get($id)
	{
		echo json_encode($this->employee->get($id));
	}
}