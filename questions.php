<?php
	session_start();
	if(!isset($_SESSION['username']))
		header('Location: login.html');	
		
	//connect to MySQL on the webserver
	$connection = mysql_connect("localhost", "simon", "simonk")
		or die("Could not connect: " . mysql_error() . "<br/>");     
       
	//select the database
	mysql_select_db("Impressions", $connection) 
		or die("Could not select database<br/>");
		
	if($_GET['courseName']){
		$courseName = $_GET['courseName'];
		$userName = $_SESSION['username'];
		$questionTitle = $_POST['questionTitle'];
		$questionPost = $_POST['questionPost'];
		
	}
?>	
<html>
	<head>
		<title><?= $courseName ?></title>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<script language="javascript">
			function clearQuestion(x){
				if(x.value == "Write title here." || x.value == "Write question here.")	
					x.value = "";
			}
		</script>
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
		<a href='CourseComment.php?courseName=<?=$courseName?>&type=Comment'>Comment</a> <a href='CourseComment.php?courseName=<?=$courseName?>&type=Resource'>Resources</a> <a href='questions.php?courseName=<?=$courseName?>'>Questions</a><br/>
		
		<h2 style='margin-left:0px;'><?=$courseName?></h2>
		<form class = 'words' action = 'questions.php?courseName=<?=$courseName?>' method = 'post'>
		<table>
			<tr><td><strong>New Question:</strong></td></tr>
			<tr><td><textarea rows="1" cols="30" name ="questionTitle" onfocus = "clearQuestion(this)">Write question title here...</textarea></td></tr>
			<tr></tr>
			<tr><td><textarea rows="5" cols="60" name ="questionPost" onfocus = "clearQuestion(this)">Write question post here...</textarea></td></tr>
			<tr><td><input type = 'submit' value = 'Ask Question'></td></tr>
			<tr><td>Post by:  <?=$userName?></td></tr>
		</table>
		</form>
	<?php
		if($questionTitle&&$questionPost){
			//insert into the Questions table
			$query = 'INSERT INTO Questions (questionTitle, questionPost) VALUES ("'.$questionTitle.'","'.$questionPost.'")';
			$result = mysql_query($query,$connection) or die ('Error 1:' . mysql_Error());
			//get the questionID from the Questions table
			$query = "SELECT * FROM Questions WHERE questionTitle='$questionTitle' AND questionPost='$questionPost'";
			$result = mysql_query($query, $connection) or die("Error 1.5: " . mysql_error());
			$row = mysql_fetch_array($result);
			//insert into the relationship between Users and Questions tables
			$query = "INSERT INTO UserAsksQuestion VALUES ('$userName', '$row[questionID]')";
			mysql_query($query, $connection) or die("Error 2: " . mysql_error());
			//get the courseID from the Courses table
			$query = "SELECT * FROM Courses WHERE courseName='$courseName'";
			$result = mysql_query($query, $connection);
			$row2 = mysql_fetch_array($result);
			//insert into the relationship between Courses and Questions tables 
			$query = "INSERT INTO QuestionOfCourseInSemester VALUES ('$row[questionID]', '$row2[courseID]', 'Spring', '2011')";
			mysql_query($query, $connection) or die("Error 3: ". mysql_error());
		}
			//get the courseID from the Courses table
			$query = "SELECT * FROM Courses WHERE courseName='$courseName'";
			$result = mysql_query($query, $connection);
			$row2 = mysql_fetch_array($result);
			
			
			$query1 = mysql_query("SELECT questionTitle, username, questionID FROM Questions WHERE questionID IN (SELECT questionID FROM QuestionOfCourseInSemester WHERE courseID='$row2[courseID]') ORDER BY questionID DESC",$connection) or die("Error 88: " . mysql_error());
			while($rows = mysql_fetch_array($query1)){
				//get the user who posted this question
				$query = "SELECT * FROM UserAsksQuestion WHERE questionID='$rows[questionID]'";
				$result = mysql_query($query, $connection) or die("Error 345: " . mysql_error());
				$row2 = mysql_fetch_array($result);
				$questionID = $rows['questionID'];
				$name = $row2['username'];
				$title = $rows['questionTitle'];
				$answers = "<a href = \"questionAnswer.php?id=".$questionID."&courseName=".$courseName."\">$title</a>";
				
				echo $answers . "  Asked by  " . $name. "<br />";
			}
	?>
		
	</body>
</html>