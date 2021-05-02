<?php
  print "Recording visiting IP ".$_SERVER["REMOTE_ADDR"]." in the Database ".$_SERVER["PGDATABASE"]."\n\n";

  # this page returns HTTP 444 to users
  http_response_code(444);
?>