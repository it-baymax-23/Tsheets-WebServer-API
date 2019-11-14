<?php
	
	class Job extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function save($data)
		{
			$field = array(); $field_value = array();
			$update_value = array();
			foreach($data as $key => $value)
			{
				if($key == 'id')
				{
					continue;
				}

				if($key != 'user_id')
				{
					$key = '"' . $value . '"';
				}
				array_push($field,$key);
				array_push($field_value,$value);
				array_push($update_value,$key . '=' . $value);
			}

			if($data['id'] == 0)
			{
				$this->db->query('insert into job(' . join(',',$field) . ') Values(' . join(',',$field_value) . ')');	
			}
			else
			{
				$this->db->query('update job set ' . join(',',$update_value) . ' where id = ' . $data['id']);
			}

			return $this->db->get_where('job',array('user_id'=>$data['user_id']))->result_array();
		}

		public function get_job($user)
		{
			if($user['role'] == 'admin')
			{
				return $this->db->get_where("job",array("user_id"=>$user['id']))->result_array();
			}
			else
			{
				return $this->db->query("Select * from job where user_id = " . $user['admin_id'] . " and FIND_IN_SET('everyone',assigns)")->result_array();
			}
		}
	}
?>