function isValid(form) {
	//make sure everything is filled out
	if (form.firstName.value == "" || form.lastName.value == "" || form.email1.value == "" || form.email2.value == "" || form.birthdate.value == "" || form.username.value == "" || form.password1.value == "" || form.password2.value == "") {
		document.write("Please fill in all fields.");
		return false;
	}
	else {
		document.write("All fields are filled in.");
	}
	
	//check if the passwords are the same
	if (form.password1.value == form.password2.value) {}
	else {
		document.write("Please make sure your passwords match.");
		return false;
	}
	//check if the emails are the same
	if (form.email1.value == form.email2.value) {}
	else {
		document.write("Please make sure your emails match.");
		return false;
	}
	//everything has been checked so we can go on to send the data to the database
	return true;
}
