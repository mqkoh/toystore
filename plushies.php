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
	<title>Dream Realm - Plushies</title>
	<link rel="icon" href="images/favicon.png">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="script.js" type="text/javascript"></script>
	<link href="https://fonts.googleapis.com/css?family=Cuprum|Exo|Indie+Flower|Nunito" rel="stylesheet">	
</head>
<body>

<div class="top">
	<a href="index.html"><img class="logo" src="images/logo_transparent.png" alt="Dream Realm"></a>
	<div class="topnav">
		<button class="topnav-button" id="home" onclick="window.location.href='index.html';">Home</button>
		<button class="topnav-button" id="categories" onclick="window.location.href='plushies.php';">Plushies</button>
		<button class="topnav-button" id="categories" onclick="window.location.href='lego.php';">Lego</button>
		<button class="topnav-button" id="categories" onclick="window.location.href='pop.php';">Pop</button>
		<button class="topnav-button" id="register" onclick="window.location.href='custRegister.php';">New to our website? Register as our new member here!</button>
		<button class="topnav-button" id="login" onclick="window.location.href='custLogin.php';">Already a member? Login here!</button>
		<button class="topnav-button" id="login-admin" onclick="window.location.href='adminLogin.php';">Login as admin</button>
	</div>
</div>	
<div id="product-grid">
	<div class="txt-heading">Dream Realm - Plushies</div>
	<?php
	$product_array = $db_handle->runQuery("SELECT * FROM product WHERE prodCategory = 'Plushies' ORDER BY prodID ASC");
	
	if (!empty($product_array)) { 
		foreach($product_array as $key=>$value){
	?>
		<div class="product-item">
			<form method="post" action="testCart.php?action=add&code=<?php echo $product_array[$key]["prodCode"]; ?>">
			<div class="product-image">
				<?php  
					$sql = "SELECT prodImage FROM product WHERE prodID = '".$product_array[$key]['prodID']."'";
					$sth = mysqli_query($connection, $sql);
					$result=mysqli_fetch_array($sth);
					echo '<img class="product-image-size" src="data:image/jpeg;base64,'.base64_encode( $result['prodImage'] ).'"/>';
				?></div>
			<div><strong><?php echo $product_array[$key]["prodName"]; ?></strong></div>
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