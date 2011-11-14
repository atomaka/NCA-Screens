<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gallery extends CI_Controller {
	public function index($start = 1) {
		$this->load->model('fileupload');
		$this->load->library('pagination');

		$page_count	= 20;		
		
		$config = array(
			'base_url'		=> base_url('/gallery/index/'),
			'total_rows'	=> $this->fileupload->count_uploads(),
			'per_page'		=> $page_count
		);

		$this->pagination->initialize($config);

		$this->data['pagination']	= $this->pagination->create_links();
		$this->data['uploads']		= $this->fileupload->get_uploads($start, $page_count);

		$this->template->load('template', 'gallery', $this->data);
	}
}


?>