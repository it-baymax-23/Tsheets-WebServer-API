<?php 
	
	class signup extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function register($data)
		{
			$valid = $this->check_user($data);

			if($valid['success'])
			{
				$query = array(); $field = array();
				foreach($data as $key=> $value)
				{
					if($key == 'password')
					{
						$value = 'MD5("' . $value . '")';
					}
					else
					{
						$value = '"' . $value  . '"';
					}


					array_push($field, $key);
					array_push($query,$value);
				}

				$this->db->query('insert into user(' . join(',',$field) . ') Values(' . join(',',$query) . ')');

				return $valid;
			}
			else
			{
				return $valid;
			}
		}	

		public function check_user($data)
		{
			$user = $this->db->query('select * from user where username = "' . $data['username'] . '" or email = "' . $data['email'] . '"')->result_array();
			if(count($user) == 0)
			{
				return array('success'=>true);
			}
			else
			{
				if($user[0]['username'] == $data['username'])
				{
					return array('success'=>false,'message'=>'Username is already exist');	
				}
				else if($user[0]['email'] == $data['email'])
				{
					return array('success'=>false,'message'=>'Email is already exist');
				}
				
			}
		}

		public function login_username($data)
		{
			$user = $data['user'];

			$data = $this->db->query('Select * from user where username = "' . $user . '" or email = "' . $user . '" and role = "' . $data['role'] . '"')->result_array();

			if(count($data) > 0)
			{
				return array('success'=>true);
			}
			else
			{
				return array('success'=>false);
			}
		}

		public function login($data)
		{
			$user = $data['user'];
			$password = $data['password'];

			$user_array = $this->db->query('Select * from user where username = "' . $user . '" or email = "' . $user . '" and role = "' . $data['role'] . '"')->result_array();

			if(count($user_array) > 0)
			{
				$user_array = $this->db->query('Select * from user where (username = "' . $user . '" or email = "' . $user .'") and password = MD5("' . $password . '")')->result_array();
				if(count($user_array) > 0)
				{
					return array('success'=>true,'user_id'=>$user_array[0]['id'],"username"=>$user_array[0]['username'],"useremail"=>$user_array[0]['email'],"profile"=>$user_array[0]['profile']);
				}
				else
				{
					return array('success'=>false,'type'=>'password');
				}
			}
			else
			{
				return array('success'=>false,'type'=>'username');
			}
		}

		public function changepass($data)
		{
			$result = $this->db->query("select * from user where id = " . $data['user_id'] . ' and password = MD5("' . $data['confirm_password'] . '")')->result_array();
			if(count($result) == 0)
			{
				return array("success"=>false);
			}
			else
			{
				$this->db->query('Update user set password = MD5("' . $data['password'] . '") where id = ' . $data['user_id']);
				return array('success'=>true);
			}
		}

		public function saveprofile($userid,$profile)
		{
			$this->db->query("Update user set profile = '" . $profile . "' where id = ". $userid);
		}
	}
?>