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
		
	if($_GET['id']){
		$questionID = $_GET['id'];
		$courseName = $_GET['courseName'];
		$userName = $_SESSION['username'];
		$answer = $_POST['answer'];
		$query1 = mysql_query("SELECT questionTitle, questionPost, username FROM Questions WHERE questionID='".$questionID."'",$connection);
		while($rows = mysql_fetch_array($query1)){
		$postname = $rows['username'];
		$questionTitle = $rows['questionTitle'];
		$questionPost = $rows['questionPost'];
		}
	}
?>	
<html>
	<head>
		<title><?=$courseName?></title>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<script language="javascript">
			function clearAnswer(x){
				if(x.value == "Write answer here.")	
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
		<br />
		<h3 style= 'margin-left:0px'>"<?=$questionTitle?>"</h3>
		<h3 style= 'margin-left:0px'><?=$questionPost?></h3>
		<form action='questionAnswer.php?id=<?=$questionID?>&courseName=<?=$courseName?>' method = 'post'>
		<table>
			<tr><td><textarea rows="5" cols="60" name ="answer" onfocus = "clearAnswer(this)">Write answer here.</textarea></td></tr>
			<tr><td><input type = 'submit' value = 'Answer Question'></td></tr>
			<tr><td>Post by:  <?=$userName?></td></tr>
		</table>
		</form>
	<?php
		if($answer){
			//Inserting answer into Answers table.
			$query = 'INSERT INTO Answers (answerPost) VALUES ("'.$answer.'")'; 
			$result = mysql_query($query,$connection) or die ('Error:' . mysql_Error());
			
			//Selecting the newly created answerID from the Answers table.
			$query_string = mysql_query("SELECT * FROM Answers WHERE answerPost='".$answer."'",$connection);
			while($rows = mysql_fetch_array($query_string)){
			$answerID = $rows['answerID'];
			
			//Inserting that answerID into UserMakesAnswer relationship and IsAnswerToQuestion relationship.
			$query_string1 = mysql_query('INSERT INTO UserMakesAnswer (username, answerID) VALUES ("'.$userName.'","'.$answerID.'")',$connection);
			$query1 = 'INSERT INTO IsAnswerToQuestion (questionID, answerID) VALUES ("'.$questionID.'","'.$answerID.'")';
			$result1 = mysql_query($query1,$connection) or die ('Error:' . mysql_Error());
			}
		}
			//Returninng the Answers to a selected question.
			//Selecting answerID from the IsAnswerToQuestion relationship.
			$query_string3 = mysql_query("SELECT answerID FROM IsAnswerToQuestion WHERE questionID='".$questionID."' ORDER BY answerID DESC",$connection);
			while($rows1 = mysql_fetch_array($query_string3)){
			$answerID_QuestionID = $rows1['answerID'];

			//Using that answerID select answerPost and answerID from the Answers table.
			$query2 = mysql_query("SELECT * FROM Answers WHERE answerID='".$answerID_QuestionID."'",$connection);
			while($rows2 = mysql_fetch_array($query2)){
			$answerPost = $rows2['answerPost']; 
			
			//Selecting the user-that-answered the question from the UserMakesAnswer relationship.
			$query3 = mysql_query("SELECT username FROM UserMakesAnswer WHERE answerID = '".$answerID_QuestionID."'",$connection);
			while($rows3 = mysql_fetch_array($query3)){
			$name = $rows3['username'];
			
			echo "<label class='words' >Answer by: " . $name . "</label><br /><label class='words' style='font-size:12px;'>on " . $rows2['dateCreated'] . "</label><br /><br/><div class='words' style='width:400px;height:75px;border: 2px solid black;font-size:20px;'> " . $answerPost . "</div><br />";
		    echo "<label class='words' style='cursor:pointer;border-bottom: 1px solid;' id='".$answerID_QuestionID."' onclick='thumb_up_answer(this.id)'>Thumb Up!</label> &nbsp; <label class='words' id='".$answerID_QuestionID."Thumb'> $rows2[cumulativeRating] </label> &nbsp; <label class='words' style='cursor:pointer;border-bottom: 1px solid;' id='".$answerID_QuestionID."' onclick='thumb_down_answer(this.id)'>Thumb Down...</label><hr/>";
			echo "<div id='username' style='display:none;' >".$name."</div>";
			echo "<div id='postID' style='display:none;' >".$answerID_QuestionID."</div>";
			echo "<br /><br />";
			}
			}
			}
	?>
	</body>
</html>