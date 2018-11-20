<?php
// The user is redirected here from custLogin.php.

// If no cookie is present, redirect the user:

if (!isset($_COOKIE['custID'])) {

	// Need the functions:
	require ('custLogin_functions.inc.php');
	redirect_user();	

}

// Print a customized message:
echo "<h1>Logged In!</h1>
<p>You are now logged in, {$_COOKIE['custName']}!</p>
<p><a href=\"custLogout.php\";>Logout</a></p>
<p><a href=\"index.html\">Home</a></p> ";

?>
