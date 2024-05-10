<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <meta http-equiv="X=UA-Compatible" content = "IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Fix It Rattle Login Page</title>
    <link rel="stylesheet" href="login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
        <div class="wrapper">
         
             <h1> Login </h1>
             <form  method="POST" action ="loginManager.php">
			    <div style="font-size: 20px;margin: 10px;color: white;">Login</div>
			    <input id="text" type="text" name="user_name"><br><br>
			    <input id="text" type="password" name="password"><br><br>
			    <input id="button" type="submit" value="Login"><br><br>
             </form>
             
                <!-- <div class ="input-box">
                    <input  type = "text" name="user_name" placeholder = "Username here" required>
                    <i class='bx bxs-user'> </i>
                </div>

                <div class ="input-box">
                    <input type = "password" name="password" placeholder = "Password here" required>
                    <i class='bx bxs-lock-alt'></i>
                    <div></div> 
                    <input type = "submit" class="btn" value="Login">
                    
            </form> -->  
        </div>
</body>
</html>

