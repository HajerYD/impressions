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
	</head>
	<body>
	
		 <!--div for the main links that are on every page-->
        <div>
            <a href="member.php" id="member" />Home</a>
            <a href="User_Profile.php" id="profile" />Profile</a>
            <a href="Courses_Available.php" id="courses" />Courses</a>
            <a href="logout.php" id="logout" />Logout</a>
		</div>
		<form action= "Courses_Available.php" method= "POST">
			Name: <input type = "text" name = "theName" /> <br />
			<input type = "button" value = "Submit"/><br/>
		</form>
		<?
			//if($_POST['theName']!=""){
				//$query = "SELECT * FROM Courses WHERE courseName = '$_POST[theName]'";

			//}
			//else{
			if(!$_GET['courseID']){
				$query = "SELECT courseName, courseNum, courseSection,courseID FROM Courses";
			}
			//}
				$result = mysql_query($query, $connection);
				echo "<table border='2' id='courses'>";
				/*	?><tr>
						<th>Department</th>
						<th>Course Name</th>
						<th>Course Number</th>
						<th>Course Section</th>
					</tr>
					<?*/
				while($row=mysql_fetch_array($result)) {
					//create and execute the query to get the department for all of the classes the user is in
					$query = "SELECT departmentID FROM CoursesInDepartment WHERE courseID='" . $row['courseID'] . "'";// && courseNum='" . $row['courseNum'] . "' && courseSection='" . $row['courseSection'] . "'";
					$result1 = mysql_query($query, $connection) or die("Error: " . mysql_error());
					$row1 = mysql_fetch_array($result1);
					
					//populate the table
					?>
					<tr>
					<td><?=$row1['departmentID']?></td>
					<td><?=$row['courseName']?></td>
					<td><?=$row['courseNum']?></td>
					<td><?=$row['courseSection']?></td>
					<td><a href='Courses_Available.php?courseID=<?=$row['courseID']?>'>View</a></td><td><a href='AddCourse.php'>Add</a></td></tr>
					<?
				}
				echo "</table>";
				die('');
			
		?>
        
		<!--div for styling the resources and questions buttons-->
		<div>
		<h2><?= $_GET['courseName'] ?></h2>		<a href=''>Resources</a> <a href=''>Questions</a><br>
		</div>
		
		
		<textarea rows="5" cols="30">Write your comment here.
		</textarea>
		<input type = 'button' value = 'POST' onclick="addComment">
		
		<h1>Under Construction</h1>
		<p>This page is still under contruction.  Please check again later.</p>
		<!--stuff needs to go here for the page-->
	</body>
</html>
