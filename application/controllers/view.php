<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class View extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->model('viewer');
		$this->viewer->clean_viewers(5 * 60);
	}

	public function index() {
		
	}

	public function specific($id = 'latest') {
		$this->load->model('fileupload');

		$total_uploads = $this->fileupload->count_uploads();

		if($id == 'latest') {
			$id = $total_uploads;
		} elseif($id == 'random') {
			$id = rand(1,$total_uploads);
		} elseif($id == false || !is_numeric($id) || $id < 0 || $id > $total_uploads) {
			exit('bad id' . $id);
		}

		$upload = $this->fileupload->get_upload($id);

		$display_views = $upload->views;

		$this->load->model('viewer');
		if($this->viewer->add_viewer($_SERVER['REMOTE_ADDR'], $id)) {
			$this->fileupload->add_view($id);
			$display_views++;
		}

		$this->data['prev'] 		= $id - 1;
		$this->data['next'] 		= ($id + 1 <= $total_uploads) ? $id + 1 : 0;

		$this->data['image']		= $id . $upload->extension;

		$this->data['original']		= $upload->original_name;
		$this->data['views']		= $display_views;
		$this->data['created']		= $upload->created;
		$this->data['height']		= $upload->height;
		$this->data['width']		= $upload->width;
		$this->data['size']			= $upload->size;


		$this->template->load('template', 'view', $this->data);
	}

	public function random() {
		$this->load->model('fileupload');
		$total_uploads = $this->fileupload->count_uploads();

		$id = rand(1,$total_uploads);

		redirect($id);
	}

	public function latest() {
		$this->load->model('fileupload');
		$total_uploads = $this->fileupload->count_uploads();

		redirect($total_uploads);
	}
}