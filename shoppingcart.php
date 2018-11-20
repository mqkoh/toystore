<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Dream Realm - Funko Pop</title>
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
					if($_GET["code"] == $k)
						unset($_SESSION["cart_item"][$k]);				
					if(empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
			}
		}
	break;
	case "empty":
		unset($_SESSION["cart_item"]);
	break;	
}
}
?>
<html>
<head>
<title>Simple PHP Shopping Cart</title>
<link href="style.css" type="text/css" rel="stylesheet" />
</head>
<body>
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
</div>
</body>
</html>