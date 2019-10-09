<?php

/* db_connect()
 * Create a Database Connection String
 * Return ConnectionString
 */

function db_connect() {
  static $connection;

  if (!isset($connection)) {
    $config = parse_ini_file('/var/www/config.ini');
    $connection = mysqli_connect('localhost', $config['username'], $config['password'], $config['dbname']);
  }

  if ($connection == false) {
    return mysqli_connect_error();
  }
  return $connection;
}

function getIPs() {
 $conn = db_connect();
 $stack = array();
 $stmt = $conn-> prepare("SELECT team_id, ip, service_score FROM Team"); 
 $result = $stmt->execute();
 $stmt->bind_result($team_id, $ip, $service_score);
 while ($stmt->fetch()) {
  $arIPs = array("team_id"=>$team_id, "ip" => $ip, "service_score" => $service_score);
  array_push($stack, $arIPs);
 }
 $stmt->close();
 return $stack;
}

function getServiceStatus($team_id, $port){
  $conn = db_connect();
  $stmt = $conn->prepare("SELECT is_active FROM ScoredService 
			  INNER JOIN Service ON ScoredService.service_id = Service.service_id
			  WHERE team_id = ?
		          AND Service.port = ?");
  $stmt->bind_param("is", $team_id, $port);
  $stmt->execute();
  $stmt->bind_result($is_active);
  $stmt->fetch();
  $stmt->close();
  return $is_active;



}

function getAllScores() {
  $conn = db_connect();
  $stack = array();
  $stmt = $conn->prepare("SELECT ip, port, is_active
	  		  FROM Service
			  ORDER BY service_id");
  $result = $stmt->execute();
  $stmt->bind_result($ip, $port, $is_active);
  while ($stmt->fetch()) {
    $arScores = array("ip" => $ip, "port" => $port, "is_active" => $is_active);
    array_push($stack, $arScores);
  
  }
  $stmt->close();
  return $stack;
}



?>
