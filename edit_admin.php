<?php 
// This page is for editing a user record.

$page_title = 'Edit Admin';
echo '<h1>Edit admin</h1>';

// Check for a valid admin ID, through GET or POST:
if ( (isset($_GET['adminID'])) && (is_numeric($_GET['adminID'])) ) { // From viewAdmin.php
	$id = $_GET['adminID'];
} elseif ( (isset($_POST['adminID'])) && (is_numeric($_POST['adminID'])) ) { // Form submission.
	$id = $_POST['adminID'];
} else { // No valid ID, kill the script.
	echo '<p class="error">[1] This page has been accessed in error.</p>';
	exit();
}

//Connect to database
require ('mysqli_connect.php');

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$errors = array();
	
	// Check for a customer name:
	if (empty($_POST['adminName'])) {
		$errors[] = 'You forgot to enter the name of the admin.';
	} else {
		$an = mysqli_real_escape_string($dbc, trim($_POST['adminName']));
	}

	// Check for an email address:
	if (empty($_POST['adminEmail'])) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$e = mysqli_real_escape_string($dbc, trim($_POST['adminEmail']));
	}
	
	if (empty($errors)) { // If everything's OK.
	
		// Test for unique email address:
		$q = "SELECT adminID FROM admin WHERE adminEmail='$e' AND adminID !=$id";
		$r = @mysqli_query($dbc, $q);
		
		
		if (mysqli_num_rows($r) == 0) {

			// Make the query:
			$q = "UPDATE admin SET adminName='$an',adminEmail='$e' WHERE adminID=$id LIMIT 1";
			$r = @mysqli_query($dbc,$q);
				
			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

				// Print a message:
				echo '<p>The admin has been edited.</p>';	
				
			} else { // If it did not run OK.
				echo '<p class="error">The admin could not be edited due to a system error. We apologize for any inconvenience.</p>'; // Public message.
				echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>'; // Debugging message.
			}
				
		} else { // Already registered.
			echo '<p class="error">The email address has already been registered.</p>';
		}
		
	} else { // Report the errors.

		echo '<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p>';
	
	} // End of if (empty($errors)) IF.
	

} // End of submit conditional.

// Always show the form...

// Retrieve the user's information:
$q = "SELECT adminName,adminEmail FROM admin WHERE adminID=$id";		
$r = @mysqli_query ($dbc, $q);

if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.

	// Get the user's information:
	$row = mysqli_fetch_array ($r, MYSQLI_NUM);
	
	// Create the form:
	echo '<form action="edit_admin.php" method="post">
			<p>Name: <input type="text" name="adminName" size="15" maxlength="15" value="' . $row[0] . '" /></p>
			<p>Email Address: <input type="text" name="adminEmail" size="20" maxlength="60" value="' . $row[1] . '" /></p>
			<p><input type="submit" name="submit" value="Submit" /></p>
			<input type="hidden" name="id" value="' . $id . '" />
		</form>';
	

} else { // Not a valid user ID.
	echo '<p class="error">This page has been accessed in error.</p>';
}

echo "<p style='text-align:center;'><a href='index_admin.html'>Back to Home Page</a></p>";

mysqli_close($dbc);
		
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

form{
	border:1px solid;
	padding:10px;
	box-shadow:5px 10px #888888;
	background-color:#33BAFF;
}
body{
	text-align:center;
	padding-top:200px;
 }
</style>