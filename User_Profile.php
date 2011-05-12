<?php
	session_start();
	if(!isset($_SESSION['username'])) {
		die("You must log in to view this page.<br/><a href='login.html' >Login</a>");
	}
	if(isset($_GET['username'])) {
		$username = $_GET['username'];
	} else {
		die("An error occurred.  Please contact the site administrator.");
	}
?>

<html>
    <head>
		<link rel="stylesheet" type="text/css" href="style.css" />
        	<title>User Profile</title>
		<div id='logo'><img src='logo.png' /></div>
    </head>
    <body>
        <!--div for the main links that are on every page-->
	
       <div id='links'> </br> <br/>
		<a class='nav_links' href='member.php' id='member' />Home</a>
		<a class='nav_links' href='User_Profile.php?username=<?=$_SESSION[username]?>' id='profile' />Profile</a>
		<a class='nav_links' href='Courses_Available.php' id='courses' />Courses</a>
		<a class='nav_links' href='logout.php' id='logout' />Logout</a>
		</div>
        <br />
        <br />
        
        <!--div for containing the username, reputation, real name, class standing-->
        <div>
            <?php
                //print out the username and edit profile if it is the current user's profile
                if($_SESSION['username'] == $_GET['username']) 
	                echo "<div class='words'><strong class='words' style='font-size:25px;'>$username</strong> - <a href='Edit_Profile.php?username=$username' style='font-size:12px;'>Edit Profile</a><br /></div>";
				else
					echo "<strong>$username</strong><br />";
            
                //connect to MySQL on the webserver
                $connection = mysql_connect("localhost", "simon", "simonk")
                    or die("Could not connect: " . mysql_error() . "<br/>");
            
                //select the database
                mysql_select_db("Impressions", $connection) 
                    or die("Could not select database<br/>");
                
                //create the query and execute for getting the rank information
                $query = "SELECT rankName FROM Rank WHERE (reputationMax, reputationMin) IN (SELECT reputationMax, reputationMin FROM UserHasRank WHERE username='" . $username . "')";
                $result1 = mysql_query($query, $connection) 
                    or die("Query failed: " . mysql_error() . "<br/>");
                while($row=mysql_fetch_array($result1)) {
                    print "<div class='words'>".$row['rankName'];               
                }
            
                //create the query and execute for getting the reputation
                $query = "SELECT reputation FROM Users WHERE username = '" . $username . "'";
                $result2 = mysql_query($query, $connection) 
                    or die("Query failed: " . mysql_error() . "<br/>");
                while($row=mysql_fetch_array($result2)) {
                    print " - " . $row['reputation'] . "</div><br/><br/>";               
                }
                             
                //create the query and execute for getting the name
                $query = "SELECT firstName FROM Users WHERE username = '" . $username . "'";
                $result3 = mysql_query($query, $connection) 
                    or die("Query failed: " . mysql_error() . "<br/>");
                while($row=mysql_fetch_array($result3)) {
                    print "<div class='words'><strong>Name: </strong> " . $row['firstName'] . "<br/>";               
                }
                
                //create the query and execute for getting the class standing
                $query = "SELECT currentStanding FROM Users WHERE username = '" . $username . "'";
                $result4 = mysql_query($query, $connection) 
                    or die("Query failed: " . mysql_error() . "<br/>");
                while($row=mysql_fetch_array($result4)) {
                    print "<strong>Current Standing: </strong>" . $row['currentStanding'] . "</div>";               
                }
             	
            ?>
        </div>
        <!--div for holding all of the classes the current user is in--> 
        <div>
            <?php
            	//print out the title of the section with h2 header
				echo "<br/><br/><strong class='words' style='font-size:25'>My Classes:</strong>";
				
				//create and execute the query to get all of the classes the current user is in.
				$query = "SELECT * FROM UserInCourseInSemester WHERE username='" . $username . "'";
				$result = mysql_query($query, $connection);
				
				//set up the table and then populate it with the courses the current user is in
				echo "<table border='2' style='font-size:13pt;' class='words' id=courses>";
				while($row=mysql_fetch_array($result)) {
					//create and execute the query to get the department for all of the classes the user is in
					$query = "SELECT departmentID FROM CoursesInDepartment WHERE courseID='" . $row['courseID'] . "'";
					$query2 = "SELECT * FROM Courses WHERE courseID='" . $row['courseID'] . "'";
					$result1 = mysql_query($query, $connection);
					$result2 = mysql_query($query2, $connection);
					$row1 = mysql_fetch_array($result1);
					$row2 = mysql_fetch_array($result2);
					
					//populate the table
					echo "<tr>";
					echo "<td><a href='CourseInfo?courseID=$row2[courseID]'>$row1[departmentID]-$row2[courseNum]-$row2[courseSection]</a></td>";
					echo "<td><a href='CourseInfo?courseID=$row2[courseID]'>$row2[courseName]</a></td>";
					echo "<td>$row[semester]-$row[year]</td>";
					echo "</tr>";
				} 
				echo "</table";
            ?>
        </div>
		<!--div for holding the links to specific pages for the current user (comments by user, resources by user, questions by user, answers by user)-->        
		<div>
			<br/>
			<br/>
			<a href="postsByUser/Comments_By_User.php?username=<?=$username?>"><strong>Comments I Have Posted</strong></a><br/>
			<a href="postsByUser/Resources_By_User.php?username=<?=$username?>"><strong>Resources I Have Posted</strong></a><br/>
			<a href="postsByUser/Questions_By_User.php?username=<?=$username?>"><strong>Questions I Have Posted</strong></a><br/>
			<a href="postsByUser/Answers_By_User.php?username=<?=$username?>"><strong>Answers I Have Posted</strong></a><br/>
		</div>
		
    </body>
</html>
