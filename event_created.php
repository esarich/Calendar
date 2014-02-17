
<?php
//start PHP section

//set up connection with database
define('DB_SERVER', 'panther.cs.middlebury.edu');
define('DB_USERNAME', 'esarich');
define('DB_PASSWORD', 'emily');
define('DB_DATABASE', 'esarich_Calendar');

$mysqli = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die("Could not connect");
session_start();


echo '<html>';
echo '<head>';
echo '<link rel="stylesheet" type="text/css" href="main_style.css">';
echo "<link href='http://fonts.googleapis.com/css?family=Spinnaker|Megrim' rel='stylesheet' type='text/css'>";
echo '</head>';

if (isset($_SESSION["username"])){
	echo "<div class='session_head'> Hey " . $_SESSION["name"] . "! <br>";
	echo '<a href="logout.php"> Log out</a> </div>';}
echo "<h2><a href='calendar.php'> MiddCal </a></h2>";
echo "<div class='quote'> \"The best thing about the future is that it comes one day at a time.\" </div> <br><br>";
echo '<title>MiddCal</title>';


$event = $_POST[event_title];
$description = mysqli_real_escape_string($mysqli, $_POST[description]);
$host = $_POST[host];
$date = $_POST[date];
$time = $_POST[time];
$location = $_POST[location];
$tags = strtolower($_POST[tags]);
$currenttime = date("M-d-Y, h:i:s a");
$event_id = time(); //We're using the current time stamp as the event ID
$tags_array = explode(",", $tags);
$user = $_SESSION['username'];

//use prepared statements to insert info about the new event into the database while protecting against 

$stmt = $mysqli ->prepare("INSERT INTO Events (creator_username, event_title, description, host, date, time, location, tags, time_created, event_id) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
if (!$stmt) {
	echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

elseif(!$stmt->bind_param('ssssssssss', $user, $event, $description, $host, $date, $time, $location, $tags, $currenttime, $event_id)){
	echo "Binding parameters failed:(" . $stmt->errno . ")" . $stmt->error;
}


elseif(!$stmt->execute()){
	echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}

else{
	echo '<html>';
	echo '<body>';
	echo 'Congratulations! You created the event "<?php echo $_POST["event_title"]; ?>"<br>';
	echo '<br>';
	echo 'Host: ' . $_POST["host"] . '<br>';
	echo 'Description:  ' . stripslashes($description) . '<br>';
	echo 'Tags: ' . $tags . '<br>';
	echo 'Date: ' . $_POST["date"] . '<br>';
	echo 'Time: ' . $_POST["time"] . '<br>';
	echo 'Location: ' . $_POST["location"] . '<br>';
	echo 'Time Created: ' . $currenttime . '<br> <br>';
	echo '<form action = "event_creation.php">';
	echo '<input class="submitLink" type="submit" value="Create another event"/>';
	echo '</form>';
	echo '</body>';
	echo '</html>';
	foreach ($tags_array as $value) {
		$value = str_replace(" ", "", $value);
		$stmt = $mysqli ->prepare("INSERT INTO Tags (tag, event_id) values (?, ?)");
		if (!$stmt) {
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}

		if(!$stmt->bind_param('ss', $value, $event_id)){
			echo "Binding parameters failed:(" . $stmt->errno . ")" . $stmt->error;
		}
		if(!$stmt->execute()){
			echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
		}
	
	}
}
	
mysql_close($mysqli);
?> 



