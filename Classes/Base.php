<?php 

namespace Classes;

/**
* Base Class
* DataClass is the Class that handle environment of the application and can be use to set API Keys
*/
class Base
{

	const APIKEY = 'fc7b7c0956a475de7d47a2a1cd7a9965'; // test API KEY 

	protected $_apiKey  = '';


	function __construct()
	{
		
		$this->setEnv();

	}

	/**
	* This method set the env values 
	*/
	private function setEnv()
	{

		// include .env file to set the env
		$env_file =  dirname(__FILE__, 2). '/.env';
		
		if(file_exists($env_file)) {

		    require $env_file;
			
			// convert all variables within env file into env's
			foreach ($variables as $k => $v) {
			
			    putenv("$k=$v");
			
			}

		}

		

	}

	/*
	* Set the API keys
	*/
	protected function setAPIKey() 
	{
		
		if(getenv('ENV') == 'LIVE'){
		
			$this->apiKey = getenv('APILIVEKEY');

			if(!$this->apiKey)
			{

				exit("API KEY IS REQUIRED IN LIVE ENVIREONMENT. Please set key in .env file");

			}
		
		}else
		{
			// set env test key else use default
			$this->apiKey =  getenv('APITESTKEY') ??  self::APIKEY;

		}

	}

}