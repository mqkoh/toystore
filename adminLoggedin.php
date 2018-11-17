<?php
// The user is redirected here from adminLogin.php.

// If no cookie is present, redirect the user:
if (!isset($_COOKIE['adminID'])) {

	// Need the functions:
	require ('adminLogin_functions.inc.php');
	redirect_user();	

}

// Print a customized message:
echo "<h1>Logged In!</h1>
<p>You are now logged in, {$_COOKIE['adminName']}!</p>
<p><a href=\"adminLogout.php\">Logout</a></p>";

?>