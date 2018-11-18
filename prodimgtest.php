<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>BLOB Data Type</title>
</head>
<body>
<form action="progimgtest.php" method="POST" enctype="multipart/form-data">
     <input type="file" name="image"><input type="submit" name="submit" value="Upload">
</form>
<?php

if(isset($_POST['submit']))
{
	mysql_connect("localhost","root","");
	mysql_select_db("db4");
	
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

?>

<img src="prodimgtest_showingimage.php?id=6">
</body>
</html>
