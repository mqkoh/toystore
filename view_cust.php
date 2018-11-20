<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Dream Realm</title>
	<link rel="icon" href="images/favicon.png">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Cuprum|Exo|Indie+Flower|Nunito" rel="stylesheet">	
</head>
<body>

<div class="top">
	<a href="index_admin.html"><img class="logo" src="images/logo_transparent.png" alt="Dream Realm"></a>
	<div class="topnav">
		<button class="lower-button" id="login-admin" onclick="window.location.href='adminLogout.php';">Log out</button>
	</div>	
</div>
</body>
</html>
<?php
// This script retrieves all the records from the customer table.

$page_title = 'View the Current Customers';

// Page header:
echo "<h1 style='text-align:center;'>Registered Customers</h1>";

require ('mysqli_connect.php'); // Connect to the db.
		
// Make the query:
$q = "SELECT custName, custGender, custEmail, custPhone, custAdd, DATE_FORMAT(registration_date, '%M, %d, %Y') AS dr 
	  FROM customer 
	  ORDER BY registration_date ASC";		
$r = @mysqli_query ($dbc, $q); // Run the query.

// Count the number of returned rows:
$num = mysqli_num_rows($r);

if ($num > 0) { // If it ran OK, display the records.

	// Print how many users there are:
	echo "<p style='text-align:center;'>There are currently<b> $num </b> registered customers.</p>\n";
$bg = '#6495ED';
	// Table header.
	echo '<table align="center" cellspacing="3" cellpadding="3" width="75%">
			<tr bgcolor="'.$bg.'">
				<td align="left"><b>Name</b></td>
				<td align="left"><b>Gender</b></td>
				<td align="left"><b>Email</b></td>
				<td align="left"><b>Phone</b></td>
				<td align="left"><b>Address</b></td>
				<td align="left"><b>Date Registered</b></td>
			</tr>
';
	
	// Fetch and print all the records:
	$bg = '#eeeeee';
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee');
		echo '<tr bgcolor="' . $bg . '">
					<td align="left">' . $row['custName'] . '</td>
					<td align="left">' . $row['custGender'] . '</td>
					<td align="left">' . $row['custEmail'] . '</td>
					<td align="left">' . $row['custPhone'] . '</td>
					<td align="left">' . $row['custAdd'] . '</td>
					<td align="left">' . $row['dr'] . '</td>
				</tr>
		';
	}

	echo '</table>'; // Close the table.
	
	mysqli_free_result ($r); // Free up the resources.	

} else { // If no records were returned.

	echo '<p class="error">There are currently no registered customers.</p>';

}

mysqli_close($dbc); // Close the database connection.

?>
<div>	
<footer id = "footer">
		<a href="index_admin.html">Home</a>
		<br>
		Copyright &copy; 2018 Dream Realm
		<br>
		<b>Disclaimer: </b> Materials such as images, audio, videos and product details on this website do not belong to <i> Dream Realm </i>
		<br>
		These materials are obtained from the internet for assignment purpose only.
</footer>
</div>

<script src="script.js" type="text/javascript"></script>