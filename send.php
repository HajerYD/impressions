<?php
	$to = "avidgamer123@gmail.com";
	$body = "This is just a php script test for email";
	$subject = "PHP Email Test";
	if(filter_var($to, FILTER_VALIDATE_EMAIL)) {
		echo "email addres is valid!!!";
	} else {
		echo "email address is not valid";
	}
	if(mail($to, $subject, $body)){
		echo("<p>Message sent!</p>");
	}else{
		echo("<p>Message not sent!</p>");
	}
?>
