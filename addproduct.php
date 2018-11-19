<?php
require 'mysqli_connect.php';
/*mysql_connect("localhost","root","");
mysql_select_db("toystore");*/
	
if (!$_POST) {
	//haven't seen the form, so show it
	$display_block = <<<END_OF_TEXT
	<form method="post" action="$_SERVER[PHP_SELF]">
	<fieldset>
	<legend>Product Code:</legend>
	<input type="text" name="prodCode" size="20" maxlength="40" required="required" /><br/>
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
	
	<fieldset>	
	<form action="blob.php" method="POST" enctype="multipart/form-data">			
	<input type="file" name="image"><input type="submit" name="submit" value="Upload">
	</fieldset>
	<br/>
			
	<button type="submit" name="submit" value="send">Add Entry</button>
	</form>
END_OF_TEXT;
} else if ($_POST) {
	//time to add to tables, so check for required fields
	if (($_POST['prodCode'] == "") || ($_POST['prodName'] == "")) {
		header("Location: addProduct.php");
		exit;
	}
	/*connect to database
	doDB();
	*/
	//create clean versions of input strings
	$safe_code = mysqli_real_escape_string($dbc, $_POST['prodCode']);
	$safe_name = mysqli_real_escape_string($dbc, $_POST['prodName']);
	$safe_category = mysqli_real_escape_string($dbc, $_POST['prodCategory']);
	$safe_price = mysqli_real_escape_string($dbc, $_POST['prodPrice']);
	$safe_desc = mysqli_real_escape_string($dbc, $_POST['prodDesc']);
	$safe_image = mysqli_real_escape_string($dbc,$_POST['image']);
	
	//add to product table
	$add_code_sql = "INSERT INTO product (prodCode)
						VALUES ('".$safe_code."')";
	$add_code_res = mysqli_query($dbc, $add_code_sql) or die(mysqli_error($dbc));
	
	$add_name_sql = "INSERT INTO product (prodName)
                       VALUES ('".$safe_name."')";
	$add_name_res = mysqli_query($dbc, $add_name_sql) or die(mysqli_error($dbc));
	/*get master_id for use with other tables
	$master_id = mysqli_insert_id($dbc);
	*/
	if ($_POST['prodCategory']) {
		$add_category_sql = "INSERT INTO product(prodCategory) VALUES ('".$safe_category."')";
		$add_category_res = mysqli_query($dbc, $add_category_sql) or die(mysqli_error($dbc));
	}
	if ($_POST['prodPrice']) {
		$add_price_sql = "INSERT INTO product(prodPrice) VALUES ('".$safe_price."')";
		$add_price_res = mysqli_query($dbc, $add_price_sql) or die(mysqli_error($dbc));
	}
	
	if ($_POST['prodDesc']) {
		$add_desc_sql = "INSERT INTO product(prodDesc) VALUES ('".$safe_desc."')";
		$add_desc_res = mysqli_query($dbc, $add_desc_sql) or die(mysqli_error($dbc));
	}
	if($_POST['submit']){
	$imagename = mysqli_real_escape_string($_FILES["image"]["name"]);
	$imagedata=mysql_real_escape_string(file_get_contents($_FILES["image"]["tmp_name"]));
	$imagetype=mysql_real_escape_string($_FILES["image"]["type"]);
	
	if(substr($imagetype,0,5)=="image")
	{

	
	$imagename=mysql_real_escape_string($_FILES["image"]["name"]);
	$imagedata=mysql_real_escape_string(file_get_contents($_FILES["image"]["tmp_name"]));
	$imagetype=mysql_real_escape_string($_FILES["image"]["type"]);
	
	if(substr($imagetype,0,5)=="image")
	{
		mysql_query("INSERT INTO pro values('','$imagename','$imagedata')");
		echo "Image uploaded";
	}
	else {
		echo "Only image are allowed";
	}
}
		
	}
	mysqli_close($dbc);
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