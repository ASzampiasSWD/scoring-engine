<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  include 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="60" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="styles/bootstrap.min.css" type="text/css" />
    <link href="styles/robotoAgain.css" rel="stylesheet" type="text/css" />
	  <link rel="stylesheet" href="styles/font-awesome.min.css" type="text/css" />
    <link rel="stylesheet" href="styles/app.css" type="text/css" />
    <title>Akron CCDC</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light">
      <a class="navbar-brand">Akron CCDC</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link">Home</a>
          </li>
          <li class="nav-item">
            <a href="about.php" class="nav-link">About</a>
          </li>
    	  <li class="nav-item">
            <a href="contact.php" class="nav-link">Contact</a>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" />
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
      </div>
    </nav>
      <section>
    <br /><br />
    <h2 class="teamTableTitle">Web Admin Day - Week 2</h2>
    <table class="table table-dark">
      <thead>
      <tr>
        <th scope="col">IP Address</th>
        <th scope="col">HTTP</th>
        <th scope="col">HTTPS</th>
      </tr>
      </thead>
      <tbody>
  	<?php
	$arIPs = getIPs();
	for ($x = 0; $x < count($arIPs); $x++) {
	  $arIP = $arIPs[$x];
	  echo '<tr><td>' . $arIP["ip"] . '</td>';
          $is_active_http = getServiceStatus($arIP["team_id"], "80");
	  $is_active_https = getServiceStatus($arIP["team_id"], "443");
	  echo 'HTTP: ' . strval($is_active_http);
	  echo 'HTTPS: ' . strval($is_active_https);
	  if (strVal($is_active_http) == "0") {
	    echo '<td style="background-color: red">OFF</td>';
	  } else {
            echo '<td style="background-color: green">ON</td>';
	  }
	  if (strVal($is_active_https) == "0") {
	    echo '<td style="background-color: red" >OFF</td>';
	  } else {
	    echo '<td style="background-color: green">ON</td>';
	  }
	}

	?>
      </tbody>
    </table>
  </div>
</section>
  <footer class="page-footer footer font-small">
			<div class="footer-copyright text-center py-3">© 2019 Copyright:
				<a href="http://amandaszampias.blogspot.com/" target="_blank"> Amanda Szampias</a>
			</div>
	</footer>
    <script src="scripts/jquery-3.3.1.slim.min.js"></script>
    <script src="scripts/popper.min.js"></script>
    <script src="scripts/bootstrap.min.js"></script>
  </body>
</html>
