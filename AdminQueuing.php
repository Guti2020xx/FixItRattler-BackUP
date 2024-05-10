<!DOCTYPE html>
<html>
<head>
    <style>
        * {
        box-sizing: border-box;
        }

        body {
        font-family: Arial, Helvetica, sans-serif;
        }

        /* Float four columns side by side */
        .column {
        float: center;
        width: 100%;
        padding: 10px 10px;
        text-wrap: 8px;
        
        }
        .button-column {
        float: center;
        width: 20%;
        padding: 10px 10px;
        
        }

        /* Remove extra left and right margins, due to padding in columns */
        .row {
          display: flex;
          } 
          .columns{
          /* float: center;
          */width: 33.33%
          /* padding: 30px; */
        }

        /* Clear floats after the columns */
        .row:after {
        content: "";
        display: table;
        clear: both;
        }

        /* Style the counter cards */
        .card {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.766); /* this adds the "card" effect */
        padding: 10px;
        text-align: left;
        background-color: white;
        border-radius: 10px;
        }
        .button {
          background-color: #ddd;
          border: none;
          color: black;
          padding: 10px 20px;
          text-align: center;
          text-decoration: none;
          display: inline-block;
          margin: 4px 2px;
          cursor: pointer;
          border-radius: 16px;
        }
        

        /* Responsive columns - one column layout (vertical) on small screens */
        @media screen and (max-width: 600px) {
        .column {
            width: 100%;
            display: block;
            margin-bottom: 20px;
        }
        
        }
    </style>
    
</head>
<link rel = "stylesheet" href = "style.css">


<body>
    <div class="topnav">
        <a href = "AdminWOReview.php" >Work Order</a>
        <a href = "AdminSearchWO.php">Search</a>
        <a class = "active" href = "AdminQueuing.php" >Active Work Orders</a>
        <a href = "AdminProgress.php">Update Progress</a>
        <a href = "AdminMessaging.php">Messaging</a>
        <a href = "login.php" class = "split"> Logout </a>
      </div> 

    
    <div class = "container">
    <div class="title">Active Work Orders</div>
    <div class="row">
        <div class="column">

          <?php
                    $serverName = "LAPTOP-TT3C4QN9\SQLEXPRESS";
                    $connectionOptions = [
                        "Database" => "WorkOrders",
                        "Uid"=> "",
                        "PWD" => "" ];
                    $conn = sqlsrv_connect($serverName, $connectionOptions);
                    if($conn == false)
                        die(print_r(sqlsrv_errors(), true));
                    
                    $sql = "SELECT ID, queuingPos, WorkOrderStatus, DateSubmitted,DateAccepted, U.Type, Progress, Issue, Name, Hall, RoomNumber 
                            FROM WorkOrderInfo JOIN User_Info as U on User_ID = UserId
                            WHERE queuingPos Is NOT NULL 
                            Order BY queuingPos ASC"; //Setting up SQL statement for Query Search
                            
                    
                    $result = sqlsrv_query($conn,$sql);//Connecting the SQL statement with Database  

                    if (!$result){//if there is an error display error 
                        die("invalid query: " . sqlsrv_errors());		
                    }

                    
                    //displaying Results
                    while($row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC)) {
                    
                        echo "<div class=\"column\">
                                <div class=\"card\">
                                  <h3> Work Order ID: ". $row["ID"] . "</h3> 
                                  <div class=\"row\">
                                    <div class=\"columns\">
                                      <p> Status = ". $row["WorkOrderStatus"] ."</p>";
                                      $dateSub = $row["DateSubmitted"];
                                if (!is_null($dateSub)){
                              echo "<p> Date Sumbitted: ". date_format($dateSub, "Y/m/d H:i:s")  ."</p>";}
                                else{echo "<td>". NULL ."</td>";}
                                      $dateAcc = $row["DateAccepted"];  
                                if(!is_null($dateAcc)){
                              echo "<p> Date Accepted: ". date_format($dateAcc, "Y/m/d H:i:s")  ."</p>";}        
                                else{echo "<td>". NULL ."</td>";}
                              echo "<p> Position in the Queue: ". $row["queuingPos"]."</p>
                                  </div>";
                                                   
                              echo "

                                    <div class=\"columns\">
                                      <p> Type = ". $row["Type"] ."</p>
                                      <p> Progress = ". $row["Progress"] ."</p>
                                      <p> Issue: ". $row["Issue"] ."</p>
                                    </div>
                                    <div class=\"columns\">
                                      <p> User ID: ". $row["Name"] ."</p>
                                      <p> Hall: ". $row["Hall"] . "</p>
                                      <p> Room Number: ". $row["RoomNumber"] . "</p>
                                    </div>
                                    <div class = 'button-column'>
                                      <form action='viewProgress.php' method='post'>
                                        <input type='hidden' name='id' value='".$row["ID"]."'>
                                        <button type='submit'>View Progress</button>
                                      </form>
                                      <form action='viewMessages.php' method='post'>
                                        <input type='hidden' name='id' value='".$row["ID"]."'>
                                        <button type='submit'>View Messages</button>
                                      </form>
                                      <form action='UpInQueue.php' method='post'>
                                        <input type='hidden' name='id' value='".$row["ID"]."'>
                                        <button type='submit'>Move Up</button>
                                      </form>
                                      <form action='DownInQueue.php' method='post'>
                                        <input type='hidden' name='id' value='".$row["ID"]."'>
                                        <button type='submit'>Move Down</button>
                                      </form>
                                    </div>
                                     </div>
                                    </div>
                                  </div>";
	                }

                   ?>
        </div>
      </div>
    </div>

        
</body>
</html>