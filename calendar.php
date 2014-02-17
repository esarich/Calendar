<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<?php
	
	
define('DB_SERVER','140.233.20.12');
define('DB_USERNAME','esarich');
define('DB_PASSWORD','emily');
define('DB_DATABASE','esarich_Calendar');

$con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die("Could not connect");



//$date = date('Y-m-d');
$today = getdate();
//get the English ending (st nd or th) for numbers
function getMonthDayEnding ($monthDay){
	if ($monthDay == 1 || $monthDay == 21  || $monthDay == 31 )	
		{$ending = "st";}
	else if ($monthDay == 2 || $monthDay ==  22)
		{$ending = "nd";}
	else if ($monthDay == 3 || $monthDay ==  23)
		{$ending = "rd";}
	else
		{$ending = "th";}
	return $ending;
	}
	
session_start(); ?>


<html>
<head>
<link rel="stylesheet" type="text/css" href="main_style.css">
<link href='http://fonts.googleapis.com/css?family=Spinnaker|Megrim' rel='stylesheet' type='text/css'>


<!--background-image:url('debut_dark.png');
	background-repeat:repeat;-->

<!-- 				MAD STYLE HAPPENING HERE----SHIELD YOUR EYES!!				-->
<style>
	
	body{
	background-image:url('midd1.jpg');
	background-attachment: fixed;
	background-size:cover;
	background-repeat:no-repeat;
	background-position: 90% 0%;
	font-family: 'Spinnaker', sans-serif; 
	font-weight: 400;
	color:#FFFFFF;
	
	}
	
	h2{ font-family: 'Megrim', cursive;
			font-weight: 400; 
			text-align:center; 
			font-size:60px;
			margin: 0px; }
	
	a:link {text-decoration:none; 
			color:#FFFFFF;}    /* unvisited link */
	a:visited {text-decoration:none; 
			color:#FFFFFF;} /* visited link */
	a:hover {text-decoration:none; 
			color:#0099FF;}   /* mouse over link */
	a:active {text-decoration:none; 
			color:#0099FF;}  /* selected link */
	
	div{text-align:center; 
				font-family: 'Megrim', cursive;
				font-weight: 500; 
				font-size:150%;}
		
	.quote {font-family: 'Spinnaker', sans-serif;
			text-align:center; 
			font-size:15px;
			color:#FFFFFF;
			}
	
	.subhead{text-align:center; 
			font-family: 'Spinnaker', sans-serif;
			font-size:100%;
			color:#FFFFFF;}
	
	.seeMoreDiv{text-align:center;
				}
	
	.event_title{ font-family: 'Spinnaker', sans-serif;
			color:#FFFFFF; 
			font-size:25px;}
			
	.event{	font-family: 'Spinnaker', sans-serif;
			color: #FFFFFF; 
			font-size:18px;}
	
	.search_key{color:#FFFFFF;
				display: inline-block;
				border-top-style:solid; 
				border-bottom-style:solid; 
				border-color:#FFFFFF; 
				font-size:30px;}
				
	.session_head{
				font-family: 'Spinnaker', sans-serif;
				color:#FFFFFF;
				text-align: right;
				font-size:15px;}
	
	p{font-size:150%; 
			color:#FFFFFF;
			text-decoration:underline;
			display: inline; }
	
	input{ font-weight: 400;
			display: inline;}
	
	
	.submitLink {font-family: 'Spinnaker', sans-serif;
			font-size: 15px;
			background-color: transparent;
			color:#FFFFFF;
			border: none;
			cursor: pointer;
			cursor: hand;}
			
	.submitLink:hover {text-decoration:none; 
			color:#0099FF;}
			
	.seeMore {font-family: 'Spinnaker', sans-serif;
			font-size: 15px;
			background-color: transparent;
			color:#FFFFFF;
			border: none;
			cursor: pointer;
			cursor: hand;}
			
	.seeMore:hover {text-decoration:none; 
			color:#0099FF;}
	
	
	
	
</style>


<title> MiddCal </title>

</head>
<body>
</html>

<?php
if (isset($_SESSION["username"])){				//if logged head
	echo "<html> ";
	
	
	echo '<form method="post" action="searched_event.php" style="float: left;">';
	echo '<input type="text" name = "specific_event" placeholder=" Search events" required>';
	echo '<input type ="submit" class = "submitLink" value="Search">';
	echo '</form>';

	echo "<div class='session_head'> Hey " . $_SESSION["name"] . "! <br>";
	echo '<a href="logout.php"> Log out</a> </div>';
	
	
	echo "<h2><a href='calendar.php'> MiddCal </a></h2> ";
	echo "<div class='quote'> \"The best thing about the future is that it comes one day at a time.\" </div>";



echo "<br>";

	echo '<div class="subhead">';
	if ($_SESSION["approver"] == 1){			
			echo '<a href="approve_events.php"> Approve events </a>';
			echo "&nbsp | &nbsp";
		}
	echo '<a href= "event_creation.php"> Create Event</a>' ;
	echo "&nbsp | &nbsp";
	echo '<a href = "edit_event.php"> Edit Event </a>';
	echo '</div>';
	
	
	echo '</html>';
}

else{ 						//not logged in header

	echo '<html><form method="post" action="searched_event.php" style="float: left;">';
	echo '<input type="text" name = "specific_event" placeholder=" Search events" required>';
	echo '<input type ="submit" class = "submitLink" value="Search">';
	echo '</form>';
	
	echo '<div class="session_head">';
	echo '<a href="register.php">Sign up</a><br>';
	echo '<a href="login.php">Log in</a> </div>';			
	
	echo "<h2><a href='calendar.php'> MiddCal </a></h2> ";
	echo "<div class='quote'> \"The best thing about the future is that it comes one day at a time.\" </div><br>";

	
	
	
	}		
//---------------------------DropDown-----------------------------------------------------------------------------


echo '<form class = "dropdown" name="thisForm" method="POST" action="' . htmlspecialchars($_SERVER["PHO_SELF"]) . '">';
echo '<br> <select size="1" name="my_dropdown">';
		

		
if ($_POST['my_dropdown'] != "date") 		//last selected date? OR not set
	echo '<option value="date"> Date</option>';
else
	echo '<option value="date" selected> Date</option>';
	
if (($_POST['my_dropdown'] != "event_title" ) || (!isset($_POST['my_dropdown']))) 				//last selected event title?
	echo '<option value="event_title"> Event Title</option>';
else
	echo '<option value="event_title" selected> Event Title</option>';
	
if (($_POST['my_dropdown'] != "host") || (!isset($_POST['my_dropdown'])))						//last selected host?
	echo '<option value="host"> Host</option>';
else
	echo '<option value="host" selected> Host</option>';

if (($_POST['my_dropdown'] != "location") || (!isset($_POST['my_dropdown'])))							//last selected location?
	echo '<option value="location"> Location</option>';
else
	echo '<option value="location" selected> Location</option>';
	
if (($_POST['my_dropdown'] != "tags") || (!isset($_POST['my_dropdown'])))								//last selected tags?
	echo '<option value="tags"> Tag</option>';
else
	echo '<option value="tags" selected> Tag</option>';

echo '</select>';

//echo 'For the next ';
//echo '<input type="text" size = "3" class = "dayNo_input" value ="' . $dayVal . '" name="dayNo">';
//echo ' days ';

echo '<input type="submit" class = "submitLink" value="Sort">';
echo '</form>';

//---------------------------------------------------------------------------------------------------------------
	
?>	



<SCRIPT LANGUAGE="javascript">
function validate() {

	fm = document.thisForm

	//use validation here to make sure the user entered
	//the information correctly

	fm.submit()

}

</SCRIPT>

<?php 
			$dayVal = 7;		//set how many days we see
	
		if (isset($_POST['seeMore'])){		//see more option-- double amount of days we see
			$dayVal = $dayVal * 2;
			}
	

echo '<br>';



/*if ($_POST['dayNo'] < 7)		
	$_POST['dayNo'] = 7;*/
$date = date('Y-m-d');
$sql = "CREATE OR REPLACE VIEW approved_events AS SELECT * FROM Events WHERE approved = 1 AND date >= '$date' ORDER BY date, time ASC";
$query = mysqli_query($con, $sql);

if ($_POST['my_dropdown'] == "event_title"){				//search by EVENT_TITLE
	$result = mysqli_query($con, "SELECT * FROM approved_events WHERE date BETWEEN '" . date('Y-m-d') . "' AND '" . date('Y-m-d', strtotime("+ " . ($dayVal - 1) . " days")) . "' ORDER BY event_title, date, time ASC");

		echo "<br>";
		$last_used = " ";	//to compare to last event title
		while ($row = mysqli_fetch_array($result)){
			$originalDate = $row['date'];
			$newDate = date("l, F d", strtotime($originalDate)); //reformatting date
			$originalTime = $row['time'];
			$newTime = date("h:i a", strtotime($originalTime)); //reformatting time
			$condensedTag = $row['tags'];
			$newTag = str_replace(',', ', ', $condensedTag);		
				if($row['event_title'] == $last_used){
					echo "<div class='event'>";
				    echo  $row['description'] . "<br>"; 
        			echo  "Host: " . $row['host'] . "<br>";
        			echo  "Location: " . $row['location'] . "<br>";
					echo  "Date: " . $newDate . " <br>";
					echo  "Time: " . $newTime . "<br>";
					echo "Tags: " . $newTag . "<br><br>";}
				else {
					echo '<div class = "search_key">' . $row['event_title'] . " </div><br> <br>";
					echo  "<div class='event'>" . $row['description'] . "<br>"; 
					echo  "Host: " . $row['host'] . "<br>"; 
					echo  "Location: " . $row['location'] . "<br>";
					echo  "Date: " . $newDate . "<br>";
					echo  "Time: " . $newTime . "<br>";
					echo "Tags: " . $newTag . "<br><br>";
					$last_used = $row['location'];}
				echo "</div><br><br>";
		}	
	echo "<br>";



}



elseif ($_POST['my_dropdown'] == "host"){				//search by HOST
	$result = mysqli_query($con, "SELECT * FROM approved_events WHERE date BETWEEN '" . date('Y-m-d') . "' AND '" . date('Y-m-d', strtotime("+ " . ($dayVal - 1) . " days")) . "' ORDER BY host, date, time ASC");

		echo " <br>";
		$last_used = " ";	//to compare to last host
		while ($row = mysqli_fetch_array($result)){
			$originalDate = $row['date'];
			$newDate = date("l, F d", strtotime($originalDate)); //reformatting date
			$originalTime = $row['time'];
			$newTime = date("h:i a", strtotime($originalTime)); //reformatting time
			$condensedTag = $row['tags'];
			$newTag = str_replace(',', ', ', $condensedTag);		
				if($row['host'] == $last_used){
        			echo  "<div class='event_title'>" . $row['event_title'] . "</div>  <br>";
        			echo "<div class='event'>";
        			echo  stripslashes($row['description']) . "<br>";
        			echo  "Location: " . $row['location'] . "<br>"; 
					echo  "Date: " . $newDate . " <br>";
					echo  "Time: " . $newTime . "<br>";
					echo "Tags: " . $newTag . "<br><br>";
					}
				else {
					echo "<div class = 'search_key'>" . $row['host'] . "</div><br><br>";
					echo  "<div class='event_title'>" . $row['event_title'] . "</div> <br>";					
					echo "<div class='event'>";
					echo  stripslashes($row['description']) . "<br>"; 
					echo  "Location: " . $row['location'] . "<br>";
					echo  "Date: " . $newDate . "<br>";
					echo  "Time: " . $newTime . "<br>";
					echo "Tags: " . $newTag . "<br><br>";
					$last_used = $row['host'];}
				echo "</div><br><br>";
		}
}


elseif ($_POST['my_dropdown'] == "location"){				//search by LOCATION
	$result = mysqli_query($con, "SELECT * FROM approved_events WHERE date BETWEEN '" . date('Y-m-d') . "' AND '" . date('Y-m-d', strtotime("+ " . ($dayVal - 1) . " days")) . "' ORDER BY location, date, time ASC");

		echo "<br>";
		$last_used = " ";	//to compare to last location
		while ($row = mysqli_fetch_array($result)){
			$originalDate = $row['date'];
			$newDate = date("l, F d", strtotime($originalDate)); //reformatting date
			$originalTime = $row['time'];
			$newTime = date("h:i a", strtotime($originalTime)); //reformatting time
			$condensedTag = $row['tags'];
			$newTag = str_replace(',', ', ', $condensedTag);		
				if($row['location'] == $last_used){
        			echo "<div class='event_title'>" . $row['event_title'] . " </div> <br>";
					echo "<div class='event'>";
        			echo  stripslashes($row['description']) . "<br>"; 
					echo  "Host: " . $row['host'] . "<br>";
					echo  "Date: " . $newDate . " <br>";
					echo  "Time: " . $newTime . "<br>";
					echo "Tags: " . $newTag . "<br><br>";}
				else {
					echo "<div class = 'search_key'>" . $row['location'] . " </div><br><br>";
					echo  "<div class='event_title'>" . $row['event_title'] . "</div> <br>";
					echo "<div class='event'>";
					echo  stripslashes($row['description']) . "<br>"; 
					echo  "Host: " . $row['host'] . "<br>"; 
					echo  "Date: " . $newDate . "<br>";
					echo  "Time: " . $newTime . "<br>";
					echo "Tags: " . $newTag . "<br><br>";
					$last_used = $row['location'];}
				echo "</div><br><br>";
		}
}




elseif ($_POST['my_dropdown'] == "tags"){				//search by TAGS
	$result = mysqli_query($con, "SELECT T.tag, E.* FROM Tags T, approved_events E WHERE T.event_ID = E.event_ID
	 AND E.approved = 1 AND E.date BETWEEN '" . date('Y-m-d') . "' AND '" . date('Y-m-d', strtotime("+ " . ($dayVal - 1) . " days")) . "' ORDER BY  T.tag, E.date, E.time ASC");
		echo "<br>";		
		$last_used = " ";	//to compare to last tag
		
		while ($row = mysqli_fetch_array($result)){
			$originalDate = $row['date'];
			$originalTime = $row['time'];		
			$newDate = date("l, F d", strtotime($originalDate)); //reformatting date
			$newTime = date("h:i a", strtotime($originalTime)); //reformatting time
			$condensedTag = $row['tags'];
			$newTag = str_replace(',', ', ', $condensedTag);
        		if($row['tag'] == $last_used){
					echo "<div class='event_title'>" . $row['event_title'] . "</div>  <br>";
        			echo "<div class='event'>";
        			echo  stripslashes($row['description']) . "<br>"; 
					echo  " Host: " . $row['host'] . "<br>";
					echo  "Location: " . $row['location'] . "<br>";
					echo  "Date: " . $newDate . " <br>";
					echo  "Time: " . $newTime . "<br>";
					echo "Tags: " . $newTag . "<br><br>";}
				else {
					$newTag = $row['tag'];
					$newTag = ucwords($newTag);
					echo "<div class = 'search_key'>" . $newTag . " </div><br><br>";
					echo  "<div class='event_title'>" . $row['event_title'] . "</div> <br>";
					echo "<div class='event'>";
					echo  stripslashes($row['description']) . "<br>"; 
					echo  "Host: " . $row['host'] . "<br>";
					echo  "Location: " . $row['location'] . "<br>"; 
					echo  "Date: " . $newDate . "<br>";
					echo  "Time: " . $newTime . "<br>";
					echo "Tags: " . $newTag . "<br><br>";
					$last_used = $row['tag'];}
				echo "</div><br><br>";
		}
}

else{														//search by DATE
		
		$result = mysqli_query($con, "SELECT * FROM approved_events WHERE date BETWEEN '" . date('Y-m-d') . "' AND '" . date('Y-m-d', strtotime("+ " . ($dayVal - 1) . " days")) . "' ORDER BY date, time ASC");
		
		echo "<br>";
		$last_used = "start";	//to compare to last date
		$day_count = 0;         //to make sure we hit all 7 days we will increment to 7
		while ($row = mysqli_fetch_array($result)){
			$originalTime = $row['time'];
			$newTime = date("h:i a", strtotime($originalTime)); //reformatting time
			$condensedTag = $row['tags'];
			$newTag = str_replace(',', ', ', $condensedTag);
			
			if ($last_used == "start"){		//first event on page
				if ($row['date'] = date('Y-m-d')){	//event happens today
					echo "<div class = 'search_key'> " . date("l, F j", strtotime($row['date'])) . getMonthDayEnding(date("d", strtotime($row['date']))) . "</div><br><br>";
					$day_count++;			
					echo  "<div class='event_title'>" . $row['event_title'] . "</div> <br>";
					echo "<div class='event'>";
					echo  stripslashes($row['description']) . "<br>"; 
					echo  "Host: " . $row['host'] . "<br>"; 
					echo  "Location: " . $row['location'] . "<br>";
					echo  "Time: " . $newTime . "<br>";
					echo "Tags: " . $newTag . "<br><br>";
					$last_used = date('Y-m-d');
				}//if
				else{	//event doesn't happen today, must fill in 'no events today'
					echo "<div class = 'search_key'>" . date("l, F j") . getMonthDayEnding(date("d")) . " </div> <br><br>";
					$day_count++;
					echo "<div class='event'>";
					echo 'No events on this date. <br> <br>';
					echo "</div>";
					echo $last_used . " " . $day_count . "<br>";
					$last_used = date("Y-m-d");
					while ($row['date'] != date('Y-m-d', strtotime("+1 day", strtotime($last_used)))){
						echo "<div class = 'search_key'>" . date('Y-m-d', strtotime("+1 day", strtotime($last_used))) . getMonthDayEnding(date('d', strtotime("+1 day", strtotime($last_used)))) . " </div> <br><br>";
						$day_count++;
						echo "<div class='event'>";
						echo 'No events on this date. <br> <br>';
						echo "</div>";
						$last_used = date('Y-m-d', strtotime("+1 day", strtotime($last_used)));
						
					}//while			
				}//else
		

			}//if
			
			elseif($row['date'] == $last_used){		//if event on same day as previously listed event
				echo  "<div class='event_title'>" . $row['event_title'] . "</div> <br>";
				echo "<div class='event'>";
				echo  stripslashes($row['description']) . "<br>"; 
				echo  "Host: " . $row['host'] . "<br>"; 
				echo  "Location: " . $row['location'] . "<br>";
				echo  "Time: " . $newTime . "<br>";
				echo "Tags: " . $newTag . "<br><br>";
			
			}//elseif
			
			elseif($row['date'] == date('Y-m-d', strtotime("+1 day", strtotime($last_used)))){	//if event on day following last date
				echo "<div class = 'search_key'> " . date("l, F j", strtotime($row['date'])) . getMonthDayEnding(date("d", strtotime($row['date']))) . "</div><br><br>";
				$day_count++;
				echo  "<div class='event_title'>" . $row['event_title'] . "</div> <br>";
				echo "<div class='event'>";
				echo stripslashes($row['description']) . "<br>"; 
				echo  "Host: " . $row['host'] . "<br>"; 
				echo  "Location: " . $row['location'] . "<br>";
				echo  "Time: " . $newTime . "<br>";
				echo "Tags: " . $newTag . "<br><br>";
				$last_used = date('Y-m-d', strtotime("+1 day", strtotime($last_used)));
			}//elseif


			else {// if event on day multiple days after last date
				while ($row['date'] != date('Y-m-d', strtotime("+1 day", strtotime($last_used)))){
						echo "<div class = 'search_key'>" . date("l, F j", strtotime("+1 day", strtotime($last_used))) . getMonthDayEnding(date('d', strtotime("+1 day", strtotime($last_used)))) . " </div> <br><br>";
						$day_count++;
						echo "<div class='event'>";
						echo 'No events on this date. <br> <br>';
						echo "</div>";
						$last_used = date('Y-m-d', strtotime("+1 day", strtotime($last_used)));
				}//while
				echo "<div class = 'search_key'> " . date("l, F j", strtotime($row['date'])) . getMonthDayEnding(date("d", strtotime($row['date']))) . "</div><br><br>";
				$day_count++;							
				echo  "<div class='event_title'>" . $row['event_title'] . "</div> <br>";
				echo "<div class='event'>";
				echo  stripslashes($row['description']) . "<br>"; 
				echo  "Host: " . $row['host'] . "<br>"; 
				echo  "Location: " . $row['location'] . "<br>";
				echo  "Time: " . $newTime . "<br>";
				echo "Tags: " . $newTag . "<br><br>";
				$last_used = date('Y-m-d', strtotime("+1 day", strtotime($last_used)));
			}//elseif
		
		
		}//while */
			
		for (; $day_count < $dayVal; $day_count++){		// print 'No events' for missing days
			$last_used = date('Y-m-d', strtotime("+ 1 days", strtotime($last_used)));
			echo "<div class = 'search_key'>" . date("l, F j", strtotime($last_used)) . getMonthDayEnding(date("d", strtotime($last_used))) . " </div> <br><br>";
			echo "<div class='event'>";
			echo 'No events on this date. <br> <br>';
			echo "</div>";
		} //for loop close

}//outer else "date" dropdown loop close




if (($_POST['my_dropdown'] == "date") || (!isset($_POST['my_dropdown']))){				//see more button at bottom
	echo "<div class='seeMoreDiv'>";
	echo '<form method="post" action="' . htmlspecialchars($_SERVER['PHO_SELF']) . '">';
	if (!isset($_POST['seeMore'])){
		echo '<input type="submit" class="seeMore" value="See More" name="seeMore">'; }
	else{
		echo '<input type="submit" class="seeMore" value="See Less" name="seeLess">'; }
	echo '</form>';
	echo '</div>';
}//if


?>



</body>
</html>
