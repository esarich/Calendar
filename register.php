<?php session_start();
?>

<!-- import fonts and add header -->
<html>
<head>
<link rel="stylesheet" type="text/css" href="main_style.css">
<link href='http://fonts.googleapis.com/css?family=Spinnaker|Megrim' rel='stylesheet' type='text/css'>
<br><br>
<h2><a href='calendar.php'>MiddCal </a></h2>
<div class='quote'> "The best thing about the future is that it comes one day at a time." </div>

<title>MiddCal</title>
</head>

<!-- registration form -->
<body>
<div class ="main">
<br><br>	
	<form method="post" action="register.php">
	<table align = "center">
	<tr align="right">
	<td>Name:</td>
	<td>
        <input class= "registerform" type="text" name="name" id="name" required> 
	</td></tr><tr><td></td></tr><tr align="right">
       	<td>Middlebury email:</td>
	<td>
        <input class= "registerform" type="text" name="username" id="username" required></td><td>@middlebury<a href="http://www2.warnerbros.com/spacejam/movie/jam.htm">.</a>edu
   	</td></tr><tr align="right">
	<td>Password:</td><td>
        <input class= "registerform" type="password" name="password" id="password" required></td></tr><tr align="right">
	<td>Confirm password:</td><td>
        <input class= "registerform" type="password" name="confirm_pw" id="confirm_pw" required></td></tr><tr align="right">
 	<td>Want approver permissions?</td></tr><tr><td> Enter the super secret password:</td> <td>
        <input class= "registerform" type="password" name="secretPassword" id="secretPassword"> </td></tr></table>
   
	<br>
    	<input class="submitLink" type="submit" name="register-submit" value="Register">
	</form>
	</div>

<?php
/**
 * simple method to encrypt or decrypt a plain text string
 * initialization vector(IV) has to be the same when encrypting and decrypting
 * PHP 5.4.9
 *
 * this is a beginners template for simple encryption decryption
 * before using this in production environments, please read about encryption
 *
 * @param string $action: can be 'encrypt' or 'decrypt'
 * @param string $string: string to encrypt or decrypt
 *
 * @return string
 */

//declare encrypt_decrypt function
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


//set up the connection to the database
define('DB_SERVER','panther.cs.middlebury.edu');
define('DB_USERNAME','esarich');
define('DB_PASSWORD','emily');
define('DB_DATABASE','esarich_Calendar');

$mysqli = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die("Could not connect");


if(isset($_POST['register-submit'])){
	//make sure they entered the same password in the 'password' and 'confirm password' fields
	if ($_POST['password'] == $_POST['confirm_pw']) {
		$name = ($_POST['name']);
   		$username = $mysqli->real_escape_string($_POST['username']);
		$username = strtolower($username);
		$password = $_POST['password'];
		$secretPassword = $_POST['secretPassword'];
    		$encrypted_txt = encrypt_decrypt('encrypt', $password);
		$hash = md5($username. rand(0, 2000));
		//if they entered the secret password, give them approver permissions
		if (empty($_POST['secretPassword']) <> 1){
			$password_check = mysqli_query($mysqli, "SELECT * FROM approver_password");
			$row = mysqli_fetch_assoc($password_check);
			if ($secretPassword == encrypt_decrypt('decrypt', $row['password'])){
				$sql= "INSERT INTO Creator (username, password, name, hash, approver) VALUES ('$username','$encrypted_txt', '$name' , '$hash', '1')";
			}
			else 
				echo "Incorrect secret password - try again";
		}
		else{
			//if they didn't enter the secret password, don't give them approver permissions
   			$sql = "INSERT INTO Creator (username, password, name, hash) VALUES ('$username','$encrypted_txt', '$name' , '$hash')";
		}
		if (!mysqli_query($mysqli, $sql)){
  			//echo "Registration Error: ";
			die(' ' . mysqli_error($mysqli));
		}
		else {	
			
			//sends verification email
			$email = $username . "@middlebury.edu";
			if(!filter_var( $email, FILTER_VALIDATE_EMAIL ))
				echo "Invalid email address";
			else{
				echo "You're almost done - check your middlebury email to verify your account and start making events!";
				$subject = "Middlebury Event Calendar Verification";
				$message = "Dear " . $name . ",
Thank you for signing up for the Middlebury Events Calendar. 
If you have received this message in error, please ignore this email.
			
Your username is: ".$username. "
		
If you would like to verify your account so you can start creating events, 
please click the link below to verify your account:
			
http://www.cs.middlebury.edu/~mwinkler/verify.php?username=".$username."&hash=".$hash."
			
Thanks!";
		
				mail($email, $subject, $message);
			}
		}
	}
	else{
		echo "It looks like your passwords didn't match. Please try again.";
	}
    
}

?>
</body>
</html>
