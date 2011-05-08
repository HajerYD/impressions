<html>
	<body>
		<?php
			session_start();
	
			if(isset($_SESSION['username'])) {
				echo "<div>
            		<a href='member.php' id='member' />Home</a>
            		<a href='User_Profile.php?username=$_SESSION[username]' id='profile' />Profile</a>
            		<a href='Courses_Available.php' id='courses' />Courses</a>
            		<a href='logout.php' id='logout' />Logout</a></div><br/><br/>";
        		echo "Welcome, ".$_SESSION['username']."!";
			} else {
	
				$username = $_POST ['username'];
				$password = $_POST ['password'];

				if($username && $password){
					$database = mysql_connect("localhost","simon", "simonk") or die("Couldn't connect");
					mysql_select_db("Impressions") or die ("Couldn't find db");

					$query = mysql_query ("SELECT * from Users where username = '$username'");
					$numrows = mysql_num_rows($query);
					//if numrows with that usename and password exists then execute otherwise output "user does not exist"
					if($numrows != 0){
						//fetch each column with that username and put it in an array $row
						while ($row = mysql_fetch_assoc($query)){
							$dbusername = $row['username'];
							$dbpassword = $row['password'];
							$activated = $row['activated'];

							if($activated=='0'){
								die("your account is not yet active, please check your email!");
							}
			
							//checking to see if they match
							if($username==$dbusername && md5($password)==$dbpassword){
								$_SESSION['username']=$username;
							} else
								die("Incorrect password<br/><a href='login.html'>Login Here</a>");
							}
					}else
						die("That user does not exist!<br/><a href='login.html'>Login Here</a>"); 
				}else 
					die("please enter your username and password!<br/><a href='login.html'>Login Here</a>");
					
				echo "<div>
            		<a href='member.php' id='member' />Home</a>
            		<a href='User_Profile.php?username=$_SESSION[username]' id='profile' />Profile</a>
            		<a href='Courses_Available.php' id='courses' />Courses</a>
            		<a href='logout.php' id='logout' />Logout</a></div><br/><br/>";
				echo "Welcome, ".$_SESSION['username']."!";
			}	
		?>
	</body>
</html>
