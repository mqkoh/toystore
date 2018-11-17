<?php 

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// For processing the login:
	require ('adminLogin_functions.inc.php');
	
	// Need the database connection:
	require ('mysqli_connect.php');
		
	// Check the login:
	list ($check, $data) = check_login($dbc, $_POST['adminEmail'], $_POST['adminPW']);
	
	if ($check) { // OK!
		
		// Set the cookies:
		setcookie ('adminID', $data['adminID']);
		setcookie ('adminName', $data['adminName']);
		
		// Redirect:
		redirect_user('adminLoggedin.php');
			
	} else { // Unsuccessful!

		// Assign $data to $errors for error reporting
		// in the login_page.inc.php file.
		$errors = $data;

	}
		
	mysqli_close($dbc); // Close the database connection.

} // End of the main submit conditional.

// Create the page:
include ('adminLogin_page.inc.php');
?>