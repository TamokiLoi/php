<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class jsonEdit extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->model('json_model');
		$data = $this->json_model->showData();
		$data = json_decode($data, true);
		$data = ['arrayData' => $data];
		$this->load->view('json_edit_view', $data);
	}

	public function edit_json()
	{
		$names = $this->input->post('name');
		$phone_numbers = $this->input->post('phone_number');

		$data = array();

		// browse each element in names, phone_numbers and push to array_data 
		for ($i = 0; $i < count($names); $i++) {
			$temp = array();
			$temp['name'] = $names[$i];
			$temp['phone_number'] = $phone_numbers[$i];
			array_push($data, $temp);
		}

		$data = json_encode($data);

		// call model handle
		$this->load->model('json_model');
		if($this->json_model->updateData($data))
		{
			$this->load->view('notification_view');
		}

	}

}

/* End of file jsonEdit.php */
/* Location: ./application/controllers/jsonEdit.php */