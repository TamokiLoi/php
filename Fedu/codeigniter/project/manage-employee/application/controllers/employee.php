<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include 'UploadHandler.php';
class employee extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->model('employee_model');
		$result = $this->employee_model->getAllData();
		$result = array('list_employees' => $result);

		// pass data to view
		$this->load->view('employee_view', $result);
	}

	public function add_employee()
	{
		// handle upload avatar_image
		$target_dir = "FileUpload/";
		$target_file = $target_dir . basename($_FILES["avatar_image"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
		    $check = getimagesize($_FILES["avatar_image"]["tmp_name"]);
		    if($check !== false) {
		        echo "File is an image - " . $check["mime"] . ".";
		        $uploadOk = 1;
		    } else {
		        echo "File is not an image.";
		        $uploadOk = 0;
		    }
		}
		// Check if file already exists
		if (file_exists($target_file)) {
		    echo "Sorry, file already exists.";
		    $uploadOk = 0;
		}
		// Check file size
		if ($_FILES["avatar_image"]["size"] > 5000000) {
		    echo "Sorry, your file is too large.";
		    $uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		    $uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
		    if (move_uploaded_file($_FILES["avatar_image"]["tmp_name"], $target_file)) {
		        // echo "The file ". basename( $_FILES["avatar_image"]["name"]). " has been uploaded.";
		    } else {
		        // echo "Sorry, there was an error uploading your file.";
		    }
		}

		// get data form from employee_view
		$name = $this->input->post('name');
		$age = $this->input->post('age');
		$phone_number = $this->input->post('phone_number');
		$avatar_image = base_url()."FileUpload/".basename($_FILES["avatar_image"]["name"]);
		$link_fb = $this->input->post('link_fb');
		$order_amount = $this->input->post('order_amount');

		// call model
		$this->load->model('employee_model');
		$data = $this->employee_model->insertData($name, $age, $phone_number, $avatar_image, $link_fb, $order_amount);
		if($data) {
			$this->load->view('insert_success_view');
		} else {
			echo "insert failed";
		}
	}

	// get id and show data need edit to layout edit_employee_view
	public function edit_employee($id)
	{
		$this->load->model('employee_model');
		$data = $this->employee_model->getDataById($id); // based on ID get data
		// convert data to array
		$data = array('data' => $data);
		// pass data to edit_view
		$this->load->view('edit_employee_view', $data);
	}

	// get data updated and pass data to model employee_model
	public function update_employee($value='')
	{

		// handle upload avatar_image
		$target_dir = "FileUpload/";
		$target_file = $target_dir . basename($_FILES["avatar_image"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
		    $check = getimagesize($_FILES["avatar_image"]["tmp_name"]);
		    if($check !== false) {
		        echo "File is an image - " . $check["mime"] . ".";
		        $uploadOk = 1;
		    } else {
		        echo "File is not an image.";
		        $uploadOk = 0;
		    }
		}
		// Check if file already exists
		if (file_exists($target_file)) {
		    // echo "Sorry, file already exists.";
		    $uploadOk = 0;
		}
		// Check file size
		if ($_FILES["avatar_image"]["size"] > 5000000) {
		    echo "Sorry, your file is too large.";
		    $uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		    // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		    $uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    // echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
		    if (move_uploaded_file($_FILES["avatar_image"]["tmp_name"], $target_file)) {
		        // echo "The file ". basename( $_FILES["avatar_image"]["name"]). " has been uploaded.";
		    } else {
		        // echo "Sorry, there was an error uploading your file.";
		    }
		}
		$avatar_image = basename($_FILES["avatar_image"]["name"]);

		// check condition, upload avatar_image
		if ($avatar_image) 
		{
			// get new avatar_image
			$avatar_image = base_url()."FileUpload/".basename($_FILES["avatar_image"]["name"]);
		}
		else 
		{
			// get old avatar_image
			$avatar_image = $this->input->post('avatar_image_old');
		}

		// get data form from edit_employee_view
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$age = $this->input->post('age');
		$phone_number = $this->input->post('phone_number');
		$link_fb = $this->input->post('link_fb');
		$order_amount = $this->input->post('order_amount');

		// call model handle data need update
		$this->load->model('employee_model');
		if ($this->employee_model->updateDataById($id, $name, $age, $phone_number, $avatar_image, $link_fb, $order_amount))
		{
			$this->load->view('update_success_view');
		}

	}

	public function delete_employee($id)
	{
		$this->load->model('employee_model');
		if ($this->employee_model->deleteDataById($id))
		{
			$this->load->view('delete_success_view');
		}
		else 
		{
			echo 'Delete not completed, please review code!';
		}
	}

	public function ajax_add_employee()
	{
		// get data form from employee_view
		$name = $this->input->post('name');
		$age = $this->input->post('age');
		$phone_number = $this->input->post('phone_number');
		$avatar_image = $this->input->post('avatar_image');
		$link_fb = $this->input->post('link_fb');
		$order_amount = $this->input->post('order_amount');

		// call model
		$this->load->model('employee_model');
		$data = $this->employee_model->insertData($name, $age, $phone_number, $avatar_image, $link_fb, $order_amount);
		if($data) {
			echo "Insert complete!";
		} else {
			echo "Insert failed, please review code!";
		}
	}

	public function uploadFile()
	{
		$uploadFile = new UploadHandler();
	}
}

/* End of file employee.php */
/* Location: ./application/controllers/employee.php */