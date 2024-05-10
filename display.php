<?
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
    echo "<div class=\"modal-content\">
    <div class=\"modal-header\">
        <span class=\"close\">&times;</span>
        <h1>ID: id=". $ID." </h1>
    </div>
    <div class=\"modal-body\">
        <h2>Information:</h2>
        
        <p>Work Order Status:    Description: </p>
        <p>Date Accepted:   Date Submitted:</p>
        <h2>Location</h2>
        <p>Hall:</p>
        <p>Area:    Room Number:</p>
        <h2>User Info</h2>
        <p> Name:  </p>
        <p> Number:     Email: </p>
        
    </div>
    <div class=\"modal-footer\">
        <h3>Modal Footer</h3>
    </div>
</div>";
}
?>