<?php
$serverName = "LAPTOP-TT3C4QN9\SQLEXPRESS";
$connectionOptions = [
    "Database"=>"WorkOrders",
    "Uid"=>"",
    "PWD"=>""
    ];
$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false)
    die(print_r(sqlsrv_errors(), true));

$sql = "select * from chat;";
$results = sqlsrv_query($conn, $sql);
if(!$results)
    die(print_r(sqlsrv_errors(), true));

while($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)){

    echo "<div class=\"container\">
    <p>" . $row["Message"] . "</p>
    <span class=\"time-right\">11:00 AM</span>
  </div>";
}