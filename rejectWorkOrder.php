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
    {   // asddasdasdasd
        $sql = "UPDATE WorkOrderInfo 
                SET WorkOrderStatus = 'Accepted' 
                WHERE ID = ?";
        $params = array($ID);


        $results = sqlsrv_query($conn, $sql, $params);
        if($results)
        {
            //prepping the email
            $sender_name ="Stmu Facilities";
            $sender_email ="juanjoguti2020@gmail.com";//your email address
            $recipient_email;
            $subject = "Work Order Denied";
            $body = "Work Order #$ID has been denied... check the platform to see why it was";

            $sqlUserID = "SELECT User_ID
                          FROM WorkOrderInfo
                          WHERE ID =?
                         ";
            
            $params = array($ID);
            $results = sqlsrv_query($conn, $sqlUserID, $params);

            $row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC);
            $userID = $row["User_ID"];

            $sqlEmail = "SELECT Email
                    FROM User_Info
                    WHERE UserId = ?";
            $params = array($userID);

            $results = sqlsrv_query($conn, $sqlEmail, $params);

            if($results)
            {
                $row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC);

                if(!$row["Email"])
                {
                   $recipient_email = "juanjoguti2020@gmail.com";
                   $body = "Work Order #$ID no email found so sent to admin email instead";
                }
                else
                {
                    $recipient_email = $row['Email'];
                }

                mail($recipient_email, $subject, $body, "From: $sender_name <$sender_email>");
            }
            echo "<script>
            alert(' Work Order with ID=".$ID." was rejected ');
            window.location.href='AdminWOReview.php'
                  </script>
                  ";
        }
        else
        {  
            echo "<script>
            alert(' Something went wrong with the query try again');
            window.location.href='AdminWOReview.php';
                  </script>
                  ";
        }
        sqlsrv_close($conn);
    }
?>