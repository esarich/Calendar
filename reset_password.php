<?php 
session_start();
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="main_style.css">
<link href='http://fonts.googleapis.com/css?family=Spinnaker|Megrim' rel='stylesheet' type='text/css'>
<br><br><h2><a href='calendar.php'>MiddCal </a></h2>
<div class='quote'> "The best thing about the future is that it comes one day at a time." </div><br><br>
<title>MiddCal</title>

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

//initialize connection with database
define('DB_SERVER','panther.cs.middlebury.edu');
define('DB_USERNAME','esarich');
define('DB_PASSWORD','emily');
define('DB_DATABASE','esarich_Calendar');

$mysqli = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die("Could not connect");

if(!isset($_POST['change_pw'])){
	echo '<html>';
	echo '<body>';
	echo '<form method="post" action="reset_password.php"><br>';
	echo 'Enter your new password here:<input type="password" name="new_pw" id="new_pw" required > <br><br>';
	echo 'Confirm your new password:<input type="password" name="confirm_pw" id="confirm_pw" required > <br> <br>';

	echo '<input class = "submitLink" type="submit" name="change_pw" value="Reset password">';

	echo '</form>';
	echo '</body>';
	echo '</html>';

	$url = $_SERVER['REQUEST_URI'];

	$explode1 = explode('?', $url);

	$explode2 = explode('&', $explode1[1]);

	$explode3 = explode("=", $explode2[0]);
	$_SESSION['username'] = $explode3[1];

	$explode4 = explode("=", $explode2[1]);
	$_SESSION['hash'] = $explode4[1];
}



elseif(isset($_POST['change_pw'])){
	if ($_POST['new_pw'] == $_POST['confirm_pw']) {
		$encrypted_pw = encrypt_decrypt('encrypt', $_POST['new_pw']);
		$username = $_SESSION['username'];
		$hash = $_SESSION['hash'];
		$sql = "UPDATE Creator SET password= '$encrypted_pw' 
		WHERE username= '$username' 
		AND hash= '$hash'"; 
		
		$query = mysqli_query($mysqli, $sql);
		
		if (!mysqli_query($mysqli, $sql)){
  			echo "Error: ";
			die(' ' . mysqli_error($mysqli));
		} else {
			echo '<a href="login.php">Click to log in.</a>';
			session_destroy();
		}
	} else {
		echo "Those passwords don't match. Try again.";
	}
}

?>

</body>
</html>

	
	
