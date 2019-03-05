<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class json_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
	}

	public function insertData($name, $data)
	{
		// create array data
		$arrData = [
		    'name' => $name,
		    'data' => $data 
		];
		$this->db->insert('warehouse', $arrData);
		return $this->db->insert_id();
	}

	public function showData()
	{
		$this->db->select('*');
		$this->db->where('name', 'contact');
		$data = $this->db->get('warehouse');
		$data = $data->result_array(); 
		foreach ($data as $item) {
			$result = $item['data'];
		}
		return $result;
	}

}

/* End of file json_model.php */
/* Location: ./application/models/json_model.php */