<?php 
session_start();

// If no cookie is present, redirect the user:
if (!isset($_COOKIE['custID'])) {

	// Need the function:
	require ('custLogin_functions.inc.php');
	redirect_user();	
	
} else { // Delete the cookies:
	setcookie ('custID', '', time() - 3600);
	setcookie ('custName', '', time() - 3600);
	if (isset($_SESSION)) {
		session_destroy();
	}
}

// Set the page title and include the HTML header:
$page_title = 'Logged Out!';

// Print a customized message:
echo "<h1>Logged Out!</h1>
<p>You are now logged out, {$_COOKIE['custName']}!<br><br>
<a href=\"index.php\";>Back to Home Page</a></p>";

?>

<style>
h1{
	font-family:Charcoal,Sans-serif;
  	left: 0;
  	top: 50%;
  	width: 100%;
  	text-align: center;
 	color: #000000;
}

p{
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
