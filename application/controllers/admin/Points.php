<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Points extends CI_Controller
{

	protected $controller = 'points';
	public function __construct()
	{
		parent::__construct();
		$this->load->language('front');
		$this->load->library('InputArray');

		if(!$this->ion_auth->is_admin())
		redirect(base_url('auth'));
	}

	public function index()
	{
		$this->load->view('admin/header');


		$this->load->view('admin/table',
			[
				'headers'=>['id','id','title','city','mp3','translate','edit','delete'],
				'url' => base_url().'admin/'.$this->controller.'/ajax',
				'header'=> 'All points'
			]);

		//$this->load->view('admin / video');
		$this->load->view('admin/footer');

	}



	public function edit($id)
	{


		$this->_set_form_validation();

		/*	var_dump($_POST);
		die();*/



		if($this->form_validation->run() === TRUE){

			foreach($_POST['img'] as $img)
			{
				$this->Crudmodel->update_or_insert(
					[
						'img'=>$img,
						'point_id'=>$id
					],'img');

			}
			unset($_POST['img']);

			$this->Crudmodel->update(['id'=>$id],$_POST,$this->controller);

			redirect(base_url().'admin/'.$this->controller);

		}
		else
		{
			$this->data['message'] = $this->display_error($this->form_validation->error_array());

		}

		$query = $this->Crudmodel->get_row(['id'=>$id],$this->controller);
		$this->_set_data($query);
		$this->_set_data_img($query);
		$this->load->view('admin/header');


		$this->data['form_url'] = base_url().'admin/'.$this->controller.'/edit/'.$id;


		$this->load->view('admin/form_extended',$this->data);
		$this->load->view('admin/point_map',['query'=>$query]);

		$this->load->view('admin/footer');


	}


	public function translate ($lang,$id)
	{

		$this->form_validation->set_rules('title','title', 'trim|required');
		$this->form_validation->set_rules('mp3','mp3', 'trim|required');

		if($this->form_validation->run() === TRUE)
		{

			$this->Crudmodel->update_or_insert([
					'point_id'=>$id,
					'lang_code'=>$lang,
					'text'=>$_POST['text'],
					'mp3'=>$_POST['mp3'],
					'lang_code'=>$lang,
					'title'=>$_POST['title']
				],'points_translate');

			redirect(base_url().'admin/'.$this->controller);
		}
		else
		{
			$this->data['message'] = $this->display_error($this->form_validation->error_array());
		}



		$this->data['form_url'] = base_url().'admin/'.$this->controller.'/translate/'.$lang.'/'.$id;
		$translate = $this->Crudmodel->get_row(['point_id'=>$id,'lang_code'=>$lang],'points_translate');
		$this->_set_data($translate);

		$this->load->view('admin/header');
		$this->load->view('admin/form_extended',$this->data);
		$this->load->view('admin/footer');
	}


	public function add()
	{
		$this->load->view('admin/header');


		$this->_set_form_validation();
		$this->_set_data();
		$this->_set_data_img();



		if($this->form_validation->run() === TRUE)
		{






			$postCopy = $_POST;
			unset($postCopy['img']);
			$id = $this->Crudmodel->add($postCopy,$this->controller);

			foreach($_POST['img'] as $img)
			{
				$this->Crudmodel->update_or_insert(
					[
						'img'=>$img,
						'point_id'=>$id
					],'img');

			}
			redirect(base_url().'admin/'.$this->controller);
		}
		else
		{
			$this->data['message'] = $this->display_error($this->form_validation->error_array());
		}



		$this->data['form_url'] = base_url().'admin/'.$this->controller.'/add/';

		$this->load->view('admin/form_extended',$this->data);

		$this->load->view('admin/point_map',$this->data);
		$this->load->view('admin/footer');
	}


	public function ajax()
	{

		// mi berem city


		// me perebiraem jaziki is spiska jazikov ? -> da :)


		$query           = $this->Crudmodel->get_all($this->controller);
		$query_translate = $this->Crudmodel->get_all("points_translate");

		$city            = [];
		foreach($this->Crudmodel->get_all('cities') as $value){
			$city[$value['id']] = $value['title'];
		}


		$translate = [];
		foreach($query_translate as $row){
			if( ! array_key_exists( $row['point_id'] , $translate )  )
			{
				$translate[$row['point_id']] = [];
			}
			$translate[ $row['point_id'] ][$row['lang_code']] = [
				'title'=>$row['title'],
				'mp3'=>$row['mp3'],

			] ;
		}




		$data['data'] = [];
		foreach($query as & $row)
		{
			if( ! array_key_exists( 'translate' , $row )  )
			{
				$row['translate'] = "";
				foreach($this->lang_array(true) as $key=>$lang){

					$title = isset($translate[$row['id']]) &&
					array_key_exists($key,$translate[$row['id']]) ?
					$translate[$row['id']][$key]['title'] . ' | ' . $key :  $key  ." | not translated yet";

					$row['translate'] .= anchor(base_url().'admin/'.$this->controller.'/translate/'.$key.'/'.$row['id'],
						$title )."<br>";
				}
			}


			$line = [];
			array_push(
				$line,
				$row['id'],
				$row['id'],
				$city[$row['city_id']],
				$row['title'],$this->player(base_url().'uploads/'.$row['mp3']),
				$row['translate'],

				anchor(base_url().'admin/'.$this->controller.'/edit/'.$row['id'],"Edit"),
				anchor(base_url().'admin/'.$this->controller.'/delete/'.$row['id'],"delete")



			);
			array_push($data['data'],$line);

		}
		echo json_encode($data);
	}

	public function ajax_upload()
	{

		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = '*';
		$this->load->library('upload',$config);



		if( ! $this->upload->do_upload('file'))
		{
			$this->session->set_flashdata('message', $this->upload->display_errors());
			echo json_encode(['error'=>true,'message'=>$this->upload->display_errors()]);
			return ;
		}
		else
		{
			$upload_data = [ 'upload_data'=> $this->upload->data()];
			echo json_encode([
					'error'=>false,
					'url'=>base_url().'uploads/'.$upload_data['upload_data']['file_name'],
					'file'=>$upload_data['upload_data']['file_name'],
					'ext'=>$upload_data['upload_data']['file_ext'],

				]);
			return;
		}
	}

	protected  function player($audio)
	{

		return
		'
		<audio controls>
		<source src="'.$audio.'" type="audio/ogg">
		<source  src="'.$audio.'" type="audio/mpeg">
		</audio>';

	}


	public function delete($id)
	{
		if($id == 1){
			redirect(base_url().'admin/'.$this->controller);
		}


		$this->Crudmodel->delete(['id'=>$id],$this->controller);

		redirect(base_url().'admin/'.$this->controller);
	}
	private function _set_form_validation()
	{
		$this->form_validation->set_rules('title','title', 'trim|required');
		$this->form_validation->set_rules('lat','lat', 'trim|required');
		$this->form_validation->set_rules('lng','lng', 'trim|required');
		$this->form_validation->set_rules('mp3','mp3', 'trim|required');
		$this->form_validation->set_rules('img[]','img[]', 'trim|required');

	}

	private function _set_data($row = null)
	{

		foreach(['title'] as $input)
		{
			$this->data['controls'][$input] = form_input($this->inputarray->getArray($input,
					'text',$input, isset($row)? $row[$input]:NULL ,TRUE));


		}
		$this->data['controls']['text'] = form_textarea('text',isset($row)? $row['text']:NULL,['placeholder'=>'text']);

		$this->data['controls']['mp3'] = $this->load->view('admin/file_upload',
			[
				'file'=> isset($row)? $row['mp3']:NULL,
				'url'=>base_url().'admin/cities/ajax_upload',
				'name'=>'mp3'

			],true);
	}
	private function _set_data_img($row = NULL)
	{

		$cities = [];

		foreach($this->Crudmodel->get_all('cities') as $value){
			$cities[$value['id']] = $value['title'];
		}



		$this->data['controls']['city_id'] =
		form_dropdown('city_id', $cities,  isset($row) ? $row['city_id'] : NULL   ,[
				'class'=>'selectpicker', 'data-live-search'=>true
			]);



		foreach(['lat','lng'] as $input)
		{
			$this->data['controls'][$input] = form_input($this->inputarray->getArray($input,
					'text',$input, isset($row)? $row[$input]:NULL ,TRUE));


		}

		$imgs = $this->Crudmodel->get_all('img',['point_id'=>$row['id']]);
		$imgs = array_column($imgs,'img');

		$this->data['controls']['img'] = $this->load->view('admin/file_upload_multiupload',
			[
				'file'=> isset($imgs)? $imgs:NULL,
				'url'=>base_url().'admin/cities/ajax_upload',
				'name'=>'img[]'

			],true);


	}



}
