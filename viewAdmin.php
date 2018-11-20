<?php 
// This script retrieves all the records from the users table.

$page_title = 'View the Current Admin';

echo "<h1 style='text-align:center;'>Registered Admins</h1>";

//Connect to database
require ('mysqli_connect.php');

// Number of records to show per page:
$display = 10;

// Determine how many pages there are...
if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.
	$pages = $_GET['p'];
} else { // Need to determine.
 	// Count the number of records:
	$q = "SELECT COUNT(adminID) FROM admin";
	$r = @mysqli_query ($dbc, $q);
	$row = @mysqli_fetch_array ($r, MYSQLI_NUM);
	$records = $row[0];
	// Calculate the number of pages...
	if ($records > $display) { // More than 1 page.
		$pages = ceil ($records/$display);
	} else {
		$pages = 1;
	}
} // End of p IF.

// Determine where in the database to start returning results...
if (isset($_GET['s']) && is_numeric($_GET['s'])) {
	$start = $_GET['s'];
} else {
	$start = 0;
}

// Determine the sort...
// Default is by registration date.
$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'rd';

// Determine the sorting order:
	switch($sort){
		case 'id':
			$order_by = 'adminID ASC';
			break;
		case 'an':
			$order_by = 'adminName ASC';
			break;
		case 'rd':
			$order_by = 'registration_date ASC';
			break;
		default:
			$order_by = 'registration_data ASC';
			$sort = 'rd';
	}

// Define the query:
$q = "	SELECT adminID,adminName,adminPW,adminGender,adminEmail,adminPhone,adminAdd,DATE_FORMAT(registration_date, '%M %d, %Y') AS dr
		FROM admin 
		ORDER BY $order_by LIMIT $start, $display";		
$r = @mysqli_query ($dbc, $q); // Run the query.

// Table header:
$bg = '#6495ED';
echo '<table align="center" cellspacing="3" cellpadding="3" width="75%">
<tr bgcolor="'.$bg.'">
	<td align="left"><b><a href="viewAdmin.php?sort=id">Admin ID</a></b></td>
	<td align="left"><b><a href="viewAdmin.php?sort=an">Admin Name</a></b></td>
	<td align="left"><b>Gender</b></td>
	<td align="left"><b>Email</b></td>
	<td align="left"><b>Phone</b></td>
	<td align="left"><b>Address</b></td>
	<td align="left"><b><a href="viewAdmin.php?sort=rd">Date Registered</a></b></td>
	<td align="left"><b>Edit</b></td>
	<td align="left"><b>Delete</b></td>
</tr>
';

// Fetch and print all the records....
$bg = '#eeeeee'; 
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee');
		echo '<tr bgcolor="' . $bg . '">
		<td align="left">'.$row['adminID'].'</td>
		<td align="left">'.$row['adminName'].'</td>
		<td align="left">'.$row['adminGender'].'</td>
		<td align="left">'.$row['adminEmail'].'</td>
		<td align="left">'.$row['adminPhone'].'</td>
		<td align="left">'.$row['adminAdd'].'</td>
		<td align="left">'.$row['dr'].'</td>
		<td align="left"><a href="edit_admin.php?id='.$row['adminID'].'">Edit</a></td>
		<td align="left"><a href="delete_admin.php?id='.$row['adminID'].'">Delete</a></td>
	</tr>
	';
} // End of WHILE loop.

echo '</table>';
mysqli_free_result ($r);
mysqli_close($dbc);

// Make the links to other pages, if necessary.
if ($pages > 1) {
	
	echo '<br /><p>';
	$current_page = ($start/$display) + 1;
	
	// If it's not the first page, make a Previous button:
	if ($current_page != 1) {
		echo '<a href="viewAdmin.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '">Previous</a> ';
	}
	
	// Make all the numbered pages:
	for ($i = 1; $i <= $pages; $i++) {
		if ($i != $current_page) {
			echo '<a href="viewAdmin.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
		} else {
			echo $i . ' ';
		}
	} // End of FOR loop.
	
	// If it's not the last page, make a Next button:
	if ($current_page != $pages) {
		echo '<a href="viewAdmin.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">Next</a>';
	}
	
	echo '</p>'; // Close the paragraph.
	
} // End of links section.
	
?>