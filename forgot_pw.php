<html>
<head>
<!-- import fonts and add header -->
<link rel="stylesheet" type="text/css" href="main_style.css">
<link href='http://fonts.googleapis.com/css?family=Spinnaker|Megrim' rel='stylesheet' type='text/css'>
</head>
<br>
<br>
<h2><a href='calendar.php'>MiddCal </a></h2>
<div class='quote'> "The best thing about the future is that it comes one day at a time." </div>

<title>MiddCal</title>


<?php
define('DB_SERVER','panther.cs.middlebury.edu');
define('DB_USERNAME','esarich');
define('DB_PASSWORD','emily');
define('DB_DATABASE','esarich_Calendar');

$mysqli = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die("Could not connect");

if (isset($_POST['reset_pw'])) {
	$username = strtolower($_POST['username']);
	

	function bind_array($stmt, &$row) {
    	$md = $stmt->result_metadata();
    	$params = array();
    	while($field = $md->fetch_field()) {
        $params[] = &$row[$field->name];
    	}

    	call_user_func_array(array($stmt, 'bind_result'), $params);
	}

	$stmt = $mysqli ->prepare("SELECT username, hash FROM Creator WHERE username = ?");

	if (!$stmt) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	if(!$stmt->bind_param('s', $username)){
		echo "Binding parameters failed:(" . $stmt->errno . ")" . $stmt->error;
	}
	
	if(!$stmt->execute()){
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	
	else{
		 bind_array($stmt, $row);
      		while($stmt->fetch()){
			$hash = $row['hash'];
		}
			if ($row['username'] == $username){
				$email = $username . "@middlebury.edu";
				$subject = "Reset password";
				$message = "Hi there,
You have submitted a request to reset your password for the Middlebury Events Calendar. 
If you do not want to change your password, delete this email and continue on with your day.
				
If you have forgotten your password, click on the link below:
					
http://www.cs.middlebury.edu/~mwinkler/reset_password.php?username=".$username."&hash=".$hash."
					
Thanks!";
			
				mail($email, $subject, $message);
				echo "<br><br>Check your email for a link to reset your password.";	
			} 
			else {
				echo "We couldn't find that username. Please make sure you typed the correct username.";
			}
		}	
}

else{
echo '<html>';
echo '<body>';
echo '<br><br>';
echo 'Forgot your password? <br><br>';
echo "We'll send you an email to reset it. <br><br><br>";

echo '<form method="post" action="forgot_pw.php">';
echo 'Enter Username:';
echo '<input type="text" name="username" required> @middlebury.edu<br><br><br>';

echo '<input class="submitLink" type="submit" name="reset_pw" value ="Reset my password"><br><br>';
echo '</form>';
echo '</body>';
echo '</html>';
}
?>

</body>
</html>
