<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$data['headings'] = array (
			'c1' => '上野 001',
			'c2' => '渋谷 001',
			'c3' => '瀬田支店 10000001',
			'c4' => 'サイクル早稲田 708',
			'c5' => '九番店 900'
		);

		$data['subheadings'] = (object) array (
			's1' => 'ｹｰｽ',
			's2' => 'ﾎﾞｰﾙ',
			's3' => 'ﾊﾞﾗ'
		);

		$data['products'] = $this->db->get('products')->result();

		$this->load->view('home',$data);
	}

	/**
	* Stores Results
	*/

	public function update() {
		/**
		* Use echo instead of return
		*/

		$inp = $this->input->post('number');
		$sum = $this->input->post('sum');
		
		$diff = $this->input->post('difference');

		if(isset($diff)) {
			$sum = $sum - $diff;
		}
		else {
			$sum = $sum + $inp;
		}
		
		//$data = array(
			//'total_0' => $sum
		//);

		//$this->db->where('id', 1);
		//$this->db->update('products', $data);

		echo json_encode($sum);
	}
}
