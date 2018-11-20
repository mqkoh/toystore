<?php 

// If no cookie is present, redirect the user:
if (!isset($_COOKIE['custID'])) {

	// Need the function:
	require ('custLogin_functions.inc.php');
	redirect_user();	
	
} else { // Delete the cookies:
	setcookie ('custID', '', time() - 3600);
	setcookie ('custName', '', time() - 3600);
	session_destroy();
}

// Set the page title and include the HTML header:
$page_title = 'Logged Out!';

// Print a customized message:
echo "<h1>Logged Out!</h1>
<p>You are now logged out, {$_COOKIE['custName']}!</p>
<a href=\"index.php\";>Back to Home Page</a>";

?>