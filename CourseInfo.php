<?php
	session_start();
	if(!isset($_SESSION['username']))
		header('Location: login.html');	
	$courseName = "Courses";
	//connect to MySQL on the webserver
	$connection = mysql_connect("localhost", "simon", "simonk")
		or die("Could not connect: " . mysql_error() . "<br/>");            
	//select the database
	mysql_select_db("Impressions", $connection) 
		or die("Could not select database<br/>");
	if($_GET['courseID']){
		$id = $_GET['courseID'];
		$result = mysql_query("SELECT courseName from Courses WHERE courseID = $id",$connection);
		$row= mysql_fetch_array($result);
		$courseName = $row['courseName'];
	}
?>
<html>
	<head>
		<title><?= $courseName ?></title>
	</head>
	<body>
	
		 <!--div for the main links that are on every page-->
        <div>
            <a href="member.php" id="member" />Home</a>
            <a href="User_Profile.php?username=<?=$username?>" id="profile" />Profile</a>
            <a href="Courses_Available.php" id="courses" />Courses</a>
            <a href="logout.php" id="logout" />Logout</a>
		</div>
		
		
		
		<!--div for styling the resources and questions buttons-->
		<div>
		<h2><?=$courseName?></h2>		<a href='CourseComment.php?courseName=<?=$courseName?>&type=Comment'>Comment</a> <a href='CourseComment.php?courseName=<?=$courseName?>&type=Resource'>Resources</a> <a href=''>Questions</a><br>
		</div>
		
		<h1>Under Construction</h1>
		<p>This page is still under contruction.  Please check again later.</p>
		<!--stuff needs to go here for the page-->
	</body>
</html>
