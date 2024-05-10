<?php
    $ID = $_POST["id"];

    $serverName= "LAPTOP-TT3C4QN9\SQLEXPRESS";
    $connectionOptions = ["Database" => "WorkOrders",
                         "Uid" => "", "PWD" => ""];
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if ($conn == false)
    {
        $alert="<script>alert('Database connection failed contact administrator');</script>";
	    echo $alert;
        die(print_r(sqlsrv_errors(), true));
        header("Location: AdminWOReview.php");
    }
    else
    {
        $sql = "Select W.WorkOrderStatus, W.DateSubmitted, W.DateAccepted, W.Type, W.Progress, W.Issue, W.Hall, W.RoomNumber, I.Email, I.Name, I.PhoneNumber
        From WorkOrderInfo as W JOIN User_Info as I ON User_ID = UserId
        WHERE W.ID = $ID";

        $results = sqlsrv_query($conn, $sql);
        $row = sqlsrv_fetch_array( $results, SQLSRV_FETCH_ASSOC);
        {
            $Status = $row['WorkOrderStatus'];
            $dateSub= $row['DateSubmitted'];
            $dateAcc= $row['DateAccepted'];
            $type = $row['Type'];
            $progress = $row['Progress'];
            $issue = $row['Issue'];
            $hall = $row['Hall'];
            $roomnum = $row['RoomNumber'];
            $email = $row['Email'];
            $name = $row['Name'];
            $phoneNum =$row['PhoneNumber'];
            
        }
        if(!$results)
        {
            die(print_r(sqlsrv_errors(), true));  
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Accept/Deny Work Orders</title>
    <style>
    .container_White {
        width: flex;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        color: black; /* Text color for content inside the container */
        border-radius: 10px;
        align-items: center;
        align-self: center;
        align-content: center;
        display: flex;
        align-items: flex-start; /* Center-align the child elements */
        height: auto;
        background-color: white;
    }

    .column {
        width: 100%;
        display: block;
        /*margin: 20px;*/
        padding: 20px; /* Adjust padding as needed */
        column-gap: 20px; /* Adjust column gap as needed */
        row-gap: 20px; /* Adjust row gap as needed */
        align-items: flex-start;
        justify-content: flex-start;
    }
    
    .row{
        display: flex;
    }
    .id-row {
    width: 100%;
    display: flex;
    justify-content: center; /* Center align the ID */
    margin-bottom: 20px; /* Adjust margin as needed */
}
.edit-button {
    background-color: #1E90FF; /* Dark Blue */
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 8px;
    transition: background-color 0.3s;
}

.edit-button:hover {
    background-color: #0066CC; /* Darker shade of Dark Blue */
}
    @media screen and (max-width: 600px) {
        .column {
            padding: 10px;
            column-gap: 10px;
            row-gap: 10px;
            align-items: flex-start;
            justify-content: flex-start;

        }

    }
</style>
</head>
<body>
<div class="container">
    <div class="title">Editing Work Order Number <?php echo $ID; ?></div>
    
    <form action="edit.php" method="POST">
        <div class=container_White>
            <input type ='hidden' name='id' value='<?php print $ID; ?>'>
            <div class=column>
                <h2> Information: </h2>
                <p>Status: 
                    <input type='text' name='WOS' value='<?php if (isset($_POST[' '])) {echo $_POST['WOS']; } else{print $Status;} ?>'></p>
                <p>Date Accepted: 
                    <input type='date' name='DA' value='<?php if (isset($_POST[' '])) {echo $_POST['DA']; } else{print date_format($dateAcc, "Y/m/d H:i:s");} ?>'></p>
                <h2>Location: </h2>
                <p>Hall: 
                    <input type='text' name='hall' value='<?php if (isset($_POST[' '])) {echo $_POST['hall']; } else{print $hall;} ?>'></p>
                <h2>User Info:</h2>
                <p> Name: <?php print $name; ?> </p>
            </div>
                
            <div class=column>
                <br><br><br>
                <p>Issue: 
                    <input type='text' name='issue' value ='<?php if (isset($_POST[' '])) {echo $_POST['issue']; } else{print $issue;} ?>'> </p> 
                <p>Date Submitted: 
                    <input type='date' name='DOS' value='<?php if (isset($_POST[' '])) {echo $_POST['DOS']; } else{print date_format($dateSub, "Y/m/d H:i:s");;} ?>'></p>
                <br><br>
                <p> Room Number:
                    <input type='text' name='roomNum' value='<?php if (isset($_POST[' '])) {echo $_POST['roomNum']; } else{print $roomnum;} ?>'></p>
                <br><br aria-setsize="10px">
                <p>Number: <?php print $phoneNum; ?></p>
            </div>

            <div class= column>
                <br><br><br>
                <p> Progress:  <?php print $progress; ?></p>
                <p>Type: 
                    <input type='text' name='Type' value='<?php if (isset($_POST[' '])) {echo $_POST['Type']; } else{print $type;} ?>'></p>
                <br><br>
                <p>Area: <?php print "Needs work" ?></p>
                <br><br>
                <p> Email: <?php print $email; ?></p>
            </div>
            
        </div> 
        <button type='submit' class='edit-button'>Edit Workorder</button>       
    </form>           
    </div>
</div>
   
</div>
</body>
</html>
