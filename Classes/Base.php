<?php

// MohKari: namespace decleration is fine, but I usually have my base as App, so this
// would be App/Classes ( see my autoload.php )
namespace Classes;

/**
* Base Class
* DataClass is the Class that handle environment of the application and can be use to set API Keys
*/

// MohKari: this is actually ok as a class. I'm not sure why you have called them private and protected though.
// If you make use of my autoload.php, you dont need to has as much logic here.
class Base
{

	// MohKari: this should be called from the env ( see my autoload.php )
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

				exit("API KEY IS REQUIRED IN LIVE ENVIREONMENT.");

			}

		}else
		{
			// set env test key else use default
			$this->apiKey =  getenv('APITESTKEY') ??  self::APIKEY;

		}

	}

}