<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	*/
	public function index()
	{
		$data['headings'] = $this->db->get('headings')->result();

		$data['subheadings'] = $this->db->get('subheadings')->result();

		$data['products'] = $this->db->get('products')->result();

		$data['infos'] = $this->db->get('informations')->result();

		$this->load->view('home',$data);
	}

	
	/**
	 * Updates info
	 *
	 * @param
	 * @return $sum
	*/
	public function update() {

		//Input
		$inp = $this->input->post('number');
		//row
		$row = $this->input->post('row');
		//column
		$col = $this->input->post('col');
		//product_id
		$product_id = $this->input->post('product');
		//To be written in
		$write = $this->input->post('write');
		//Existing summation value
		$sum = $this->input->post('sum');
		//If new value is smaller than the previous one
		$decreased_diff = $this->input->post('decreased_difference');
		//If new value is greater than the previous one
		$increased_diff = $this->input->post('increased_difference');

		if(isset($decreased_diff)) {
			//Decreased difference needs to be deducted
			$sum = $sum - $decreased_diff;
		}
		elseif (isset($increased_diff)) {
			//Increased difference needs to be added
			$sum = $sum + $increased_diff;
		}
		else {
			//If the difference is 0 or new and old cell value are same
			//For new value just add with the previous one
			$sum = $sum + $inp;
		}
		
		
		//Store summation in products
		if ($write === 'a') {
			$cell = 'total_0';
		}
		elseif ($write === 'b') {
			$cell = 'total_1';
		}
		else {
			$cell = 'total_2';
		}

		$data = array(
			$cell => $sum
		);

		$this->db->trans_start();
		$this->db->where('id', $product_id);
		$this->db->update('products', $data);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
        	return 'product_error';
		}
		//Storing in products ends

		
		//Store infos in informations
		$array = array('row' => $row, 'col' => $col);
		$data = array(
			'data' => $inp
		);
		$this->db->trans_start();
		$this->db->where($array);
		$this->db->update('informations', $data);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
        	return 'information_error';
		}
		//storing infos ends
		
		echo json_encode($sum);
	}
}
