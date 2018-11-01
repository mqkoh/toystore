<?php 
// This script performs an INSERT query to add a record to the users table.

$page_title = 'Register';

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require ('include.php'); // Connect to the db.
		
	$errors = array(); // Initialize an error array.
	
	// Check for a customer Name:
	if (empty($_POST['custName'])) {
		$errors[] = 'You forgot to enter your name.';
	} else {
		$fn = mysqli_real_escape_string($mysqli, trim($_POST['custName'])); // capture the string
	}
	
	// Check for a password and match against the confirmed password:
	if (!empty($_POST['pass1'])){
		if($_POST['pass2'] != $_POST['pass2']){
			$errors[] = 'Your password did not match the confirmed password.';
		}else{
			$p = mysqli_real_escape_string($mysqli, trim($_POST['pass1']));
		}
	}else {
		$errors[] = 'You forgot to enter your password.';
	}
	
	/* Check for customer:
	if (empty($_POST['last_name'])){
		$errors[] = 'You forgot to enter your last name.';
	}else{
		$ln = mysqli_real_escape_string($mysqli, trim($_POST['last_name']));
	}
	*/
	
	// Check for an email address:
	if (empty($_POST['email'])){
		$errors[] = 'You forgot to enter your email address.';
	}else{
		$e = mysqli_real_escape_string($mysqli, trim($_POST['email']));
	}
	
	if (empty($errors)) { // If everything's OK.
	
		// Register the user in the database...
		
		// Make the query:
		$q = "INSERT INTO customer()VALUES('$fn','$ln','$e',SHA1('$p'),NOW())";	//SHA1 = encryption
		$r = @mysqli_query ($mysqli, $q); // Run the query.
		if ($r) { // If it ran OK.
		
			// Print a message:
			echo '<h1>Thank you!</h1>
		<p>You are now registered successfully.</p><p><br /></p>';	
		
		} else { // If it did not run OK.
			
			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>'; 
			
			// Debugging message:
			echo '<p>' . mysqli_error($mysqli) . '<br /><br />Query: ' . $q . '</p>';
						
		} // End of if ($r) IF.
		
		mysqli_close($mysqli); // Close the database connection.

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
<h1>Register Customer</h1>
<form action="register.php" method="post">
	<p>Name: <input type="text" name="custName" size="15" maxlength="20" value="<?php if (isset($_POST['custName'])) echo $_POST['custName']; ?>" /></p>
	<p>Password: <input type="password" name="pass1" size="10" maxlength="20" value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1'];?>"  /></p>
	<p>Confirm Password: <input type="password" name="pass2" size="10" maxlength="20" value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2'];?>"  /></p>
	<p>Gender: <input type="radio" name="gender" value="<?php if (isset($_POST['email'])) echo $_POST['email'];?>" /> Male<br>
				<input type="radio" name="gender" value="<?php if (isset($_POST['email'])) echo $_POST['email'];?>" />Female<br></p>
	<p>Email Address: <input type="text" name="email" size="20" maxlength="60" value="<?php if (isset($_POST['email'])) echo $_POST['email'];?>" placeholder="j@gmail.com" /> </p>
	<p>Phone Number: <input type="tel" name="custPhone" size="15" maxlength="40" value="<?php if (isset($_POST['custPhone'])) echo $_POST['custPhone']; ?>" /></p>
	<p>Address: <input type="text" name="custAdd" size="30" maxlength="75" value="<?php if (isset($_POST['custAdd'])) echo $_POST['custAdd']; ?>" /></p>
	<p><input type="submit" name="submit" value="Register" /></p>  
</form>