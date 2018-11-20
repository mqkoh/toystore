<?php
// This script retrieves all the records from the admin table.

$page_title = 'View Current Products';

// Page header:
echo "<h1 style='text-align:center;'>Registered Products</h1>";

require ('mysqli_connect.php'); // Connect to the db.

// Make the query:
$q = "SELECT prodID,prodCode,prodName,prodCategory,prodPrice,prodDesc FROM product ORDER BY prodID ASC";
$r = @mysqli_query ($dbc, $q); // Run the query.

// Count the number of returned rows:
$num = mysqli_num_rows($r);

if ($num > 0) { // If it ran OK, display the records.

	// Print how many users there are:
	echo "<p style='text-align:center;'>There are currently <b> $num </b> registered products.</p>\n";

	// Table header.
	$bg = '#6495ED';
	echo '<table align="center" cellspacing="3" cellpadding="3" width="75%">
	<tr bgcolor="'.$bg.'">
			<td align="left"><b>ID</b></td>
			<td align="left"><b>Code</b></td>
			<td align="left"><b>Name</b></td>
			<td align="left"><b>Category</b></td>
			<td align="left"><b>Price</b></td>
			<td align="left"><b>Descriptions</b></td>
	</tr>
';

	// Fetch and print all the records:
	$bg = '#eeeeee';
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee');
		echo '<tr bgcolor="' . $bg . '">
				<td align="left">' . $row['prodID'] . '</td>
				<td align="left">' . $row['prodCode'] . '</td>
				<td align="left">' . $row['prodName'] . '</td>
				<td align="left">' . $row['prodCategory'] . '</td>
				<td align="left">' . $row['prodPrice'] . '</td>
				<td align="left">' . $row['prodDesc'] . '</td>
			</tr>
		';
	}

	echo '</table>'; // Close the table.

	mysqli_free_result ($r); // Free up the resources.

} else { // If no records were returned.

	echo '<p class="error">There are currently no registered products.</p>';

}

mysqli_close($dbc); // Close the database connection.

?>