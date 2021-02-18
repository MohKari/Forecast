<?php if(!isset($_SESSION)){session_start();} ?>
<!DOCTYPE html>
<html lang="en">
  <head>

    <title>Weather Forcast</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- MohKari: CDN's good stuff. -->
    <!-- ATF -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="assets/js/custom.js" defer></script>


  </head>
<body>

  <nav class="navbar navbar-expand-sm bg-dark navbar-dark">

    <ul class="navbar-nav">
      <li class="nav-item active">
      <a class="nav-link" href="index.php">Weather Forecast</a>
      </li>
    </ul>

  </nav>

    <div class="container-fluid banner-search-img">

      <div class="search-wrapper">

        <div class="col-md-12">

          <div class="input-group">

            <input type="search" id="search-city" class="form-control" placeholder="Search" />

            <button type="button" class="btn btn-dark"><i class="fas fa-search"></i></button>

          </div>

          <div id="suggesstion-box" class="d-none" style="background: background: #f0f0f0">
            <ul class='p-3' id='city' ></ul>
          </div>

           <?php

            if(isset($_SESSION['flash'])){?>

              <div class="alert alert-danger mt-5" role="alert">

                <?php echo $_SESSION['flash']; unset($_SESSION['flash']); ?>

                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

               </div>

          <?php } ?>

        </div>


      </div>

    </div>


