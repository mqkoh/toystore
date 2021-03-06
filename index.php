<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Dream Realm</title>
	<link rel="icon" href="images/favicon.png">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Cuprum|Exo|Indie+Flower|Nunito" rel="stylesheet">	
</head>
<body>

<div class="top">
	<button class="iconbox" onclick="window.location.href='shoppingcart.php';">Shopping Cart<img class="icon" src="images/shoppingcart.png"></button>
	<a href="index.php"><img class="logo" src="images/logo_transparent.png" alt="Dream Realm"></a>
	<div class="topnav">
		<?php 
			if (isset($_COOKIE['custName'])) {
				echo "Hi, ".$_COOKIE['custName'];
				echo "&emsp;<a href=\"custLogout.php\";>Logout</a>";
				echo "<br><a href=\"edit_password.php\";>Change your password?</a>";
			} else {
		?>
		<button class="lower-button" id="register" onclick="window.location.href='custRegister.php';">New to our website? Register as our new member here!</button>
		<button class="lower-button" id="login" onclick="window.location.href='custLogin.php';">Already a member? Login here!</button>
		<button class="lower-button" id="login-admin" onclick="window.location.href='adminLogin.php';">Login as admin</button>
		<?php }?>
	</div>	
</div>

<div class="content">

	<div class="about">
		<h1>About</h1>
		<h2>Vision</h2>
		<p>To be the dominant toy and educational toy retailer for children in Asia offering the right products, at the right place,at the right time in a pleasurable and shopping environment.</p>

		<h2>Mission</h2>
		<p>To nurture and develop the core competence of the Dream Realm retailing chain for the benefit of our stakeholders(customers,shareholders, employees). 
        </p>
	</div>
	
	<div class="category">
		<img class="banner" src="images/banner_plush2.jpg">
		<img class="banner" src="images/banner_lego1.png">
		<img class="banner" src="images/banner_pop.jpg">
		<button class="button" id="button-left" onclick="plusDivs(-1)">&#8249;</button>
		<button class="button" id="button-right" onclick="plusDivs(1)">&#8250;</button>
		<button class="navigate" id="navigate-plush" onclick="window.location.href='plushies.php';" style="display: block;">Check out our cute and cuddly plushies!</button>
		<button class="navigate" id="navigate-lego" onclick="window.location.href='lego.php';">Check out our Lego collections!</button>
		<button class="navigate" id="navigate-pop" onclick="window.location.href='pop.php';">Check out our Pop collections!</button>
	</div>
	
	<div class="contactus">
	
		<div class="contactform">
			<h1>Contact Us</h1>
			<form id="send_form" action="handle_contactform.php" method="post">
				<label for="name">Name&emsp;&emsp;&emsp;: </label><input type="text" id="name" name="name" placeholder="Enter your name" size="30" required="required"><br><br>
				<label for="email">Email &emsp;&emsp;&emsp;: </label><input type="email" id="email" name="email" placeholder="Enter your email address" size="30" required="required"><br><br>
				<label for="comment">Comments&emsp;: </label><textarea id="comment" name="comment" placeholder="What would you like to tell us?" rows="8" cols="30" required="required"></textarea><br><br>
				<button id="submit"">Submit</button>
			</form>
		</div>
		
		<div class="findus">
			<h1>Send us an email</h1>
			<a href="mailto:dreamrealm.info@gmail.com?subject=Feedback"><img class="social" src="images/email.png"></a>
			<br><br>
			<h1>Find Us At...</h1>
			<a href="https://fb.me/dreamrealmm"><img class="social" src="images/facebook.png"></a>
			<a href="https://www.instagram.com/_dreamrealmm/"><img class="social" src="images/instagram.png"></a>
			
		</div>
		
	</div>
	
	<div id = "footer">
		<a href="index.php">Home</a>&emsp;
		<a href="plushies.php">Plushies</a>&emsp;
		<a href="lego.php">Lego</a>&emsp;
		<a href="pop.php">Funko Pop</a>&emsp;
		<br>
		Copyright &copy; 2018 Dream Realm
		<br>
		<b>Disclaimer: </b> Materials such as images, audio, videos and product details on this website do not belong to <i> Dream Realm </i>
		<br>
		These materials are obtained from the internet for assignment purpose only.
	</div>
</div>

<script src="script.js" type="text/javascript"></script>
</body>
</html>