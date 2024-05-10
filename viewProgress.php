<?php

if(!isset($_SESSION['Role']) || !isset($_SESSION['ID']) || ($_SESSION['Role'] != "Admin")) 
{
    echo "<script>
    alert('Please login.');
    window.location.href='login.php';
    </script>";
    exit; // Stop further script execution after redirection
}

    $ID = $_POST["id"];

    $serverName= "LAPTOP-JP2PAISQ";
    $connectionOptions = ["Database" => "WorkOrders",
                         "Uid" => "", "PWD" => ""];
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if ($conn == false)
    {
        $alert="<script>alert('Database connection failed contact administrator');</script>";
	    echo $alert;
        die(print_r(sqlsrv_errors(), true));
        header("Location: AdminQueuing.php");
    }
    else
    {
        $sql = "SELECT ID, WorkOrderStatus, Progress 
                FROM WorkOrderInfo 
                WHERE ID = ?";
        $params = array($ID);
            

        $results = sqlsrv_query($conn, $sql, $params);
        if(!$results)
        {
            die(print_r(sqlsrv_errors(), true));  
        }
    }
?>

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
	<!-- Remove from below to <\?php in the event that this .php is shown in the same page as the Queuing page -->
	
	<div class="topnav">
        <a href = "AdminWOReview.php" >Work Order</a>
        <a href = "AdminSearchWO.php">Search</a>
        <a href = "AdminQueuing.php" >Active Work Orders</a>
        <a class = "active" href = "AdminProgress.php">Update Progress</a>
        <a href = "AdminMessaging.php">Messaging</a>
		<a href = "login.php" class = "split"> Logout </a>
      </div>
	
	<center>
	<div class="header-title"> Progress</div>
	
	<?php
	while($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)) {
					$progressBarID = "pb" . $row["ID"]; //progress bar for Work Order ID
					$statusID = 's' . $row["ID"]; //progress status for Work Order ID
					if(strtoupper($row["WorkOrderStatus"]) != 'DENIED' && strtoupper($row["WorkOrderStatus"]) != 'PENDING')
					echo 	"<div class='container'>
							<h3> Work Order ID: ". $row["ID"] . "</h3>
							<td> Status: " . $row["WorkOrderStatus"] . ", Progress Queue #: " . $row["Progress"] . "</td> <br>
							<br> <div class='bar-container'>
								<div class='progress-bar' id='" . $progressBarID . "'></div>
							</div> <br>
								<p id = '" . $statusID . "'>Status: Sent</p> <br>" . ' 
							
								<button type="button" onclick="setStatus(\''.$progressBarID.'\',\''.$statusID.'\', 60,  \'In Progress\')">In Progress</button> <br>
								<button type="button" onclick="setStatus(\''.$progressBarID.'\',\''.$statusID.'\', 100, \'Completed\')">Set to Completed</button>
							</div> <br>';
					
					elseif(strtoupper($row["WorkOrderStatus"]) == 'PENDING')
					echo "
            <!DOCTYPE html>
            <html>
            <head></head>
            <body>
                <form id='form1' action=\"viewWorkOrder.php\" method=\"POST\">
                    <input type='text' name='id' value='".$ID."'>
                </form>
                <script>
                    alert('Work Order Status is pending. Please accept Work Order to view progress');
                    window.onload = function() {
                        document.getElementById('form1').submit();
                    };
                </script>
            </body>
            </html>";
					
					else
					echo "
            <!DOCTYPE html>
            <html>
            <head></head>
            <body>
                <form id='form1' action=\"viewWorkOrder.php\" method=\"POST\">
                    <input type='text' name='id' value='".$ID."'>
                </form>
                <script>
                    alert('Work Order Status is denied. You cannot view progress on a denied Work Order.');
                    window.onload = function() {
                        document.getElementById('form1').submit();
                    };
                </script>
            </body>
            </html>";
					}
					
					?>
</center>
	<script>

function setStatus(pbID, sID, statusValue, statusText){
	percentage = statusValue+"%";
	document.getElementById(pbID).style.width = percentage;
	document.getElementById(sID).innerHTML = 'Status: ' + statusText;
}

	</script>

</body>
</html>