<?php 

namespace Classes;

require_once 'Base.php';

/**
* Data Class
* DataClass is the Class that handle all data response required by application
*/
class Data extends Base
{

	protected $_url    = 'https://api.openweathermap.org/data/2.5/weather?q={#},uk&units=metric';  // OPEN API URL  

	function __construct()
	{

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
		
		if($response = $this->_requestAPI()){

			$response = json_decode($response,true);
			return $response;

		}

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


// HANDLE FRONTEND DATA 

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
	// we have input suggest city 
	if(!empty($_POST["keyword"])) 
	{
		$m = new Data();
		$p = $m->getCity($_POST["keyword"]);
		$li = '';
		foreach ($p as $key => $value) {
			$li .= "<li >".$value."</li>";
		}
		echo "<ul>".$li."</ul>";
	}	
}

?>
