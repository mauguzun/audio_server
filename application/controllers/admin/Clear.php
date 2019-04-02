<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Clear extends CI_Controller
{

	protected $controller = 'points';
	public function __construct()
	{
		parent::__construct();
		if(!$this->ion_auth->is_admin())
		redirect(base_url('auth'));

	}

	public function index()
	{
		$this->load->view('admin/header');
		
		$query = $this->Crudmodel->get_all("img");
		$imgs  = array_column($query,'img');
		
		$query = $this->Crudmodel->get_all("points");
		$audio  = array_column($query,'mp3');


		
		foreach(scandir("uploads") as $value)
		{
			if(in_array($value,$imgs)| in_array($value,$audio)){
				
			}else{
				@unlink("uploads/".$value);
				echo $value;
			}
			
		}
		$this->load->view('admin/footer');
	}




}
