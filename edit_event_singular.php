
<?php
//start PHP selection

//set up connection with database
define('DB_SERVER', 'panther.cs.middlebury.edu');
define('DB_USERNAME', 'esarich');
define('DB_PASSWORD', 'emily');
define('DB_DATABASE', 'esarich_Calendar');

$con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die("Could not connect");


session_start();
//import fonts and stylesheet
echo '<html>';
echo '<head>';
echo '<link rel="stylesheet" type="text/css" href="main_style.css">';
echo "<link href='http://fonts.googleapis.com/css?family=Spinnaker|Megrim' rel='stylesheet' type='text/css'>";
if (isset($_SESSION["username"])){
echo "<div class='session_head'> Hey " . $_SESSION["name"] . "! <br>";
echo '<a href="logout.php"> Log out</a> </div>';}
echo '<title>MiddCal</title>';
echo '</head>';
echo "<h2><a href='calendar.php'>MiddCal </a></h2>";
echo "<div class='quote'> \"The best thing about the future is that it comes one day at a time.\" </div><br><br>";

//show logout option for logged-in users and show header


//if someone manages to get to this page without logging in, they won't see any events, so we don't have to wrap everything in an if/else statement that checks for logged-in status
if (isset($_SESSION["name"])){	

}
else 
	echo "Bro, do you even go here?";


?>
<html>
<body>


<?php


//get info for the event the user chose on the previous page
$result = mysqli_query($con, "SELECT * FROM Events WHERE event_ID='" . $_POST["event_id"] . "' ORDER BY date, time ASC");

//form to allow the user to make changes
while ($row = mysqli_fetch_array($result)){
	$condensedTag = str_replace(' ', '', $row['tags']);
	$newTag = str_replace(',', ', ', $condensedTag);
	echo '<div class="main"><form method = "post" action="edit_event_database">';
	echo '<table align="center">';
	echo '<tr>';
	echo '<td align ="right">';
	echo 'Host: ';
	echo '</td>';
	echo '<td>';
	echo '<input type="text" name="host" value = "' . $row['host'] . '" required>';
	echo '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td align ="right">';
	echo 'Event Title: ';
	echo '</td>';
	echo '<td>';
	echo '<input type="text" name="event_title" value = "' . $row['event_title'] . '" required>';
	echo '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td align ="right">';
	echo 'Description: ';
	echo '</td>';
	echo '<td>';
	echo '<textarea name="description" rows="3" columns="60">'. $row['description'] . '</textarea><br>';
	echo '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td align ="right">';
	echo 'Tags <br>(Separate by commas)';
	echo '</td>';
	echo '<td>';
	echo '<textarea name="tags" rows="3" columns="60"> ' . $newTag . ' </textarea>';
	echo '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td align ="right">';
	echo 'Date: ';
	echo '</td>';
	echo '<td>';
	echo '<input type="date" name="date" placeholder="yyyy-mm-dd" value = "' . $row['date'] . '" required>';
	echo '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td align="right">';
	echo 'Time: ';
	echo '</td>';
	echo '<td>';
	echo '<input type="time" name="time" placeholder="hh:mm am/pm" value = "' . $row['time'] . '" required>';
	echo '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td align ="right">';
	echo 'Location: ';
	echo '</td>';
	echo '<td>';
	echo '<input type="text" name="location" value = "' . $row['location'] . '" required>';
	echo '</td>';
	echo '</tr>';
	echo '</table>';
	echo '<input type ="hidden" name = "event_id" value ="' . $row['event_ID'] . '" ><br>';
	echo '<input class="submitLink" type="submit" value="Submit"> </div>';

}

mysql_close($con)
?>



</body>
</html>
