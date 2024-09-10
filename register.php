<?php
session_start();
require('conn database.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles.css" rel="stylesheet">
    <title>REGISTER</title>
</head>
<f>
<method="POST" action="http://localhost/php-opdrachten/website/register.php"></method>
<header>
   <a href="http://localhost/php-opdrachten/website/website.php">HOME</a>
</header>
<br>
<br>
<h1>REGISTER</h1>
<form action="register.php" method="post">
  <label for="username">Username:</label> 
  <input id="username" name="username" type="text" />
  <br>
  <br>
  <label for="email">Email:</label>
  <input id="email" name="email" type="email" />
  <br>
  <br>
  <label for="password">Password:</label>
  <input id="password" name="password" type="password" />
  <br>
  <br>
  <input name="register" type="submit" value="Register" />
</form>
<h2>
  <p>Do you have an account already?<a href="http://localhost/php-opdrachten/website/login.php">LOGIN HERE</a></p> 
</h2>

<?php

 if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
 	exit('Please complete the registration form!');
 }

 if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
 	exit('Please complete the registration form');
 }

 if ($stmt = $conn->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
 	$stmt->bind_param('s', $_POST['username']);
 	$stmt->execute();
 	$stmt->store_result();
 	if ($stmt->num_rows > 0) {
 		echo 'Username exists, please choose another!';
 	} else {
     if ($stmt = $conn->prepare('INSERT INTO accounts (username, password, email) VALUES (?, ?, ?)')) {
       $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
       $stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);
       $stmt->execute();
       echo 'You have successfully registered! You can now login!';
     } else {
       echo 'Could not prepare statement!';
     }
 	}
 	$stmt->close();
 } else {
 	echo 'Could not prepare statement!';
 }
  $conn->close();

 if ($stmt = $conn->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
   if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
     exit('Email is not valid!');
   }
   if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) == 0) {
     exit('Username is not valid!');
 }
 if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
 	exit('Password must be between 5 and 20 characters long!');
}
}

?>
</body>
</html>