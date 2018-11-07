<?php
function doDB(){
	global $mysqli;
	
	//connect to server and select database; you may need it
	$mysqli = mysqli_connect("localhost", "root", "", "toystore");
	
	//if connection fails, stop script execution 
	if(mysqli_connect_errno()){
		printf("Could not connect to MYSQL: %s\n", mysqli_connect_errno());
		exit();
	}
}

/*

// Set the database access information as constants:
DEFINE('DB_HOST','localhost');
DEFINE('DB_USER','root');
DEFINE('DB_PASSWORD','');
DEFINE('DB_NAME','toystore');

// Make the connection:
$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );

// Set the encoding...
mysqli_set_charset($dbc, 'utf8');
*/

?>

