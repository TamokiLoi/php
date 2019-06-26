<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Slides extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('slides_model');
	}

	public function index()
	{
		$this->load->view('addData_view');
	}

	public function addSlide()
	{
		// get data from database
		$data = $this->slides_model->getDataSlide();

		// decode json
		$data = json_decode($data, true);
		if($data == null) {
			echo 'data is null';
			$data = array();
		}

		// upload file
		$target_dir = "uploads/";
		$target_file = $target_dir . basename($_FILES["slide_image"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
		    $check = getimagesize($_FILES["slide_image"]["tmp_name"]);
		    if($check !== false) {
		        // echo "File is an image - " . $check["mime"] . ".";
		        $uploadOk = 1;
		    } else {
		        // echo "File is not an image.";
		        $uploadOk = 0;
		    }
		}

		// get data from view
		$title = $this->input->post('title');
		$description = $this->input->post('description');
		$button_link = $this->input->post('button_link');
		$button_text = $this->input->post('button_text');
		$slide_image = base_url() . 'uploads/'. basename($_FILES["slide_image"]["name"]);

		// add content in json by method array_push
		$oneSlideImage = array(
			'title' => $title,
			'description' => $description,
			'button_link' => $button_link,
			'button_text' => $button_text,
			'slide_image' => $slide_image
		);
		array_push($data, $oneSlideImage);

		// encode json
		$data = json_encode($data);

		// update data to database
		if ($this->slides_model->updateDataSlide($data))
		{
			$this->load->view('success');
		}
	}

	public function editSlide()
	{
		
	}

}

/* End of file Slides.php */
/* Location: ./application/controllers/Slides.php */