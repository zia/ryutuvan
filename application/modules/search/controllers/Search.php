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
			'title' => $this->input->post('term'),
			'quantity' => $this->input->post('term')
		);

		//$query = $this->db->get_where('products', $data)->unbuffered_row();

		//$query = $this->db->like('id', $this->input->post('term'));
				 //$this->db->or_like('title', $this->input->post('term'));

		//$query = $query->result();

		//$query = $this->db->or_like($data)->result();


		$query = $this->db->select('*')
					->from('products')
					->or_like($data)->get();
		
		if($query->num_rows()>0) {
			echo json_encode($query->result());
		}
		else {
			echo 0;
		}
	}
}
