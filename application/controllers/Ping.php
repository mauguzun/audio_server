<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ping extends CI_Controller
{

	public function __construct()
	{

		parent::__construct();

	}

	public function index()
	{
		
		
		
		if(isset($_GET['text'])){
			$d =  $this->Crudmodel->add(['text'=>$_GET['text'] ],'pings');
			if ($d % 10 == 0){
				echo "audio";
			}else{echo $d;}
		}else{
			echo "get text please";  
		}
			
		
	}
}