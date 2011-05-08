<?php
	$username = $_POST["username"];
	$oldPassword = md5($_POST["oldPassword"]);
	$newPassword = md5($_POST["newPassword1"]);
	
	$connection = mysql_connect("localhost", "simon", "simonk");
	mysql_select_db("Impressions", $connection);
	
	//get the current password from the database
	$query_string = "SELECT password FROM Users WHERE username='$username'";
	$result = mysql_query($query_string, $connection);
	$row1 = mysql_fetch_array($result);
	
	if($oldPassword == $row1["password"]) {
		$query_string = "UPDATE Users SET password='$newPassword' WHERE username='$username'";
		$result = mysql_query($query_string, $connection);
		header("Content-type: text/plain");
		if($result) {
			echo "Password Changed!";
		} else { 
			echo "Error While Changing Password";
		}
	} else {
		echo "Error While Changing Password";
	}
?>