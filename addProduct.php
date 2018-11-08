<?php
include 'include.php';

if (!$_POST) {
	//haven't seen the form, so show it
	$display_block = <<<END_OF_TEXT
	<form method="post" action="$_SERVER[PHP_SELF]">

	<fieldset>
	<legend>Product ID:</legend>
	<input type="text" name="prodID" size="20" maxlength="40" /><br/>
	</fieldset>		
	<br/>
			
	<fieldset>
	<legend>Product Name:</legend>
	<input type="text" name="prodName" size="30" maxlength="75" required="required" /><br/>
	</fieldset>
	<br/>
	
	<fieldset>
	<legend>Product Category:</legend>
		<select name="prodCategory" size="1">
			<option value="Funko Pop">Funko Pop</option>
			<option value="Lego">Lego</option>
			<option value="Plushies">Plushies</option>
		</select>
	</fieldset>
	<br/>		
			
	<fieldset>
	<legend>Product Price:</legend>
	<input type="text" name="prodPrice" size="30" maxlength="75" required="required" />
	</fieldset>
	<br/>
			
	<fieldset>				
	<legend>Product Description:</legend>
	<textarea id="prodDesc" name="prodDesc" cols="35" rows="5"></textarea>
	</fieldset>
	<br/>	
			
	<button type="submit" name="submit" value="send">Add Entry</button>
	</form>
END_OF_TEXT;

} else if ($_POST) {
	//time to add to tables, so check for required fields
	if (($_POST['prodID'] == "") || ($_POST['prodName'] == "")) {
		header("Location: addProduct.php");
		exit;
	}

	//connect to database
	doDB();

	//create clean versions of input strings
	$safe_id = mysqli_real_escape_string($mysqli, $_POST['prodID']);
	$safe_name = mysqli_real_escape_string($mysqli, $_POST['prodName']);
	$safe_category = mysqli_real_escape_string($mysqli, $_POST['prodCategory']);
	$safe_price = mysqli_real_escape_string($mysqli, $_POST['prodPrice']);
	$safe_desc = mysqli_real_escape_string($mysqli, $_POST['prodDesc']);
	
	//add to product table
	$add_name_sql = "INSERT INTO product (prodName)
                       VALUES ('".$safe_name."')";
	$add_name_res = mysqli_query($mysqli, $add_name_sql) or die(mysqli_error($mysqli));

	/*get master_id for use with other tables
	$master_id = mysqli_insert_id($mysqli);
	*/

	if ($_POST['prodCategory']) {
		$add_category_sql = "INSERT INTO product(category)  VALUES ('".$safe_category."')";
		$add_category_res = mysqli_query($mysqli, $add_category_sql) or die(mysqli_error($mysqli));
	}

	if ($_POST['prodPrice']) {
		$add_price_sql = "INSERT INTO product(price) VALUES ('".$safe_price."')";
		$add_price_res = mysqli_query($mysqli, $add_price_sql) or die(mysqli_error($mysqli));
	}
	
	if ($_POST['prodDesc']) {
		$add_desc_sql = "INSERT INTO product(desc) VALUES ('".$safe_desc."')";
		$add_desc_res = mysqli_query($mysqli, $add_desc_sql) or die(mysqli_error($mysqli));
	}
	
	mysqli_close($mysqli);
	$display_block = "<p>Your entry has been added.  Would you like to <a href=\"addentry.php\">add another</a>?</p>";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Add an Entry</title>
</head>
<body>
<h1>Add an Entry</h1>
<?php echo $display_block; ?>
</body>
</html>