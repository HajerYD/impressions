<?php
	session_start();
	if(!isset($_SESSION['username']))
		die("You must log in to view this page.<br/><a href='../login.html' >Login Here</a>");
?>

<html>
	<head>
		<title>Answers By User</title>
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
        
        <h2 style='margin-left:0px;'>Answers By <?=$_GET['username']?></h2>
        <!--div for the list of comments by the user-->
        <div>
        <?php
                //connect to MySQL on the webserver
                $connection = mysql_connect("localhost", "simon", "simonk")
                    or die("Could not connect: " . mysql_error() . "<br/>");
            
                //select the database
                mysql_select_db("Impressions", $connection) 
                    or die("Could not select database<br/>");
                
                //create the query and execute for getting all of the postID's from a user
                $query1 = "SELECT * FROM UserMakesAnswer WHERE username='" . $_GET['username'] . "' ORDER BY answerID DESC";
                $result1 = mysql_query($query1, $connection) 
                    or die("Query 1 failed: " . mysql_error() . "<br />");
                while($row1=mysql_fetch_array($result1)) {  
                	//get all of the information about each answer
               		$query2 = "SELECT * FROM Answers WHERE answerID='" . $row1['answerID'] . "'";
               		$result2 = mysql_query($query2, $connection)
               			or die("Query 2 failed: " . mysql_error() . "<br />"); 
               		$row2 = mysql_fetch_array($result2);
               		
               		//get the question information where the answer was made
		           	$query3 = "SELECT * FROM Questions WHERE questionID = (SELECT questionID FROM IsAnswerToQuestion WHERE answerID='" . $row1['answerID'] . "')";
		           	$result3 = mysql_query($query3, $connection)
		           		or die("Query 3 failed: " . mysql_error());
		           	$row3 = mysql_fetch_array($result3);
		           		        		
		            //get the course information where the answer was made
		           	$query4 = "SELECT * FROM Courses WHERE courseID = (SELECT courseID FROM QuestionOfCourseInSemester WHERE questionID='$row3[questionID]')";
		           	$result4 = mysql_query($query4, $connection)
		           		or die("Query 4 failed: " . mysql_error());
		           	$row4 = mysql_fetch_array($result4);
		           	
		           	//get the course information where the answer was made
		           	$query5 = "SELECT departmentID FROM CoursesInDepartment WHERE courseID='$row4[courseID]'";
		           	$result5 = mysql_query($query5, $connection)
		           		or die("Query 5 failed: " . mysql_error());
		           	$row5 = mysql_fetch_array($result5);
		           	
		           	//print out the information of each comment
		           	echo "<a href='../CourseInfo?courseID=$row4[courseID]'><strong>$row4[courseName]&nbsp;&nbsp;&nbsp;$row5[departmentID]-$row4[courseNum]-$row4[courseSection]</strong></a><br />";
		           	echo "<a href='../questionAnswer.php?id=$row3[questionID]'><strong>$row3[questionTitle]</strong></a><br />";//add href
		           	echo "<label style='font-size:12px;'>Posted: $row2[dateCreated]</label><br />";
		           	echo "<textarea style='width:500px;height:100px;max-width:500px;max-height:100px;' cols='50' readonly='readonly'>$row2[answerPost]</textarea><br />";
		           	echo "<label style='font-size:15px;'>Rating: $row2[cumulativeRating]</label>";
		           	echo "<br /><br />";
                }
        ?>
        </div>
	</body>
</html>
