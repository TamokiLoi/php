<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class employee_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
	}

	public function insertDataToMySQL($name, $age, $phone_number, $avatar_image, $link_fb, $order_amount)
	{
		// handle get_data and update to mysql
		$data = array(
			'name' => $name,
			'age' => $age,
			'phone_number' => $phone_number,
			'avatar_image' => $avatar_image,
			'link_fb' => $link_fb,
			'order_amount' => $order_amount
		);
		$this->db->insert('employee', $data);
		return $this->db->insert_id();
	}

}

/* End of file employee_model.php */
/* Location: ./application/models/employee_model.php */