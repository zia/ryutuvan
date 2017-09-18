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

		$this->db->from('informations');
		$this->db->order_by("row", "asc");
		$this->db->order_by("col", "asc");
		$data['infos'] = $this->db->get()->result();

		//Footer data
		$footer['title'] = '';

		$this->load->view('layouts/header',$header);
		$this->load->view('home',$data);
		$this->load->view('layouts/footer',$footer);
	}

	public function update ($row = NULL, $col = NULL, $new_value = NULL) {
		$this->db->trans_start();
		$this->db->where(array('row' => $row, 'col' => $col));
		$this->db->update('informations', array('data' => $new_value));
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		    echo 0;
		else {
			$data = $this->calculate($row);
			echo $data;
		}
	}

	public function calculate($row=NULL) {
		if($row) {
			$data['a'] = $this->db->query("SELECT SUM(data) FROM `informations` WHERE row=$row and col%3=0")->unbuffered_row();
			$data['b'] = $this->db->query("SELECT SUM(data) FROM `informations` WHERE row=$row and col%3=1")->unbuffered_row();
			$data['c'] = $this->db->query("SELECT SUM(data) FROM `informations` WHERE row=$row and col%3=2")->unbuffered_row();
		}
		else {
			$data='';
		}
		echo json_encode($data);
	}
}
