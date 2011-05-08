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
		<script language="javascript">
			function clearComment(x){
				if(x.value == "Write your comment here.")	
					x.value = "";
			}
		</script>
	</head>
	
	<body>
	
		<?echo $type;?>
		<h2><?=$courseName?></h2>
		
		<form action= "Courses_Available.php" method= "POST">
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
		</form>
		
		<form action = 'CourseComment.php?courseName=<?=$courseName?>&type=<?=$type?>' method = 'post'>
		<table>
			<tr><td>Comment:</td></tr>
			<tr><td><textarea rows="5" cols="30" name ="comment" onfocus = "clearComment(this)">Write your comment here.</textarea></td></tr>
			<tr><td><input type = 'submit' value = 'Comment'></td></tr>
			<tr><td>Posted by:</td><td><?=$userName?></td></tr>
		</table>
		</form>
	<?php
		if($comment&&$type){
			echo "$type, $comment";
			$query = 'INSERT INTO Comments_Resources (commentPost, type) VALUES ("'.$comment.'","'.$type.'")';
			$result = mysql_query($query,$connection) or die ('Error:' . mysql_Error());
		}
	?>
	</body>
</html>