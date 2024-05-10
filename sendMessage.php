<?php
    $MID = $_POST["mid"];
    $MESSAGE = $_POST["message"];
    $WOID = $_POST["woid"];
    $UID = $_POST["uid"];

    $serverName= "LAPTOP-TT3C4QN9\SQLEXPRESS";
    $connectionOptions = ["Database" => "WorkOrders",
                         "Uid" => "", "PWD" => ""];
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if ($conn == false)
    {
        $alert="<script>alert('Database connection failed (How?), contact administrator');</script>";
        echo $alert;
        die(print_r(sqlsrv_errors(), true));
        header("Location: AdminQueuing.php");
    }
    else
    {
        $sql = "INSERT INTO Chat VALUES($MID, '$MESSAGE', $WOID, $UID)";

        $results = sqlsrv_query($conn, $sql);
        if($results)
        {
            echo "
            <!DOCTYPE html>
            <html>
            <head></head>
            <body>
                <form id='form1' action=\"viewMessages.php\" method=\"POST\">
                    <input type='text' name='id' value='". $WOID."'>
                </form>
                <script>
                    alert('Message successfully sent');
                    window.onload = function() {
                        document.getElementById('form1').submit();
                    };
                </script>
            </body>
            </html>";
        }
        else
        {  
            echo "<script>
            alert(' Something went wrong with sending a message, please try again.');
            window.location.href='AdminQueuing.php';
                  </script>
                  ";
        }
        sqlsrv_close($conn);
    }
?>