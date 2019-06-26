<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class slides_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
	}

	public function getDataSlide()
	{
		$this->db->select('*');
		$this->db->where('name_att', 'slide_topbanner');
		$dl = $this->db->get('homepageattribute');
		$dl = $dl->result_array();
		foreach ($dl as $value) {
			$temp = $value['value_att'];
		}
		return $temp;
	}

	public function updateDataSlide($dataUpdate)
	{
		// get data_update and update to database
		$data = array(
			'name_att' => 'slide_topbanner',
			'value_att' => $dataUpdate
		);
		$this->db->where('name_att', 'slide_topbanner');
		return $this->db->update('homepageattribute', $data);
	}

}

/* End of file slides_model.php */
/* Location: ./application/models/slides_model.php */