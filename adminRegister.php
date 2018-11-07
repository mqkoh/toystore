<?php 
// This script performs an INSERT query to add a record to the admin table.

$page_title = 'Admin Register';

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require ('include.php'); // Connect to the db.
		
	$errors = array(); // Initialize an error array.
	
	// Check for a admin's ID:
	if (empty($_POST['adminID'])) {
		$errors[] = 'You forgot to enter your ID.';
	} else {
		$aid = mysqli_real_escape_string($mysqli, trim($_POST['adminID'])); // capture the string
	}
	
	// Check for a customer Name:
	if (empty($_POST['adminName'])) {
		$errors[] = 'You forgot to enter your name.';
	} else {
		$an = mysqli_real_escape_string($mysqli, trim($_POST['adminName'])); // capture the string
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
	
	//Check for customer gender 
	if (empty($_POST['adminGender'])){
		$errors[] = 'You forgot to pick your gender.';
	}else{
		$ag = mysqli_real_escape_string($mysqli, trim($_POST['adminGender']));
	}
	
	// Check for an email address:
	if (empty($_POST['adminEmail'])){
		$errors[] = 'You forgot to enter your email address.';
	}else{
		$ae = mysqli_real_escape_string($mysqli, trim($_POST['adminEmail']));
	}
	
	// Check for phone number:
	 if (empty($_POST['adminPhone'])){
	 	$errors[] = 'You forgot to enter your phone number.';
	 }else{
	 	$ap = mysqli_real_escape_string($mysqli, trim($_POST['adminPhone']));
	 }
	 
	// Check for address:
	if(empty($_POST['adminAdd'])){
		$errors[] = 'You forgot to enter your address.';
	}else{
		$aa = mysqli_real_escape_string($mysqli, trim($_POST['adminAdd']));
	}
	
	if (empty($errors)) { // If everything's OK.
	
		// Register the user in the database...
		
		// Make the query:
		$q = "INSERT INTO admin(adminID,adminName,adminPW,adminGender,adminEmail,adminPhone,adminAdd)VALUES('$aid','$an',SHA1('$p'),'$ag','$ae','$ap','$aa')";	//SHA1 = encryption
		$r = @mysqli_query ($mysqli, $q); // Run the query.
		if ($r) { // If it ran OK.
		
			// Print a message:
			echo '	<h1>Thank you!</h1>
					<p>You are now registered successfully.</p><p><br /></p>';	
		
		} else { // If it did not run OK.
			
			// Public message:
			echo '	<h1>System Error</h1>
					<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>'; 
			
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
<h1>Register Admin</h1>
<form action="adminRegister.php" method="post">
	<p>Name				: <input type="text" name="adminName" size="20" maxlength="40" value="<?php if (isset($_POST['amdinName'])) echo $_POST['adminName']; ?>" /></p>
	<p>Password			: <input type="password" name="pass1" size="10" maxlength="20" value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1'];?>"  /></p>
	<p>Confirm Password	: <input type="password" name="pass2" size="10" maxlength="20" value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2'];?>"  /></p>
	<p>Gender			: <input type="radio" name="adminGender" value="<?php if (isset($_POST['adminGender'])) echo $_POST['adminGender'];?>" /> Male
						<input type="radio" name="adminGender" value="<?php if (isset($_POST['adminGender'])) echo $_POST['adminGender'];?>" />Female<br></p>
	<p>Email Address	: <input type="text" name="adminEmail" size="20" maxlength="60" value="<?php if (isset($_POST['adminEmail'])) echo $_POST['adminEmail'];?>" placeholder="jennifer@gmail.com" /> </p>
	<p>Phone Number		: <input type="tel" name="adminPhone" size="20" maxlength="40" value="<?php if (isset($_POST['adminPhone'])) echo $_POST['adminPhone']; ?>" placeholder="010-2325679" /></p>
	<p>Address			: <input type="text" name="adminAdd" size="30" maxlength="75" value="<?php if (isset($_POST['adminAdd'])) echo $_POST['adminAdd']; ?>" /></p><br>
	<p><input type="submit" name="submit" value="Register" /></p>  
</form>