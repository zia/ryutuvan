<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	*/
	public function index()
	{
		//Header data
		//Page Title
		$header['title'] = '受注＆欠品入力画面';

		$data['headings'] = $this->db->get('headings')->result();
		$data['subheadings'] = $this->db->get('subheadings')->result();
		$this->db->from('products');
		$this->db->order_by("row", "asc");
		$data['products'] = $this->db->get()->result();
		$data['infos'] = $this->db->get('informations')->result();

		//Footer data
		$footer['title'] = '';

		$this->load->view('layouts/header',$header);
		$this->load->view('home',$data);
		$this->load->view('layouts/footer',$footer);
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

		if($sum < 0) {
			// Remove this if negetive value required.
			$sum = 0;
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

		// Store products in products table
 		$product_data = array(
			$cell => $sum
		);
		// Store infos in informations table
		$array = array('row' => $row, 'col' => $col);
		$info_data = array(
			'data' => $inp
		);

		$this->db->trans_start();
		
		//products
		$this->db->where('id', $product_id);
		$this->db->update('products', $product_data);

		//infos
		$this->db->where($array);
		$this->db->update('informations', $info_data);
		
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
        	return 'transaction_error';
		}
		
		echo json_encode($sum);
	}
}
