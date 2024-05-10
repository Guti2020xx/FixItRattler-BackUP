<?php
session_start();

//checking credentials in each page
if(!isset($_SESSION['Role']) || !isset($_SESSION['ID']) || ($_SESSION['Role'] != "Student" && $_SESSION['Role'] != "Admin")) 
{
    echo "<script>
    alert('Please login.');
    window.location.href='login.php';
    </script>";
    exit; // Stop further script execution after redirection
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Work Order Request Form</title>
    <style>
         .form-group {
            margin-bottom: 15px;
            background-color: #ddd;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input, .form-group textarea, .form-group select {
            
            width: 95%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            color: black; /* Text color for input and textarea */
        }
        .form-group input[type="submit"], .form-group input[type="reset"] {
            background-color: #5cb85c;
            color: white;
            border: 4px solid #fff;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .form-group input[type="submit"]:hover,
        .form-group input[type="reset"]:hover {
            background-color: #4cae4c;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
        }
    </style>
    
</head>
<link rel = "stylesheet" href = "style.css">

<body>
    <div class="topnav">
        <a href = "StudentView.html" > Home </a>
        <a class = "active" href = "StudentSubmitWO.php" > Submit Work Order</a>
        <a href = "StudentProgress.html" >Progress</a>
        <a href = "StudentMessaging.html">Messaging</a>
        <a href = "login.php" class = "split"> Logout </a>
    </div>

    <!-- <div class="header-title">St. Mary's University</div> -->
    <div class="container">     
        <div class="title">Work Order Request</div>
        <form id="workOrderForm" action="SubmitWorkOrder.php" method ="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Residence Hall:</label>
                <select name="Hall">
                    <option value="Anthony Frederick"> Anthony Frederick </option>
                    <option value="Marian"> Marian</option>
                    <option value="Chaminade"> Chaminade </option>
                    <option value="Treadaway"> Treadaway </option>
                    <option value="Dougherty"> Dougherty</option>
                    <option value="Founders"> Founders </option>
                    <option value="Lourdes"> Lourdes </option>
                    <option value="Cremer"> Andrew Cremer </option>
                    <option value="Leies"> Leies </option>
                    <option value="Perigueux"> Perigueux </option>
                </select>
            </div>

            <div class="form-group">
                <label> Room Number: </label>
                <input type="number" name="roomNum" >
            </div>

            <div class="form-group">
                <label> Location: </label>
                <input type="text" name="location">
            </div>

            <div class="form-group">
                <label>Category:</label>
                <select name="category" required>
                    <option value="HVAC"> HVAC </option>
                    <option value="Plumbing"> Plumbing </option>
                    <option value="Housekeeping"> Housekeeping </option>
                    <option value="Maintenance/Repairs"> Maintenance/Repairs </option>
                    <option value="Furniture Replacement"> Furniture Replacement </option>
                    <option value="Other"> Other </option>
                </select>
            </div>
          
             <div class="form-group">
                <label> Image: </label>
                <input type="file" name="image" required>
            </div>
            
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name= "description" required></textarea>
            </div>

            <div class="form-group button-group">
                <input type="submit" value="Submit" name = "Submit">
                <input type="reset">
            </div>

        </form>
    </div>    
</body>
</html>