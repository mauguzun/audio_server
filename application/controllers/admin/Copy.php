<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Copy extends CI_Controller
{

	protected $url = "";
	protected $default_audio = "";

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{

		$data = json_decode(file_get_contents("http://tricypolitain.com/api/copy_list"))   ;

		echo "<ol>";
		foreach($data->data as $row){

			echo  "<li><a href='".base_url().'/admin/copy/make/'.$row[0]."'>".$row[4]->en->title."</a></li>";

		}
		echo "</ol>";
	}
	public function make($id)
	{
		$data = json_decode(file_get_contents("http://tricypolitain.com/api/copy_list"))   ;
		foreach($data->data as $row){

			if($row[0] == $id ){

				var_dump( $row[3] );

				$name    = $row[0].'.png';
				$audio   = 'fr.mp3';

				$lat     = $row[1];
				$lng     = $row[2];
				$city_id = 1;

				$title   = $row[4]->en->title;
				$text    = $row[4]->en->text;


				$id      = $this->Crudmodel->add([
						'city_id'=>$city_id,
						'lat'=>$lat,
						'lng'=>$lng,
						'title'=>$title,
						'text'=>$text,
						'mp3'=>$audio,
						'img'=>$name,
					],'points');

				foreach($row[3] as $key=>$value)
				{
					$img = $this->saveImg($value,$key.$name);
					$this->Crudmodel->update_or_insert(['point_id'=>$id,'img'=>$key.$name],'img');
				}

				foreach(['lv','ru','fr'] as $code){

					if(!isset($row[4]->$code))
					continue;

					$title = $row[4]->$code->title;
					$text  = $row[4]->$code->text;



					echo 	$this->Crudmodel->add([
							'mp3'=>$audio,
							'lang_code'=>$code,
							'point_id'=>$id,
							'title'=>$title,
							'text'=>$text,

						],'points_translate');
				}


			}


		}
	}
	public function saveImg($data,$name)
	{


		list($type, $data) = explode(';', $data);
		list(, $data) = explode(',', $data);
		$data = base64_decode($data);

		file_put_contents('./uploads/'.$name, $data);

	}


}
