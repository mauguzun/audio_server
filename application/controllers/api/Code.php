<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';


class Code extends REST_Controller
{

	function __construct()
	{
		// Construct the parent class
		parent::__construct();
	}

	public function index_post()
	{


		$lang = $this->config->item('language');
		if( isset($_POST['page_name']))
		{


			$text = null;
			if($lang != 'en'){
				$query = $this->Crudmodel->get_joins(
					'pages',[
						"pages_translate"=>"pages.id=pages_translate.page_id and
						 pages_translate.lang_code = '".$lang."'"],"pages.* , pages_translate.text as trans_text",NULL,NULL,[
						"pages.page_name" => $_POST['page_name'],
					]);
				
				
				if(is_array($query) && isset($query[0]) && $query[0]['text']){
					
						$text =  $query[0]['trans_text'] != null ? $query[0]['trans_text'] :   $query[0]['text'];
				}
			
			}
			else
			if(!$text){
				$query = $this->Crudmodel->get_row(['page_name'=>$_POST['page_name']],'pages');
				if($query)
				$text = $query['text'];
			}




			if($text){
				$this->set_response(['action' => true, 'code' => $text], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
				return;

			}

		}

		$this->set_response(['action' => false, 'message' => lang('not_exist')], REST_Controller::HTTP_OK);


	}

}
