function thumb_up(postID) {
	var username = document.getElementById("username");

	//talk to the php code to insert the params into the database
	var params = "postID=" + postID + "&username=" + username.innerHTML;
	var url = "../thumb_up.php";
	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.setRequestHeader("Content-Length", params.length);
	//xhr.setRequestHeader("Connection", "close");
	xhr.onreadystatechange = function () {
		if(xhr.readyState == 4 && xhr.status == 200) {
			var result = xhr.responseText;
			if (result == "true") {
				var rating = document.getElementById(postID + "Thumb").innerHTML*1;
				document.getElementById(postID + "Thumb").innerHTML = rating+1;
			} else {
				alert("there was a problem");
			}
			return true;
		}
	}
	xhr.send(params);
}

function thumb_down(postID) {
	var username = document.getElementById("username");
	
	//talk to the php code to insert the params into the database
	var params = "postID=" + postID + "&username=" + username.innerHTML;
	var url = "../thumb_down.php";
	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.setRequestHeader("Content-Length", params.length);
	//xhr.setRequestHeader("Connection", "close");
	xhr.onreadystatechange = function () {
		if(xhr.readyState == 4 && xhr.status == 200) {
			var result = xhr.responseText;
			if (result == "true") {
				var rating = document.getElementById(postID + "Thumb").innerHTML*1;
				document.getElementById(postID + "Thumb").innerHTML = rating-1;
			} else {
				alert("there was a problem");
			}
			return true;
		}
	}
	xhr.send(params);
}

function thumb_up_answer(postID) {
	var username = document.getElementById("username");
	
	//talk to the php code to insert the params into the database
	var params = "postID=" + postID + "&username=" + username.innerHTML;
	var url = "../thumb_up_answer.php";
	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.setRequestHeader("Content-Length", params.length);
	//xhr.setRequestHeader("Connection", "close");
	xhr.onreadystatechange = function () {
		if(xhr.readyState == 4 && xhr.status == 200) {
			var result = xhr.responseText;
			if (result == "true") {
				var rating = document.getElementById(postID + "Thumb").innerHTML*1;
				document.getElementById(postID + "Thumb").innerHTML = rating+1;
			} else {
				alert("there was a problem");
			}
			return true;
		}
	}
	xhr.send(params);
}

function thumb_down_answer(postID) {
	var username = document.getElementById("username");
	
	//talk to the php code to insert the params into the database
	var params = "postID=" + postID + "&username=" + username.innerHTML;
	var url = "../thumb_down_answer.php";
	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.setRequestHeader("Content-Length", params.length);
	//xhr.setRequestHeader("Connection", "close");
	xhr.onreadystatechange = function () {
		if(xhr.readyState == 4 && xhr.status == 200) {
			var result = xhr.responseText;
			if (result == "true") {
				var rating = document.getElementById(postID + "Thumb").innerHTML*1;
				document.getElementById(postID + "Thumb").innerHTML = rating-1;
			} else {
				alert("there was a problem");
			}
			return true;
		}
	}
	xhr.send(params);
}