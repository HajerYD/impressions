<html>
<head>
<title>Register Confirmation</title>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<?php

	// Encrypting the password and setting all the variables for later use
	$first = ($_POST["firstName"]); 
	$password = md5($_POST["password1"]);
	$last = ($_POST["lastName"]);
	$bdayMonth = ($_POST["bdayMonth"]);
	$bdayDay = $_POST["bdayDay"];
	$bdayYear = $_POST["bdayYear"];
	$email	 = ($_POST["email1"]);
	$currentStanding = ($_POST["currentStanding"]);
	$username = ($_POST["username"]);

	// Connecting, selecting database
	$link = mysql_connect("localhost", "simon", "simonk")
		or die("Could not connect: " . mysql_error() . "<br/>");
	//echo "Connected successfully<br/>";

	//select the database to use once connected to mysql
	mysql_select_db("Impressions") or die("Could not select database<br/>");

	//generate random number for the activation process.
	$random = rand(23456789,98765432);

	// Performing SQL query
	$query = "INSERT INTO Users VALUES ('$first','$last','".$bdayYear."/".$bdayMonth."/".$bdayDay."','$currentStanding','$username','$password','$random','1','$email','DEFAULT','DEFAULT','$random','1');";
	$result = mysql_query($query) or die("Query failed: " . mysql_error() . "<br>");

	//create a row in UserHasRank for the User
	$query2 = "INSERT INTO UserHasRank VALUES ('$username', '0', '99')";
	$result = mysql_query($query2) or die("Query 2 failed: " . mysql_error());

	/* echo "starting mail sending";
	//copy
	
	require_once("pear/share/pear/Mail.php");
echo "<br/>1";
	$from = "Alex Hokanson <verify.impressions@gmail.com>";
	$to = "<avidgamer123@gmail.com>";
	$subject = "Activate your account";
	$body = "
	\n
	Hello $firstName,
	\no
	\n
	Please copy/paste the following URL into your browser to activate your account:
	\n
	10.40.40.84/activate.php?username=$username&code=$random;
	\n
	\n
	Thanks!
	";

	$host = "localhost";
	$port = "587";
	$username = "verify.impressions@gmail.com";
	$password = "!mpressions";
echo "2";
	$headers = array ('From' => $from,
		'To' => $to,
		'Subject' => $subject);
echo "3";
	$mailer_params['host'] = $host;
	$mailer_params['port'] = $port;
	$mailer_params['auth'] = true;
	$mailer_params['username'] = $username;
	$mailer_params['password'] = $password;          		          		          		
	
	$smtp = Mail::factory('smtp', $mailer_params);
echo "4";
	error_reporting(E_ALL);
	ini_set(‘display_errors’, ‘on’); 
echo "5";
	if (PEAR::isError($smtp)) {
		die("Error : " . $smtp->getMessage());
	}
echo "6";
	echo "<br />";
	echo "gettype: ";
	echo gettype($smtp);
	echo "<br />";
	echo "get_class: ";
	echo get_class($smtp);
	echo "<br />";
	echo "var_dump: ";
	echo var_dump($smtp);
	
	$mail = $smtp->send($to, $headers, $body) or die("Something bad happened"); 
echo "7";
	if (PEAR::isError($mail)) {
		echo("<p>" . $mail->getMessage() . "</p>");
	} else {
		echo("<p>Message successfully sent!</p>");
	}
	
	
	
	//copy end
	echo "mail sent hopefully.";
	//sending email
	$to = $email;
	$subject = "Activate your account";
	$headers = "From: Impressions@Impressions.com";
	$server = "mail.manchester.edu";

	ini_set("SMTP",$server);
	ini_set("smtp_port","25"); 
	$body = "

	Hello $firstName,\n\n
	
	
	Please copy/paste the following URL into your browser to activate your account:\n
	
	10.40.40.84/activate.php?username=$username&code=$random;\n\n


	Thanks!
	";

	//function to send email
	mail($to, $subject, $body, $headers);*/
	//Close the connection to the server since we're done querying
	mysql_close($link);
	echo "You have successfully registered with Impressions!<br /><a href='login.html'>Login Here!</a>";
?>
</body>
</html>