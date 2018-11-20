// find current filename
var url = window.location.pathname;
var filename = url.substring(url.lastIndexOf('/')+1);

if (filename == "index.html") {
	var slideIndex = 1;
	showDivs(slideIndex);

	function plusDivs(n) {
	  showDivs(slideIndex += n);
	}

	function showDivs(n) {
	  var i;
	  var x = document.getElementsByClassName("banner");
	  var y = document.getElementsByClassName("navigate");
	  if (n > x.length) {slideIndex = 1}    
	  if (n < 1) {slideIndex = x.length}
	  for (i = 0; i < x.length; i++) {
	     x[i].style.display = "none";
	     y[i].style.display = "none";
	  }
	  x[slideIndex-1].style.display = "block";
	  y[slideIndex-1].style.display = "block";
	}
	
}
	function checkout() {
		if (confirm("Do you want to check out your items?")) {
			document.getElementById("shopping-cart").innerHTML = "<br>Thank you for shopping with us!";
		} 
	}





