<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Viewer extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function add_viewer($ip, $id) {
		$this->db->select('image_id')->where('image_id',$id)->where('ip',$ip);
		$query = $this->db->get('viewers');

		if($query->num_rows() == 0) {
			$data = array(
				'ip'			=> $ip,
				'image_id'		=> $id,
				'timestamp'		=> time()
			);

			$this->db->insert('viewers',$data);

			return true;
		} else {
			return false;
		}
	}

	function clean_viewers($duration) {
		$clean_time = time() - $duration;

		$this->db->where('timestamp <', $clean_time)->delete('viewers');
	}
}

?>