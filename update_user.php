<?php
    $firstName = $_POST["firstName"];
	$lastName = $_POST["lastName"];
	$email = $_POST["email"];
	$currentStanding = $_POST["currentStanding"];
	$birthday = $_POST["birthday"];
	$username = $_POST["username"];
	
	$connection = mysql_connect("localhost", "simon", "simonk");
	mysql_select_db("Impressions", $connection);
	
	
	$query_string = "";
	if($currentStanding!="" && $birthday!="") {
		$query_string = "UPDATE Users SET firstName='$firstName', lastName='$lastName', email='$email', currentStanding='$currentStanding', birthdate='$birthday' WHERE username='$username'";
	} elseif($currentStanding!="") {
		$query_string = "UPDATE Users SET firstName='$firstName', lastName='$lastName', email='$email', currentStanding='$currentStanding' WHERE username='$username'";
	} elseif($birthday!="") {
		$query_string = "UPDATE Users SET firstName='$firstName', lastName='$lastName', email='$email', birthdate='$birthday' WHERE username='$username'";
	} else {
		$query_string = "UPDATE Users SET firstName='$firstName', lastName='$lastName', email='$email' WHERE username='$username'";
	}
	
	$result = mysql_query($query_string, $connection);
	header("Content-type: text/plain");
	if($result) {
		echo "User Information Updated!";
	} else { 
		echo "Error Updating User Information";
	}
?>
