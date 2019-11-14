<?php 

	class shift extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function save($data)
		{
			$field = array(); $field_value = array();
			$update_value = array();
			$field_array = array('jobid','user_id','shift_type');


			foreach($data as $key => $value)
			{
				if($key == 'id')
				{
					continue;
				}

				array_push($field,$key);

				if(!in_array($key,$field_array))
				{
					$value = '"' . $value . '"';
				}
				array_push($update_value,$key . '=' . $value);
				array_push($field_value,$value);
			}

			if(!isset($data['id']))
			{
				$this->db->query('insert into shift(' . join(',',$field) . ') Values(' . join(',',$field_value) . ')');	
			}
			else
			{
				$this->db->query("update shift set " . join(',',$update_value) . ' where id = ' .$data['id']);
			}

			return array('success'=>true,"data"=>$this->db->get_where("shift",array())->result_array());

		}

		public function delete($id)
		{
			$this->db->query('Delete from shift where id = ' . $id);
			return array('success'=>true);
		}

		public function get_shift($user)
		{
			$id = '';
			if($user['role'] == 'admin')
			{
				$id = $user['id'];
			}
			else
			{
				$id = $user['admin_id'];
			}

			return $this->db->get_where("shift",array("user_id"=>$id))->result_array();	
		}

	}
?>