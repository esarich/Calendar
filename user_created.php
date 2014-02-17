<html>
<body>

<?php

//This section connects to the database
define('DB_SERVER', 'panther.cs.middlebury.edu');
define('DB_USERNAME', 'esarich');
define('DB_PASSWORD', 'emily');
define('DB_DATABASE', 'esarich_Calendar');

$con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or 
die("Connection failed. Try again.");

$username = explode('@', $_POST[email]);

$sql= "INSERT INTO Creator (name, username, password)
VALUES ('$_POST[name]', '$username[0]', '$_POST[password]')";

if (!mysqli_query($con, $sql)) {
	die('Error: ' .mysqli_error($con));
}

echo "User has successfully been created <br>";

mysql_close($con);
?>

<!This is what the users see after registering: >

Thank you for registering, <?php echo $_POST["name"]; ?><br>
Your registered email is: <?php echo $_POST["email"]; ?><br>
Your username is: <?php echo $username[0]; ?><br>
Your password is: <?php echo $_POST["password"]; ?><br><br>
Check your email for your verification email! (Just kidding we haven't 
set that feature up yet)

<form action = "calendar.php">
	<input type="submit" value="Continue to Calendar"/>

</body>
<html>