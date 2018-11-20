<?php 
// This page is for deleting a product record.

$page_title = 'Delete Product';
echo '<h1>Delete Product</h1>';

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

		// Delete the record.
		if($_POST['sure'] == 'Yes'){
			
			// Make the query:
			$q = "DELETE FROM product WHERE prodID = $id LIMIT 1";
			$r = @mysqli_query($dbc, $q);
			
			if(mysqli_affected_rows($dbc) == 1){// If it ran OK.
				
				// Print a message:
				echo 'The product has been deleted.';
			}else {// If the query did not run OK.
				echo '<p class="error"> The product could not be deleted due to system error.</p>';// Public message.
				echo '<p>'.mysqli_error($dbc).'<br /> Query: ' .$q.'</p>';// Debugging message.;
			}
		}else { // No confirmation of deletion.
			echo '<p>The product has NOT been deleted.</p>';
		}
		
} else { // Show the form.

	// Retrieve the product's information:
	$q = "SELECT prodCode,prodName,prodDesc,prodImage FROM product WHERE prodID=$id";
	$r = @mysqli_query ($dbc, $q);

	if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.

		// Get the user's information:
		$row = mysqli_fetch_array ($r, MYSQLI_NUM);
		
		// Display the record being deleted:
		echo "<fieldset>
				<legend>Product Details</legend>
				<p><b>Product Code</b>&nbsp		: $row[0]</p>
				<p><b>Product Name</b>&nbsp		: $row[1]</p>
				<p><b>Product Description</b>&nbsp	: $row[2]</p>
				<p><b>Product Image</b>&nbsp	: $row[3]</p>
			</fieldset><br/>
			Are you sure you want to delete this product?";
		
		// Create the form:
		echo '<form action="delete_product.php" method="post"><br/>
				<input type="radio" name="sure" value="Yes" /> Yes 
				<input type="radio" name="sure" value="No" checked="checked" /> No <br/><br/>
				<input type="submit" name="submit" value="Submit" />
				<input type="hidden" name="prodID" value="' . $id . '" />
			</form>';
	
	} else { // Not a valid user ID.
		echo '<p class="error">This page has been accessed in error.</p>';
	}

} // End of the main submission conditional.

mysqli_close($dbc);
		
?>