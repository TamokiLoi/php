<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->model('slides_model');
		$data = $this->slides_model->getDataSlide();
		$data = array("arrayData" => $data);
		$this->load->view('home', $data);
	}

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */