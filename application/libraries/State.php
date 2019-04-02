<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';



use Pushbots\PushbotsClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7;
use Clickatell\Rest;
use Clickatell\ClickatellException;
/**
* Class Ion_auth
*/
class State
{
	private $_error = null;
	private $_table = 'orders';
	public function __construct()
	{
		$this->CI =& get_instance();


		$this->CI->load->model('Crudmodel');

	}

	public function set($id,$status)
	{
		// 1 check status if != 7
		// 3 6 date
		$query = $this->CI->Crudmodel->get_row(['id' =>$id ] , 'orders');
		if($query )
		{

			if($query['status_id'] == $status)
			{

				$this->setError ( "Same status $status : in order $id");
				return false;
			}
			switch($status)
			{
				case 2:
				case 5:


				$order = $this->CI->Crudmodel->get_row(['id' =>$id ] , $this->_table);

				if($status == 2)
				{
					$message = lang("driver_arrived") . PHP_EOL . $order['stop_address'] . PHP_EOL;

				}
				else
				{
					$message = lang("wrong_location") . PHP_EOL . $order['stop_address'] . PHP_EOL;

				}


				$this->sendMessages($order,$status,$message);
				break;

				case 3:

				$this->CI->Crudmodel->update(['id' =>$id ],['status_id'=>$status,'start_time'=>date("Y-m-d H:i:s"),'stop_time'=>NULL] , 'orders');
				break;

				case 6:
				$this->CI->Crudmodel->update(['id' =>$id ],['status_id'=>$status,'stop_time'=>date("Y-m-d H:i:s")] , 'orders');
				break;

				default:
				$this->CI->Crudmodel->update(['id' =>$id ],['status_id'=>$status] , 'orders');

			}

			return TRUE;


		}

		$this->setError ( "Not have row with curretn id $id");
		return false;


	}
	private function sendMessages( $order  , $status ,$message)
	{
		$client     = new PushbotsClient(PUSH_ID, PUSH_SECRET);
		$clickatell = new \Clickatell\Rest(CLICKATELL);


		try
		{
			
			$push_notification = $client->campaign->alias($order['phone'], $message);
			$sms               = $clickatell->sendMessage(['to' => [$order['phone']], 'content' => $message . URLAPP]);
			$this->CI->Crudmodel->update(['id' =>$order['id'] ], ['status_id' => $status], 'orders');

		} catch(Exception $e){
			$this->setError( $e->getMessage());
			return FALSE;
		}
	}

	public function time_diff($date)
	{

		$date1 = strtotime ($date);
		$date2 = time();
		$mins  = ($date2 - $date1) / 60;
		return $mins;
	}

	/**
	* string
	* @param undefined $error
	*
	* @return
	*/
	private function setError($error)
	{
		$this->_error = $error;

		log_message('error', $this->_error);

	}
	public function getError()
	{
		return $this->_error;
	}

}
