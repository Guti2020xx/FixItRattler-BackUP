<?php
$ID = $_POST["id"];
 $serverName = "LAPTOP-TT3C4QN9\SQLEXPRESS";
 $connectionOptions = [
     "Database" => "WorkOrders",
     "Uid"=> "",
     "PWD" => "" ];
 $conn = sqlsrv_connect($serverName, $connectionOptions);
 if($conn == false)
     die(print_r(sqlsrv_errors(), true));
 else
{
    // $UpdateSql = "UPDATE WorkOrderInfo
    //               Set queuingPos = '1'
    //               Where ID = $ID";
    // $results = sqlsrv_query($conn, $UpdateSql);


    $sql = "SELECT queuingPos
            FROM WorkOrderInfo
            WHERE ID = $ID ";
    $results = sqlsrv_query($conn, $sql);

    $row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC);
    {
        
        $CurrentQueue= $row["queuingPos"];
        $UpdateQueue = $CurrentQueue - 1;
    }
    if($CurrentQueue <= 1)
        {
            echo "<script>
                alert('WorkOrder $ID is already at the top');
                window.location.href='AdminQueuing.php';
            </script>";
        }
    else
    {
        $SwapW0 = "SELECT ID
              FROM WorkOrderInfo
              WHERE queuingPos = $UpdateQueue";
    $results = sqlsrv_query($conn, $SwapW0);

    $row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC);
    {
        $OtherWO= $row["ID"];
    }
    

    $UpdateSql = "UPDATE WorkOrderInfo
                  Set queuingPos = $UpdateQueue
                  Where ID = $ID";
    
    sqlsrv_query($conn, $UpdateSql);

    $UpdateOtherSQL = "UPDATE WorkOrderInfo
                       Set queuingPos = $CurrentQueue
                       Where ID = $OtherWO";
    sqlsrv_query($conn, $UpdateOtherSQL);
    
    echo "<script>
            alert('WorkOrder $ID has been moved up');
            window.location.href='AdminQueuing.php';
        </script>";


    }

    
}
?>