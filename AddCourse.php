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
?>
<html>
	<head>
		<title>Add a course</title>
	</head>
	<body>
		<?php
			if($_POST['semester']){
				$un = $_SESSION['username'];
				$sm = $_POST['semester'];
				$yr = $_POST['year'];
				$id = $_GET['courseID'];
				$queryString = "INSERT INTO UserInCourseInSemester VALUES($sm,'$yr',$id,'$un')";
				if(mysql_query($queryString,$connection)){
					echo("<p>Course succesfully added!</p>");
					echo("<a href='Courses_Available.php'>Back</a>");
				}else{
					echo("Error adding course!");
				}
			}else{
			?>
					<p>Enter the semester and year you took this course: </p>
					Semester:
				<?	echo('<form action="AddCourse.php?courseID='.$_GET["courseID"].'" method=POST>'); ?>
					<select name='semester'>
					<option value='1'>Fall</option>
					<option value='2'>January</option>
					<option value='3'>Spring</option>
					<option value='4'>Summer</option>
					</select>
					Year:
					<select name = "year">
					<option></option>
					<script type="text/javascript" >
						year=2011;
						for(i=50;i>0;i--) {
							document.write("<option value='" + year + "'>" + year-- + "</option>");
						}
					</script>
					<input type='submit' />
					</select>
					</form>					
			<?	
			}
			
		?>
		<!--<meta http-equiv="REFRESH" content="0;url=CourseInfo.php">-->
	</body>
</html>