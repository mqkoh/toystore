<?php 
// This page is for editing a user record.

$page_title = 'Edit product';
echo '<h1>Edit Product</h1>';

// Check for a valid product ID, through GET or POST:
if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // From viewCustomer.php
	$id = $_GET['id'];
} elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form submission.
	$id = $_POST['id'];
} else { // No valid ID, kill the script.
	echo '<p class="error">This page has been accessed in error.</p>';
	exit();
}

//Connect to database
require ('mysqli_connect.php');

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$errors = array();
	
	// Check for a product name:
	if (empty($_POST['prodCode'])) {
		$errors[] = 'You forgot to enter the code of the product.';
	} else {
		$pc = mysqli_real_escape_string($dbc, trim($_POST['prodCode']));
	}
	
	/* Check for a last name:
	if (empty($_POST['last_name'])) {
		$errors[] = 'You forgot to enter your last name.';
	} else {
		$ln = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
	}
	*/

	// Check for an email address:
	if (empty($_POST['prodName'])) {
		$errors[] = 'You forgot to enter the product name.';
	} else {
		$pn = mysqli_real_escape_string($dbc, trim($_POST['prodName']));
	}
	
	if (empty($errors)) { // If everything's OK.
	
		// Test for unique email address:
		$q = "SELECT prodID FROM product WHERE prodName='$pn' AND prodID !=$id";
		$r = @mysqli_query($dbc, $q);
		
		
		if (mysqli_num_rows($r) == 0) {

			// Make the query:
			$q = "UPDATE product SET prodCode='$pc',prodName='$pn' WHERE prodID=$id LIMIT 1";
			$r = @mysqli_query($dbc,$q);
				
			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

				// Print a message:
				echo '<p>The product has been edited.</p>';	
				
			} else { // If it did not run OK.
				echo '<p class="error">The product could not be edited due to a system error. We apologize for any inconvenience.</p>'; // Public message.
				echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>'; // Debugging message.
			}
				
		} else { // Already registered.
			echo '<p class="error">The product name has already been registered.</p>';
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
$q = "SELECT prodCode,prodName FROM product WHERE prodID=$id";		
$r = @mysqli_query ($dbc, $q);

if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.

	// Get the user's information:
	$row = mysqli_fetch_array ($r, MYSQLI_NUM);
	
	// Create the form:
	echo '<form action="edit_product.php" method="post">
			<p>Product Code: <input type="text" name="prodCode" size="15" maxlength="15" value="' . $row[0] . '" /></p>
			<p>Product Name: <input type="text" name="prodName" size="20" maxlength="60" value="' . $row[1] . '" /></p>
			<p><input type="submit" name="submit" value="Submit" /></p>
			<input type="hidden" name="id" value="' . $id . '" />
		</form>';

} else { // Not a valid product ID.
	echo '<p class="error">This page has been accessed in error.</p>';
}

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