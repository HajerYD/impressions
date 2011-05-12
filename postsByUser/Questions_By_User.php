<?php
	session_start();
	if(!isset($_SESSION['username']))
		die("You must log in to view this page.<br/><a href='../login.html' >Login Here</a>");
?>

<html>
	<head>
		<title>Questions By User</title>
		<link rel="stylesheet" type="text/css" href="../style.css" />

	</head>
	<body>
		<!--div for the main links that are on every page-->
        <div id='logo'><img src='../logo.png' />
				<div style="background-image:url('../links_bg.png');width:1500px;height:107px;background-repeat:no-repeat;"> <br /> <br />
				<a class='nav_links' href='../member.php' id='member' />Home</a>
				<a class='nav_links' href='../User_Profile.php?username=<?=$_SESSION[username]?>' id='profile' />Profile</a>
				<a class='nav_links' href='../Courses_Available.php' id='courses' />Courses</a>
				<a class='nav_links' href='../logout.php' id='logout' />Logout</a>
				</div>
        <br/>
        
        <h2 style='margin-left:0px;'>Questions By <?=$_GET['username']?></h2>
        <!--div for the list of questions by the user-->
        <div>
        <?php
                //connect to MySQL on the webserver
                $connection = mysql_connect("localhost", "simon", "simonk")
                    or die("Could not connect: " . mysql_error() . "<br/>");
            
                //select the database
                mysql_select_db("Impressions", $connection) 
                    or die("Could not select database<br/>");
                
                //create the query and execute for getting all of the postID's from a user
                $query1 = "SELECT * FROM UserAsksQuestion WHERE username='" . $_GET['username'] . "' ORDER BY questionID DESC";
                $result1 = mysql_query($query1, $connection) 
                    or die("Query 1 failed: " . mysql_error() . "<br />");
                while($row1=mysql_fetch_array($result1)) {  
                	//get all of the information about each question
               		$query2 = "SELECT * FROM Questions WHERE questionID='" . $row1['questionID'] . "'";
               		$result2 = mysql_query($query2, $connection)
               			or die("Query 2 failed: " . mysql_error() . "<br />"); 
               		$row2 = mysql_fetch_array($result2);
               		
               		//get the course information where the question was asked
		           	$query3 = "SELECT * FROM Courses WHERE courseID = (SELECT courseID FROM QuestionOfCourseInSemester WHERE questionID='" . $row1['questionID'] . "')";
		           	$result3 = mysql_query($query3, $connection)
		           		or die("Query 3 failed: " . mysql_error());
		           	$row3 = mysql_fetch_array($result3);
		           		        		
		           	//get the course information where the comment was made
		           	$query4 = "SELECT * FROM CoursesInDepartment WHERE courseID='$row3[courseID]'";
		           	$result4 = mysql_query($query4, $connection)
		           		or die("Query 4 failed: " . mysql_error());
		           	$row4 = mysql_fetch_array($result4);
		           		
		           	//print out the information of each comment
		           	echo "<a href='../CourseInfo?courseID=$row3[courseID]'><strong>$row3[courseName]&nbsp;&nbsp;&nbsp;$row4[departmentID]-$row3[courseNum]-$row3[courseSection]</strong></a><br />";
		            echo "<br /><a href='../questionAnswer.php?id=$row2[questionID]'>$row2[questionTitle]</a><br />";
		           	echo "<label style='font-size:12px;'>Posted: $row2[dateCreated]</label><br />";
		           	echo "<br /><br />";
                }
        ?>
        </div>
	</body>
</html>
