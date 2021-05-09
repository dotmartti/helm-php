<?php
  # 
  $connection = pg_connect ("host=".$_SERVER["PGHOSTREAD"]." dbname=".$_SERVER["PGDATABASE"]." user=".$_SERVER["PGUSER"]." password=".$_SERVER["PGPASSWORD"]);
  if(!$connection) {
    # let's not continue when we cannot verify the IP from the database
    exit;
  }

  # using HTTP_X_FORWARDED_FOR to not get the nginx, but the actual client IP
  $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
  $select="SELECT count(1) ip FROM blocklist WHERE ip='".$ipaddress."'";

  # send an email to notify of visitors
  ini_set( 'display_errors', 1 );
  error_reporting( E_ALL );
  $to_email = "martti.remmelgas@gmail.com";
  $subject = "Testing dotmartti/helm-php project";
  $message = "Visitor from: $ipaddress";
  $mail_result = mail($to_email,$subject,$message);
  
  # if IP is blocked, then stop all processing
  $result2 = pg_query($connection, $select);

  # only deal with query, when we actually have some IPs blocked (table exists)
  if ($result2) {
    if (pg_fetch_assoc($result2, 0)['ip'] == "1") {
      http_response_code(403);
      echo "Your IP is blocked!";
      exit;
    }
  }

  if (isset($_GET['n']) && is_numeric($_GET['n'])) {
      echo $_GET['n']*$_GET['n'];
  } else {
      echo "please set a variable n to a number you want to square";
  }
?>
