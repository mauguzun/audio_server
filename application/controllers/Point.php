<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Point extends CI_Controller
{


	public function __construct()
	{

		parent::__construct();
		$this->load->language('front');
		$this->password();
	}

	public function index($id = 213)
	{





		if($this->config->item('language') != 'en'){
			$point = $this->Crudmodel->get_joins('points',["points_translate"=>"points.id=points_translate.point_id and points_translate.lang_code = '".$this->config->item('language')."'"], "points.* , points_translate.mp3 as mp3_trans ,  points_translate.text as text_trans,  points_translate.title as title_trans ",NULL,NULL,["points.id" => $id]);
			if(is_array($point) && array_key_exists(0,$point)){
				$point = $point[0];
				$point['title'] = ($point['title_trans'] != null) ? $point['title_trans'] : $point['title'];
				$point['text'] = ($point['text_trans'] != null) ? $point['text_trans'] : $point['text'];
				$point['mp3'] = ($point['mp3_trans'] != null) ? $point['mp3_trans'] : $point['mp3'];

			}
			else
			{
				$point = null;
			}


		}
		else
		{
			$point = $this->Crudmodel->get_row(['id'=>$id],'points');
		}
		

		
		
		// get other Points
		if($point != null)
		{

			if($this->config->item('language') != 'en'){
				$points = $this->Crudmodel->get_joins(
					'points',[ "points_translate"=>"points.id=points_translate.point_id
						and points_translate.lang_code = '".$this->config->item('language')."'"], "points.* ,
					, points_translate.title as title_trans ",NULL,NULL,["points.city_id" => $point['city_id']]);




				foreach($points as & $value)
				{
					$value['title'] = ($value['title_trans'] != null) ? $value['title_trans'] : $value['title'].$value['id'];
				}

			}
			else
			{
				$points = $this->Crudmodel->get_all('points',['city_id'=>$point['city_id']]);
			}


		}

		$imgs = $this->Crudmodel->get_all('img',['point_id'=>$id]);
		$point['img'] = array_column($imgs,'img');	
		
	
			
		foreach($points as &$one){
			$pimg = $this->Crudmodel->get_all('img',['point_id'=>$one['id']]);
			$one['img'] = array_column($pimg,'img');		
		}
		
		

		$city = $this->Crudmodel->city_with_count($this->config->item('language'));


		if(!$point)
		{
			redirect(base_url());
		}
		
		

		$this->title = $point['title'];
		$this->desc = $point['text'];
		$this->url = base_url();

		$this->show_header();

		$this->load->view('front/point',[
				'point'=>$point,
				'city'=>$city
			]);







		$this->load->view('front/gallery',['points'=>$points]);
		$this->load->view('front/selector',['points'=>$points , 'point'=>$point]);
		$this->load->view('front/counter',['cities'=>$city]);

		$this->load->view('front/footer');




	}
}