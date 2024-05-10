<?php
// doesn't have the date and time yet make sure you do that
// also get ready for associating it to an actual user
session_start();

// checking session credentials
if(!isset($_SESSION['Role']) || !isset($_SESSION['ID']) || ($_SESSION['Role'] != "Student" && $_SESSION['Role'] != "Admin")) 
{
    echo "<script>
    alert('Please login.');
    window.location.href='login.php';
    </script>";
    exit; // Stop further script execution after redirection
}

        $Hall = $_POST['Hall'];

        if(!isset($_POST['roomNum']))
        {
            $roomNum = 0;
        }
        else
        {
            $roomNum = $_POST['roomNum'];
        }

        $location = $_POST['location'];
        $description = $_POST['description'];
        $catType = $_POST['category'];
        $userID = $_SESSION['ID'];

        $file_name = $_FILES['image']['name'];
        $tempname = $_FILES['image']['tmp_name'];

        $folder = 'Images/'.$file_name;

    $serverName= "LAPTOP-JP2PAISQ";
    $connectionOptions = ["Database" => "WorkOrders",
                         "Uid" => "", "PWD" => ""];
    $conn = sqlsrv_connect($serverName, $connectionOptions);

    if ($conn == false)
    {
        $alert="<script>alert('Database connection failed contact administrator');</script>";
	    echo $alert;
        die(print_r(sqlsrv_errors(), true));
        header("Location: StudentSubmitWO.php");
    }
    else {
        $sqlMax = "SELECT MAX(ID) AS MAXID FROM WorkOrderInfo";
        $results = sqlsrv_query($conn, $sqlMax);
        $row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC);
        
        if ($row === null) {
            // Handle the case where table is empty
            $id = 1; // Start from 1 if no existing IDs
        } else {
            $id = $row['MAXID'] + 1; // Increment the maximum ID found
        }


    //$sql query for inserting stuff into the DB
    $sql = "INSERT INTO WorkOrderInfo (ID, WorkOrderStatus, Type, Progress, Issue, User_ID, Hall, RoomNumber, WorkOrderImg)
    VALUES (?, 'pending', ?, 'In Progress', ?, ?, ?, ?, ?)";

    // Define the parameters to be bound in the SQL command
    $params = array($id, $catType, $description, $userID, $Hall, $roomNum, $file_name);

    // Execute the query with the parameters
    $results = sqlsrv_query($conn, $sql, $params);

        if($results)
        {
            //moving images into the folder
            move_uploaded_file($tempname, $folder);

            //prepping the email
            $sender_name ="Stmu Facilities";
            $sender_email ="juanjoguti2020@gmail.com";//your email address
            $recipient_email;
            $subject = "Work Order Submitted";
            $body = "Work Order #$id has been received by facilities: 
                    \n Work Order Location: $Hall Room: $roomNum
                    \n Work Status: Pending \n Work Order Type: $catType ";

            $sql = "SELECT Email
                    FROM User_Info
                    WHERE UserId = ?";
            $params = array($id);


            $results = sqlsrv_query($conn, $sql, $params);
            $row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC);

            $recipient_email = $row['Email'];

            if($results)
            {
                mail($recipient_email, $subject, $body, "From: $sender_name <$sender_email>");
            }
            echo "<script>
                 alert('Submission successful. Redirecting back to form.');
                 window.location.href='StudentSubmitWO.php';
                 </script>";
        }
        else{
            echo "<script>
            alert('Submission unsuccessful. Redirecting back to form.');
            window.location.href='StudentSubmitWO.php';
            </script>";
        }
        sqlsrv_close($conn);
    }
?>