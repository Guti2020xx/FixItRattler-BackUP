<?php
session_start();

$serverName = "LAPTOP-JP2PAISQ";
$connectionOptions = ["Database" => "WorkOrders", "Uid" => "", "PWD" => ""];

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    echo "Database connection failed. Contact administrator.<br>";
    die(print_r(sqlsrv_errors(), true));
}

if (isset($_POST['user_name']) && isset($_POST['password'])) {
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    // Prepare SQL query
    $sql = "SELECT UserId, Role FROM User_Info WHERE Email = ? AND password = ?";
    $params = array($user_name, $password);

    // Execute query
    $result = sqlsrv_query($conn, $sql, $params);
    if ($result) 
    {
        if (sqlsrv_has_rows($result) > 0) {
            $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

            //trimming because of whitespace???
            $role = trim($row["Role"]);

            // Set session variables
            $_SESSION['ID'] = $row["UserId"];
            $_SESSION['Role'] = $role;

            if ($role == "Student") {
                echo "<script>alert('Login Successful!!! Going to student page.'); 
                      window.location.href='StudentView.php';</script>";
            } else if ($role == "Admin") {
                echo "<script>alert('Login Successful!!! Going to admin page.');
                      window.location.href='adminHome.php';</script>";
            } else {
                echo "<script>alert('Something is wrong with your account. Contact Facilities.');
                     ";
            }
        } else {
            echo "<script>alert('Account does not exist or password is incorrect.'); 
                  window.location.href='login.php';</script>";
        }
    } 
    else 
    {
        echo "Error in executing query.<br>";
        die(print_r(sqlsrv_errors(), true));
    }
}

// Always close the connection
sqlsrv_close($conn);
?>