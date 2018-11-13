<?php

// This page lets customer change their password.

$page_title = 'Update your details';

// Check for a valid admin ID, through GET or POST:
if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // From viewCustomer.php
	$id = $_GET['id'];
} elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form submission.
	$id = $_POST['id'];
} else { // No valid ID, kill the script.
	echo '<p class="error">This page has been accessed in error.</p>';
	exit();
}

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require ('mysqli_connect.php'); // Connect to the db.
		
	$errors = array(); // Initialize an error array.
	
	// Check for a customer Name:
	if (empty($_POST['custName'])) {
		$errors[] = 'You forgot to enter your name.';
	} else {
		$ncn = mysqli_real_escape_string($dbc, trim($_POST['custName'])); // capture the string
	}
	
	//Check for customer gender
	if (empty($_POST['custGender'])){
		$errors[] = 'You forgot to pick your gender.';
	}else{
		$ng = mysqli_real_escape_string($dbc, trim($_POST['custGender']));
	}
	
	// Check for an email address:
	if (empty($_POST['custEmail'])){
		$errors[] = 'You forgot to enter your email address.';
	}else{
		$ne = mysqli_real_escape_string($dbc,trim($_POST['custEmail']));
	}
	
	// Check for phone number:
	if (empty($_POST['custPhone'])){
		$errors[] = 'You forgot to enter your phone number.';
	}else{
		$ncp = mysqli_real_escape_string($dbc, trim($_POST['custPhone']));
	}
	
	// Check for address:
	if(empty($_POST['custAdd'])){
		$errors[] = 'You forgot to enter your address.';
	}else{
		$na = mysqli_real_escape_string($dbc, trim($_POST['custAdd']));
	}
	
	// Check for the current password:
	if (empty($_POST['custPW'])){
		$errors[] = 'You forgot to enter your password,';
	}else{
		$p = mysqli_real_escape_string($dbc,trim($_POST['custPW']));
	}	

	// Check for a new password and match 
	// against the confirmed password:
	if (!empty($_POST['pass1'])){
		if($_POST['pass1'] != $_POST['pass2']){
			$errors[] = 'Your new password did not match the confirmed password.';
		}else {
			$np = mysqli_real_escape_string($dbc,trim($_POST['pass1']));
		}
	}else {
		$errors[] = 'You forgot to enter your new password.';
	}
	
	if (empty($errors)){
	 		
		// Check that they've entered the right email address/password combination:
		$q = "SELECT custID,custName,custGender,custEmail,custPhone,custAdd FROM customer WHERE (custEmail='$ne' AND custPW=SHA1('$p') )";
		$r = @mysqli_query($dbc, $q);
		$num = @mysqli_num_rows($r);
		if ($num == 1) { // Match was made.
	
			// Get the user_id:
			$row = mysqli_fetch_array($r, MYSQLI_NUM);

			// Make the UPDATE query:
			$q = "UPDATE customer SET custName='$ncn',custGender='$ng',custPhone='$ncp',custAdd='$na',custPW=SHA1('$np') WHERE custID=$row[0]";		
			$r = @mysqli_query($dbc, $q);
			
			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

				// Print a message.
				echo '<h1>Thank you!</h1>
				<p>Your details have been updated.</p><p><br /></p>';	

			} else { // If it did not run OK.

				// Public message:
				echo '<h1>System Error</h1>
				<p class="error">Your password could not be changed due to a system error. We apologize for any inconvenience.</p>'; 
	
				// Debugging message:
				echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
	
			}

			mysqli_close($dbc); // Close the database connection.

			// Include the footer and quit the script (to not show the form).
			exit();
				
		} else { // Invalid email address/password combination.
			echo '<h1>Error!</h1>
			<p class="error">The email address and password do not match those on file.</p>';
		}
		
	} else { // Report the errors.

		echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p><p><br /></p>';
	
	} // End of if (empty($errors)) IF.

	
	// Retrieve the user's information:
	$q = "SELECT custName,custGender,custEmail,custPhone,custAdd FROM admin WHERE custID=$id";
	$r = @mysqli_query ($dbc, $q);

	if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.

	// Get the user's information:
	$row = mysqli_fetch_array ($r, MYSQLI_NUM);

	// Create the form:
	echo '<h1>Update your details</h1>
			<form action="password.php" method="post">
				<fieldset>
				<legend><b>Customer Details</b></legend>
				<p>Name&nbsp;: <input type="text" name="custName" size="20" maxlength="60" value="'.$row[0].'"  /></p>
				<p>Gender&nbsp;: <input type="radio" name="custGender" value="'.$row[1].'" /> Male
								 <input type="radio" name="custGender" value="'.$row[0].'"  />Female<br></p>
				<p>Email Address&nbsp;: <input type="text" name="custEmail" size="20" maxlength="60" value="'.$row[2].'"  /> </p>
				<p>Phone Number&nbsp;: <input type="tel" name="custPhone" size="20" maxlength="40" value="'.$row[3].'>" /></p>
				<p>Address&nbsp;: <input type="text" name="custAdd" size="30" maxlength="75" value="'.$row[4].'" /></p><br>
				</fieldset>
				<br/>
				
				<fieldset>
				<legend><b>Login Details</b></legend>
				<p>Current Password: <input type="password" name="custPW" size="10" maxlength="20" value="<?php if (isset($_POST['custPW'])) echo $_POST['custPW']; ?>"  /></p>
				<p>New Password: <input type="password" name="pass1" size="10" maxlength="20" value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>"  /></p>
				<p>Confirm New Password: <input type="password" name="pass2" size="10" maxlength="20" value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>"  /></p><br/>
				</fieldset>
				
				<p><input type="submit" name="submit" value="Update Details" /></p>
			</form>';
	else { // Not a valid user ID.
		echo '<p class="error">This page has been accessed in error.</p>';
	}
	
	mysqli_close($dbc);
?>