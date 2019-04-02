<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{


	public function __construct()
	{

		parent::__construct();
		$this->load->language('front');
		$this->load->language('auth');



	}

	public function index()
	{

		$text = null;
		if(isset($_POST['password']))
		{
			if( trim($_POST['password']) == PASS)
			{

				$this->input->set_cookie("ut",trim($_POST['password']));
				if(isset($_GET['url']))
				{
					redirect($_GET['url']);
				}
				else
				{
					redirect(base_url().'guide');
				}
			}else{
				$text = lang("wrong_pass");
			}

		}
		


		$this->url = base_url().'login/';

		$this->show_header();
		$this->load->view('front/login',['text'=>$text]);

		$this->load->view('front/footer');

	}
}