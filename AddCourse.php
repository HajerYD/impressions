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
		<link rel="stylesheet" type="text/css" href="style.css" />

	</head>
	<body>
		<div id='logo'><img src='logo.png' /></div>
		<div id='links'> </br> <br/>
			<a class='nav_links' href='member.php' id='member' />Home</a>
			<a class='nav_links' href='User_Profile.php?username=<?=$_SESSION[username]?>' id='profile' />Profile</a>
			<a class='nav_links' href='Courses_Available.php' id='courses' />Courses</a>
			<a class='nav_links' href='logout.php' id='logout' />Logout</a>
		</div>
		

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
					echo("<p class='words'>Error adding course! </p>");
				}
			}else{
			?>
					<label class='words'>Enter the semester and year you took this course:</label><br /><br />
					<label class='words'>Semester: </label>
				<?	echo('<form action="AddCourse.php?courseID='.$_GET["courseID"].'" method=POST>'); ?>
					<select name='semester'>
					<option value='1'>Fall</option>
					<option value='2'>January</option>
					<option value='3'>Spring</option>
					<option value='4'>Summer</option>
					</select>
					<label class='words'>Year: </label>
					<select name = "year">
					<option></option>
					<script type="text/javascript" >
						year=2011;
						for(i=50;i>0;i--) {
							document.write("<option value='" + year + "'>" + year-- + "</option>");
						}
					</script>
					</select>
					<br />
					<br />
					<input type='submit' value='Add Course!' />
					</form>					
			<?	
			}
			
		?>
		<!--<meta http-equiv="REFRESH" content="0;url=CourseInfo.php">-->
	</body>
</html>