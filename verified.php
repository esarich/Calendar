<?php session_start(); ?>
<html>

<body>
<?php
//set up connection with database
define('DB_SERVER', 'panther.cs.middlebury.edu');
define('DB_USERNAME', 'esarich');
define('DB_PASSWORD', 'emily');
define('DB_DATABASE', 'esarich_Calendar');

$con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die("Could not connect");

//import fonts and stylesheet
echo '<html>';
echo '<head>';
echo '<link rel="stylesheet" type="text/css" href="main_style.css">';
echo "<link href='http://fonts.googleapis.com/css?family=Spinnaker|Megrim' rel='stylesheet' type='text/css'>";
echo "<br><br><h2><a href='calendar.php'>MiddCal </a></h2>";
echo "<div class='quote'> \"The best thing about the future is that it comes one day at a time.\" </div>";

//show logout option for logged-in users and show header
echo '<title>MiddCal</title>';
echo '</head>';

$sql = ("UPDATE Creator SET verified=1 WHERE username= '". $_SESSION['username']. "' AND hash='".$_SESSION['hash']."'");
		echo '<br>Account has successfully been verified<br><br>';
		echo '<a href="login.php">Click to log in.</a>';
	
	if (!mysqli_query($con, $sql)){
		die('Error: Connection to Database Interrupted! <br>' . mysqli_error($con));
	} 
	
session_destroy();
	
mysqli_close($con);

?>
</body>
</html>
