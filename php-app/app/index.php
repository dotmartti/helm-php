<html>
 <body>
  <h1>
<?php
if (isset($_GET['n'])) {
    echo $_GET['n']*$_GET['n'];
} else {
    echo "please set a variable n to a number you want to square";
}
?>
  </h1>
  <p>
<?php
    print "Your IP address is ".$_SERVER['REMOTE_ADDR']."\n\n";
    print "Database ".$_SERVER["PGDATABASE"]." at ".$_SERVER["PGHOST"]."\n";
?>
  </p>
 </body>
</html>
