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
        <title>User Profile</title>
    </head>
    <body>
        <!--div for the main links that are on every page-->
        <div>
            <a href="member.php" id="member" />Home</a>
            <a href="User_Profile.php?username=<?=$username?>" id="profile" />Profile</a>
            <a href="Courses_Available.php" id="courses" />Courses</a>
            <a href="logout.php" id="logout" />Logout</a>
        </div>
        <br />
        <br />
        
        <!--div for containing the username, reputation, real name, class standing-->
        <div>
            <?php
                //print out the username in this div
                echo "<strong>$username</username><br />";
            
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
                    print $row['rankName'];               
                }
            
                //create the query and execute for getting the reputation
                $query = "SELECT reputation FROM Users WHERE username = '" . $username . "'";
                $result2 = mysql_query($query, $connection) 
                    or die("Query failed: " . mysql_error() . "<br/>");
                while($row=mysql_fetch_array($result2)) {
                    print " - " . $row['reputation'] . "<br/><br/>";               
                }
                             
                //create the query and execute for getting the name
                $query = "SELECT firstName FROM Users WHERE username = '" . $username . "'";
                $result3 = mysql_query($query, $connection) 
                    or die("Query failed: " . mysql_error() . "<br/>");
                while($row=mysql_fetch_array($result3)) {
                    print "Name: " . $row['firstName'] . "<br/>";               
                }
                
                //create the query and execute for getting the class standing
                $query = "SELECT currentStanding FROM Users WHERE username = '" . $username . "'";
                $result4 = mysql_query($query, $connection) 
                    or die("Query failed: " . mysql_error() . "<br/>");
                while($row=mysql_fetch_array($result4)) {
                    print "Current Standing: " . $row['currentStanding'] . "<br/>";               
                }
             	
            ?>
        </div>
        <!--div for holding all of the classes the current user is in--> 
        <div>
            <?php
            	//print out the title of the section with h2 header
				echo "<br/><br/><h2>My Classes:</h2>";
				
				//create and execute the query to get all of the classes the current user is in.
				$query = "SELECT * FROM UserInCourseInSemester WHERE username='" . $username . "'";
				$result = mysql_query($query, $connection);
				
				//set up the table and then populate it with the courses the current user is in
				echo "<table border='2' id=courses>";
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
					echo "<td><a href=''>$row1[departmentID]-$row2[courseNum]-$row2[courseSection]</a></td>";//need to enter in a page for which each course will be shown
					echo "<td><a href=''>$row2[courseName]</a></td>";//need to enter in a page for which each course will be shown
					echo "<td><a href=''>$row[semester]-$row[year]</a></td>";//need to enter in a page for which each course will be shown
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
			<a href="postsByUser/SubComments_By_User.php?username=<?=$username?>"><strong>SubComments I Have Posted</strong></a><br/>
		</div>
		
		                
    </body>
</html>
