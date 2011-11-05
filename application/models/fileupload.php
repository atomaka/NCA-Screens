<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fileupload extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function add_upload($extension, $original_name) {
		$data = array(
			'extension'			=> $extension,
			'original_name'		=> $original_name,
		);

		$this->db->insert('uploads', $data);

		return $this->db->insert_id();
	}
}

?>