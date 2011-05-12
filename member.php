<?php
	session_start();
	
	if(!isset($_SESSION['username'])) {
		$username = $_POST ['username'];
		$password = $_POST ['password'];
		
		if(!$username || !$password) {
			header('Location: login.html');
		}
	}
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
	<body>
		
		<?php
			session_start();
	
			if(isset($_SESSION['username'])) {
				echo "<div id='logo'><img src='logo.png' /></div>
				<div id='links'> </br> <br/>
					<a class='nav_links' href='member.php' id='member' />Home</a>
					<a class='nav_links' href='User_Profile.php?username=$_SESSION[username]' id='profile' />Profile</a>
					<a class='nav_links' href='Courses_Available.php' id='courses' />Courses</a>
					<a class='nav_links' href='logout.php' id='logout' />Logout</a>
				</div>";
				echo "<div class='words'>Welcome, ".$_SESSION['username']."!</div>";
				echo "<div class='words'>Welcome to MC's Course Impressions<br /> 
					<div class='words'> Start rating your classes now! <a href='Courses_Available.php' id='courses'>
						click here </a> so you can start viewing your classes!</div> 
						</div>";
				echo "<img src='pic.jpg'>"; 
				echo "<img src='alex.bmp'>"; 
			} else {
	
				$username = $_POST ['username'];
				$password = $_POST ['password'];

				if($username && $password){
					$database = mysql_connect("localhost","simon", "simonk") or die("Couldn't connect");
					mysql_select_db("Impressions", $database) or die ("Couldn't find db");

					$query = mysql_query ("SELECT * from Users where username = '$username'");
					$numrows = mysql_num_rows($query);
					//if numrows with that usename and password exists then execute otherwise output user does not exist
					if($numrows != 0){
						//fetch each column with that username and put it in an array $row
						while ($row = mysql_fetch_array($query)){
							$dbusername = $row['username'];
							$dbpassword = $row['password'];
							$activated = $row['activated'];

							if($activated=='0'){
								die("your account is not yet active, please check your email!");
							}
			
							//checking to see if they match
							if($username==$dbusername && md5($password)==$dbpassword){
								$_SESSION['username']=$username;
							} else {
								die("Incorrect password<br /><a href='login.html'>Login Here</a>");
							}
						}
					} else { 
						die("<p class='words'>That user does not exist!<br/><a href='login.html'>Login Here</a></p>");
					}
				} else {
					die("<p class='words'>please enter your username and password!<br/><a href='login.html'>Login Here</a></p>");
				}
				echo "<div id='logo'><img src='logo.png' /></div>
					<div id='links'><br /><br />
						<a class='nav_links' href='member.php' id='member' />Home</a>
						<a class='nav_links' href='User_Profile.php?username=$_SESSION[username]' id='profile' />Profile</a>
						<a class='nav_links' href='Courses_Available.php' id='courses' />Courses</a>
						<a class='nav_links' href='logout.php' id='logout' />Logout</a>
					</div>";
				echo "<div class='words'>Welcome, ".$_SESSION['username']."!</div>";
				echo "<div class='words'>Welcome to MC's Course Impressions<br /> 
					<div class='words'> Start rating your classes now! <a href='Courses_Available.php' id='courses'>
						click here </a> so you can start viewing your classes!</div> 
						</div>";
				echo "<img src='pic.jpg'>"; 
				echo "<img src='alex.bmp'>"; 
			}	
		?>
	</body>
</html>
