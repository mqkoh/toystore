<?php
require 'mysqli_connect.php';
/*mysql_connect("localhost","root","");
mysql_select_db("toystore");*/
	
if (!$_POST) {
	//haven't seen the form, so show it
	$display_block = <<<END_OF_TEXT
	<form method="post" enctype="multipart/form-data" action="$_SERVER[PHP_SELF]">
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
	<input type="file" name="image">
	</fieldset>
	<br/>
			
	<button type="submit" name="submit" value="send">Add Entry</button>
	
	</form>
END_OF_TEXT;
} else if ($_POST) {
	/*redundant with required=required"
	//time to add to tables, so check for required fields
	if (($_POST['prodCode'] == "") || ($_POST['prodName'] == "")) {
		header("Location: addProduct.php");
		exit;
	}*/
	$errors = array();
	
	if (empty($_POST['prodPrice'])){
	 	$errors[] = 'You forgot to enter your the price.';
	 } else {
		$prodPrice_pattern = "/^\d+(\.\d{2})?$/";

		if (preg_match ($prodPrice_pattern, $_POST['prodPrice'])){
			$safe_price = mysqli_real_escape_string($dbc, $_POST['prodPrice']); // capture the string
		} else{
			$errors[]= "Wrong price format!";
		}
	}

	if (empty($_POST['prodImage'])) {
		$errors[] = 'You forgot to enter the product image.';
	} else {
		$imagename = mysqli_real_escape_string($dbc, $_FILES["image"]["name"]);
		$imagedata = mysqli_real_escape_string($dbc, file_get_contents($_FILES["image"]["tmp_name"]));
		$imagetype = mysqli_real_escape_string($dbc, $_FILES["image"]["type"]);
	
	    /*if(substr($imagetype,0,5)=="image"){
			mysqli_query("INSERT INTO pro values('','$imagename','$imagedata')");
			echo "Image uploaded";
		} else {
			echo "Only image are allowed";
		}*/
	}
	
	/*connect to database
	doDB();
	*/
	//create clean versions of input strings
	$safe_code = mysqli_real_escape_string($dbc, $_POST['prodCode']);
	$safe_name = mysqli_real_escape_string($dbc, $_POST['prodName']);
	$safe_category = mysqli_real_escape_string($dbc, $_POST['prodCategory']);
	//$safe_price = mysqli_real_escape_string($dbc, $_POST['prodPrice']);
	$safe_desc = mysqli_real_escape_string($dbc, $_POST['prodDesc']);
	$safe_image = mysqli_real_escape_string($dbc,$_POST['image']);
	
	//add to product table
	$add_product_sql = "INSERT INTO product (prodCode, prodName, prodCategory, prodPrice, prodDesc, prodImage)
						VALUES ('".$safe_code."', '".$safe_name."', '".$safe_category."', '".$safe_price."', '".$safe_desc."', '".$imagedata."')";
	$add_product_res = mysqli_query($dbc, $add_product_sql) or die(mysqli_error($dbc));
	
	/*get master_id for use with other tables
	$master_id = mysqli_insert_id($dbc);
	
	
	if($_POST['submit']){
		$imagename = mysqli_real_escape_string($_FILES["image"]["name"]);
		$imagedata = mysqli_real_escape_string(file_get_contents($_FILES["image"]["tmp_name"]));
		$imagetype = mysqli_real_escape_string($_FILES["image"]["type"]);
	
	    if(substr($imagetype,0,5)=="image"){
			mysql_query("INSERT INTO pro values('','$imagename','$imagedata')");
			echo "Image uploaded";
		} else {
			echo "Only image are allowed";
		}
	}
	*/
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