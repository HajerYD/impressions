<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
	<body>
		<?php
			session_start();

			$username = $_POST ['username'];
			$password = $_POST ['password'];

			if($username && $password){
				$database = mysql_connect("localhost","simon", "simonk") or die("Couldn't connect");
				mysql_select_db("Impressions") or die ("Couldn't find db");

				$query = mysql_query ("SELECT * from Users where username = '$username'");
				$numrows = mysql_num_rows($query);
			//if numrows with that usename and password exists then execute otherwise output "user doesnot exist
			if($numrows != 0){
			//fetch each column with that username and put it in an array $row
				while ($row = mysql_fetch_assoc($query)){
					$dbusername = $row['username'];
					$dbpassword = $row['password'];
					$activated = $row['activated'];

				if($activated=='0'){
					die("your account is not yet active, please check your email!");
					exit();
				}
				//checking to see if they match
				if($username==$dbusername && md5($password)==$dbpassword){
					echo "you're in!<a href='member.php'>Click here</a> to enter the member page";
					$_SESSION['username']=$username;
				}
				else
					echo "Incorrect password";

				}
			}
			 else
				die("That user does not exist!"); 
			}else 
				die("please enter your username and password!");

		?>
	</body>
</html>