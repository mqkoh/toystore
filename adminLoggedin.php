<?php
//start session
session_start();

// The user is redirected here from adminLogin.php.

// If no cookie is present, redirect the user:
if (!isset($_COOKIE['adminID'])) {

	// Need the functions:
	require ('adminLogin_functions.inc.php');
	redirect_user();	

}

//set user
$_SESSION["user"]="admin";

// Print a customized message:

echo "<h1>Logged In!</h1>";
echo "<br><br>";
echo "<div>
		<p>You are now logged in, {$_COOKIE['adminName']}!</p>
		<p><a href=\"adminLogout.php\";>Logout</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"index_admin.html\">Home</a></p>
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
	background-color:#bf99d9;
}
body{
	text-align:center;
	padding-top:200px;
	
 }
</style>
</html>