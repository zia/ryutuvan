<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Renders Search View
	*/
	public function index()
	{
		$data['headings'] = $this->db->get('headings')->result();
		$data['subheadings'] = $this->db->get('subheadings')->result();
		$data['products'] = $this->db->get('products')->result();
		$data['infos'] = $this->db->get('informations')->result();
		$this->load->view('search',$data);
	}

	/**
	 * Search Functionality
	 * @param
	 * @return
	*/
	public function search_result() {

		$data = array(
			'title' => $this->input->post('term')
		);

		$query = $this->db->get_where('products', $data)->result();
		
		if($query) {
			echo json_encode($query);
		}
		else {
			echo 'No match Found.';
		}
	}
}
