<?php 
// This script performs an INSERT query to add a record to the customer table.

$page_title = 'Customer Register';

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require ('mysqli_connect.php'); // Connect to the db.
		
	$errors = array(); // Initialize an error array.
	
	// Check for a customer Name:
	if (empty($_POST['custName'])) {
		$errors[] = 'You forgot to enter your name.';
	} else {
		$custName_pattern = "/^[A-Za-z0-9]{5,20}$/";

		if (preg_match ($custName_pattern, $_POST['custName'])){
			echo "Your username is correct!";
			$cn = mysqli_real_escape_string($dbc, trim($_POST['custName'])); // capture the string
		} else{
			$errors[]= "Wrong username format!";
		}
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
	if (empty($_POST['custGender'])){
		$errors[] = 'You forgot to pick your gender.';
	}else{
		$g = mysqli_real_escape_string($dbc, trim($_POST['custGender']));
	}
	
	// Check for an email address:
	if (empty($_POST['custEmail'])){
		$errors[] = 'You forgot to enter your email address.';
	} else {
		//$email_pattern = "/^([a-zA-Z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/";
		//$email_pattern = "/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/";
		$email_pattern = "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix";
		
		
		if (preg_match ($email_pattern, $_POST['custEmail'])){
			$e = mysqli_real_escape_string($dbc, trim($_POST['custEmail']));
			echo "Your email is ok.";
		} else{
			$errors[] = 'Wrong email address format!';
		}
	}
	
	// Check for phone number:
	 if (empty($_POST['custPhone'])){
	 	$errors[] = 'You forgot to enter your phone number.';
	 }else {
		$custPhone_pattern ="/^01[0-9]1*-\d{7}$/";


		if (preg_match ($custPhone_pattern, $_POST['custPhone'])){
			echo "Your phone number is correct!";
			$cp = mysqli_real_escape_string($dbc, trim($_POST['custPhone'])); // capture the string
		} else{
			$errors[]= "Wrong phone number format!";
		}
	} 
	 
	 
	// Check for address:
	if(empty($_POST['custAdd'])){
		$errors[] = 'You forgot to enter your address.';
	}else{
		$a = mysqli_real_escape_string($dbc, trim($_POST['custAdd']));
	}
	
	if (empty($errors)) { // If everything's OK.
	
		// Register the user in the database...
		
		// Make the query:
		$q = "INSERT INTO customer(custName,custPW,custGender,custEmail,custPhone,custAdd,registration_date)VALUES('$cn',SHA1('$p'),'$g','$e','$cp','$a',NOW())";	//SHA1 = encryption
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


<h1>Register Customer</h1>
<div>
<form action="custRegister.php" method="post">

	<h5>Dear customers, <br/> Kindly confirm all your details before you click the register button.<br/>
	Only password are made available for edit purposes in future.<br/> Sorry for the inconvenience caused.</h5>
	<p>Name				: <input type="text" name="custName" size="20" maxlength="40" value="<?php if (isset($_POST['custName'])) echo $_POST['custName']; ?>" /></p>
	<p>Password			: <input type="password" name="pass1" size="10" maxlength="20" value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1'];?>"  /></p>
	<p>Confirm Password	: <input type="password" name="pass2" size="10" maxlength="20" value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2'];?>"  /></p>
	<p>Gender			: <input type="radio" name="custGender" <?php if (isset($_POST['custGender']) && ($_POST['custGender']) == "M") echo $_POST['custGender'];?> value="M" /> Male
						  <input type="radio" name="custGender" <?php if (isset($_POST['custGender']) && ($_POST['custGender']) == "F") echo $_POST['custGender'];?> value="F"  />Female<br></p>
	<p>Email Address	: <input type="text" name="custEmail" size="20" maxlength="60" value="<?php if (isset($_POST['custEmail'])) echo $_POST['custEmail'];?>" placeholder="jennifer@gmail.com" /> </p>
	<p>Phone Number		: <input type="tel" name="custPhone" size="20" maxlength="40" value="<?php if (isset($_POST['custPhone'])) echo $_POST['custPhone']; ?>" placeholder="010-2325679" /></p>
	<p>Address			: <input type="text" name="custAdd" size="30" maxlength="75" value="<?php if (isset($_POST['custAdd'])) echo $_POST['custAdd']; ?>" /></p><br>
	<p><input type="submit" name="submit" value="Register" /></p>  
</form>
</div>
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
<style>
body {
	background-image: linear-gradient(#E9C548, #E7E573);
	background-size: 100%;
	color: white;
	font-family: 'Nunito', sans-serif;
	margin: 20pt;
	}
	
h1{
	font-family:Charcoal,Sans-serif;
  	left: 0;
  	top: 50%;
  	width: 100%;
  	text-align: center;
 	color: #000000;
}

div{
	border:1px solid;
	padding:10px;
	box-shadow:5px 10px #888888;
}
body{
	text-align:center;
	background-color:#bf99d9;
	padding-top:300px;
	
 }
</style>
