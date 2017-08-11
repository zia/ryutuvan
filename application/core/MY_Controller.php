<?php
class MY_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		/**
		* Database Loading Dynamically
		* This is Mother Controller
		*/
		$this->load->helper('url');
		if(base_url() === 'http://localhost/ryutuvan/') {
			$this->load->database('local',TRUE);
		}
		else {
			$this->load->database('global',TRUE);
		}
	}
}