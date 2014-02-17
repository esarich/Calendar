<?php
session_start();

define('DB_SERVER', 'panther.cs.middlebury.edu');
define('DB_USERNAME', 'esarich');
define('DB_PASSWORD', 'emily');
define('DB_DATABASE', 'esarich_Calendar');
//connect to database
$mysqli = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die("Could not connect");

//import texts 
echo '<html>';
echo '<head>';
echo '<link rel="stylesheet" type="text/css" href="main_style.css">';
echo "<link href='http://fonts.googleapis.com/css?family=Spinnaker|Megrim' rel='stylesheet' type='text/css'>";

//give logged-in users the option to log out
if (isset($_SESSION["username"])){
echo "<div class='session_head'> Hey " . $_SESSION["name"] . "! <br>";
echo '<a href="logout.php"> Log out</a> </div>';}

//add header
echo "<h2><a href='calendar.php'>MiddCal </a></h2>";
echo "<div class='quote'> \"The best thing about the future is that it comes one day at a time.\" </div> <br><br>";
echo '<title>MiddCal</title>';
echo '</head>';
$entered_text = $_POST[specific_event];

//The commented out section involves using prepared statements to prevent SQL injections, but we couldn't get it to work correctly. 

function bind_array($stmt, &$row) {
    $md = $stmt->result_metadata();
    $params = array();
    while($field = $md->fetch_field()) {
        $params[] = &$row[$field->name];
    }

    call_user_func_array(array($stmt, 'bind_result'), $params);
}

$stmt = $mysqli ->prepare("SELECT * FROM approved_events WHERE event_title LIKE CONCAT('%', ? , '%') 
								UNION 
								SELECT * FROM approved_events WHERE location LIKE CONCAT('%', ? , '%') UNION
								SELECT * FROM approved_events WHERE description LIKE CONCAT('%', ? , '%') UNION
								SELECT * FROM approved_events WHERE host LIKE CONCAT('%', ? , '%') UNION
								SELECT * FROM approved_events WHERE date LIKE CONCAT('%', ? , '%') UNION
								SELECT E.* FROM approved_events E, Tags T WHERE T.event_ID = E.event_ID AND T.tag LIKE CONCAT('%', ? , '%')ORDER BY date, time");


if (!$stmt) {
	echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

if(!$stmt->bind_param('ssssss', $entered_text, $entered_text, $entered_text, $entered_text, $entered_text, $entered_text)){
	echo "Binding parameters failed:(" . $stmt->errno . ")" . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}
else{
      	bind_array($stmt, $row);
      	while($stmt->fetch()){
    		$condensedTag = $row['tags'];
		$newTag = str_replace(',', ', ', $condensedTag);
		$originalDate = $row['date'];
		$newDate = date("l, F d", strtotime($originalDate)); //reformatting date
		$originalTime = $row['time'];
		$newTime = date("h:i a", strtotime($originalTime)); //reformatting time
		echo "<div class='event_title_search' >" . $row['event_title'] . "</div><br>";
		echo "<div class='event'>" . stripslashes($row['description']) . " <br>";
		echo "Host: " . $row['host'] . "<br>";
		echo "Location: " . $row['location'] . "<br>";
		echo "Date: " . $newDate . "<br>";
		echo "Time: " . $newTime . " <br>";
		echo "Tags: " . $newTag . "</div><br> <br>";}            
    


}
mysql_close($con)
?>

<form method="post" action="searched_event.php">
Try again: <input type="text" name = "specific_event" value="<?php echo $_POST[specific_event] ?>" required>
<input class="submitLink" type ="submit" value="search">
</form>





</div>
