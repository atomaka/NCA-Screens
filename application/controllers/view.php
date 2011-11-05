<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class View extends CI_Controller {
	public function index() {
		$this->load->model('fileupload');

		$id = $this->uri->segment($this->uri->total_segments());
		$total_uploads = $this->fileupload->count_uploads();

		if($id == false || !is_numeric($id) || $id < 0 || $id > $total_uploads) {
			exit('bad id');
		}

		$upload = $this->fileupload->get_upload($id);

		$this->load->model('viewer');

		print_r($upload);
	}
}