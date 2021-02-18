<?php

namespace Classes;

// MohKari: should be loaded via autoloader
// Use App/Classes/Base
// I would call this "BaseClass" because you might end up with loads of files called "Base" otherwise.
require_once 'Base.php';

/**
* Data Class
* DataClass is the Class that handle all data response required by application
*/
class Data extends Base
{

	// MohKari: why do some of your methods have _ before them?

	// should be from .env ( in my opinion )
	protected $_url    = 'https://api.openweathermap.org/data/2.5/weather?q={#},uk&units=metric';  // OPEN API URL

	function __construct()
	{

		// this is a bit weird...
		// parent construct just sets "setEnv"
		// then setApiKey just sets the api key...
		// I think it would make more sense to set them both at the same time from the parent
		// if you want to call the "parent" __construct, you can remove __constrcut here
		// because it extends Base, so it would auto call Base.__construct()

		parent::__construct();

		// set API KEY
		$this->setAPIKey();

	}


	/**
	* All API requests are handled by this method
	* @param  string  Search term query to fetch the data .
	* @return array   I
	*/
	public function getForcast($location='london') : array
	{

		$this->_setURL($location);

		// MohKari: not sure if I like this... $this->_requestAPI() will return false OR some data?
		if($response = $this->_requestAPI()){

			// MohKari: good, setting the value, then returning on separate line, easier to debug in future :D
			$response = json_decode($response,true);
			return $response;

		}

		// MohKari: you could of made a "response class" and used that for these
		// Response::error("bad request") ( more classes = you know how to use OOPHP )
		return ['cod'=>400, 'message'=>'Bad Request' ];
	}

	/**
	* Set url and replace the search term
	*/
	private function _setURL($term, $pattern='{#}')
	{

		$url = preg_replace('/'.$pattern.'/', $term, $this->_url);
		$this->_url = $url.'&APPID='.$this->apiKey;

	}

	/**
	* All API requests are handled by this method
	* @return string  Response send by the API
	*/
	private function _requestAPI() {

		// MohKari: there should be an error handler here...
		// Oh, and throwing exceptions is pretty cool too.
		// I can explain exceptions a bit more if you need, but again, it
		// makes it look like you know OOPHP :D

     	// // get the response
        // $response = curl_exec($curl);

        // // get any errors
        // $error = curl_error($curl);

        // // if any errors, set these properties
        // if($error){

        // 	throw new \Exception($error);

        // }else{

        // 	$this->state = "success";
        // 	$this->data = json_decode($response);

        // }

        // // close the curl
        // curl_close($curl);

		$curl = curl_init();

		curl_setopt_array($curl, array(

			CURLOPT_URL => $this->_url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT => 5,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',

		));

		$response = curl_exec($curl);
		$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		curl_close($curl);

		// MohKari: I would put the return on a new line, also, why is it a string?
		// Maybe this should return a Response::error()

		// ERROR HANDLE IN CASE OF FORBIDDEN REQUEST OR API is down
		if($code == 403 || $code == 0 ) {  return '{"cod":"403","message":"Request forbidden"}'; }

		return $response;

	}

	/*
	* Get Cities from json file Have limit it to 6 but can be extended
	*/
	public function getCity($keyword)
	{

		// Array of of matched keyword
		$city_data = [];

		if(trim($keyword) && strlen($keyword)>2) {

			// MohKari: any path to a file should include an absolute path, so like __DIR__.'/Data/gb.json'
			// get list of cities from json file
			$str = file_get_contents('Data/gb.json');

 			$data = json_decode($str,true);

 			$keyword = strtolower(trim($keyword));

 			$i = 0;

			foreach ($data as $res) {

				if(  stripos(strtolower($res['city']),  $keyword) !== FALSE) {

					$city_data[] =  $res['city'];

					if($i == 6) {break;	}

					$i++;

				}
			}

		}

		// return all the cities
		return $city_data;

	}

}

// MohKari: The class was doing well till I got here...
// Classes should do one job. THis class is handling some data, and also handing request.
// this should be refactored into this own class.

// HANDLE FRONTEND DATA

if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST')
{
	// we have input suggest city
	if(!empty($_POST["keyword"]))
	{
		$obj = new Data();

		$cities = $obj->getCity($_POST["keyword"]);

		$li = '';

		if(!empty($cities)) {

			foreach ($cities as $key => $value) {

				$li .= "<a href='report.php?loc={$value}'><li class='city-list'>".$value."</li></a>";

			}

		}else{

			$li .= "<li class='city-list'>No city found.</li>";

		}

		echo $li;
	}
}

?>
