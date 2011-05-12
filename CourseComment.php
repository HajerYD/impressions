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
		$comment = $_POST['comment'];
		$type = $_GET['type'];
	}
	
?>		
<html>
	<head>
		<title><?= $courseName ?></title>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<script language="javascript">
			function clearComment(x){
				if(x.value == "Write your comment here.")	
					x.value = "";
			}
		</script>
		<script type='text/javascript' src='javascripts/thumb_up_down.js'></script>
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
		<h2 style="margin-left:0px"><?=$type?>s</h2>
		
	<!--	<form class='words' action= "CourseComment.php" method= "POST">
			<table>Semester:<tr>
				<select name ="Semester">
				<option>Fall</option>
				<option>Spring</option>
				</select>
			</tr>
			<tr>Year:<select name = "Year">
			<option></option>
					<script type="text/javascript" >
                   year=2011;
                   	for(i=50;i>0;i--) {
                   		document.write("<option value='" + year + "'>" + year-- + "</option>");
                   	}
                   </script>
			</select>
			</tr>
			</table>
			
		<input type = "submit" value = "Search"/><br/>
		</form> -->
		
		<form class = 'words' action = 'CourseComment.php?courseName=<?=$courseName?>&type=<?=$type?>' method = 'POST'>
		<table class ='words'>
			<tr></tr>
			<tr><td><textarea rows="5" cols="47" name ="comment" onfocus = "clearComment(this)">Write your comment here.</textarea></td></tr>
			<tr><td><input type = 'submit' value = 'Post <?=$type?>'></td></tr>
			
		</table>
		</form>
	<?php
		if($comment&&$type){
			//insert into the table for holding comments and resources
			$query = 'INSERT INTO Comments_Resources (commentPost, type) VALUES ("'.$comment.'","'.$type.'")';
			$result = mysql_query($query,$connection) or die ('Error 1:' . mysql_Error());
			//get the postID from the same table
			$query = "SELECT * FROM Comments_Resources WHERE commentPost = '$comment' AND type='$type'";
			$result = mysql_query($query, $connection);
			$row = mysql_fetch_array($result);
			//insert into the relation between Comments_Resources and Users tables
			$query = "INSERT INTO UserMakesPost VALUES ('$userName', '$row[postID]')";
			$result = mysql_query($query, $connection) or die("Error 2: " . mysql_error());
			//get the courseID from the Courses table
			$query = "SELECT * FROM Courses WHERE courseName='$courseName'";
			$result = mysql_query($query, $connection);
			$row2 = mysql_fetch_array($result);
			//insert into relation between Comments_Resources and Courses and Semester
			$query = "INSERT INTO CommentInCourseInSemester VALUES ('$row[postID]', '$row2[courseID]', 'Spring', '2011')";
			mysql_query($query, $connection) or die("Error 3: " . mysql_error());
			
		}
		
		//get the courseID from the Courses table
		$query = "SELECT * FROM Courses WHERE courseName='$courseName'";
		$result = mysql_query($query, $connection);
		$row2 = mysql_fetch_array($result);
		
		$query1 = mysql_query("SELECT * FROM Comments_Resources WHERE type = '".$type."' AND postID IN (SELECT postID FROM CommentInCourseInSemester WHERE courseID='$row2[courseID]') ORDER BY postID DESC",$connection);
		while($rows = mysql_fetch_array($query1)){
			//get the username of the user who made the post
			$query = "SELECT * FROM UserMakesPost WHERE postID='$rows[postID]'";
			$result = mysql_query($query, $connection) or die("Error 927: " . mysql_error());
			$row2 = mysql_fetch_array($result);
			
			$id = $rows['postID'];
			$name = $row2['username'];
			$comment = $rows['commentPost'];
			
			//were going to work on deleting comments if the session[username] wrote it
			/*if($dellink){
				?><form action="CourseComment.php?id=<?=$id?>" method =
				mysql_query("DELETE FROM Comments_Resources WHERE id = 
			}*/
			echo "<label class='words' >Posted by: " . $name . "</label><br /><label class='words' style='font-size:12px;'>on " . $rows['dateCreated'] . "</label><br /><br/><div class='words' style='width:400px;height:75px;border: 2px solid black;font-size:20px;'> " . $comment . "</div><br />";
		   	echo "<label class='words' style='border-bottom: 1px solid;cursor:pointer;' id='".$rows['postID']."' onclick='thumb_up(this.id)'>Thumb Up!</label> &nbsp; <label class='words' id='".$rows[postID]."Thumb'> $rows[cumulativeRating] </label> &nbsp; <label class='words' style='border-bottom: 1px solid;cursor:pointer;' id='$rows[postID]' onclick='thumb_down(this.id)'>Thumb Down...</label><hr/>";
			echo "<div id='username' style='display:none;' >".$name."</div>";
			echo "<div id='postID' style='display:none;' >".$id."</div>";
			echo "<br /><br />";
		
		}
	?>
	</body>
</html>