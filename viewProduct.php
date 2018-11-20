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
// This script retrieves all the records from the users table.

$page_title = 'View Products';

echo "<h1 style='text-align:center;'>Product's Address Book</h1>";
echo "<p style='text-align:center;'><a href=\"addProduct.php\";>Add a New Product</a></p>";

//Connect to database
require ('mysqli_connect.php');

// Number of records to show per page:
$display = 10;

// Determine how many pages there are...
if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.
	$pages = $_GET['p'];
} else { // Need to determine.
 	// Count the number of records:
	$q = "SELECT COUNT(prodID) FROM product";
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
			$order_by = 'prodID ASC';
			break;
		case 'pc':
			$order_by = 'prodCode ASC';
			break;
		case 'pn':
			$order_by = 'prodName ASC';
			break;
		default:
			$order_by = 'prodCode ASC';
			$sort = 'pc';
	}

// Define the query:
$q = "	SELECT prodID,prodCode,prodName,prodCategory,prodPrice,prodDesc
		FROM product
		ORDER BY $order_by LIMIT $start, $display";
$r = @mysqli_query ($dbc, $q); // Run the query.

// Table header:
$bg = '#6495ED';
echo '<table align="center" cellspacing="3" cellpadding="3" width="75%">
<tr bgcolor="'.$bg.'">
	<td align="left"><b><a href="viewProduct.php?sort=id">ID</a></b></td>
	<td align="left"><b><a href="viewProduct.php?sort=pc">Code</a></b></td>
	<td align="left"><b><a href="viewProduct.php?sort=pn">Name</a></b></td>
	<td align="left"><b>Category</b></td>
	<td align="left"><b>Price (RM)</b></td>
	<td align="left"><b>Description</b></td>
	<td align="left"><b>Edit</b></td>
	<td align="left"><b>Delete</b></td>
</tr>
';

// Fetch and print all the records....
$bg = '#eeeeee';
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee');
		echo '<tr bgcolor="' . $bg . '">
		<td align="left">'.$row['prodID'].'</td>
		<td align="left">'.$row['prodCode'].'</td>
		<td align="left">'.$row['prodName'].'</td>
		<td align="left">'.$row['prodCategory'].'</td>
		<td align="left">'.$row['prodPrice'].'</td>
		<td align="left">'.$row['prodDesc'].'</td>
		<td align="left"><a href="edit_product.php?id='.$row['prodID'].'">Edit</a></td>
		<td align="left"><a href="delete_product.php?id='.$row['prodID'].'">Delete</a></td>
	</tr>
	';
} // End of WHILE loop.

echo '</table>';
mysqli_free_result ($r);
mysqli_close($dbc);

// Make the links to other pages, if necessary.
if ($pages > 1) {

	echo "<br /><p style='text-align:center;'>";
	$current_page = ($start/$display) + 1;

	// If it's not the first page, make a Previous button:
	if ($current_page != 1) {
		echo '<a href="viewProduct.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '">Previous</a> ';
	}

	// Make all the numbered pages:
	for ($i = 1; $i <= $pages; $i++) {
		if ($i != $current_page) {
			echo '<a href="viewProduct.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
		} else {
			echo $i . ' ';
		}
	} // End of FOR loop.

	// If it's not the last page, make a Next button:
	if ($current_page != $pages) {
		echo '<a href="viewProduct.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">Next</a>';
	}

	echo '</p>'; // Close the paragraph.

} // End of links section.

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
