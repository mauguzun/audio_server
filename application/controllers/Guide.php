<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guide extends CI_Controller
{


	public function __construct()
	{

		parent::__construct();
		$this->load->language('front');
		
		$this->password();

	}

	public function index($cityid = 1)
	{
		
	

		$this->url = base_url().'/guide/'.$cityid;
		$this->show_header();

		$this->load->view('front/guide',

			[
				'cityid'=>$cityid,
				'lang'=>$this->config->item('language')

			]
		);
		$city = $this->Crudmodel->city_with_count();
		$this->load->view('front/counter',[
			'cities'=>$city,
			
		]);

		$this->load->view('front/footer');

	}
}