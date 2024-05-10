<!DOCTYPE html>
<html>
<head>
    <style>
	
.bar-container {
	height: 50px;
	width: 75%;
	background-color: #CCC;
	position: relative;
	border-radius: 7px;
}

.bar-container .progress-bar {
	position: absolute;
	width: 10%;
	height: 100%;
	border-radius: 7px;
	background-color: rgb(93,128,168);
}

    </style>
    
</head>
<link rel = "stylesheet" href = "style.css">

<body>
    <div class="topnav">
        <a href = "AdminWOReview.php" >Work Order</a>
        <a href = "AdminSearchWO.php">Search</a>
        <a href = "AdminQueuing.php" >Active Work Orders</a>
        <a class = "active" href = "AdminProgress.php">Update Progress</a>
        <a href = "AdminMessaging.php">Messaging</a>
		<a href = "login.php" class = "split"> Logout </a>
      </div> 
	<div class="header-title"> Progress</div>
	
	<div>
		<a href = "AdminQueuing.php">Exit Progress</a>
	</div>
	
	<!-- <center> -->
	
	<div class="bar-container">
		<div class="progress-bar" id="progressBar"></div>
	</div> <br>
	
	<!-- 	<progress id="progressBar" value="10" max="100"></progress> 
			Old progress bar, too small -->
	
	<div class="container">
		<p>Status: </p><p id="progressStatus">Sent</p>
	</div> <br>
	
	<div class="container">
		<button type="button" onclick="setStatus(20,  'Accepted')">Set to Accepted</button> <br>
		<button type="button" onclick="setStatus(40,  'On the Way')">Set to On the Way</button> <br>
		<button type="button" onclick="setStatus(60,  'On Site, Fix in Progress')">Set to On Site, Fix in Progress</button> <br>
		<button type="button" onclick="setStatus(100, 'Completed')">Set to Completed</button>
	</div>
	
	<script>

function setStatus(statusValue, statusText){
	percentage = statusValue+"%";
	document.getElementById("progressBar").style.width = percentage;
	document.getElementById("progressStatus").innerHTML = statusText;
	// document.getElementById("progressBar").value = statusValue; for old progressBar
}

	</script>
</body>
</html>