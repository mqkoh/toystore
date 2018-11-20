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
?>
<h1>Admin Login</h1>
<div>
<form action="adminLogin.php" method="post">
	<p>Email Address: <input type="text" name="adminEmail" size="20" maxlength="40" /> </p>
	<p>Password: <input type="password" name="adminPW" size="20" maxlength="40" /></p>
	<p><input type="submit" name="submit" value="Login" /></p>
</form>

</div>
<style>
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
