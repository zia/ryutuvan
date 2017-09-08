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
		//Header data
		//Page Title
		$header['title'] = '手書入力画面';
		
		//Gather datas for views
		$data['headings'] = $this->db->get('headings')->result();
		$data['subheadings'] = $this->db->get('subheadings')->result();
		$this->db->from('products');
		$this->db->order_by("row", "asc");
		$data['products'] = $this->db->get()->result();
		$data['infos'] = $this->db->get('informations')->result();

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
			'title' => $this->input->get('term'),
			'quantity' => $this->input->get('term')
		);
		$query = $this->db->select('row')
					->from('products')
					->or_where($data)->get();
		
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
	* @param
	* @return
	*/
	public function update() {
		$dummy_data = $this->input->get('data');
		$data = (object) $dummy_data[0];

		if($data->row > 1) {
			$this->db->set('row', -1, FALSE);
			$this->db->where('row', $data->row);
			$this->db->update('products');
			for ($row=$data->row; $row > 1; $row-=2) { 
				$this->db->set('row', $row, FALSE);
				$this->db->where('row', $row-2);
				$this->db->update('products');
			}
			$this->db->set('row', 1, FALSE);
			$this->db->where('row', -1);
			$this->db->update('products');
			echo $data->row;
		}
		else {
			/* No change required for first row */
			echo 0;
		}
	}

	/**
	* Update Functionality
	*
	* Sorts the info of the products
	*
	* @param
	* @return
	*/
	public function update_info() {
		
		$this->db->select('data');
		$this->db->from('informations');
		$this->db->where('informations.row <= ', 5);
		$this->db->join('products', 'products.row = informations.row');
		$query = $this->db->get()->result();
		$temp = array();
		$c= $r = 0;
		foreach ($query as $key => $value) {
			$temp[$r][$c] = $value->data;
			$c++;
			if($c==21) {
				$r++;$c=0;
			}
		}
		$count= 0;
		for($r=0;$r<2;$r++) {
			for($c=$count;$c<=$count+20;$c++) {
				if ($temp[$r][$c] != $temp[$r+1][$c]) {
					$this->db->select('data');
					$this->db->from('informations');
					$this->db->where(array('row'=>3,'col'=>5));
					$row = $this->db->get()->row();

					echo $row->data;
				}
			}
			$count=0;
			echo "<hr>";
		}
		//echo '<pre>';
		//print_r($temp);
		//echo "</pre>";
		exit();

		$dummy_data = $this->input->get('data');
		$data = (object) $dummy_data[0];

		if($data->row > 1) {
			$ret = 0;
			$this->db->select('data');
			$this->db->from('informations');
			$this->db->where('row', $data->row);
			$query = $this->db->get();

			$temp = array();
			foreach ($query->result() as $key) {
				$temp[] = $key->data;
			}

			for($row=$data->row;$row>1;$row-=2) {
				$this->db->select('data');
				$this->db->from('informations');
				$this->db->where('row', $row-2);
				$query = $this->db->get();
				$count = 0;
				foreach ($query->result() as $key) {
					$this->db->set('data', $key->data, FALSE);
					$this->db->where(array('row'=>$row,'col'=> $count++));
					$this->db->update('informations');
				}
			}

			for($i=0;$i<count($temp); $i++) {
				$this->db->set('data', $temp[$i], FALSE);
				$this->db->where(array('row'=>$row,'col'=> $i));
				$this->db->update('informations');
			}

			$ret = 1;
		}
		else {
			$ret = 0;
		}
		echo $ret;
	}
}
