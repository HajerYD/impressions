<?php
	session_start();
	echo "Username: " . $_SESSION['username'];
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
            <a href="login.html" id="logout" onclick="" />Logout</a>
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
                
                //close the connection
                mysql_close($connection);
            ?>
        </div>
        
        <div>
            <?php
                
            ?>
        </div>
        
        
        
        <?php
        
        ?>
    </body>
</html>
