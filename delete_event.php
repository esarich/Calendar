<?php

define('DB_SERVER', 'panther.cs.middlebury.edu');
define('DB_USERNAME', 'esarich');
define('DB_PASSWORD', 'emily');
define('DB_DATABASE', 'esarich_Calendar');

$con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die("Could not connect");



mysqli_query($con, "DELETE From Events WHERE event_ID=$_POST[event_id]");
mysqli_query($con, "DELETE From Tags WHERE event_ID=$_POST[event_id]");
header('Location: approve_events.php');

mysql_close($con)

?>
