



<html>
<head>
<!-- import fonts and add header -->
<link rel="stylesheet" type="text/css" href="main_style.css">
<link href='http://fonts.googleapis.com/css?family=Spinnaker|Megrim' rel='stylesheet' type='text/css'>
</head>

<div class="session_head">
<a href="register.php">Sign up</a>
</div>
	
<br>
<h2><a href='calendar.php'>MiddCal </a></h2>
<div class='quote'> "The best thing about the future is that it comes one day at a time." </div>

<title>MiddCal</title>

<!-- login form -->
<body>
<br>
<br>
<div class="main">
<form action = "login_check.php" method="post">
Username: <input type ="text" name = "susername" required> <br> <br>
Password: <input type = "password" name ="spassword" required> <br> <br>
<input class="submitLink" type = "submit" value = "Login">  
</form>
<br><br><br>
<form action = "forgot_pw.php" method="post">
<input class="submitLink" type = "submit" value = "Forgot Password?">  
</form>

<br>
<br>


</div>

</body>
</html>
