<html>
	<head>
		<title>Registration Results</title>
	</head>
	<body>
		<?php
			$password = md5($_POST["password1"]);
			echo $password . "<br/>"

			// Connecting, selecting database
			$link = mysql_connect("localhost", "simon", "simonk")
		 		or die("Could not connect: " . mysql_error() . "<br/>");
			echo "Connected successfully<br/>";
			mysql_select_db("Impressions") or die("Could not select database<br/>");
	
			// Performing SQL query
			$query = "INSERT INTO RegisteredUsers () VALUES ('" . $_POST["firstName"] . "','" . $_POST["lastName"] . "','" . $_POST["birthdate"] . "','" . $_POST["currentStanding"] . "','" . $_POST["username"] . "','" . $password . "', 'DEFAULT', 'DEFAULT','" . $_POST["email1"] . "');";
			$result = mysql_query($query) or die("Query failed: " . mysql_error() . "<br/>"); 
		
			//Close the connection to the server since we're done querying			
			mysql_close($link);
		?>
	</body>
</html>
