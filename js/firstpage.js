// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

var img=document.getElementById("logo-size");
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
// Logo, second-bar problem solved

var img = document.getElementsByClassName("first-bar-logo")[0];

var secondbar = document.getElementsByClassName("stickybar")[0];


// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
  img.classList.remove("first-bar-logo");
  secondbar.classList.remove("stickybar");
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
  img.classList.add("first-bar-logo");
  secondbar.classList.add("stickybar");
  
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
  modal.style.display = "none";
  img.classList.add("first-bar-logo");
  secondbar.classList.add("stickybar");

  }
}