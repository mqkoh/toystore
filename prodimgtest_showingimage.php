<?php
mysql_connect("localhost","root","");
mysql_select_db("db4");


if(isset($_GET[id])){
	

$id=mysql_real_escape_string($_GET['id']);
$query=mysql_query("select * from pro where 'id'='$id'");
while($row=mysql_fetch_assoc($query))
{
	$imagedata=$row['image'];
	
}
header("content-type:image/jpg");
echo $imagedata;

}
else {
	echo "error!";
}
?>