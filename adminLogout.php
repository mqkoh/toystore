<?php 

// If no cookie is present, redirect the user:
if (!isset($_COOKIE['adminID'])) {

	// Need the function:
	require ('adminLogin_functions.inc.php');
	redirect_user();	
	
} else { // Delete the cookies:
	setcookie ('adminID', '', time() - 3600);
	setcookie ('adminName', '', time() - 3600);
}

// Set the page title and include the HTML header:
$page_title = 'Logged Out!';

// Print a customized message:
echo "<h1>Logged Out!</h1>
<p>You are now logged out, {$_COOKIE['adminName']}!</p>";

?>