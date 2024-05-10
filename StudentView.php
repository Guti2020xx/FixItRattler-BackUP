<!DOCTYPE html>
<html>
<head>
    <style>
      /* Dropdown Button */
      .dropbtn {
        position: center;
        background-color: #e5f5ff;
        color: rgb(8, 8, 8);
        padding: 16px;
        font-size: 16px;
        border: none;
        cursor: pointer;
        table-layout: auto;
        width: 100%;
        padding: 10px 10px;
        border-radius: 10px;
        margin-top: 20px;
        
      }

      /* Dropdown button on hover & focus */
      .dropbtn:hover, .dropbtn:focus {
        background-color: #2980B9;
      }

      /* The container <div> - needed to position the dropdown content */
      .dropdown {
        position: relative;
        display: inline-block;
        padding: 10px 10px;
        table-layout: auto;
        width: 100%;
        
       
      }

      /* Dropdown Content (Hidden by Default) */
      .dropdown-content {
        display: none;
        position: auto;
        background-color: #f1f1f1;
        /* min-width: 160px; */
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        width: 100%;
        table-layout: auto;
        
      }

      /* Links inside the dropdown */
      .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        width: 100%;
        table-layout: auto;
      }

      /* Change color of dropdown links on hover */
      .dropdown-content a:hover {background-color: #ddd;}

      /* Show the dropdown menu (use JS to add this class to the .dropdown-content container when the user clicks on the dropdown button) */
      .show {display:block;}
    </style>
    
</head>
<link rel = "stylesheet" href = "style.css">
<script src="script.js"></script>

<body>
    <div class="topnav">
      <a class = "active" href = "StudentView.html" > Home </a>
      <a href = "StudentSubmitWO.php" > Submit Work Order</a>
      <a href = "StudentProgress.html" >Progress</a>
      <a href = "StudentMessaging.html">Messaging</a>
      <a href = "login.php" class = "split"> Logout </a>
    </div>
    
    <div class="container">
      <div class="title">FAQs</div>
      <div class="dropdown">
        <button onclick='FAQDropDown("ADropdown")' class="dropbtn">What do I include in the work order</button>
        <div id="ADropdown" class="dropdown-content">
          <a href="#">Fill out all the fields in the form, then be very descriptive when describing the location, this includes location in room, 
            what the issue is, what is currently happening, etc.</a>
        </div>
        <button onclick='FAQDropDown("BDropdown")' class="dropbtn">My Room is too cold/too hot</button>
        <div id="BDropdown" class="dropdown-content">
          <a href="#">If your room doesn't have a thermostat, the building runs off a centeralize AC, so unless its extremely hot or extremely cold,
            facilities can not fix your room</a>
        </div>
        <button onclick='FAQDropDown("CDropdown")' class="dropbtn">What do I do if its an emergency</button>
        <div id="CDropdown" class="dropdown-content">
          <a href="#">Call the office of Residence life, or the off hours number. You can also call facilities @</a>
        </div>
      </div>
    </div>

</body>
</html>