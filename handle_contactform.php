<?php

$name = $_POST['name'];
$email = $_POST['email'];
$comment = $_POST['comment'];

echo '<h1>Thank you for your feedback!</h1><h2>We will send you a reply as soon as possible.</h2>';
echo 'Name: ' . $name;
echo '<br>Email: ' . $email;
echo '<br>Comment: ' . $comment;
echo '<br><br><a href="index.html">Return to home page.</a>';
		
?>

<link href="https://fonts.googleapis.com/css?family=Cuprum|Exo|Indie+Flower|Nunito" rel="stylesheet">
<style>
body {
	background-image: linear-gradient(#CB8BEC, #E1C2F1);
	background-size: 100%;
	color: white;
	font-family: 'Nunito', sans-serif;
	margin: 20pt;
	}
</style>