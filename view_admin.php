<?php
// This script retrieves all the records from the admin table.

$page_title = 'View the Current Admins';

// Page header:
echo "<h1 style='text-align:center;'>Registered Admins</h1>";

require ('mysqli_connect.php'); // Connect to the db.

// Make the query:
$q = "SELECT adminName, adminGender, adminEmail, adminPhone, adminAdd, DATE_FORMAT(registration_date, '%M %d, %Y') AS dr FROM admin ORDER BY registration_date ASC";
$r = @mysqli_query ($dbc, $q); // Run the query.

// Count the number of returned rows:
$num = mysqli_num_rows($r);

if ($num > 0) { // If it ran OK, display the records.

	// Print how many users there are:
	echo "<p style='text-align:center;'>There are currently <b> $num </b> registered admins.</p>\n";

	// Table header.
	$bg = '#6495ED';
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
				<td align="left">' . $row['adminName'] . '</td>
				<td align="left">' . $row['adminGender'] . '</td>
				<td align="left">' . $row['adminEmail'] . '</td>
				<td align="left">' . $row['adminPhone'] . '</td>
				<td align="left">' . $row['adminAdd'] . '</td>
				<td align="left">' . $row['dr'] . '</td>
			</tr>
		';
	}

	echo '</table>'; // Close the table.

	mysqli_free_result ($r); // Free up the resources.

} else { // If no records were returned.

	echo '<p class="error">There are currently no registered admins.</p>';

}

mysqli_close($dbc); // Close the database connection.

?>