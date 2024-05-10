<!DOCTYPE html>
<html>
<head>
    <title>Work Order Search</title>
    <style>
    
     /* Style the counter cards */
     .card {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.766); /* this adds the "card" effect */
        padding: 20px;
        text-align: left;
        background-color: white;
        border-radius: 10px;
        
        }
        /* The Modal (background) */
        .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        }

        /* The Close Button */
        .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        }

        .close:hover,
        .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
        }
    </style>
    
</head>
<link rel = "stylesheet" type = "text/css" href = "style.css"> </link>


<body>
    <div class="topnav">
        <a href = "AdminWOReview.php" >Work Order</a>
        <a class = "active" href = "AdminSearchWO.php">Search</a>
        <a href = "AdminQueuing.php" >Active Work Orders</a>
        <a href = "AdminProgress.php">Update Progress</a>
        <a href = "AdminMessaging.php">Messaging</a>
        <a href = "login.php" class = "split"> Logout </a>
      </div> 

      <div class="container">
        <!-- <div id="Search" class="tabcontent"> -->
        <div class="title">Search for a Work Order</div>
        
        <div>
            <div >
                <div class = "card" >
                <form action="" method="GET">
                        <label> Work Order ID:</label>
                        <Input type="text" name = "Search" value = "<?php if (!empty($_GET[' '])) {echo $_GET['Search'];} ?>" placeholder= "Select">
                        <input type="submit" value=">>">

                        <label for="Dorm">Dorm Name:</label>
                        <select type="text" name = "DormInput" value = "<?php if (isset($_GET[' '])) {echo $_GET['DormInput'];} ?>" class = "form control" placeholder= "Select">
                                <option value="0">Select</option>
                                <option value="Marian">Marian</option>
                                <option value="Treadaway">Treadaway</option>
                                <option value="Chaminade">Chaminade</option>
                                <option value="Periguex">Periguex</option>
                                <option value="Adele">Adele</option>
                        </select>
                    
            
                        <label for="Type">Type:</label>
                        <select type="text" name = "TypeInput" value = "<?php if (isset($_GET[' '])) {echo $_GET['TypeInput'];} ?>" class = "form control"placeholder= "Select">
                            <option value="0">Select</option>
                            <option value="Restroom">Restroom</option>
                            <option value="Electrical">Electrical</option>
                            <option value="Furniture">Furniture</option>
                            <option value="AC">A/C</option>
                            <option value="Something Else">Something Else</option>
                        </select>

                        <label for="Progress">Progress:</label>
                        <select type="text" name = "progressInput" value = "<?php if (isset($_GET[' '])) {echo $_GET['progressInput'];} ?>" class = "form control" placeholder= "Select">
                            <option value="0">Select</option>
                            <option value="Accepted">Accepted</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Top 10">Top 10</option>
                            <option value="Done">Done</option>
                        </select>

                        <label for="Date">Date Accepted</label>
                        <input type="date" name = "dateInput" placeholder="Search.." value = "<?php if (!empty($_GET[''])) {echo $_GET['dateInput'];} ?>" class = "form control">

                </form>
                
                
                    
                    
                    
                </div>
            </div> 
            <br>
            <table>
                <tr>
                    <th> ID </th> 
					<th> Status </th>
                    <th> Submitted </th>
                    <th> Accepted </th>
                    <th> Type </th>
                    <th> Progress </th>
					<th> Issue </th>
					<th> UserId </th>
                    <th> hall </th>
                    <th> Room </th>
                </tr>

                <tbody>
                <?php
                    $serverName = "LAPTOP-TT3C4QN9\SQLEXPRESS";
                    $connectionOptions = [
                        "Database" => "WorkOrders",
                        "Uid"=> "",
                        "PWD" => "" ];
                    $conn = sqlsrv_connect($serverName, $connectionOptions);
                    if($conn == false)
                        die(print_r(sqlsrv_errors(), true));
                    
                    $sql = "SELECT * FROM WorkOrderInfo WHERE"; //Setting up SQL statement for Query Search
                    $count = 0; //IF 0 then no AND is added
                    
                    print ("at if");
                    //Checking the ID Seach if set then adding to String Query
                    if(!empty($_GET['Search']) )
                    {
                        $filtervalues = $_GET['Search'];
                        print ( $_GET['Search']);
                        $sql .= " ID Like '%$filtervalues%'";
                        $count = $count +1;//adding one because there is a component in query
                    }

                    //Checking the Dorm Name if set then adding to String Query\
                    
                    if(isset($_GET['DormInput']) && strcmp($_GET['DormInput'],"0"))//Making sure there is no default
                    {   
                        if ($count != 0) //Seeing if and needs to added to SQL before adding the rest
                        {
                            $sql .= " AND";
                        }
                        $dormValues = $_GET['DormInput'];
                        $sql .= " Hall ='$dormValues'";
                        $count = $count +1;//adding one because there is a component in query
                    }
                    //Checking Workorder type
                    if(isset($_GET['TypeInput']) && strcmp($_GET['TypeInput'],"0"))//Making sure there is no default
                    {
                        if ($count != 0)//Seeing if and needs to added to SQL before adding the rest
                        {
                            $sql .= " AND";
                        }
                        $typeValues = $_GET['TypeInput'];
                        $sql .= " Type ='$typeValues'";
                        $count = $count +1;//adding one because there is a component in query
                    }
                    //Checking Progress type
                    if(isset($_GET['progressInput']) && strcmp($_GET['progressInput'],"0"))//Making sure there is no default
                    {
                        if ($count != 0)//Seeing if and needs to added to SQL before adding the rest
                        {
                            $sql .= " AND";
                        }
                        $progressValues = $_GET['progressInput'];
                        $sql .= " Progress ='$progressValues'";
                        $count = $count +1;//adding one because there is a component in query
                    }
                     if(!empty($_GET['dateInput']))
                     {
                        if ($count != 0)//Seeing if and needs to added to SQL before adding the rest
                        {
                            $sql .= " AND";
                        }
                        $dateValues = $_GET['dateInput'];//date_format($_GET['dateInput'], "Y/m/d");
                        $sql .= " DateAccepted = '$dateValues'";
                        $count = $count +1;//adding one because there is a component in query
                    }
                    //IF no search is entered display alll work orders
                    if($count == 0){ $sql = "SELECT * FROM WorkOrderInfo ";   }
                    
                    $result = sqlsrv_query($conn,$sql);//Connecting the SQL statement with Database  

                    if (!$result){//if there is an error display error 
                        die("invalid query: " . sqlsrv_errors());		
                    }

                    
                    //displaying Results
                    while($row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC)) {
                        $id=$row["ID"];

                        echo "<tr> 
                             <td> ". $id . "</text></td> 
                            <td>". $row["WorkOrderStatus"] ."</td>";
                            $dateSub = $row["DateSubmitted"];
                            if (!is_null($dateSub)){
                                echo "<td>". date_format($dateSub, "Y/m/d H:i:s")  ."</td>";}
                            else{echo "<td>". NULL ."</td>";}
                            $dateAcc = $row["DateAccepted"];  
                            if(!is_null($dateAcc)){
                                echo    "<td>". date_format($dateAcc, "Y/m/d H:i:s") ."</td>";}        
                            else{echo "<td>". NULL ."</td>";}                    
                        echo "<td>". $row["Type"] ."</td>
                            <td>". $row["Progress"] ."</td>
                            <td>". $row["Issue"] ."</td>
                            <td>". $row["User_ID"] ."</td>
                            <td>". $row["Hall"] . "</td>
                            <td>". $row["RoomNumber"] . "</td>
                            <td>                            
                                <form action='viewWorkOrder.php' method='post'>
                                    <input type='hidden' name='id' value='".$row["ID"]."'>
                                    <button type='submit' class='button'>View</button>
                                </form>

                            </td> 

                            </tr>";
                        
                            }
                   ?>
            </tbody>
        </div>
    </div>
</div>

<script>
function myFunction() {
  var popup = document.getElementById("myPopup");
  popup.classList.toggle("show");
}
</script>

 <!-- <script>
// // Get the modal
// var modal = document.getElementById('myModal');

// // Get the <span> element that closes the modal
// var span = document.getElementsByClassName("close")[0];

// // Get all buttons with class 'view-btn'
// var buttons = document.getElementsByClassName('view-btn');

// // Iterate over each button and attach click event listener
// for (var i = 0; i < buttons.length; i++) {
//     buttons[i].addEventListener('click', function() {
        
//         event.preventDefault();
//         // Get the ID of the clicked button
//         var btnID = this.id;
        
//         // Extract the row ID from the button ID
//         var rowID = btnID.split('-')[2];

//         // When the user clicks the button, open the modal 
//         modal.style.display = "block";
//     });
// }

// // When the user clicks on <span> (x), close the modal
// span.onclick = function() {
//   modal.style.display = "none";
// }

// // When the user clicks anywhere outside of the modal, close it
// window.onclick = function(event) {
//   if (event.target == modal) {
//     modal.style.display = "none";
//   }
// }

// </script> -->

<!-- <script>
// // Get the modal
// var modal = document.getElementsByClassName('modal');;

// // Get the <span> element that closes the modal
// var span = document.getElementsByClassName("close")[0];

// // When the user clicks the button, open the modal 
// // Get all buttons with class 'view-btn'
// var buttons = document.getElementsByClassName('view-btn');

// // Iterate over each button and attach click event listener
// for (var i = 0; i < buttons.length; i++) {
//     buttons[i].addEventListener('click', function() {
//         // Get the ID of the clicked button
//         var btnID = this.id;
        
//         // Extract the row ID from the button ID
//         var rowID = btnID.split('-')[2];

//         // Get the modal
//         //var modal = document.getElementById("myModal");
//         print(rowID);

//         // When the user clicks the button, open the modal 
//         modal.style.display = "display";

//     });
// }

// // When the user clicks on <span> (x), close the modal
// span.onclick = function() {
//   modal.style.display = "none";
// }

// // When the user clicks anywhere outside of the modal, close it
// window.onclick = function(event) {
//   if (event.target == modal) {
//     modal.style.display = "none";
//   }
// }

// </script>      -->
      
</body>
</html>