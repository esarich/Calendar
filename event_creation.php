<?php
session_start();
//import fonts and stylesheet
echo '<html>';
echo '<head>';
echo '<link rel="stylesheet" type="text/css" href="main_style.css">';
echo "<link href='http://fonts.googleapis.com/css?family=Spinnaker|Megrim' rel='stylesheet' type='text/css'>";

//show logout button if user is logged in, add header
if (isset($_SESSION["username"])){
echo "<div class='session_head'> Hey " . $_SESSION["name"] . "! <br>";
echo '<a href="logout.php"> Log out</a> </div>';}
echo "<h2><a href='calendar.php'>MiddCal </a></h2>";
echo "<div class='quote'> \"The best thing about the future is that it comes one day at a time.\" </div><br><br>";
echo '<title>MiddCal</title>';
echo '</head>';

//check to make sure would-be event creators are logged in to an account
if (isset($_SESSION["name"])){


//all the forms for the various event fields the user needs to specify
echo' <body> <div class="main">';

echo' <form action="event_created.php" method="post">';
echo '<table align="center">';
echo '<tr>';
echo '<td align ="right">';
echo' Event Title: ';
echo '</td>';
echo '<td>';
echo '<input type="text" name="event_title" required>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td align ="right">';
echo 'Host: '; 
echo '</td>';
echo '<td>';
echo '<input type="text" name="host" required>';
echo '</td>';
echo '</tr>';

echo '<tr>';
echo '<td align ="right">';
echo' Please describe your event in <br>1000 characters or less: ';
echo '</td>';
echo '<td>';
echo' <textarea name="description" rows="3" columns="60"> </textarea>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td align ="right">';
echo 'Add some tags so people <br>can find your event!<br>(Please separate tags by commas)';
echo '</td>';
echo '<td>';
echo '<textarea name="tags" rows="3" columns="60" required> </textarea>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td align ="right" >';
echo 'Date: ';
echo '</td>';
echo '<td>';
echo '<input type="date" name="date" placeholder="yyyy-mm-dd" required>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td align ="right" >';
echo 'Time: ';
echo '</td>';
echo '<td>';
echo '<input type="time" name="time" placeholder="hh:mm am/pm" required>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td align ="right" >';
echo 'Location: ';
echo '</td>';
echo '<td>';
echo '<input type="text" name="location" required>';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '<br><br>Have you reserved your space? <input type="checkbox" name="Reserved" value="Yes" required>Yes <br><br><br>';
echo '<input class="submitLink" type="submit" value="Submit">';
echo '</form>';

echo' </div></body>';
echo' </html>';

}
//if someone manages to naviagte to this page without being logged in
else 
	echo "You're not logged in to an account- how did you get here?";
?>
