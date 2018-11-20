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
<div class="content">
<div class="top">
	<button class="iconbox" onclick="window.location.href='shoppingcart.php';">Shopping Cart<img class="icon" src="images/shoppingcart.png"></button>
	<a href="index.html"><img class="logo" src="images/logo_transparent.png" alt="Dream Realm"></a>
	<div class="topnav">
		<?php 
			if (isset($_SESSION["user"])&&$_SESSION["user"]=="customer") {
				echo "Hi, ".$_COOKIE['custName'];
				echo "&emsp;<a href=\"custLogout.php\";>Logout</a>";
			} else {
		?>
		<button class="lower-button" id="register" onclick="window.location.href='custRegister.php';">New to our website? Register as our new member here!</button>
		<button class="lower-button" id="login" onclick="window.location.href='custLogin.php';">Already a member? Login here!</button>
		<button class="lower-button" id="login-admin" onclick="window.location.href='adminLogin.php';">Login as admin</button>
		<?php }?>
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
			<form method="post" action="shoppingcart.php?action=add&prodCode=<?php echo $product_array[$key]["prodCode"]; ?>">
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
	<div id = "footer">
		<a href="index.php">Home</a>&emsp;
		<a href="plushies.php">Plushies</a>&emsp;
		<a href="lego.php">Lego</a>&emsp;
		<a href="pop.php">Funko Pop</a>&emsp;
		<br>
		Copyright &copy; 2018 Dream Realm
		<br>
		<b>Disclaimer: </b> Materials such as images, audio, videos and product details on this website do not belong to <i> Dream Realm </i>
		<br>
		These materials are obtained from the internet for assignment purpose only.
	</div>
</div>
<script src="script.js" type="text/javascript"></script>
</body>
</html>