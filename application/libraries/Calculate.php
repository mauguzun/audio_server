<?php
/**
* Created by PhpStorm.
* User: maugu
* Date: 11/7/2018
* Time: 2:09 PM
*/

class Calculate
{


	private $_key = "AIzaSyAX50gEvAyz9A6Sh3BMvC9eOblbLLZOses";

	private $_perMinute = 100;
	private $_perMetter = 0.4;

	private $_drivers = null;
	private $_distance = null;
	private $_start = null;
	private $_stop = null;

	public function setStart($start)
	{
		$this->_start = $start;
	}

	public function calculatePrice()
	{
		// cooficient
		return   round ( $this->_perMetter * $this->_distance / 100  , 2) ;
	}


	public function setDistance($distance)
	{
		$this->_distance = $distance;
	}

	/**
	* @param  array $drivers
	*/
	public function setDrivers($drivers)
	{
		$this->_drivers = $drivers;
	}


	public function sortDriver()
	{
		// 1 vse svabodnie
		// 2 vse kto visadit v etam meste
		//
		// todo use queue
	
		$call = [];
		foreach($this->_drivers as $driver){
			if($driver['status'] == 0){
				
				$result = $this->distance($this->_start, "{$driver['lat']},{$driver['lng']}"  );
				//$result['address']= $this->getAddress($driver['lat'],$driver['lng']);

				$call[$driver['user_id']] = $result ;
			} // todo others not bussied

		}
		//var_dump($call);
		
		usort($call,
			function($a, $b)
			{
				return $a['distance'] - $b['distance'];
			});
		// todo get first ? 
		
		// call  ? send notification to driver
		
		return $call;
	

	}

	public function distance($start, $stop)
	{

		$start    = urlencode ( trim($start));
		$stop     = urlencode ( trim($stop));

		$url      = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins={$start}&destinations={$stop}&key=".GOOGLE;
		$responce = file_get_contents($url);
		try
		{
			$obj = json_decode($responce);
			if($obj->status == 'OK'){


				return [
					"duration" => $obj->rows[0]->elements[0]->duration->value,
					"distance" => $obj->rows[0]->elements[0]->distance->value,
				];
			}
		} catch(Exception $ex){
			return null;
		}


	}
	public  function getAddress($lat,$lng)
	{
		$url = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$lat},{$lng}&key=".GOOGLE;
		$data= @file_get_contents($url);

		try
		{
			$obj = json_decode($data);
			if($obj->status == 'OK'){
				return $obj->results[0]->formatted_address;

			}
		} catch(Exception $ex){
			return null;
		}

	}

}