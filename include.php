<?php
function doDB(){
	global $mysqli;
	
	//connect to server and select database; you may need it
	$mysqli = mysqli_connect("localhost", "root", "", "toystore");
	
	//if connection fails, stop script execution 
	if(mysqli_connect_errno()){
		printf("Connect failed: %s\n", mysqli_connect_errno());
		exit();
	}
}
?>
