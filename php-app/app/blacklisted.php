<?php
  # this page returns HTTP 444 to users
  http_response_code(444);

  $connection = pg_connect ("host=".$_SERVER["PGHOST"]." dbname=".$_SERVER["PGDATABASE"]." user=".$_SERVER["PGUSER"]." password=".$_SERVER["PGPASSWORD"]);
  if($connection) {
    print "connected\n";
  } else {
    print "there has been an error connecting\n";
  } 
  print "Recording visiting IP ".$_SERVER["REMOTE_ADDR"]." in the Database ".$_SERVER["PGDATABASE"]."\n\n";

  
?>