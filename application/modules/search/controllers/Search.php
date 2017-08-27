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
		//Gather datas..
		$data['headings'] = $this->db->get('headings')->result();
		$data['subheadings'] = $this->db->get('subheadings')->result();

		$this->db->from('products');
		$this->db->order_by("row", "asc");
		$data['products'] = $this->db->get()->result();
		
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
		$query = $this->db->select('id,row')
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
		//$searched_row = 5;
		//$count = $this->db->count_all('headings')*3;

		//$this->db->select('data');
		//$this->db->from('products');
		//$this->db->where('informations.row <= ', $searched_row);
		//$this->db->join('informations', 'informations.row = products.row');

		//$query = $this->db->get()->result();

		//echo '<pre>';
		//print_r($query);
		//echo '</pre>';

		//for ($i=0;$i<count($query);$i++) {
			//echo $query[$i]->data.'<br>';
			//for($j=0;$j<$count;$j++) {
				//echo '&nbsp;&nbsp;&nbsp;'.$query[$j]->data.'<br>';
			//}
		//}

		//exit();

		$dummy_data = $this->input->post('data');
		$data = (object) $dummy_data[0];
		if($data->row > 1) {
			$this->db->select('data');
			$this->db->from('informations');
			$this->db->where('row', $data->row);
			$query = $this->db->get();

			$temp = array();
			foreach ($query->result() as $key) {
				$temp[] = $key->data;
			}

			for($row=$data->row; $row > 1; $row-=2) {
				
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

			//Set searched row -1..(products)
			$this->db->set('row', -1, FALSE);
			$this->db->where('row', $data->row);
			$this->db->update('products');

			//row alawys odd..
			for ($row=$data->row; $row > 1; $row-=2) { 
				$this->db->set('row', $row, FALSE);
				$this->db->where('row', $row-2);
				$this->db->update('products');
			}

			//Set searched row as row 1..
			$this->db->set('row', 1, FALSE);
			$this->db->where('row', -1);
			$this->db->update('products');

			echo 1;
		}
		else {
			/* No change required for first row */
			echo 0;
		}
	}
}
