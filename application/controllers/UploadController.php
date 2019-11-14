<?php 

class UploadController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('timesheet');
	}

	public function index(){

	}

	public function uploadtimesheet(){
		$data = $this->input->post();

		if((isset($data['starttime']) && isset($data['endtime'])) || $data['state'] == 'clockin')
		{
			$config = array(
				"upload_path"=>"./uploads/",
				"allowed_types"=>"gif|jpg|png",
				"max_size"=>10000,
				"max_width"=>10240,
				"max_height"=>76800
			);

			$this->load->library('upload',$config);


			$array_filename = array('filename'=>array(),'error'=>array());

			$data['attachment'] = array();

			if(!$this->timesheet->checktimesheet($data))
			{
				echo json_encode(array('success'=>false));
			}
			else
			{
				foreach($_FILES as $key => $file)
				{
					if($this->upload->do_upload($key))
					{
						$uploaddata = $this->upload->data();
						array_push($data['attachment'],$config['upload_path'] . $uploaddata['file_name']);
					}
					
				}
				$element_json = $this->timesheet->save($data);	
				header('Content-Type:application/json');
				echo json_encode($element_json);
			}
			
			
		}
		else
		{
			
			header('Content-Type:application/json');
			echo json_encode(array('success'=>false));
		}
	}

	public function delete($id)
	{
		$result = $this->timesheet->delete($id);
		echo json_encode($result);
	}
}