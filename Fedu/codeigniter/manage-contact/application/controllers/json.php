<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class json extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('json_model');
	}

	public function index()
	{
		// $contact1 = array(
		// 	'name' => 'tamoki',
		// 	'phone_number' => '0938947221',
		// 	);
		// $contact2 = array(
		// 	'name' => 'rimoto',
		// 	'phone_number' => '0769988251',
		// 	);
		// $contact3 = array(
		// 	'name' => 'mom',
		// 	'phone_number' => '0796816842',
		// 	);
		// $contacts = array ();
		// array_push($contacts, $contact1);
		// array_push($contacts, $contact2);
		// array_push($contacts, $contact3);

		// // encode list contacts
		// $contacts = json_encode($contacts);

		// // call model insert data to sql
		// $this->load->model('json_model');
		// echo $this->json_model->insertData('contact', $contacts);

		$this->load->model('json_model');
		$data = $this->json_model->showData();
		$data = json_decode($data);
		$result = [
		    'items' => $data
		];
		$this->load->view('json_view', $result);
	}

	public function delete_json($phone_number)
	{
		// get data 
		$data = $this->json_model->showData();
		$data = json_decode($data);

		// check element need delete in list
		foreach ($data as $key => $value) 
		{
			if($value->phone_number === $phone_number) 
			{
				unset($data[$key]);
			}
		}
		$data = json_encode($data);
		if ($this->json_model->updateData($data))
		{
			$this->load->view('notification_view');
		}
	}

}

/* End of file json.php */
/* Location: ./application/controllers/json.php */