<?php
// This script retrieves all the records from the admin table.

$page_title = 'View the Current Admins';

// Page header:
echo '<h1>Registered Admins</h1>';

require ('mysqli_connect.php'); // Connect to the db.

// Make the query:
$q = "SELECT adminName, adminGender, adminEmail, adminPhone, adminAdd, DATE_FORMAT(registration_date, '%M %d, %Y') AS dr FROM admin ORDER BY registration_date ASC";
$r = @mysqli_query ($dbc, $q); // Run the query.

// Count the number of returned rows:
$num = mysqli_num_rows($r);

if ($num > 0) { // If it ran OK, display the records.

	// Print how many users there are:
	echo "<p>There are currently $num registered admins.</p>\n";

	// Table header.
	echo '<table align="center" cellspacing="3" cellpadding="3" width="75%">
	<tr><td align="left"><b>Name</b></td><td align="left"><b>Gender</b></td><td align="left"><b>Email</b></td><td align="left"><b>Phone</b></td><td align="left"><b>Address</b></td><td align="left"><b>Date Registered</b></td></tr>
';

	// Fetch and print all the records:
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		echo '<tr><td align="left">' . $row['adminName'] . '<tr><td align="left">' . $row['adminGender'] . '<tr><td align="left">' . $row['adminEmail'] . '<tr><td align="left">' . $row['adminPhone'] . '<tr><td align="left">' . $row['adminAdd'] . '</td><td align="left">' . $row['dr'] . '</td></tr>
		';
	}

	echo '</table>'; // Close the table.

	mysqli_free_result ($r); // Free up the resources.

} else { // If no records were returned.

	echo '<p class="error">There are currently no registered admins.</p>';

}

mysqli_close($dbc); // Close the database connection.

?>