<?php 

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// For processing the login:
	require ('custLogin_functions.inc.php');
	
	// Need the database connection:
	require ('mysqli_connect.php');
		
	// Check the login:
	list ($check, $data) = check_login($dbc, $_POST['custEmail'], $_POST['custPW']);
	
	if ($check) { // OK!
		
		// Set the cookies:
		setcookie ('custID', $data['custID']);
		setcookie ('custName', $data['custName']);
		
		// Redirect:
		redirect_user('custLoggedin.php');
			
	} else { // Unsuccessful!

		// Assign $data to $errors for error reporting
		// in the login_page.inc.php file.
		$errors = $data;

	}
		
	mysqli_close($dbc); // Close the database connection.

} // End of the main submit conditional.

// Create the page:
include ('custLogin_page.inc.php');
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
