<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';


class Cities extends REST_Controller
{

	private $controller = 'cities';
	function __construct()
	{
		// Construct the parent class
		parent::__construct();
	}

	public function index_post()
	{


		$lang = $this->config->item('language');




		if($lang != 'en'){
			$query = $this->Crudmodel->get_joins(
				'cities',[
					"cities_translate"=>"cities.id=cities_translate.city_id and
					cities_translate.lang_code = '".$lang."'"],
				"cities.* , cities_translate.title as trans_title ",NULL,NULL,[
				]);

			foreach($query as & $value){
				$value['title'] = ($value['trans_title'] != null) ? $value['trans_title'] : $value['title'];
				$value['img'] = base_url().'uploads/'.$value['img'];
			}
		}
		else
		{
			$query = $this->Crudmodel->get_all($this->controller);
			foreach($query as & $value){
				$value['img'] = base_url().'uploads/'.$value['img'];
			}
		}


		if($query){
			$this->set_response(['action' => true, 'code' => $query], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			return;

		}
		else
		{
			$this->set_response(['action' => false, 'message' => lang('not_exist')], REST_Controller::HTTP_OK);

		}





	}

}
