<?php
session_start();
if(!isset($_SESSION['Role']) || !isset($_SESSION['ID']) || ($_SESSION['Role'] != "Admin")) 
{
    echo "<script>
    alert('Please login.');
    window.location.href='login.php';
    </script>";
    exit; // Stop further script execution after redirection
}

$serverName= "LAPTOP-JP2PAISQ";
$connectionOptions = ["Database" => "WorkOrders",
                     "Uid" => "", "PWD" => ""];
$conn = sqlsrv_connect($serverName, $connectionOptions);
$row;
$results;

if ($conn == false)
{
        $alert="<script>alert('Database connection failed contact administrator');</script>";
	    echo $alert;
        die(print_r(sqlsrv_errors(), true));
}
else
{ // change WHERE to pending because well we only want those
    $sql = "SELECT ID, Type, Issue, Hall, User_ID 
            FROM WorkOrderInfo
            WHERE WorkOrderStatus = 'Pending' ";

    $results = sqlsrv_query($conn, $sql);
    if(!$results)
    {
        die(print_r(sqlsrv_errors(), true));  
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  -->
    <title>Accept/Deny Work Orders</title>
    <style>

        /* .container {
            display: flex;
            height: 60%;
            
        } */

        /* .table-container {
            overflow-y: auto; /* Enable vertical scrolling 
            max-height: 100%; /* Adjust based on your requirements *
            width: fit-content;
            border-radius: 5px;
            display: flex;
            justify-content: center;
            height: fit-content;
        }
        table {
            width: 100%; /* Adjust table width as needed *
            border-collapse: collapse;
            background-color: whitesmoke;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #eee; *
        }*/
        .button {
            margin: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .table-container table{
            top: 50%;
        }
    </style>
</head>
<link rel = "stylesheet" href = "style.css">

<body>

    <div class="topnav">
        <a class = "active" href = "AdminWOReview.php" >Work Order</a>
        <a href = "AdminSearchWO.php">Search</a>
        <a href = "AdminQueuing.php" >Active Work Orders</a>
        <a href = "AdminProgress.php">Update Progress</a>
        <a href = "AdminMessaging.php">Messaging</a>
        <a href = "login.php" class = "split"> Logout </a>
      </div> 

<!-- <h1 class="main header"> Work Orders</h1> -->
<div class="container">
    <div class="title">Accept or Deny a Work Order</div>
        <table>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Description</th>
                <th>Hall</th>
                <th>User_ID</th>
                <th>Actions</th>

            </tr>
            <!-- Example rows (add more to test scrolling) -->
            <div class="scrollable columns">
            <!-- <tr>
                <td>1</td>
                <td> Work Order 1 </td>
                <td>100</td>
                <td>Description</td>
                <td> <button class="button">View</button></td>
                <td> <button class="button">Accept</button></td>
                <td> <button class="button">Deny</button></td>
            </tr> -->

            <?php 

                while($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC))
                {
                    echo "<tr>
                        <td>". $row["ID"] ." </td>
                        <td>". $row["Type"] ." </td>
                        <td>". $row["Issue"] ." </td>
                        <td>". $row["Hall"] ." </td>
                        <td>". $row["User_ID"] ." </td>


                        <td>
                        <form action='viewWorkOrder.php' method='post'>
                            <input type='hidden' name='id' value='".$row["ID"]."'>
                            <button type='submit' class='button'>View</button>
                        </form>
                        </td>

                        <td>
                        <form action='acceptWorkOrder.php' method='post'>
                            <input type='hidden' name='id' value='".$row["ID"]."'>
                            <button type='submit' class='button'>Accept</button>
                        </form>
                        </td>

                        <td>
                        <form action='rejectWorkOrder.php' method='post'>
                            <input type='hidden' name='id' value='".$row["ID"]."'>
                            <button type='submit' class='button'>Reject</button>
                        </form>
                        </td>
                        </tr>";
                }
            ?>

            </div>
            <!-- Repeat or add more rows here to fill the space and test the scrollbar -->
        </table>
</div>

</body>
</html>