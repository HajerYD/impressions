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
		$id1 = $_GET['departmentID'];
		$result = mysql_query("SELECT courseName from Courses WHERE courseID = $id",$connection);
		$result1 = mysql_query("SELECT name from Department WHERE id = '$id1'",$connection);
		$result2 = mysql_query("SELECT semester, year FROM CoursesAvailableInSemester WHERE courseID = '$id'",$connection);
		$row= mysql_fetch_array($result);
		$row1= mysql_fetch_array($result1);
		$row2= mysql_fetch_array($result2);
		$courseName = $row['courseName'];
		$departmentName = $row1['name'];
		$semester = $row2['semester'];
		$year = $row2['year'];
		
	}
?>
<html>
	<head>
		<title><?= $courseName ?></title>
		<link rel="stylesheet" type="text/css" href="style.css" />

	</head>
	<body>
	
		  <!--div for the main links that are on every page-->
        
              <div id='logo'><img src='logo.png' /></div>
		<div id='links'> </br> <br/>
			<a class='nav_links' href='member.php' id='member' />Home</a>
			<a class='nav_links' href='User_Profile.php?username=<?=$_SESSION[username]?>' id='profile' />Profile</a>
			<a class='nav_links' href='Courses_Available.php' id='courses' />Courses</a>
			<a class='nav_links' href='logout.php' id='logout' />Logout</a>
		</div>
		
		
		
		<!--div for styling the resources and questions links-->
		<div class='words'>
		<h2>Welcome to <?=$courseName?>!</h2>
		Department: <?=$departmentName?><br />
		Year:<?=$year?><br />
		Semester:<?=$semester?><br /> <br />
		<a href='CourseComment.php?courseName=<?=$courseName?>&type=Comment'>Comment</a> <a href='CourseComment.php?courseName=<?=$courseName?>&type=Resource'>Resources</a> <a href='questions.php?courseName=<?=$courseName?>'>Questions</a><br/>
		</div>
		
	</body>
</html>
