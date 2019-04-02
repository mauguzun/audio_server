<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller
{


	public function __construct()
	{

		parent::__construct();
		$this->load->language('front');
		
		
		

	}

	public function index()
	{
		
	
		$this->url = base_url().'point/';

		$this->show_header();
		$this->load->view('front/choose_lang',[
			'url'=>$this->url 
		]);
		
		$this->load->view('front/footer');

	}
}