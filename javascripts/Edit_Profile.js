function update_User() {
	//get all of the elements from the form and store them as variables for easy access.
	var firstName = document.getElementById("firstName");
	var lastName = document.getElementById("lastName");
	var email1 = document.getElementById("email1");
	var email2 = document.getElementById("email2");
	var currentStanding = document.getElementById("currentStanding");
	var bdayMonth = document.getElementById("bdayMonth");
	var bdayDay = document.getElementById("bdayDay");
	var bdayYear = document.getElementById("bdayYear");
	var username = document.getElementById("username");
	var oldPassword = document.getElementById("oldPassword");
	var newPassword1 = document.getElementById("newPassword1");
	var newPassword2 = document.getElementById("newPassword2");
	
	//check if the text fields are all filled in
	if (firstName.value == "" || lastName.value == "" || email1.value == "" || email2.value == "") {
		alert("Please make sure your name and email are filled out.");
		return false;
	}
	//check if the emails match
	if(email1.value != email2.value) {
		alert("Check that your emails match and try again.");
		return false;
	}
	//check if it is a manchester email!
	var pattern = /manchester.edu$/;
	if(!pattern.test(email1.value)) {
		alert("You must use your Manchester email.");
		return false;
	}
	
	var params;
	//check if the currentStanding the birthday fields are filled in.
	if(currentStanding.value != "" && bdayMonth.value != "" && bdayDay.value != "" && bdayYear.value != "") {
		params = "username="+username.value+"&firstName="+firstName.value+"&lastName="+lastName.value+"&email="+email1.value+"&currentStanding="+currentStanding.value+"&birthday="+bdayYear.value+"-"+bdayMonth.value+"-"+bdayDay.value;
	} else if(currentStanding.value != "") {
		params = "username="+username.value+"&firstName="+firstName.value+"&lastName="+lastName.value+"&email="+email1.value+"&currentStanding="+currentStanding.value;
	} else if(bdayMonth.value != "" && bdayDay.value != "" && bdayYear.value != "") {
		params = "username="+username.value+"&firstName="+firstName.value+"&lastName="+lastName.value+"&email="+email1.value+"&birthday="+bdayYear.value+"-"+bdayMonth.value+"-"+bdayDay.value;
	} else {
		params = "username="+username.value+"&firstName="+firstName.value+"&lastName="+lastName.value+"&email="+email1.value;
	}
	
	//talk to the php code to insert the params into the database
	var url = "../update_user.php";
	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.setRequestHeader("Content-Length", params.length);
	xhr.setRequestHeader("Connection", "close");
	xhr.onreadystatechange = function () {
		if(xhr.readyState == 4 && xhr.status == 200) {
			var result = xhr.responseText;
			document.getElementById("result1").innerHTML = result;
			return true;
		}
	}
	xhr.send(params);
}

function changePassword() {
	var username = document.getElementById("username");
	var oldPassword = document.getElementById("oldPassword");
	var newPassword1 = document.getElementById("newPassword1");
	var newPassword2 = document.getElementById("newPassword2");
	
	//check if the new passwords are empty
	if(newPassword1.value == "" || newPassword2.value == "" || oldPassword.value == "") {
		alert("Please fill in all password fields");
		return false;
	}
	
	//check if the passwords are the same
	if(newPassword1.value != newPassword2.value) {
		alert("Please make sure your passwords match");
		return false;
	}
	
	//talk to the php code to insert the params into the database
	var url = "../change_password.php";
	var params = "username="+username.value+"&oldPassword="+oldPassword.value+"&newPassword1="+newPassword1.value;
	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.setRequestHeader("Content-Length", params.length);
	xhr.setRequestHeader("Connection", "close");
	xhr.onreadystatechange = function () {
		if(xhr.readyState == 4 && xhr.status == 200) {
			var result = xhr.responseText;
			document.getElementById("result").innerHTML = result;
			return true;
		}
	}
	xhr.send(params);
}
