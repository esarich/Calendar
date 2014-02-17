<?php
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



	//set up connection with database
	define('DB_SERVER', 'panther.cs.middlebury.edu');
	define('DB_USERNAME', 'esarich');
	define('DB_PASSWORD', 'emily');
	define('DB_DATABASE', 'esarich_Calendar');
	
	$con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die("Could not connect");
	
	$sql = "CREATE OR REPLACE VIEW unapproved_events1 AS SELECT * FROM Events WHERE approved = 0 and date >= '" . date('Y-m-d') . "' ORDER BY date, time ASC";

	$query = mysqli_query($con, $sql);
	
	$result = mysqli_query($con, "SELECT * FROM unapproved_events1 WHERE date >= '" . date('Y-m-d') . "' ORDER BY date, time ASC");

	$x = 0;
	echo '<html>';
	echo '<body>';
	
	
	
	if ($_SESSION["approver"] == 1){
		while ($row = mysqli_fetch_array($result)){
			$x = 1;

			echo "<div class='event_title'>" . $row['event_title'] . "</div><br>";
			echo '<div class="event">' ;
			echo "Description: " . stripslashes($row['description']) . "<br>";	
			echo "Host: " . $row['host'] . "<br>";
			echo "Created by: " . $row['creator_username'] . "<br>";
			echo "Location: " . $row['location'] . "<br>";
			echo "Date and time: " . $row['date'] . " at " . $row['time'] . " </div><br>";
			?>
			<html>
			<head>
			<link rel="stylesheet" type="text/css" href="main_style.css">
			<link href='http://fonts.googleapis.com/css?family=Monoton|Spinnaker' rel='stylesheet' type='text/css'>
			</head>
			<body>
			<form method = "post" action = "approve_event_database.php">
			<input class="submitLink" type ="submit" value="Approve">
			<input type ="hidden" name = "event_id" value ="<?php echo $row['event_ID'];?>">
			</form> 
			<form method = "post" action = "edit_event_singular.php">
			<input class="submitLink" type ="submit" value="Edit">
			<input type ="hidden" name = "event_id" value ="<?php echo $row['event_ID'];?>">
			</form> 
			<form method = "post" action = "delete_event.php">
			<input class="submitLink" type ="submit" value="Delete">
			<input type ="hidden" name = "event_id" value ="<?php echo $row['event_ID'];?>">
			</form> 
			<br>
			<br><br>
			<br>
			</body>
			</html>
			<?php "<br> <br>";
		}
		if ($x == 0){
			echo '<html>';
			echo '<body>';
			echo "<div class='main'> There are no more unapproved events </div><br><br>";
			echo '</body>';
			echo '</html>';
		}
	}
	else 
		echo "You don't have approver permissions - How did you get here?";
	

	mysql_close($con)
	

?>



