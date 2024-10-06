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
<method="POST" action="register.php"></method>
<header>
<button onclick="window.location.href = 'website.php';">HOME</button>
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
  <p>Do you have an account already?<button onclick="window.location.href = 'login.php';">LOGIN</button></p> 
</h2>

<?php

 if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
 	exit();
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
?>
</body>
</html>