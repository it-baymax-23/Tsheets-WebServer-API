<?php 
	
	class DefaultController extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('signup');
		}

		public function signup()
		{
			$data = $this->input->post();
			$data = $this->signup->register($data);
			echo json_encode($data);
		}

		public function signin_username()
		{
			$data = $this->input->post();
			$data = $this->signup->login_username($data);
			echo json_encode($data);
		}

		public function signin()
		{
			$data = $this->input->post();
			$data = $this->signup->login($data);


			header('Content-Type:application/json');
			echo json_encode($data);
		}

		public function changepass()
		{
			$data = $this->input->post();
			$data = $this->signup->changepass($data);
			echo json_encode($data);
		}

		public function uploadprofile()
		{

			$userid = $this->input->post('user_id');
			$config = array(
				"upload_path"=>"./uploads/",
				"allowed_types"=>"gif|jpg|png",
				"max_size"=>10000,
				"max_width"=>102400,
				"max_height"=>76800
			);

			$this->load->library('upload',$config);
			if($this->upload->do_upload("image"))
			{
				$data = $this->upload->data();
				$profile = $config['upload_path'] . $data['file_name'];
				$this->signup->saveprofile($userid,$profile);
				echo json_encode(array("profile"=>base_url() . $profile));
			}
			else
			{
				echo json_encode(array("profile"=>""));
			}
		}

	}
?>