<?php
//session_start();
//require_once("dbcontroller.php");
//$db_handle = new DBController();
//$connection = $db_handle->connectDB();
require ('mysqli_connect.php');
$stmt = $dbc->prepare("SELECT prodImage FROM product WHERE prodID=?"); 
$stmt->bind_param("i", $id);
//$id = $product_array[$key]["prodID"];
$id = 34;					
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($image);
$stmt->fetch();
header("Content-Type: image/jpeg");
echo $image;
?>