<?php 
// This script performs an INSERT query to add a record to the product table.

$page_title = 'Product Register';

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require ('include.php'); // Connect to the db.
		
	$errors = array(); // Initialize an error array.
	
	// Check for a product's ID:
	if (empty($_POST['prodID'])) {
		$errors[] = 'You forgot to enter the product ID.';
	} else {
		$pid = mysqli_real_escape_string($mysqli, trim($_POST['prodID'])); // capture the string
	}
	
	// Check for a product's Name:
	if (empty($_POST['prodName'])) {
		$errors[] = 'You forgot to enter the product name.';
	} else {
		$pn = mysqli_real_escape_string($mysqli, trim($_POST['prodName'])); // capture the string
	}
	
	//Check for product's category 
	if (empty($_POST['prodCategory'])){
		$errors[] = 'You forgot to choose the category for the product.';
	}else{
		$pc = mysqli_real_escape_string($mysqli, trim($_POST['prodCategory']));
	}
	
	// Check for product's price
	if (empty($_POST['prodPrice'])){
		$errors[] = 'You forgot to enter the price of the product.';
	}else{
		$pp = mysqli_real_escape_string($mysqli, trim($_POST['prodPrice']));
	}
	
	// add in regular exxpression for product price validation?

	
	
	
	

	 
	// Check for product's description:
	if(empty($_POST['prodDesc'])){
		$errors[] = 'You forgot to enter the description for the product.';
	}else{
		$pd = mysqli_real_escape_string($mysqli, trim($_POST['prodDesc']));
	}
	
	if (empty($errors)) { // If everything's OK.
	
		// Register the user in the database...
		
		// Make the query:
		$q = "INSERT INTO product(prodID,prodName,prodCategory,prodPrice,prodDesc)VALUES('$pid',$pn','$pc','$pp','$pd')";
		$r = @mysqli_query ($mysqli, $q); // Run the query.
		if ($r) { // If it ran OK.
		
			// Print a message:
			echo '	<h1>Thank you!</h1>
					<p>The product have been registered successfully.</p><p><br /></p>';	
		
		} else { // If it did not run OK.
			
			// Public message:
			echo '	<h1>System Error</h1>
					<p class="error">You could registere the product due to a system error. We apologize for any inconvenience.</p>'; 
			
			// Debugging message:
			echo '<p>' . mysqli_error($mysqli) . '<br /><br />Query: ' . $q . '</p>';
						
		} // End of if ($r) IF.
		
		mysqli_close(); // Close the database connection.

		exit();
		
	} else { // Report the errors.
	
		echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p><p><br /></p>';
		
	} // End of if (empty($errors)) IF.
	
	mysqli_close($mysqli); // Close the database connection.

} // End of the main Submit conditional.
?>
<h1>Register Product</h1>
<form action="prodRegister.php" method="post">
	<p>ID				: <input type="text" name="prodID" size="20" maxlength="40" value="<?php if (isset($_POST['prodID'])) echo $_POST['prodID']; ?>" /></p>
	<p>Name				: <input type="text" name="prodName" size="20" maxlength="40" value="<?php if (isset($_POST['prodName'])) echo $_POST['prodName']; ?>" /></p>
	<p>Product Category	: <select name="prodCategory">
							<option value="<?php if (isset($_POST['prodCategory'])) echo $_POST['FunkoPop']; ?>">Funko Pop</option>
							<option value="<?php if (isset($_POST['prodCategory'])) echo $_POST['Lego']; ?>">Lego</option>
							<option value="<?php if (isset($_POST['prodCategory'])) echo $_POST['Plushies']; ?>">Plushies</option>
						  </select>
	<p>Product Price	: <input type="text" name="prodPrice" size="20" maxlength="40" value="<?php if (isset($_POST['prodPrice'])) echo $_POST['prodPrice']; ?>" placeholder="RM 33.99" /></p>
	<p>Product Description	: <textarea name="prodDesc" rows="20" cols="40" <?php if (isset($_POST['prodDesc'])) echo $_POST['prodDesc']; ?> /></textarea></p><br>
	<p><input type="submit" name="submit" value="Register" /></p>  
</form>