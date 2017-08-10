<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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
		$data['headings'] = (object) array (
			'c1' => '百合ヶ丘 000',
			'c2' => '百合ヶ丘 001',
			'c3' => '百合ヶ丘 002',
			'c4' => '百合ヶ丘 003',
			'c5' => '百合ヶ丘 004',
			'c6' => '百合ヶ丘 005'
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
		
		/*
		$data = array(
			'total_0' => $sum
		);

		$this->db->where('id', 1);
		$this->db->update('products', $data);
		*/

		echo json_encode($sum);
	}
}
