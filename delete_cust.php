<?php 
// This page is for deleting a customer record.

$page_title = 'Delete a Customer';
echo '<h1>Delete a customer</h1>';

// Check for a valid customer ID, through GET or POST:
if ( (isset($_GET['custID'])) && (is_numeric($_GET['custID'])) ) { // From viewCustomer.php
	$id = $_GET['custID'];
} elseif ( (isset($_POST['custID'])) && (is_numeric($_POST['custID'])) ) { // Form submission.
	$id = $_POST['custID'];
} else { // No valid ID, kill the script.
	echo '<p class="error">This page has been accessed in error.</p>';
	exit();
 }

//Connect to database
require ('mysqli_connect.php');

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		// Delete the record.
		if($_POST['sure'] == 'Yes'){
			
			// Make the query:
			$q = "DELETE FROM customer WHERE custID = $id LIMIT 1";
			$r = @mysqli_query($dbc, $q);
			
			if(mysqli_affected_rows($dbc) == 1){// If it ran OK.
				
				// Print a message:
				echo 'The customer has been deleted.';
			}else {// If the query did not run OK.
				echo '<p class="error"> The customer could not be deleted due to system error.</p>';// Public message.
				echo '<p>'.mysqli_error($dbc).'<br /> Query: ' .$q.'</p>';// Debugging message.;
			}
		}else { // No confirmation of deletion.
			echo '<p>The customer has NOT been deleted.</p>';
		}
		
} else { // Show the form.

	// Retrieve the user's information:
	$q = "SELECT custName FROM customer WHERE custID=$id";
	$r = @mysqli_query ($dbc, $q);

	if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.

		// Get the user's information:
		$row = mysqli_fetch_array ($r, MYSQLI_NUM);
		
		// Display the record being deleted:
		echo "<h3>Name: $row[0]</h3>
		Are you sure you want to delete this user?";
		
		// Create the form:
		echo '<form action="delete_cust.php" method="post">
	<input type="radio" name="sure" value="Yes" /> Yes 
	<input type="radio" name="sure" value="No" checked="checked" /> No
	<input type="submit" name="submit" value="Submit" />
	<input type="hidden" name="custID" value="' . $id . '" />
	</form>';
	
	} else { // Not a valid user ID.
		echo '<p class="error">This page has been accessed in error.</p>';
	}

} // End of the main submission conditional.

mysqli_close($dbc);
		
?>