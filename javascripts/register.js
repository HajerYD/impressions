function isValid(form) {
	
	//get all of the elements from the form
	var firstName = document.getElementById('firstName');
	var lastName = document.getElementById("lastName");
	var email1 = document.getElementById("email1");
	var email2 = document.getElementById("email2");
	var currentStanding = document.getElementById("currentStanding");
	var bdayMonth = form.elements["bdayMonth");
	var bdayDay = document.getElementById("bdayDay");
	var bdayYear = document.getElementById("bdayYear");
	var username = document.getElementById("username");
	var password1 = document.getElementById("password1");
	var password2 = document.getElementById("password2");
	
	//make sure everything is filled out
	if (firstName.value == "" || lastName.value == "" || email1.value == "" || email2.value == "" || currentStanding.value == "" || bdayMonth.value == "" || bdayDay.value == "" || bdayYear.value == "" || username.value == "" || password1.value == "" || password2.value == "") {
		alert("Please fill in all fields.");
		return false;
	}
	
	//check if the passwords are the same
	if (form.password1.value == form.password2.value) {}
	else {
		alert("Please make sure your passwords match.");
		return false;
	}
	//check if the emails are the same
	if (form.email1.value == form.email2.value) {}
	else {
		alert("Please make sure your emails match.");
		return false;
	}
	
	//make sure they are using their Manchester email account.  
	//it must end in ...spartans.manchester.edu or ...manchester.edu
	var pattern = /manchester.edu$/;
	if(!pattern.test(email1.value)) {
		alert("You must use your Manchester email.");
		return false;
	}
	
	//everything has been checked so we can go on to send the data to the database
	return true;
}
