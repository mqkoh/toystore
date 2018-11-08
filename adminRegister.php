<?php 
// This script performs an INSERT query to add a record to the admin table.

$page_title = 'Admin Register';

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require ('mysqli_connect.php'); // Connect to the db.
		
	$errors = array(); // Initialize an error array.
	
	// Check for a admin's ID:
	if (empty($_POST['adminID'])) {
		$errors[] = 'You forgot to enter your ID.';
	} else {
		$aid = mysqli_real_escape_string($dbc, trim($_POST['adminID'])); // capture the string
	}
	
	// Check for a customer Name:
	if (empty($_POST['adminName'])) {
		$errors[] = 'You forgot to enter your name.';
	} else {
		$an = mysqli_real_escape_string($dbc, trim($_POST['adminName'])); // capture the string
	}
	
	// Check for a password and match against the confirmed password:
	if (!empty($_POST['pass1'])){
		if($_POST['pass2'] != $_POST['pass2']){
			$errors[] = 'Your password did not match the confirmed password.';
		}else{
			$p = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
		}
	}else {
		$errors[] = 'You forgot to enter your password.';
	}
	
	//Check for customer gender 
	if (empty($_POST['adminGender'])){
		$errors[] = 'You forgot to pick your gender.';
	}else{
		$ag = mysqli_real_escape_string($dbc, trim($_POST['adminGender']));
	}
	
	// Check for an email address:
	if (empty($_POST['adminEmail'])){
		$errors[] = 'You forgot to enter your email address.';
	}else{
		$ae = mysqli_real_escape_string($dbc, trim($_POST['adminEmail']));
	}
	
	// Check for phone number:
	 if (empty($_POST['adminPhone'])){
	 	$errors[] = 'You forgot to enter your phone number.';
	 }else{
	 	$ap = mysqli_real_escape_string($dbc, trim($_POST['adminPhone']));
	 }
	 
	// Check for address:
	if(empty($_POST['adminAdd'])){
		$errors[] = 'You forgot to enter your address.';
	}else{
		$aa = mysqli_real_escape_string($dbc, trim($_POST['adminAdd']));
	}
	
	if (empty($errors)) { // If everything's OK.
	
		// Register the user in the database...
		
		// Make the query:
		$q = "INSERT INTO admin(adminID,adminName,adminPW,adminGender,adminEmail,adminPhone,adminAdd,registration_date)VALUES('$aid','$an',SHA1('$p'),'$ag','$ae','$ap','$aa',NOW())";	//SHA1 = encryption
		$r = @mysqli_query ($dbc, $q); // Run the query.
		if ($r) { // If it ran OK.
		
			// Print a message:
			echo '	<h1>Thank you!</h1>
					<p>You are now registered successfully.</p><p><br /></p>';	
		
		} else { // If it did not run OK.
			
			// Public message:
			echo '	<h1>System Error</h1>
					<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>'; 
			
			// Debugging message:
			echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
						
		} // End of if ($r) IF.
		
		mysqli_close($dbc); // Close the database connection.

		exit();
		
	} else { // Report the errors.
	
		echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p><p><br /></p>';
		
	} // End of if (empty($errors)) IF.
	
	mysqli_close($dbc); // Close the database connection.

} // End of the main Submit conditional.
?>
<h1>Register Admin</h1>
<form action="adminRegister.php" method="post">
	
	<fieldset>
	<legend>ID:</legend>
	<input type="text" name="adminID" size="20" maxlength="40" value="<?php if (isset($_POST['adminID'])) echo $_POST['adminID']; ?>" />
	</fieldset>
	<br/>
	
	<fieldset>
	<legend>Name:</legend>
	<input type="text" name="adminName" size="20" maxlength="40" value="<?php if (isset($_POST['amdinName'])) echo $_POST['adminName']; ?>" />
	</fieldset>
	<br/>
	
	<fieldset>
	<legend>Password:</legend>
	<input type="password" name="pass1" size="20" maxlength="40" value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1'];?>"  />
	</fieldset>
	<br/>
	
	<fieldset>
	<legend>Confirm Password:</legend>
	<input type="password" name="pass2" size="20" maxlength="40" value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2'];?>"  />
	</fieldset>
	<br/>
	
	<fieldset>
	<legend>Gender:</legend>
	<input type="radio" name="adminGender" <?php if (isset($_POST['adminGender']) && ($_POST['adminGender']) == "M") echo $_POST['adminGender'];?> value="M" /> Male
	<input type="radio" name="adminGender" <?php if (isset($_POST['adminGender']) && ($_POST['adminGender']) == "F") echo $_POST['adminGender'];?> value="F"  />Female
	</fieldset>
	<br/>
	
	<fieldset>
	<legend>Email Address:</legend>
	<input type="text" name="adminEmail" size="20" maxlength="40" value="<?php if (isset($_POST['adminEmail'])) echo $_POST['adminEmail'];?>" placeholder="jennifer@gmail.com" /> 
	</fieldset>
	<br/>
	
	<fieldset>
	<legend>Phone Number:</legend>
	<input type="tel" name="adminPhone" size="20" maxlength="40" value="<?php if (isset($_POST['adminPhone'])) echo $_POST['adminPhone']; ?>" placeholder="010-2325679" />
	</fieldset>
	<br/>
	
	<fieldset>
	<legend>Address:</legend>
	<input type="text" name="adminAdd" size="20" maxlength="75" value="<?php if (isset($_POST['adminAdd'])) echo $_POST['adminAdd']; ?>" />
	</fieldset>
	<br/>
	
	<p><input type="submit" name="submit" value="Register" /></p>  
</form>