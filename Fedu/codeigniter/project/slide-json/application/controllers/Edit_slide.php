<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Edit_slide extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// get data from database
		$this->load->model('slides_model');
		$data = $this->slides_model->getDataSlide();

		// decode json data to array
		$data = json_decode($data, true);

		$data = array(
			'arrayData' => $data 
		);

		// pass data to view
		$this->load->view('editSlide_view', $data, FALSE);
	}

	public function editSlide()
	{
		// get data
		$title = $this->input->post('title');
		$description = $this->input->post('description');
		$button_link = $this->input->post('button_link');
		$button_text = $this->input->post('button_text');

		// get all image and upload
		$fileNames = $_FILES['slide_image']['name']; // store name file
		$fileTemp = $_FILES['slide_image']['tmp_name']; // store file

		$slide_image = array();
		$slide_image_old = $this->input->post('slide_image_old');

		// loop for get name each file
		for ($i = 0; $i < count($fileNames) ; $i++) {
			if (empty($fileNames[$i])) {
				$slide_image[$i] = $slide_image_old[$i];
			} else {
				$linkImage = 'uploads/' . $fileNames[$i];
				move_uploaded_file($fileTemp[$i], $linkImage);
				$slide_image[$i] = base_url() . 'uploads/' . $fileNames[$i];
			}
		} // $slide_image contain all file need update to database

		// create array all-slide need update
		$allSlide = array ();

		// insert each element in array
		for ($i = 0; $i < count($title); $i++) {
			$temp = array();
			$temp['title'] = $title[$i];
			$temp['description'] = $description[$i];
			$temp['button_link'] = $button_link[$i];
			$temp['button_text'] = $button_text[$i];
			$temp['slide_image'] = $slide_image[$i];
			array_push($allSlide, $temp);
		}

		// encode new array
		$allSlide = json_encode($allSlide);

		// call model update data to database
		$this->load->model('slides_model');
		if ($this->slides_model->updateDataSlide($allSlide))
		{
			$this->load->view('success');
		}
	}

}

/* End of file EditSlides.php */
/* Location: ./application/controllers/EditSlides.php */