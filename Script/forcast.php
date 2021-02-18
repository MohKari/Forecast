<?php

###############################################################
#   ******* FORCAST SCRIPTS *******		                      #
# This script is anly allowed to run from CLI                 #
# Can be run directly from roon folder of application         #
# Command  php Script/forcast.php                             #
# *************************************************           #
# 1) The Script will prompt for location.                     #
# 2) On entering correct location will show weather condition #
###############################################################

// MohKari: Your namespace should be "Script", to match the directory it is inside
namespace Scripts;

// MohKari: Don't need any of this with auto loading
$root_dir = dirname(__FILE__, 2);

require $root_dir.'/Classes/Data.php';

use Classes\Data as DataClass;

	// If request is from http exit as we only want this to be run from cli
	if(isset($_SERVER['REQUEST_METHOD'])){

		echo "Access Forbiden";
		exit();

	}

	// MohKari: this whole file is procedural. As stupid as it sounds, you just needed to wrap this crap up in a class
	// So, once this is a class, you would give it a method called "run" or something, and then from your cli you would be like
	// 'php run-script.php' ( btw, you dont need to include the .php part on the script file ). the 'run-script.php' would
	// just initiate this class, and then execute the run method. The reason we want to do it as a class is because you can then
	// "easily" run this logic from anywhere by creating a new this class and running the method.

	// Innitiate the script by Fetching the location
	getValue();

	/**
	* This function gets the Location value from command line
	*/
	function getValue()
	{

		echo "Enter Location : \n";

		// handle user input
		$handle = fopen ("php://stdin","r");

		// trim the spaces and convert to lowercase to handle commands.
		$entered_value = strtolower(trim(fgets($handle)));

		if($entered_value == null || $entered_value == ' '  ){

		    echo "We require location OR you can can type quit to exit.  \n ";

		    getValue();
		    exit();

		}
		elseif ($entered_value == 'quit') {
			// Exit the function
			abort();

		}

		// Get forcast if value is entered.
		getForcast($entered_value);

	}

	/**
	* This function gets the Location value from command line.
	* @param string User entered value.
	*/
	function getForcast($entered_value)
	{

		$obj =  new DataClass();

		// Call getForcast Method from DataClass and print  response.
		$response = $obj->getForcast($entered_value);

		// If Location entered is valid and we have successfull response
		if(!empty($response) && $response['cod'] == 200){

			echo "\n ** Weather Conditions For ".strtoupper($entered_value)." *** \n";

			echo "Current weather conditions: {$response['weather']['0']['main'] } \n";

			echo "The current temperature, in celsius: {$response['main']['temp']} \n";

			echo "Feels like temperature, in celsius: {$response['main']['feels_like']} \n";

			echo "Humidity percentage: {$response['main']['humidity']}% \n";

			echo "Minimum temperature, in celsius: {$response['main']['temp_min']} \n";

			echo "Maximum temperature, in celsius: {$response['main']['temp_max']} \n";

			echo "Wind speed, in miles per hour: {$response['wind']['speed']} \n";

			if(isset($response['rain']['1h'])){

				echo "Rain volume for the last hour, in millimeters: {$response['main']['humidity']} \n";

			}

			echo "******************************************** \n";

		}else{

			echo "ERROR: ". strtoupper($response['message']). "\n";
		}

		// User can either Abort or can continue with new location.
		echo "\n You can enter new location OR you can can type quit to exit.  \n ";
		getValue();

	}

	/**
	* This function abort the script..
	*/
	function abort()
	{
		echo "\n";
		echo "Thank you, ABORTING...\n";
		exit();

	}



?>