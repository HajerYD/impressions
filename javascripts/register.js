function isValid(form) {
	
	//get all of the elements from the form
	var firstName = form.elements["firstName"];
	var lastName = form.elements["lastName"];
	var email1 = form.elements["email1"];
	var email2 = form.elements["email2"];
	var currentStanding = form.elements["currentStanding"];
	var bdayMonth = form.elements["bdayMonth"];
	var bdayDay = form.elements["bdayDay"];
	var bdayYear = form.elements["bdayYear"];
	var username = form.elements["username"];
	var password1 = form.elements["password1"];
	var password2 = form.elements["password2"];
	
	//make sure everything is filled out
	if (firstName.value == "" || lastName.value == "" || email1.value == "" || email2.value == "" || currentStanding.value == "" || bdayMonth.value == "" || bdayDay.value == "" || bdayYear.value == "" || username.value == "" || password1.value == "" || password2.value == "") {
		alert("Please fill in all fields.<br/>");
		return false;
	}
	
	//check if the passwords are the same
	if (form.password1.value == form.password2.value) {}
	else {
		alert("Please make sure your passwords match.<br/>");
		return false;
	}
	//check if the emails are the same
	if (form.email1.value == form.email2.value) {}
	else {
		alert("Please make sure your emails match.<br/>");
		return false;
	}
	//everything has been checked so we can go on to send the data to the database
	return true;
}
