<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Cities extends CI_Controller
{

	protected $controller = 'cities';
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
				'headers'=>['id','id','title','img','translate','edit','delete'],
				'url' => base_url().'admin/'.$this->controller.'/ajax',
				'header'=> 'All cities'
			]);

		//$this->load->view('admin / video');
		$this->load->view('admin/footer');

	}



	public function edit($id = null )
	{


		if($id == null ){
				redirect(base_url().'admin/'.$this->controller);
		}

		$this->_set_form_validation();



		if($this->form_validation->run() === TRUE)
		{
			$this->Crudmodel->update(['id'=>$id],['title'=>$_POST['title'],'img'=>$_POST['img']],$this->controller);
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
		$this->load->view('admin/footer');


	}


	public function translate ($lang,$id)
	{

		$this->_set_form_validation();
		$translate = $this->Crudmodel->get_row(['city_id'=>$id,'lang_code'=>$lang],'cities_translate');
		$this->_set_data($translate);

		$this->load->view('admin/header');

		if($this->form_validation->run() === TRUE){

			$this->Crudmodel->update_or_insert([
				'city_id'=>$id,
				'lang_code'=>$lang,
				'title'=>$_POST['title']
			],'cities_translate');
			
			redirect(base_url().'admin/'.$this->controller);
		}
		else
		{
			$this->data['message'] = $this->display_error($this->form_validation->error_array());
		}



		$this->data['form_url'] = base_url().'admin/'.$this->controller.'/translate/'.$lang.'/'.$id;


		$this->load->view('admin/form_extended',$this->data);
		$this->load->view('admin/footer');
	}


	public function add()
	{
		$this->load->view('admin/header');


		$this->_set_form_validation();
		$this->_set_data();
		$this->_set_data_img();


		if($this->form_validation->run() === TRUE){

			$this->Crudmodel->add($_POST,$this->controller);
			redirect(base_url().'admin/'.$this->controller);
		}
		else
		{
			$this->data['message'] = $this->display_error($this->form_validation->error_array());
		}



		$this->data['form_url'] = base_url().'admin/'.$this->controller.'/add/';
		$this->load->view('admin/form_extended',$this->data);

		$this->load->view('admin/footer');
	}


	public function ajax()
	{

		// mi berem city


		// me perebiraem jaziki is spiska jazikov ? -> da :)


		$query           = $this->Crudmodel->get_all($this->controller);
		$query_translate = $this->Crudmodel->get_all("cities_translate");


		$translate       = [];
		foreach($query_translate as $row)
		{
			if( ! array_key_exists( $row['city_id'] , $translate )  ){
				$translate[$row['city_id']] = [];
			}
			$translate[ $row['city_id'] ][$row['lang_code']] = $row['title'];
		}

	
	
	
		$data['data'] = [];
		foreach($query as & $row){
			if( ! array_key_exists( 'translate' , $row )  ){
				$row['translate'] = "";
				foreach($this->lang_array(true) as $key=>$lang)
				{

					$title = isset($translate[$row['id']]) && 
					array_key_exists($key,$translate[$row['id']]) ?
					$translate[$row['id']][$key] . ' | ' . $key :  $key  ." | not translated yet";

					$row['translate'] .= anchor(base_url().'admin/'.$this->controller.'/translate/'.$key.'/'.$row['id'],
						$title )."<br>";
				}
			}


			$line = [];
			array_push(
				$line,
				$row['id'],
				$row['id'],
				$row['title'],
				"<img style='width:90px;'  src='".base_url()."uploads/".$row['img']."' />",
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



		if( ! $this->upload->do_upload('file')){
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


	public function delete($id)
	{
		if($id == 1)
		{
			redirect(base_url().'admin/'.$this->controller);
		}

		
		$this->Crudmodel->delete(['id'=>$id],$this->controller);

		redirect(base_url().'admin/'.$this->controller);
	}
	private function _set_form_validation()
	{
		$this->form_validation->set_rules('title','title', 'trim|required');

	}
	private function _set_data($row = null)
	{


		$this->data['controls']['title'] = form_input($this->inputarray->getArray('title',
				'text','title', isset($row)? $row['title']:NULL ,TRUE));




	}
	private function _set_data_img($row = NULL)
	{
		

		$this->data['controls']['img'] = $this->load->view('admin/file_upload',
			[
				'file'=> isset($row)? $row['img']:NULL,
				'url'=>base_url().'admin/cities/ajax_upload',
				'name'=>'img'

			],true);
	}



}
