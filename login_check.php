<?php

//define encrypt_decrypt function
function encrypt_decrypt($action, $string) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'This is my secret key';
    $secret_iv = 'This is my secret iv';

    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}

//connect to server
define('DB_SERVER', 'panther.cs.middlebury.edu');
define('DB_USERNAME','esarich');
define('DB_PASSWORD','emily');
define('DB_DATABASE','esarich_Calendar');

$mysqli = mysqli_connect (DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die ("Could not connect");
session_start();


$username = $mysqli->real_escape_string($_POST['susername']);
$username = strtolower($username);
$password = $_POST[spassword];
$encrypted_txt = encrypt_decrypt('encrypt', $password);
$sql = "SELECT * FROM Creator WHERE username ='$username'";

if (!mysqli_query($mysqli, $sql)){
	echo "error ";
	die('Error: ' . mysqli_error($mysqli));
}
else {
	$result = mysqli_query($mysqli,$sql);
	$row = mysqli_fetch_array($result);
	$fetchedpass = $row['password'];
	$decrypted_txt = encrypt_decrypt('decrypt', $fetchedpass);
	//check if password matches the username
	if ($decrypted_txt === $password){
		//check if they've verified their account via email 
		if ($row['verified'] == 1){
			//if their password is correct and they've verifed their account, start a session and send user back to calendar
			$full_name = explode(' ', $row['name']);
			$_SESSION["name"] = $full_name[0];
			$_SESSION["username"] = $row['username'];
			if($row['approver'] == 1){
				$_SESSION["approver"] = '1';
			}
			header('Location: calendar.php');
		}
		//if their account is verified
		else {
			echo '<html>';
			echo '<head>';
			echo '<link rel="stylesheet" type="text/css" href="main_style.css">';
			echo "<link href='http://fonts.googleapis.com/css?family=Spinnaker|Megrim' rel='stylesheet' type='text/css'>";
			echo "<br><br><h2><a href='calendar.php'>MiddCal </a></h2>";
			echo '<title>MiddCal</title>';
			echo '</head>';
			echo "Your account isn't verified - check your email for a verification link";
		}
	}
	//if they enter a password that doesn't correspond to an account
	else{
		echo '<html>';
		echo '<head>';
		echo '<link rel="stylesheet" type="text/css" href="main_style.css">';
		echo "<link href='http://fonts.googleapis.com/css?family=Spinnaker|Megrim' rel='stylesheet' type='text/css'>";
		echo "<br><br><h2><a href='calendar.php'>MiddCal </a></h2>";
		echo '<title>MiddCal</title>';
		echo '</head>';
		echo "Login failed - try reentering username and password <br><br>";
		echo '<body>';
		echo '<form action = "login_check.php" method="post">';
		echo 'Username: <input type ="text" name = "susername" required> <br> <br>';
		echo 'Password: <input type = "password" name ="spassword" required> <br> <br>';
		echo '<input type = "submit" class = "submitLink" value = "Login"> <br> <br>';
		echo '</form>';
		echo '<form action = "forgot_pw.php" method="post">';
		echo '<input class="submitLink" type = "submit" value = "Forgot Password?">';  
		echo '</form>';
		echo '</body>';
	}
}
	


mysql_close($con)
?>
