<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class employee_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
	}

	// handle get_all_data from sql to show-layout
	public function getAllData()
	{
		$this->db->select('*');
		$data = $this->db->get('employee');
		$data = $data->result_array();
		return $data;
	}

	// handle get_data and update from layout to sql
	public function insertData($name, $age, $phone_number, $avatar_image, $link_fb, $order_amount)
	{
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