<?php
$ID = $_POST["id"];

$serverName = "LAPTOP-TT3C4QN9\SQLEXPRESS";
$connectionOptions = [
    "Database"=>"WorkOrders",
    "Uid"=>"",
    "PWD"=>""
    ];
$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false)
    die(print_r(sqlsrv_errors(), true));

$sql = "SELECT Chat.*, User_Info.Name, User_Info.type from Chat, User_Info WHERE \"Work Order ID\" = $ID AND UserId = \"User ID\"";
//SELECT Chat."Message ID", Chat.Message, Chat."Work Order ID", User_Info.UserId, User_Info.Name, User_Info.type from Chat, User_Info WHERE "Work Order ID" = 1 AND UserId = "User ID";
$results = sqlsrv_query($conn, $sql);
if(!$results)
    die(print_r(sqlsrv_errors(), true));

?>
<!DOCTYPE html>
<html>
<head>
    <title>Work Order Request Form</title>
    <style>

        .form-group {
            margin-bottom: 15px;
            background-color: #ddd;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input, .form-group textarea {
            width: 90%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            color: black; /* Text color for input and textarea */
        }
        .form-group input[type="submit"], .form-group input[type="reset"] {
            background-color: #5cb85c;
            color: white;
            border: 4px solid #fff;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .form-group input[type="submit"]:hover,
        .form-group input[type="reset"]:hover {
            background-color: #4cae4c;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
        }
        /* Chat containers */
        .container {
            border: 2px solid #dedede;
            background: #f1f1f1;
            color: white;
            border-radius: 5px;
            padding: 10px;
            margin: 10px;
        }

        /* Darker chat container */
        .darker {
        border-color: #ccc;
        background-color: #ddd;
        }
		
		.message {
		display: none;
		}

        /* Clear floats */
        .container::after {
        content: "";
        clear: both;
        display: table;
        }
		
		/* Style message text */
        .text-right {
        float: right;
        }

        /* Style name text */
        .name-right {
        float: right;
        color: #aaa;
        }

        /* Style name text */
        .name-left {
        float: left;
        color: #999;
        }

        /* Button used to open the chat form - fixed at the bottom of the page */
        .open-button {
        background-color: #555;
        color: white;
        padding: 16px 20px;
        border: none;
        cursor: pointer;
        opacity: 0.8;
        position: fixed;
        bottom: 23px;
        right: 28px;
        width: 300px;
        }

        /* The popup chat - hidden by default */
        .chat-popup {
        display: none;
        position: fixed;
        bottom: 0;
        right: 15px;
        border: 3px solid #f1f1f1;
        z-index: 9;
        }

        /* Add styles to the form container */
        .form-container {
        max-width: 600px;
        padding: 10px;
        background-color: white;
        }

        /* Full-width textarea */
        .form-container textarea {
        width: 90%;
        padding: 15px;
        margin: 5px 0 22px 0;
        border: none;
        background: #f1f1f1;
        resize: none;
        min-height: 200px;
        }

        /* When the textarea gets focus, do something */
        .form-container textarea:focus {
        background-color: #ddd;
        outline: none;
        }

        /* Set a style for the submit/send button */
        .form-container .btn {
        background-color: #04AA6D;
        color: white;
        padding: 16px 20px;
        border: none;
        cursor: pointer;
        width: 100%;
        margin-bottom:10px;
        opacity: 0.8;
        }

        /* Add a red background color to the cancel button */
        .form-container .cancel {
        background-color: red;
        }

        /* Add some hover effects to buttons */
        .form-container .btn:hover, .open-button:hover {
        opacity: 1;
        }
    </style>
    
</head>
<link rel = "stylesheet" href = "style.css">

<body>
    <div class="topnav">
        <a href = "AdminWOReview.php" >Work Order</a>
        <a href = "AdminSearchWO.php">Search</a>
        <a href = "AdminQueuing.php" >Active Work Orders</a>
        <a href = "AdminProgress.php">Update Progress</a>
        <a class = "active" href = "AdminMessaging.php">Messaging</a>
        <a href = "login.php" class = "split"> Logout </a>
      </div> 

	<center>
		<div class="header-title"> <?php echo "Messages for Work Order ID: $ID"; ?> </div>
	</center>
	
		<?php
		  while($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)){
			if($row["type"] == "Student")
				echo "<div class=\"container\">
				<p style=\"text-align:left\">" . $row["Message"] . "</p>
				<span class=\"name-left\">" . $row["Name"] . "</span>
				</div>";
			else if($row["type"] == "Admin")
				echo "<div class=\"container\">
				<p style=\"text-align:right\">" . $row["Message"] . "</p>
				<span class=\"name-right\">" . $row["Name"] . "</span>
				</div>";
			}
			
			$lastMessageID = "Select Max(\"Message ID\") as m FROM Chat";
			
			$messageResult = sqlsrv_query($conn, $lastMessageID);
			$messageRow = sqlsrv_fetch_array($messageResult, SQLSRV_FETCH_ASSOC);
			$messageID = ($messageRow['m'] + 1);
			
			$adminSearch = "Select Chat.[User ID] FROM Chat, User_Info WHERE [Work Order ID] = $ID AND [User ID] = UserId AND type = 'Admin'";
			
			$adminResult = sqlsrv_query($conn, $adminSearch);
			$adminRow = sqlsrv_fetch_array($adminResult, SQLSRV_FETCH_ASSOC);
			$adminID = $adminRow ? $adminRow["User ID"] : 1;
			
			echo "<button class=\"open-button\" onclick=\"openForm()\">Chat</button>

			<div class=\"chat-popup\" id=\"myForm\">
				<form action=\"sendMessage.php\" class=\"form-container\" method = \"POST\">
					<input type='hidden' name='mid' value='".$messageID."'>"
					//.'<input type="hidden" name="message" id="messageText">'
					."<input type='hidden' name='woid' value='".$ID."'>
					<input type='hidden' name='uid' value='".$adminID."'>
					
					<h1>Chat</h1>

					<label><b>Message</b></label>".
					
					"<input type='text' name='message'></input>"
					
					//<textarea for=\"messageText\" placeholder=\"Type message..\"></textarea>

					."<button type=\"submit\" class=\"btn\">Send</button>
					<button type=\"button\" class=\"btn cancel\" onclick=\"closeForm()\">Close</button>
				</div>";

?>
	  
      <script>
function openForm() {
  document.getElementById("myForm").style.display = "block";
}

function closeForm() {
  document.getElementById("myForm").style.display = "none";
}
	</script>
</body>
</html>