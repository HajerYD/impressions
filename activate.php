<?php
	$connect = mysql_connect("localhost","simon","simonk") or die("Cannot connect!");
	mysql_select_db("Impressions") or die("Cannot find db");
	$username = $_GET['username'];
	$code = $_GET['code'];

	if($username && $code){
		//Checking if the activation code and email are in the same instance.
		$check = mysql_query("select * from Users where username='$username' and random='$code'");

		$checknum = mysql_num_rows($check);
			if($checknum==1){
				//activation of the account.
			$activate = mysql_query ("update Users set activated='1' where random = '$code'");
				die("Your account has been acitivated. Proceed to <a href= login.html>Log In<a/>");
			}else
				die("Invalid activation code!");
	}else 
		die("Data missing");
?>
