<p?php
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
  <input id="username" name="username" required="" type="text" />
  <br>
  <br>
  <label for="email">Email:</label>
  <input id="email" name="email" required="" type="email" />
  <br>
  <br>
  <label for="password">Password:</label>
  <input id="password" name="password" required="" type="password" />
  <br>
  <br>
  <input name="register" type="submit" value="Register" />
</form>
<h2>
  <p>Do you have an account already?<a href="http://localhost/php-opdrachten/website/login.php">LOGIN HERE</a></p> 
</h2>

<?php

?>
</body>
</html>