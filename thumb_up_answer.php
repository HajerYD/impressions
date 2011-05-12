<?php
	$postID = $_POST['postID'];
	$username = $_POST['username'];
	
	$connection = mysql_connect("localhost", "simon", "simonk");
	mysql_select_db("Impressions", $connection);
	
	$query_string = "UPDATE Answers SET cumulativeRating=cumulativeRating+1 WHERE answerID='$postID'";
	$result = mysql_query($query_string, $connection);
	
	$query_string = "UPDATE Users SET reputation=reputation+1 WHERE username='$username'";
	$result = mysql_query($query_string, $connection);
	
	header("Content-type: text/plain");
	if($result) {
		echo "true";
	} else {
		echo "false";
	}	
?>