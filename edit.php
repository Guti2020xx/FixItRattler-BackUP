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
     $sql = "UPDATE WorkOrderInfo
             SET WorkOrderStatus='". $_POST['WOS'] . "', DateSubmitted='". $_POST['DOS']."', DateAccepted='". $_POST['DA']."',
                 Type='".$_POST['Type']."', Hall = '". $_POST['hall']."', Issue = '". $_POST['issue']."', RoomNumber = '". $_POST['roomNum'] ."'
                 WHERE ID= ". $_POST['id']."; ";

    $results = sqlsrv_query($conn, $sql);
    if($results)
    {
        echo " 
        <!DOCTYPE html>
        <html>
        <head></head>
        <body>
            <form id='form1' action=\"viewWorkOrder.php\" method=\"POST\">
                <p>help <p>
                <input type='text' name='id' value='". $_POST['id']."'>
            </form>
            <script>
                alert('Updated Data');
                window.onload = function() {
                    document.getElementById('form1').submit();
                };
            </script>
        </body>
        </html>";
                
         
    }
    else{
        die(print_r(sqlsrv_errors(), true)); 
    }
}


?>