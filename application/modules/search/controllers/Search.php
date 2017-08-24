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
		
		//$data['products'] = $this->db->get('products')->result();

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

		// Without Live Search
		$query = $this->db->select('*')
					->from('products')
					->or_where($data)->get();

		// Live search..
		// $query = $this->db->select('*')
		// 			->from('products')
		// 			->or_like($data)->get();

		// Check the query
		//echo $this->db->last_query();
		//exit();
		
		if($query->num_rows()>0) {
			// Use with 'WHERE'
			//echo json_encode($query->first_row());
			//echo json_encode($query->unbuffered_row());
			
			// Use with 'LIKE' or 'WHERE' both
			echo json_encode($query->result());
			//echo json_encode($query->result_array());
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
		//Recieved in array format
		$dummy_data = $this->input->post('data');
		
		//I love to work with object..
		$data = (object) $dummy_data[0];

		/**
		* Change the row from bottom. for example; searched row
		* is 7 (which is set to null first), then where row = 5
		* set it row = 7, where row = 3 set it row = 5 and so on..
		*/
		if($data->row > 1) {
			
			//Had to remove relation between tables..
			//Infos need to be updated first..as products
			//depends on info but info dosen't.

			$query = $this->db->get_where('informations', array('row' => $data->row));
			$temp = array();
			if($query->num_rows() > 0) {
				foreach ($query->result() as $key) {
					$temp[] = $key->data;
				}
			}

			for($row=$data->row; $row > 1; $row-=2) {
				$query = $this->db->get_where('informations', array('row' => $row-2));
				if($query->num_rows() > 0) {
					$count = 0;
					foreach ($query->result() as $key) {
						$this->db->set('data', $key->data, FALSE);
						$this->db->where(array('row'=>$row,'col'=> $count++));
						$this->db->update('informations');
					}
				}
			}

			$count = 0;
			for($i=0;$i<count($temp); $i++) {
				$this->db->set('data', $temp[$i], FALSE);
				$this->db->where(array('row'=>$row,'col'=> $count++));
				$this->db->update('informations');
			}

			//Set searched row null..(products)
			$this->db->set('row', 'NULL', FALSE);
			$this->db->where('id', $data->id);
			$this->db->update('products');

			//row alawys odd..
			for ($row=$data->row; $row > 1; $row-=2) { 
				$this->db->set('row', $row, FALSE);
				$this->db->where('row', $row-2);
				$this->db->update('products');
			}

			//Set searched row as row 1..
			$this->db->set('row', 1, FALSE);
			$this->db->where('row', NULL);
			$this->db->update('products');

			echo $data->id;
		}
		else {
			/* No change required for first row */
			echo 'negetive';
		}
	}
}
