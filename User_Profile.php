<?php
	session_start();
	if(!isset($_SESSION['username'])) {
		die("You must log in to view this page.<br/><a href='login.html' >Login</a>");
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
            <a href="User_Profile.php" id="profile" />Profile</a>
            <a href="Courses_Available.php" id="courses" />Courses</a>
            <a href="logout.php" id="logout" />Logout</a>
        </div>
        
        <!--div for containing the username, reputation, real name, class standing-->
        <div>
            <?php
                //print out the username in this div
                echo $_POST['username'];
            
                //connect to MySQL on the webserver
                $connection = mysql_connect("localhost", "simon", "simonk")
                    or die("Could not connect: " . mysql_error() . "<br/>");
            
                //select the database
                mysql_select_db("Impressions", $connection) 
                    or die("Could not select database<br/>");
                
                //create the query and execute for getting the rank information
                $query = "SELECT rankName FROM Rank WHERE (reputationMax, reputationMin) IN (SELECT reputationMax, reputationMin FROM UserHasRank WHERE username='ashokanson')";//use a variable for the username here
                $result1 = mysql_query($query, $connection) 
                    or die("Query failed: " . mysql_error() . "<br>");
                while($row=mysql_fetch_array($result1)) {
                    print $row['rankName'];               
                }
            
                //create the query and execute for getting the reputation
                $query = "SELECT reputation FROM Users WHERE username = 'ashokanson'";//use a variable for the username here
                $result2 = mysql_query($query, $connection) 
                    or die("Query failed: " . mysql_error() . "<br>");
                while($row=mysql_fetch_array($result2)) {
                    print " - " . $row['reputation'] . "<br/><br/>";               
                }
                             
                //create the query and execute for getting the name
                $query = "SELECT firstName FROM Users WHERE username = 'ashokanson'";//use a variable for the username here
                $result3 = mysql_query($query, $connection) 
                    or die("Query failed: " . mysql_error() . "<br>");
                while($row=mysql_fetch_array($result3)) {
                    print "Name: " . $row['firstName'] . "<br/>";               
                }
                
                //create the query and execute for getting the class standing
                $query = "SELECT currentStanding FROM Users WHERE username = 'ashokanson'";//use a variable for the username here
                $result4 = mysql_query($query, $connection) 
                    or die("Query failed: " . mysql_error() . "<br>");
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
				$query = "SELECT courseName, courseNum, courseSection FROM UsersInCourse WHERE username='" . $_SESSION['username']. "'";
				$result = mysql_query($query, $connection);
				
				//set up the table and then populate it with the courses the current user is in
				echo "<table border='2' id=courses>";
				while($row=mysql_fetch_array($result)) {
					//create and execute the query to get the department for all of the classes the user is in
					$query = "SELECT departmentID FROM CoursesInDepartment WHERE courseName='" . $row['courseName'] . "' && courseNum='" . $row['courseNum'] . "' && courseSection='" . $row['courseSection'] . "'";
					$result1 = mysql_query($query, $connection) or die("Error: " . mysql_error());
					$row1 = mysql_fetch_array($result1);
					
					//populate the table
					echo "<tr>";
					echo "<td><a href=''>$row1[departmentID]-$row[courseNum]-$row[courseSection]</a></td>";//need to enter in a page for which each course will be shown
					echo "<td><a href=''>$row[courseName]</a></td>";//need to enter in a page for which each course will be shown
					echo "</tr>";
				}
				echo "</table";
            ?>
        </div>
		<!--div for holding the links to specific pages for the current user (comments by user, resources by user, questions by user, answers by user)-->        
		<div>
			<br/>
			<br/>
			<a href=""><strong>Comments I Have Posted</strong></a><br/><!--need to put in href value-->
			<a href=""><strong>Resources I Have Posted</strong></a><br/><!--need to put in href value-->
			<a href=""><strong>Questions I Have Posted</strong></a><br/><!--need to put in href value-->
			<a href=""><strong>Answers I Have Posted</strong></a><br/><!--need to put in href value-->
		</div>
		                
    </body>
</html>
