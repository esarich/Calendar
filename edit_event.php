
<?php 

//start PHP selection

//set up connection with database
define('DB_SERVER', 'panther.cs.middlebury.edu');
define('DB_USERNAME', 'esarich');
define('DB_PASSWORD', 'emily');
define('DB_DATABASE', 'esarich_Calendar');

$con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die("Could not connect");
session_start();
echo '<html>';
echo '<head>';
echo '<link rel="stylesheet" type="text/css" href="main_style.css">';
echo "<link href='http://fonts.googleapis.com/css?family=Spinnaker|Megrim' rel='stylesheet' type='text/css'>";
if (isset($_SESSION["username"])){
echo "<div class='session_head'> Hey " . $_SESSION["name"] . "! <br>";
echo '<a href="logout.php"> Log out</a> </div>';}
echo "<h2><a href='calendar.php'>MiddCal </a></h2>";
echo "<div class='quote'> \"The best thing about the future is that it comes one day at a time.\" </div><br><br>";
echo '<title>MiddCal</title>';
echo '</head>';

if (isset($_SESSION["name"])){	
	$result = mysqli_query($con, "SELECT * FROM Events WHERE creator_username='" . $_SESSION["username"] . "' AND date >= '" . date('Y-m-d') . "' ORDER BY date, time ASC");
	while ($row = mysqli_fetch_array($result)){
		$condensedTag = str_replace(' ', '', $row['tags']);
		$newTag = str_replace(',', ', ', $condensedTag);
		$originalDate = $row['date'];
		$newDate = date("l, F d", strtotime($originalDate)); //reformatting date
		$originalTime = $row['time'];
		$newTime = date("h:i a", strtotime($originalTime)); //reformatting time	
		echo '<div class="event_title">' . $row['event_title'] . '</div><br>';
		echo "<div class='event'>Description: " . stripslashes($row['description']) . "<br>";	
		echo "Host: " . $row['host'] . "<br>";
		echo "Location: " . $row['location'] . "<br>";
		echo "Date and time: " . $newDate . " at " . $newTime . "<br>";
		echo "Tags: " . $newTag . " </div><br>";
		echo "<html>";
		echo '<form method = "post" action = "edit_event_singular.php">';
		echo '<input class= "submitLink" type ="submit" value="Edit">';
		echo '<input type ="hidden" name = "event_id" value ="' . $row['event_ID'] . '" >';
		echo '<form method = "post" action = "delete_event.php">';
		echo '<input class= "submitLink" type ="submit" value="Delete">';
		echo '<input type ="hidden" name = "event_id" value ="' . $row['event_ID'] . '" >';
		echo "</form> </html><br>";
		echo "<br>";
	}
}

else{ 
	echo "<html>";
	echo "<body><div class='main'>";
	echo "You're not logged into an account! <br><br>";
	echo '<a href="login.php">Login</a>';
	echo '<br><br>';
	echo '<a href="register.php">Sign up</a>';
	echo "</div></body>";
	echo "</html>";
	}



mysql_close($con)
?>




