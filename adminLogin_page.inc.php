<?php 

// Print any error messages, if they exist:
if (isset($errors) && !empty($errors)) {
	echo '<h1>Error!</h1>
	<p class="error">The following error(s) occurred:<br />';
	foreach ($errors as $msg) {
		echo " - $msg<br />\n";
	}
	echo '</p><p>Please try again.</p>';
}

// Display the form:
?><h1>Login</h1>
<form action="adminLogin.php" method="post">
	<p>Email Address: <input type="text" name="adminEmail" size="20" maxlength="40" /> </p>
	<p>Password: <input type="password" name="adminPW" size="20" maxlength="40" /></p>
	<p><input type="submit" name="submit" value="Login" /></p>
</form>
<style>
