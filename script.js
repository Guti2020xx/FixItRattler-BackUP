/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
function FAQDropDown(clicked) {
  document.getElementById(clicked).classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}

  function Search(evt)
  {

  }
  

  function openForm() {
    document.getElementById("myForm").style.display = "block";
  }
  
  function closeForm() {
    document.getElementById("myForm").style.display = "none";
  }
  
  function sendMessage() {
	document.getElementById("messageBlock").style.display = "block";
    var x = document.getElementById("messageText").value;
    document.getElementById("sentText").innerHTML = x;
  } 