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
	public function search_result() {
		$data = array(
			//'title' => $this->input->get('term'),
			'quantity' => $this->input->get('term')
		);
		$query = $this->db->select('row')
					->from('products')
					->where($data)->get();
		
		if($query->num_rows()>0) {
			echo json_encode($query->result());
		}
		else {
			echo 0;
		}
	}

	/**
	 * Update Functionality
	 *
	 * Sorts the table
	 *
	 * @param $r is for Searched_Row
	 * @return $r || 0
	*/
	public function update($r = NULL) {
		if($r != NULL) {
			$this->benchmark->mark('start');
			$this->db->select_min('row');
			$min = ($this->db->get('products')->row()->row)-1;
			$this->db->set('row', $min, FALSE);
			$this->db->where('row', $r);
			$this->db->update('products');
			$this->benchmark->mark('end');
			echo $this->benchmark->elapsed_time('start', 'end');
		}
		else {
			echo 0;
		}
	}

	/**
	 * Update Functionality
	 *
	 * Don't touch row column only update data
	 * Sorts the info of the products
	 *
	 * @param
	 * @return
	*/
	public function update_info($r = NULL) {
		if ($this->input->is_ajax_request()) {
			if($r != NULL) {
				$this->benchmark->mark('cat');
				$this->swap(1,$r);
				$this->swap(5,$r);
				$this->swap(3,5);

				//for($row = $r; $row > $r/2; $row-=2) {
					//$this->swap($r,$r-2);
				//}
				$this->benchmark->mark('dog');

				// $this->benchmark->mark('cat');
				// $this->db->set('row', 0, FALSE);
				// $this->db->where('row', $r);
				// $this->db->update('informations');

				// for ($row=$r; $row > 1; $row-=2) { 
				// 	$this->db->set('row', $row, FALSE);
				// 	$this->db->where('row', $row-2);
				// 	$this->db->update('informations');
				// }
				// $this->db->set('row', 1, FALSE);
				// $this->db->where('row', 0);
				// $this->db->update('informations');
				// $this->benchmark->mark('dog');
				echo $this->benchmark->elapsed_time('cat', 'dog');
				// echo $r;
			}
			else {
				echo 0;
			}
		}
		else {
			show_error("No direct access allowed!");
		}
	}

	/**
	 * Seems unnecessary
	 */
	public function swap($r1 = NULL, $r2 = NULL) {
		if ($this->input->is_ajax_request()) {
			if($r1 != NULL && $r2 != NULL) {
				// get data of the given rows
				$this->db->select('data');
				$this->db->where('row',$r1);
				$this->db->or_where('row',$r2);
				$data = $this->db->get('informations')->result_array();
				
				// slice the array in half
				$len = count($data);
				$r1_data = array_slice($data,0,$len/2);
				$r2_data = array_slice($data,$len/2);

				// build r2
				$col = 0;
				foreach ($r1_data as $key=>$value) {
					$this->db->where(array('row' => $r2, 'col' => $col++));
					$this->db->update('informations', array('data' => $value['data']));
				}

				// build r1
				$col = 0;
				foreach ($r2_data as $key=>$value) {
					$this->db->where(array('row' => $r1, 'col' => $col++));
					$this->db->update('informations', array('data' => $value['data']));
				}
			}
			else {
				echo 'what values you supplied muthafuka!';
			}
		}
		else {
			show_error("No direct access allowed!");
		}
	}
}
