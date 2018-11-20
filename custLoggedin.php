<?php
// The user is redirected here from custLogin.php.

// If no cookie is present, redirect the user:
if (!isset($_COOKIE['custID'])) {

	// Need the functions:
	require ('custLogin_functions.inc.php');
	redirect_user();	

}

// Print a customized message:
echo "<h1>Logged In!</h1>";
echo "<br><br>";
echo "<div>
		<p>You are now logged in, {$_COOKIE['custName']}!</p>
		<p><a href=\"custLogout.php\";>Logout</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"index.html\">Home</a></p>
	</div>";
?>
<html>
<style>
h1{
	font-family:Charcoal,Sans-serif;
  	left: 0;
  	top: 50%;
  	width: 100%;
  	text-align: center;
 	color: #000000;
}

div{
	border:1px solid;
	padding:10px;
	box-shadow:5px 10px #888888;
}
body{
	text-align:center;
	background-color:#bf99d9;
	padding-top:300px;
	
 }
</style>
</html>