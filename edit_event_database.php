<?php

define('DB_SERVER', 'panther.cs.middlebury.edu');
define('DB_USERNAME', 'esarich');
define('DB_PASSWORD', 'emily');
define('DB_DATABASE', 'esarich_Calendar');

$mysqli = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die("Could not connect");

session_start();
if (isset($_SESSION["name"])){	
echo "Hi " . $_SESSION["name"] . "! Your event has been updated!<br>";
}
else 
	echo "OPEN THE POD BAY DOOR, HAL!";


$tags = str_replace(' ', '', $_POST[tags]);
$tags = strtolower($tags);
//split tags into an array
$tags_array = explode(",", $tags);
$location = strtolower($_POST[location]);
$location = ucwords($location);
$event = $_POST[event_title];
$description = $_POST[description];
$host = $_POST[host];
$date = $_POST[date];
$time = $_POST[time];
$event_id = $_POST[event_id];

//prepared statements protect against the possibility of an sql injection
$stmt = $mysqli ->prepare("UPDATE Events SET event_title = ?, description = ?, host = ?, date = ?, time = ?, location = ?, tags = ?, approved = 0 WHERE event_ID = $_POST[event_id]"); 

if (!$stmt) {
	echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

if(!$stmt->bind_param('sssssss', $event, $description, $host, $date, $time, $location, $tags)){
	echo "Binding parameters failed:(" . $stmt->errno . ")" . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}

//delete old tags from the tags table
if (!mysqli_query($mysqli, "DELETE FROM Tags WHERE event_ID=$_POST[event_id]")){
	die('Error: ' . mysqli_error($mysqli));
}

//insert new tags
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
//send the user back to the edit event page-they won't ever actually see this 
$urlBack = 'edit_event.php';
echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$urlBack.'">'; 


mysql_close($mysqli)

?>
