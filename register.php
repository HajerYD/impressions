<?php

				// Encrypting the password and setting all the variables for later use
				$first = ($_POST["firstName"]); 
				$password = md5($_POST["password1"]);
				$last = ($_POST["lastName"]);
				$bdayMonth = ($_POST["bdayMonth"]);
				$bdayDay = $_POST["bdayDay"];
				$bdayYear = $_POST["bdayYear"];
				$email	 = ($_POST["email1"]);
				$current = ($_POST["currentStanding"]);
				$username = ($_POST["username"]);

				// Connecting, selecting database
				$link = mysql_connect("localhost", "simon", "simonk")
		 			or die("Could not connect: " . mysql_error() . "<br/>");
				echo "Connected successfully<br/>";

				//select the database to use once connected to mysql
				mysql_select_db("Impressions") or die("Could not select database<br/>");

				//generate random number for the activation process.
				$random = rand(23456789,98765432);

				// Performing SQL query
				$query = "INSERT INTO Users VALUES ('$first','$last','".bdayYear."/".bdayMonth."/".bdayDay."','$currentStanding','$username','$password','$random','0','$email','DEFAULT','DEFAULT','$random','0');";
				$result = mysql_query($query) or die("Query failed: " . mysql_error() . "<br>");


				/*echo "starting mail sending";
				//copy
				
				require_once "/home/alex/pear/share/pear/Mail.php";
				echo "1";
        		$from = "<verify.impressions@gmail.com>";
       		 	$to = "<avidgamer123@gmail.com>";
        		$subject = "Activate your account";
        		$body = "
				\n
				Hello $firstName,
				\n
				\n
				Please copy/paste the following URL into your browser to activate your account:
				\n
				10.40.40.84/activate.php?username=$username&code=$random;
				\n
				\n
				Thanks!
				";

        		$host = "ssl://smtp.gmail.com";
        		$port = "465";
        		$username = "verify.impressions@gmail.com";
        		$password = "!mpressions";
echo "2";
        		$headers = array ('From' => $from,
          			'To' => $to,
          			'Subject' => $subject);
          		echo "3";
        		$smtp = Mail::factory('smtp',
          		array ('host' => $host,
            		'port' => $port,
            		'auth' => true,
            		'username' => $username,
            		'password' => $password));
echo "4";
        		$mail = $smtp->send($to, $headers, $body);  //this is where it stops... it prints out 4, but not 5
echo "5";
				if (PEAR::isError($mail)) {
					echo("<p>" . $mail->getMessage() . "</p>");
				} else {
					echo("<p>Message successfully sent!</p>");
				}
				
				//copy end
				echo "mail sent hopefully.";
				//sending email
				$to = $email;
				$subject = "Activate your account";
				$headers = "From: Impressions@Impressions.com";
				$server = "mail.manchester.edu";

				ini_set("SMTP",$server);
				ini_set("smtp_port","25"); 
				$body = "

				Hello $firstName,\n\n
				
				
				Please copy/paste the following URL into your browser to activate your account:\n
				
				10.40.40.84/activate.php?username=$username&code=$random;\n\n


				Thanks!
				";

				//function to send email
				mail($to, $subject, $body, $headers);*/
				//Close the connection to the server since we're done querying
				mysql_close($link);
				echo "You have successfully registered with Impressions!</br>Please check your e-mail for a verification e-mail.";
?>
