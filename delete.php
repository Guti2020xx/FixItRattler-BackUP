<?php
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
     $sql = "DELETE FROM WorkOrderInfo
             WHERE ID= ". $_POST['id']."; ";

    $results = sqlsrv_query($conn, $sql);
    if($results)
    {
        echo "<script>
                alert('Deleted Data');
                window.location.href='AdminWOReview.php';
            </script>";
    }
    else{
        die(print_r(sqlsrv_errors(), true)); 
    }
}