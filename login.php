<?php
session_start();
require ('conn database.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles.css" rel="stylesheet">
    <title>invulformulier</title>
</head>
<f>
<method="POST" action="http://localhost/php-opdrachten/website/login.php"></method>
<header>
   <a href="http://localhost/php-opdrachten/website/website.php">HOME</a>
</header>
<br>
<br>
<h1>LOGIN</h1>
<form>
   <p>username</p>
   <input type="text" name="login">
<br><br>
   <p>password</p>
   <input type="password" name="pw">
<br><br>
<input name="LOGIN" type="submit" value="Login" />
</form>
<h2>
  <p>Don't have an account?<a href="http://localhost/php-opdrachten/website/register.php">REGISTER HERE</a></p> 
</h2>
<?php
$servername = "fullstack";
$username = "root";
$password = "password";
$dbname = "MyDB";

$conn = new mysqli($servername, $username, $password, $dbname);


?>
</body>
</html>