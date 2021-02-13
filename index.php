<!DOCTYPE html>
<html lang="en">
<head>

  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 
  <!-- ATF -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="assets/js/custom.js" defer></script>

</head>
<body>

  <!-- http://api.openweathermap.org/data/2.5/weather?q=London,uk&units=metric&APPID=fc7b7c0956a475de7d47a2a1cd7a9965 -->
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  
  <ul class="navbar-nav">
   <li class="nav-item active">
      <a class="nav-link" href="#">Weather Forecast</a>
    </li>
  </ul>
  
</nav>  

<style type="text/css">
    .forcast-result-container{
      border-radius: 10px;
    margin-top: -20px;
    }
</style>
  
<div class="container-fluid banner-search-img">
	<div class="search-wrapper">
		<div class="col-md-12">	
		<div class="input-group">
		  <input type="search" id="search-city" class="form-control" placeholder="Search" aria-label="Search"
			aria-describedby="search-addon" />
		  <button type="button" class="btn btn-dark">search</button>
		</div>
		</div>
	</div>
</div>

<div class="container">
  <div class="forcast-result-container bg-dark">
      <div class="forcast-header"><span><h4>MON</h4></span> <span><h4>MON</h4></span></div>
      <div class="forcast-body">fsdfsd</div>
  </div>
</div>


<!--BTF -->
</body>
</html>
