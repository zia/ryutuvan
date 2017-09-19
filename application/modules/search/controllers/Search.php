<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Renders Search View
	*/
	public function index() {
		//Header data
		//Page Title
		$header['title'] = '手書入力画面';
		
		//Gather datas for views
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
		$this->load->view('search',$data);
		$this->load->view('layouts/footer',$footer);
	}

	/**
	 * Search Functionality
	 * @param
	 * @return
	*/
	public function search_result($term=NULL) {
		if($term!=NULL) {
			$query = $this->db->select('row')->from('products')->where('quantity',$term)->get()->unbuffered_row();
			if(isset($query)) {
				if($query->row > 1)
					echo json_encode($query);
				else echo -1;
			}
			else echo 0;
		}
	}

	/**
	 * Update Functionality
	 *
	 * Sorts the products table
	 *
	 * @param $r is for Searched_Row
	 * @return $r || 0
	*/
	public function update($r=NULL) {
		if($r!=NULL) {
			$this->db->set('row','NULL',FALSE);
			$this->db->where('row',$r);
			$this->db->update('products');
			for ($row=$r;$row>1;$row-=2) {
				$this->db->set('row',$row,FALSE);
				$this->db->where('row',$row-2);
				$this->db->update('products');
			}
			$this->db->set('row',1,FALSE);
			$this->db->where('row',NULL);
			$this->db->update('products');
			echo $r;
		}
		else echo 0;
	}

	/**
	 * Update Functionality
	 *
	 * Sorts the info of the products
	 *
	 * @param $r is for searched row
	 * @return $r || 0
	*/
	public function update_info($r=NULL) {
		if($r!=NULL) {
			$this->db->set('row','NULL',FALSE);
			$this->db->where('row',$r);
			$this->db->update('informations');
			for ($row=$r;$row>1;$row-=2) { 
				$this->db->set('row',$row,FALSE);
				$this->db->where('row',$row-2);
				$this->db->update('informations');
			}
			$this->db->set('row',1,FALSE);
			$this->db->where('row',NULL);
			$this->db->update('informations');
			echo $r;
		}
		else echo 0;
	}
}
