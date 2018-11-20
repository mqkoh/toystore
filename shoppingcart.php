<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Shopping Cart</title>
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
		<button class="lower-button" id="register" onclick="window.location.href='custRegister.php';">New to our website? Register as our new member here!</button>
		<button class="lower-button" id="login" onclick="window.location.href='custLogin.php';">Already a member? Login here!</button>
		<button class="lower-button" id="login-admin" onclick="window.location.href='adminLogin.php';">Login as admin</button>
	</div>	
</div>
<?php 	
if(!empty($_GET["action"])) {
switch($_GET["action"]) {
	case "add":
		if(!empty($_POST["quantity"])) {
			$productByCode = $db_handle->runQuery("SELECT * FROM product WHERE prodCode='" . $_GET["prodCode"] . "'");
			$itemArray = array($productByCode[0]["prodCode"]=>array('name'=>$productByCode[0]["prodName"], 'code'=>$productByCode[0]["prodCode"], 'quantity'=>$_POST["quantity"], 'price'=>$productByCode[0]["prodPrice"]));
			
			if(!empty($_SESSION["cart_item"])) {
				if(in_array($productByCode[0]["prodCode"],$_SESSION["cart_item"])) {
					foreach($_SESSION["cart_item"] as $k => $v) {
							if($productByCode[0]["prodCode"] == $k)
								$_SESSION["cart_item"][$k]["quantity"] = $_POST["quantity"];
					}
				} else {
					$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
				}
			} else {
				$_SESSION["cart_item"] = $itemArray;
			}
		}
	break;
	case "remove":
		if(!empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $k => $v) {
					if($_GET["prodCode"] == $k)
						unset($_SESSION["cart_item"][$k]);				
					if(empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
			}
		}
	break;
	case "empty":
		unset($_SESSION["cart_item"]);
	break;
	case "checkout":
		unset($_SESSION["cart_item"]);
	break;	
}
}
?>
<div id="shopping-cart">
<div class="txt-heading">Shopping Cart <a id="btnEmpty" href="shoppingcart.php?action=empty">Empty Cart</a></div>
<?php
if(isset($_SESSION["cart_item"])){
    $item_total = 0;
?>	
<table>
	<tbody>
		<tr>
			<th><strong>Name</strong></th>
			<th><strong>Code</strong></th>
			<th><strong>Quantity</strong></th>
			<th><strong>Unit Price <br> (RM)</strong></th>
			<th><strong>Action</strong></th>
		</tr>
		<?php 
		foreach ($_SESSION["cart_item"] as $item){
		?>
		<tr>
			<td><?php echo $item["name"];?></td>
			<td><?php echo $item["code"];?></td>
			<td><?php echo $item["quantity"];?></td>
			<td><?php echo $item["price"];?></td>
			<td><a href="shoppingcart.php?action=remove&prodCode=<?php echo $item["code"];?>" class="btnRemoveAction">Remove Item</a></td>
		</tr>
		<?php 
		$item_total+=($item["price"]*$item["quantity"]);
		}
		?>
		<tr>
		<td colspan=5 align=right><strong>Total: </strong><?php echo "RM". $item_total; ?></td> 
		</tr>
	</tbody>
</table>
<?php
}
?>
<button class="continue" onclick="javascript:history.go(-1)">Continue Shopping</button>
<button class="check-out" onclick="checkout()">Finished shopping? Check out your items!</button>
</div>
	<div id = "footer">
		<a href="index.html">Home</a>&emsp;
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
</body>
</html>