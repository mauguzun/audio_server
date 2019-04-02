<?php
/**
* CodeIgniter
*
* An open source application development framework for PHP
*
* This content is released under the MIT License (MIT)
*
* Copyright (c) 2014 - 2018, British Columbia Institute of Technology
*
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* The above copyright notice and this permission notice shall be included in
* all copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
* THE SOFTWARE.
*
* @package	CodeIgniter
* @author	EllisLab Dev Team
* @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
* @copyright	Copyright (c) 2014 - 2018, British Columbia Institute of Technology (https://bcit.ca/)
* @license	https://opensource.org/licenses/MIT	MIT License
* @link	https://codeigniter.com
* @since	Version 1.0.0
* @filesource
*/
date_default_timezone_set('Europe/Riga');
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Application Controller Class
*
* This class object is the super class that every library in
* CodeIgniter will be assigned to.
*
* @package		CodeIgniter
* @subpackage	Libraries
* @category	Libraries
* @author		EllisLab Dev Team
* @link		https://codeigniter.com/user_guide/general/controllers.html
*/
class CI_Controller
{

	/**
	* Reference to the CI singleton
	*
	* @var	object
	*/
	private static $instance;


	protected $title ;
	protected $desc ;
	protected $url ;
	/**
	* Class constructor
	*
	* @return	void
	*/
	public function __construct()
	{



		self::$instance =& $this;



		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach(is_loaded() as $var => $class){
			$this->$var =& load_class($class);
		}



		//  remember

		/*   if (isset($_POST['lang'])) {
		if (in_array($_POST['lang'], $this->_allowed)) {
		$this->config->set_item('language', $_POST['lang']);

		}
		unset($_POST['lang']);
		}*/

		$this->load =& load_class('Loader', 'core');
		$this->load->initialize();
		$this->_front_lang();
		log_message('info', 'Controller Class Initialized');
		$this->title = lang('title');
		$this->desc = lang('desc');
		$this->url = base_url();
	}

	// --------------------------------------------------------------------

	/**
	* Get the CI singleton
	*
	* @static
	* @return	object
	*/
	public static function & get_instance()
	{
		return self::$instance;
	}

	private function _front_lang()
	{


		if(isset($_GET['lang']) && array_key_exists($_GET['lang'],$this->lang_array())   )
		{
			$this->config->set_item('language',$_GET['lang']);
			$this->session->set_userdata('language' , $_GET['lang']);
		}
		else
		if( is_array($this->session->userdata) && array_key_exists('language',$this->session->userdata) )
		{
			$this->config->set_item('language',$this->session->userdata('language'));
		}
		else
		{
			$this->config->set_item('language','en');
			$this->session->set_userdata('language' ,'en');
		}
	}


	protected function display_error($error)
	{
		$res = "";
		foreach($error as $key=>$value){
			$res .= $key . " - " .$value . "<br> ";
		}
		return $res;
	}
	protected function lang_array($disableDefault = false)
	{


		$langs =
		[
			'en'=>'English',
			'fr'=>'Français',
			'ru'=>'Русский',
			'lv'=>'Latviešu valoda'
		];

		if($disableDefault)
		{
			unset($langs['en']);
			return $langs;
		}
		else
		{
			return $langs;
		}
	}

	protected function password()
	{
		if($this->input->cookie('ut') != PASS)
		{
			$redirectBack = current_url() . '?' . $_SERVER['QUERY_STRING'];
			redirect(base_url().'/login?url='.$redirectBack);
		}


	}

	protected function show_header()
	{
		$this->load->view('front/header',
			[
				'current_lang'=> $this->config->item('language'),
				'langs'=>$this->lang_array(),
				'url'=>$this->url,
				'title'=>$this->title,
				'desc'=>$this->desc
			]

		);
	}

}
