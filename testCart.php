<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_GET["action"])) {
switch($_GET["action"]) {
	case "add":
		if(!empty($_POST["quantity"])) {
			$productByCode = $db_handle->runQuery("SELECT * FROM product WHERE code='" . $_GET["code"] . "'");
			$itemArray = array($productByCode[0]["code"]=>array('name'=>$productByCode[0]["name"], 'code'=>$productByCode[0]["code"], 'quantity'=>$_POST["quantity"], 'price'=>$productByCode[0]["price"]));
			
			if(!empty($_SESSION["cart_item"])) {
				if(in_array($productByCode[0]["code"],$_SESSION["cart_item"])) {
					foreach($_SESSION["cart_item"] as $k => $v) {
							if($productByCode[0]["code"] == $k)
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
<div class="txt-heading">Shopping Cart <a id="btnEmpty" href="index.php?action=empty">Empty Cart</a></div>
<?php
if(isset($_SESSION["cart_item"])){
    $item_total = 0;
?>	
<table>
	<tbody>
		<tr>
			<th>Name</th>
			<th>Code</th>
			<th>Quantity</th>
			<th>Unit Price (RM)</th>
			<th>Action</th>
		</tr>
		<?php 
		foreach ($_SESSION["cart_item"] as $item) {
		?>
		<tr>
			<td><?php echo $item["name"];?></td>
			<td><?php echo $item["code"];?></td>
			<td><?php echo $item["quantity"];?></td>
			<td><?php echo $item["price"];?></td>
			<td><a href="index.php?action=remove&code=<?php echo $item["code"];?>" class="btnRemoveAction">Remove Item</a></td>
		</tr>
		<?php 
		$item_total += ($item["price"] * $item["quantity"]);
		}
		?>
		<tr>
			<td colspan=5 align=right><strong>Total: </strong><?php echo "RM " . $item_total;?></td>
		</tr>
	</tbody>
</table>
<?php
}
?>
</div>
</body>
</html>