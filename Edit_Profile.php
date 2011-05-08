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
	
	//need to get the information about the user so that the fields are pre-completed with current information
	$connection = mysql_connect("localhost","simon","simonk") or die("Error: " . mysql_error());\
	mysql_select_db("Impressions", $connection) or die("Error: " . mysql_error);
	$query_string = "SELECT * FROM Users WHERE username='$username'";
	$result = mysql_query($query_string, $connection) or die("Error: " . mysql_error());
	
	if($row=mysql_fetch_array($result)) {		
?>

<html>
    <head>
        <title>Edit Profile</title>
        <script src="javascripts/Edit_Profile.js" type="text/javascript"></script>
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
       
       <!--div for holding the form that the user fills out to change user profile settings-->
       <div>
       		<form action="">
       			<input type="hidden" id="username" value="<?=$username?>" />
       			<table>
		        	<tr><td>First Name:</td> <td><input type = "text" id="firstName" name="firstName" value="<?=$row[firstName]?>" /></td></tr>
		            <tr><td>Last Name:</td> <td><input type = "text" name="lastName" id="lastName" value="<?=$row[lastName]?>" /></td></tr>
		            <tr><td>Spartan E-Mail:</td> <td><input type = "text" name="email1" id="email1" value="<?=$row[email]?>" /></td></tr>
		            <tr><td>Re-type E-Mail:</td> <td><input type = "text" name="email2" id="email2" value="<?=$row[email]?>" /></td></tr>
		            <tr><td>Current Standing</td><td><select name="currentStanding" id="currentStanding" >
		         	   <option value=""></option>
		         	   <option value="Freshman">Freshman</option>
		               <option value="Sophomore">Sophomore</option>
		               <option value="Junior">Junior</option>
		               <option value="Senior">Senior</option>
		            </select></td></tr>
		            <tr><td>Birthday:</td> <td>Month: <select name="bdayMonth" id="bdayMonth" >
					   <option value=""></option>
		         	   <option value="01">01</option>
		               <option value="02">02</option>
		               <option value="03">03</option>
		               <option value="04">04</option>
		               <option value="05">05</option>
		               <option value="06">06</option>
		               <option value="07">07</option>
		               <option value="08">08</option>
		               <option value="09">09</option>
		               <option value="10">10</option>
		               <option value="11">11</option>
		               <option value="12">12</option>
		            </select>
		            Day: <select name="bdayDay" id="bdayDay" >
					   <option value=""></option>
		         	   <option value="01">01</option>
		               <option value="02">02</option>
		               <option value="03">03</option>
		               <option value="04">04</option>
		               <option value="05">05</option>
		               <option value="06">06</option>
		               <option value="07">07</option>
		               <option value="08">08</option>
		               <option value="09">09</option>
		               <option value="10">10</option>
		               <option value="11">11</option>
		               <option value="12">12</option>
		               <option value="13">13</option>
		               <option value="14">14</option>
		               <option value="15">15</option>
		               <option value="16">16</option>
		               <option value="17">17</option>
		               <option value="18">18</option>
		               <option value="19">19</option>
		               <option value="20">20</option>
		               <option value="21">21</option>
		               <option value="22">22</option>
		               <option value="23">23</option>
		               <option value="24">24</option>
		               <option value="25">25</option>
		               <option value="26">26</option>
		               <option value="27">27</option>
		               <option value="28">28</option>
		               <option value="29">29</option>
		               <option value="30">30</option>
		               <option value="31">31</option>
		            </select></td>
		            <td>Year: <select name="bdayYear" id="bdayYear" >
		               <option></option>
		            <!--watch out for the inline javascript!!!!-->
		               <script type="text/javascript" >
		               year=2011;
		               	for(i=50;i>0;i--) {
		               		document.write("<option value='" + year + "'>" + year-- + "</option>");
		               	}
		               </script>
		               
		            </select></td></tr>
					
					<tr><td><input type="button" value="Save Changes" onclick="update_User()" /></td></tr>
				</table>
				<br />
				<span id="result1" style="color:red;"></span>
				<br />
				<br />
				<table>
					<tr><td>Old Password:</td><td><input type="password" id="oldPassword" /></td></tr>
					<tr><td>New Password:</td><td><input type="password" id="newPassword1" /></td></tr>
					<tr><td>Re-Enter Password:</td><td><input type="password" id="newPassword2" /></td></tr>
					<tr><td><input type="button" value="Change Password!" onclick="changePassword()" /></td></tr>
		  		</table>
		  		<br />
	      		
       		</form>
       		<span id="result" style="color:red;"></span>
       </div> 
	</body>
</html>

<?php
	} else {
		die("An error has occurred.  Please contact your system administrator.");
	}
?>
