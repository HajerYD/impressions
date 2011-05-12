<?php
	session_start();
	if(!isset($_SESSION['username']))
		header('Location: login.html');	
	$courseName = "Courses";
	if($_GET['courseName'])
		$courseName = $_GET['courseName'];
	//connect to MySQL on the webserver
	$connection = mysql_connect("localhost", "simon", "simonk")
		or die("Could not connect: " . mysql_error() . "<br/>");            
	//select the database
	mysql_select_db("Impressions", $connection) 
		or die("Could not select database<br/>");
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
		<form class='words' action= "Courses_Available.php" method= "POST">
			Name: <input type = "text" name = "theName" /> &nbsp;
			<input type="submit" value = "Search"/><br/>
		</form>
		
		
		<?php	
			if($_POST['theName']!=""){
				$query = "SELECT * FROM Courses WHERE courseName LIKE '%$_POST[theName]%'";
			}
			else if(!$_GET['courseID']){
				$query = "SELECT courseName, courseNum, courseSection, courseID FROM Courses";
			
			}
				$result = mysql_query($query, $connection);
				echo "<table class='words' border='2' id='courses'>";
					?><tr>
						<th>Course Number</th>
						<th>Course Name</th>
						
						<th>Course Section</th>
					</tr>
					<?
				while($row=mysql_fetch_array($result)) {
					//create and execute the query to get the department for all of the classes the user is in
					$query = "SELECT departmentID FROM CoursesInDepartment WHERE courseID='" . $row['courseID'] . "'";// && courseNum='" . $row['courseNum'] . "' && courseSection='" . $row['courseSection'] . "'";
					$result1 = mysql_query($query, $connection) or die("Error: " . mysql_error());
					$row1 = mysql_fetch_array($result1);
					
					//populate the table
					?>
					<tr>
					<td><?=$row1['departmentID']?>-<?=$row['courseNum']?></td>
					<td><?=$row['courseName']?></td>
					
					<td><?=$row['courseSection']?></td>
					<td><a href='CourseInfo?courseID=<?=$row['courseID']?>&departmentID=<?=$row1['departmentID']?>'>View</a></td><td><a href='AddCourse.php?courseID=<?=$row['courseID']?>'>Add</a></td></tr>
					<?
				}
				echo "</table>";
				die('');
			
			
		?>
        
	</body>
</html>
