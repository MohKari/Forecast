<?php if(!isset($_SESSION)){session_start();} ?>

<?php 

	$loc = $_GET['loc'];
 
 	require 'Classes/Data.php';

 	use Classes\Data as DataClass;

 	$obj =  new DataClass();

	// Call getForcast Method from DataClass and print  response.
	$response = $obj->getForcast($loc);

	if($response['cod'] != 200) {
		
		$_SESSION['flash'] = $response['message'];

		header('Location: '.'index.php');
		exit();
	}


?> 

<?php include 'index.php'; ?>

    <div class="container">
		<div class="forcast-result-container bg-dark p-3">
			
			<div class="forcast-header">
				<h4 class="text-light">Weather Condition: <?= ucwords($response['name'])  ?> <img alt="<?= $response['weather']['0']['description'] ?>" src="http://openweathermap.org/img/w/<?= ucwords($response['weather']['0']['icon'])  ?>.png"> </h4> 
			</div>
			
			<div class="forcast-body">

				<p class="text-light" >Current weather conditions: <?= ucwords($response['weather']['0']['description'])  ?> </p>
				<p class="text-light">The current temperature, in celsius: <?= ucwords($response['main']['temp'])  ?> </p>
				<p class="text-light" >Feels like temperature, in celsius: <?= ucwords($response['main']['feels_like'])  ?> </p>
				<p class="text-light" >Humidity percentage: <?= ucwords($response['main']['humidity'])  ?>% </p>
				<p class="text-light" >Minimum temperature, in celsius: <?= ucwords($response['main']['temp_min'])  ?> </p>
				<p class="text-light" >Maximum temperature, in celsius: <?= $response['main']['temp_max']  ?> </p>
				<p class="text-light" >Wind speed, in miles per hour: <?= $response['wind']['speed']  ?></p>
				
				<?php if(isset($response['rain']['1h'])){ ?>
					<p class="text-light" >Rain volume for the last hour, in millimeters: <?= ucwords($response['rain']['1h'])  ?></p>
				<?php } ?>

			</div>

		</div>
	</div>

</body>
</html>


