<?php

	class timesheet extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function save($data)
		{
			$id = '';
			
			$field = array(); $field_value = array();
			$update_value = array();

			foreach($data as $key => $value)
			{
				if($key == 'ref_id')
				{
					continue;
				}

				array_push($field,$key);

				if(is_array($value))
				{
					$value = join(',',$value);
				}

				if($key != 'userid' && $key != 'jobid')
				{
					$value = "'" . $value . "'";
				}

				array_push($field_value,$value);
				array_push($update_value,$key . '=' . $value);
			}

			if(isset($data['ref_id']) && $data['ref_id'] && count($this->get($data['ref_id'])) > 0)
			{
				// $result = $this->get($data['ref_id'])[0];
				// $attachment = $result['attachment'];
				// $attach_array = preg_split('/,/', $attachment);

				// foreach ($attach_array as $key => $value) {
				// 	if(file_exists($value))
				// 	{
				// 		unlink($value);
				// 	}
				// }
				$this->db->query('update timesheet set ' . join(',',$update_value) . ' where id = ' . $data['ref_id']);
				return array('success'=>true,"ref_id"=>0);
			}
			else
			{
				//echo $data['attachment'];exit;
				$this->db->query('insert into timesheet(' . join(',',$field) . ') Values(' . join(',',$field_value) . ')');	
				return array('success'=>true,"ref_id"=>$this->db->query("select max(id) as id from timesheet")->result_array()[0]['id']);
			}
			

			
		}

		public function checktimesheet($data)		
		{
			$sql = 'Select * from timesheet where endtime > "' . $data['starttime'] . '" and starttime < "' . $data['endtime'] . '" and jobid = ' . $data['jobid'];

			if(isset($data['ref_id']))
			{
				return $sql . ' and id != ' .  $data['ref_id'];
			}

			if(isset($data['state']) && $data['state'] == 'clockin')
			{
				return true;
			}

			$result = $this->db->query($sql)->result_array();
			if(count($result))
			{
				return false;
			}
			else
			{
				return true;
			}

		}

		public function get($id)
		{
			return $this->db->query('Select * from timesheet where id = ' . $id)->result_array();
		}

		public function delete($id)
		{
			$this->db->query('Delete from timesheet where id = ' . $id);
			return array('success'=>true);
		}

		public function get_timesheet($user)
		{
			return $this->db->get_where("timesheet",array("userid"=>$user['id']))->result_array();
		}

		public function deletetimesheet($user)
		{
			$this->db->query('Delete from timesheet where userid = ' . $user);
		}
	}