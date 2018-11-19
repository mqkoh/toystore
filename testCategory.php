<?php 
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
$connection = $db_handle->connectDB();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Dream Realm - Pop</title>
	<link rel="icon" href="images/favicon.png">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="script.js" type="text/javascript"></script>
	<link href="https://fonts.googleapis.com/css?family=Cuprum|Exo|Indie+Flower|Nunito" rel="stylesheet">	
</head>
<body>

<div class="top">
	<a href="index.html"><img class="logo" src="images/logo_transparent.png" alt="Dream Realm"></a>
	<div class="topnav">
		<button class="topnav-button" id="register" onclick="window.location.href='custRegister.php';">New to our website? Register as our new member here!</button>
		<button class="topnav-button" id="login" onclick="#">Already a member? Login here!</button>
	</div>	
</div>

<div id="product-grid">
	<div class="txt-heading">Products</div>
	<?php
	$product_array = $db_handle->runQuery("SELECT * FROM product WHERE prodCategory = 'Funko Pop' ORDER BY prodID ASC");
	$stmt = $connection->prepare("SELECT prodImage FROM product WHERE prodID=?"); 
	$stmt->bind_param("i", $id);
	
	if (!empty($product_array)) { 
		foreach($product_array as $key=>$value){
	?>
		<div class="product-item">
			<form method="post" action="testCart.php?action=add&code=<?php echo $product_array[$key]["prodCode"]; ?>">
			<div class="product-image"><img class="product-image-size" 
				src="<?php 
					$id = $product_array[$key]["prodID"];					
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($image);
					$stmt->fetch();
					header("Content-Type: image/jpeg");
					echo $image;
					//echo $product_array[$key]["prodImage"]; 
				?>"></div>
			<div><strong><?php echo $product_array[$key]["name"]; ?></strong></div>
			<div class="product-price"><?php echo "RM ".$product_array[$key]["prodPrice"]; ?></div>
			<div><input type="text" name="quantity" value="1" size="2" /><input type="submit" value="Add to cart" class="btnAddAction" /></div>
			</form>
		</div>
	<?php
			}
	}
	?>
</div>

<script src="script.js" type="text/javascript"></script>
</body>
</html>