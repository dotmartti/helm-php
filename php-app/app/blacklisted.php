<?php
  # this page returns HTTP 444 to users, no matter what
  http_response_code(444);

  $connection = pg_connect ("host=".$_SERVER["PGHOST"]." dbname=".$_SERVER["PGDATABASE"]." user=".$_SERVER["PGUSER"]." password=".$_SERVER["PGPASSWORD"]);
  if(!$connection) {
    exit;
  } 

  # create a table to record blocking
  $create = "CREATE TABLE IF NOT EXISTS blocklist (ip varchar(39) PRIMARY KEY";
  $create .= ",path varchar(255), timestamp TIMESTAMP NOT NULL DEFAULT NOW())";
  $result = pg_query($connection, $create);
  if (!$result) {
    exit;
  }
  
  # using HTTP_X_FORWARDED_FOR to not get the nginx, but the client IP
  $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
  $select="SELECT count(1) ip FROM blocklist WHERE ip='".$ipaddress."'";

  # if IP is blocked, then stop all processing
  $result2 = pg_query($connection, $select);
  if (pg_fetch_assoc($result2, 0)['ip'] == "1") {
    exit;
  }

  # insert the ipaddress and path to be blocked
  $path = $_SERVER["REQUEST_URI"];
  $insert="INSERT INTO blocklist VALUES ('".$ipaddress."', '".$path."')";
  $result3 = pg_query($connection, $insert);
  if (!$result3) {
    exit;
  }
?>