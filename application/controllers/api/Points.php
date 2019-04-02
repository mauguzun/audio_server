<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';


class Points extends REST_Controller
{
	private $controller = 'points';
	function __construct()
	{
		// Construct the parent class
		parent::__construct();
	}

	public function index_post()
	{


		$lang = $this->config->item('language');
		if( isset($_POST['city'])){

			$missed = 0;
			if($lang != 'en')
			{
				$query = $this->Crudmodel->get_joins(
					$this->controller,[
						"points_translate"=>"points.id=points_translate.point_id and
						points_translate.lang_code = '".$lang."'"],
					"points.* , points_translate.mp3 as mp3_trans,  points_translate.text as text_trans,  points_translate.title as title_trans ",NULL,NULL,["points.city_id" => $_POST['city']]);




				foreach($query as & $value){
					if($value['mp3_trans'] != null)
					{
						$value['mp3'] = $value['mp3_trans'];
					}
					else
					{
						$missed++;
					}

					$value['title'] = ($value['title_trans'] != null) ? $value['title_trans'] : $value['title'];
					$value['text'] = ($value['text_trans'] != null) ? $value['text_trans'] : $value['text'];
					$value['mp3'] = base_url().'uploads/'.$value['mp3'];



					$pimg = $this->Crudmodel->get_all('img',['point_id'=>$value['id']]);
					$value['img'] = array_column($pimg,'img');
					$value['img'] = preg_filter('/^/',  base_url().'uploads/', $value['img']);

					$value['active'] = TRUE;
				}

			}
			else
			{
				$query = $this->Crudmodel->get_all($this->controller,['city_id'=>$_POST['city']]);
				foreach($query as & $value){
					$value['mp3'] = base_url().'uploads/'.$value['mp3'];
					$pimg = $this->Crudmodel->get_all('img',['point_id'=>$value['id']]);
					$value['img'] = array_column($pimg,'img');
					$value['img'] = preg_filter('/^/',  base_url().'uploads/', $value['img']);
					$value['active'] = TRUE;
				}
			}

			$message = ($missed > 0 ) ? lang('not_full_translate')  : NULL ;
			$this->set_response(['action' => true, 'count'=>count($query)  ,  'message' => $message , 'points'=>$query ], REST_Controller::HTTP_OK);
			return ;
		}

		$this->set_response(['action' => false, 'message' => lang('not_exist')], REST_Controller::HTTP_OK);


	}

}
