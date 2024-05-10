<?php
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
        header("Location: AdminWOReview.php");
    }
    else
    {
        
        
        $sql = "Select W.ID, W.WorkOrderStatus, W.DateSubmitted, W.DateAccepted, W.Type, W.Progress, W.Issue, W.Hall, W.RoomNumber, W.WorkOrderImg, I.Email, I.Name, I.PhoneNumber
        From WorkOrderInfo as W JOIN User_Info as I ON User_ID = UserId
        WHERE W.ID = $ID";

        $results = sqlsrv_query($conn, $sql);
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
    <title>Viewing Work Order</title>
    <style>
    .container_White {
        width: fill;
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
    display: flex;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 8px;
    transition: background-color 0.3s;
}

.edit-button:hover {
    background-color: #0066CC; /* Darker shade of Dark Blue */
}

/* Style for the delete button */
.delete-button {
            background-color: #ff0000; /* Red background */
            color: #ffffff; /* White text */
            padding: 15px 32px; /* Padding around the text */
            border: none; /* No border */
            border-radius: 8px; /* Rounded corners */
            cursor: pointer; /* Show hand cursor on hover */
            font-size: 16px; /* Font size */
            margin: 4px 2px;
            display: flex;

        }

        /* Hover effect */
        .delete-button:hover {
            background-color: #cc0000; /* Darker red on hover */
        }

        .button-container {
            display: inline-block; /* Display buttons inline */
            margin-right: 10px; /* Add margin between buttons */
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
<div class="topnav">
        <a href = "AdminWOReview.php" >Work Order</a>
        <a href = "AdminSearchWO.php">Search</a>
        <a href = "AdminQueuing.php" >Active Work Orders</a>
        <a href = "AdminProgress.php">Update Progress</a>
        <a href = "AdminMessaging.php">Messaging</a>
        <a href = "login.php" class = "split"> Logout </a>
      </div> 
<div class="container">
    <div class="title">Work Order Details: Work Order Number <?php echo $ID; ?></div>
    
    <?php 
        // Assuming $results is your SQL Server query result
        while ($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)) {
            echo " 

            <form action='editWorkOrder.php' method='post'>
                <input type='hidden' name='id' value='".$row["ID"]."'>
                <div class='button-container'>
                    <button type = sumbit class=edit-button>Edit Workorder</button>
                </div>
            </form>
            <form action='delete.php' method='post'>
                <input type='hidden' name='id' value='".$row["ID"]."'>
                <div class='button-container'>
                    <button type = submit class=delete-button>Delete Workorder</button>
                </div>
            </form>
        
            <div class=container_White>
                <div class=column>
                    <h2> Information: </h2>
                    <p>Work Order Status: ". $row['WorkOrderStatus']."</p>
                    <p>Date Accepted: ". date_format($row['DateAccepted'], "Y/m/d H:i:s") ."</p>

                    <h2>Location: </h2>
                    <p>Hall: ". $row['Hall']." </p>

                    <h2>User Info:</h2>
                    <p> Name: ". $row['Name']." </p>
                </div>
                
                
                <div class = column>
                    <br><br><br>
                    <p> Description: ". $row['Issue']." </p>
                    <p>Date Submitted: ". date_format($row['DateSubmitted'], "Y/m/d H:i:s") ."</p>

                    <br><br>
                    <p> Room Number: ". $row['RoomNumber']."</p>

                    <br><br>
                    <p> Number: ". $row['PhoneNumber']."</p>
                </div>

                <div class = column>
                    <br><br><br>
                    <p>Progress: ". $row['Progress']."</p>
                    <p>Type: ". $row['Type']."</p>

                    <br><br>
                    <p> Area: ". $row['Progress']."</p>
                     
                    <br><br>
                    <p> Email: ". $row['Email']."</p>
                </div>

                <div class = column>
                    <br><br><br>
                   <p> Image:</p>
                   <img style=\"max-width: 450px; max-height: 300px\"src='Images/".$row['WorkOrderImg']."'>
                </div>
                <div class = 'row'>
                    <div class = 'columns'>
                        <form action='viewProgress.php' method='post'>
                            <input type='hidden' name='id' value='".$row["ID"]."'>
                            <button type='submit'>View Progress</button>
                        </form>
                    </div>
                    <div class = 'columns'>
                        <form action='viewMessages.php' method='post'>
                            <input type='hidden' name='id' value='".$row["ID"]."'>
                            <button type='submit'>View Messages</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>
            ";
        }
    ?>
   
</div>
</body>
</html>