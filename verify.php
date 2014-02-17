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

$_SESSION['username'] = $_GET['username'];
$_SESSION['hash'] = $_GET['hash'];



//if submit and yes, verify account

	
$username = $_SESSION['username'];
$hash = $_SESSION['hash'];

$query = mysqli_query($con, "SELECT username, hash, verified FROM Creator 
WHERE username= '". $username. "' AND hash= '".$hash."'");
$rows = mysqli_fetch_array($query);

if ($rows['verified'] == 1){
		echo "<br>It looks like your account has already been verified.<br>";
		echo '<a href="login.php">Click to log in.</a>';
}
elseif ($rows['verified'] == 0 && $username == $rows['username'] && $hash == $rows['hash']) { 
	//if there's an unactivated account matching the username and hash,
	//activate the account
	
	//form that asks user if they want to verify account
	echo "<br>Hello, " . $_SESSION['username'] . "<br>";

	echo "<form action='verified.php' method='post'>";

	echo "Would you like to verify your account?<br>";
	echo "<input type='checkbox' name='act_verify' value='Yes' required>Yes <br><br>";
	echo "<input class='submitLink' type='submit' name= 'verify' value='Verify'> <br>";
	echo "</form>";
} 
 
else {
	echo "<br>Error: Username not found<br>";
	echo '<br><br><a href="register.php">Click to create an account.</a>';
}

	
mysqli_close($con);

?>

</body>
</html>
 

	
