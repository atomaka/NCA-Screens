<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fileupload extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function add_upload($extension, $original_name, $width, $height, $size, $hash) {
		$data = array(
			'extension'			=> $extension,
			'original_name'		=> $original_name,
			'width'				=> $width,
			'height'			=> $height,
			'size'				=> $size,
			'hash'				=> $hash,
		);

		$this->db->insert('uploads', $data);

		return $this->db->insert_id();
	}

	function count_uploads() {
		return $this->db->count_all('uploads');
	}

	function get_upload($id) {
		$this->db->select('extension, original_name, width, height, size, views, created')->from('uploads')->where('id',$id);
		$query = $this->db->get();

		$result = $query->result();

		return $result[0];
	}

	function add_view($id) {
		$this->db->where('id',$id)->set('views','views + 1',false)->update('uploads');
	}

	function get_uploads($start = false, $count = false) {
		if($start != false && $count != false) {
			$query = $this->db->get('uploads', $count, $start);
		} else {
			$query = $this->db->get('uploads');
		}
		

		return $query->result();
	}

	function check_duplicate($hash) {
		$this->db->select('id')->from('uploads')->where('hash',$hash);
		$query = $this->db->get();

		if($query->num_rows == 0) {
			return false;
		} else {
			$result = $query->result();

			return $result[0]->id;
		}
	}
}

?>