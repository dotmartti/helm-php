<?php
  # this page returns HTTP 444 to users
  http_response_code(444);

  $connection = pg_connect ("host=".$_SERVER["PGHOST"]." dbname=".$_SERVER["PGDATABASE"]." user=".$_SERVER["PGUSER"]." password=".$_SERVER["PGPASSWORD"]);
  if(!$connection) {
    # DEBUG OUTPUT print "ERROR: Connecting the database\n";
    exit;
  } 

  # create a table to record blocking
  $create = "CREATE TABLE IF NOT EXISTS blocklist (ip varchar(39) PRIMARY KEY";
  $create .= ",path varchar(255), timestamp TIMESTAMP NOT NULL DEFAULT NOW())";
  $result = pg_query($connection, $create);
  if (!$result) {
    # DEBUG OUTPUT echo "ERROR: Couldn't create the blocklist table.\n";
    exit;
  }
  
  # if IP is blocked, then stop all processing
  $path = $_SERVER["REQUEST_URI"];
  $ipaddress = $_SERVER["REMOTE_ADDR"];
  $select="SELECT count(1) ip FROM blocklist WHERE ip='".$ipaddress."'";

  $result2 = pg_query($connection, $select);
  # DEBUG OUTPUT echo "query result ".pg_fetch_assoc($result2, 0)['ip']."\n";
  if (pg_fetch_assoc($result2, 0)['ip'] == "1") {
    # DEBUG OUTPUT echo "IP blocked: $ipaddress.\n";
    exit;
  }

  # insert the ipaddress to be blocked
  $insert="INSERT INTO blocklist VALUES ('".$ipaddress."', '".$path."')";
  $result3 = pg_query($connection, $insert);
  if (!$result3) {
    # DEBUG OUTPUT echo "ERROR Couldn't block the IP $ipaddress.\n";
    exit;
  }
?>