<?php
	session_start();
	if(!isset($_SESSION['username']))
		header('Location: http://localhost/login.html');
?>

<html>
	<head>
		<title>Courese Available</title>
	</head>
	<body>
		<h1>Under Construction</h1>
		<p>This page is still under contruction.  Please check again later.</p>
		<!--stuff needs to go here for the page-->
	</body>
</html>
