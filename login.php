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
    <title>LOGIN</title>
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
   <input type="text" name="username">
<br><br>
   <p>password</p>
   <input type="password" name="password">
<br><br>
  <input name="login" type="submit" value="LOGIN" />
</form>
<h2>
  <p>Don't have an account?<a href="http://localhost/php-opdrachten/website/register.php">REGISTER HERE</a></p> 
</h2>
<?php

if(!isset($_POST['username'], $_POST['password'])){
   exit('Enter username and password');
}

if($stmt = $con->prepare('SELECT id, password FROM Users WHERE username = ?')){
   $stmt->bind_param('s', $_POST['username']);
   $stmt->execute();

$stmt->stire_result();
$stmt->close();

$stmt->store_result();

if($stmt->num_rows>0){
   $stmt->bind_result($id, $password);
   $stmt->fetch();

   if(password_verify($_POST['password'], $password)){
      session_regenerate_id();
      $_SESSION['loggedin'] = TRUE;
      $_SESSION['name'] = $_POST['username'];
      $_SESSION['id'] = $id;
      header('Location: website.php');
   }else{
      echo 'Incorrect username and/or password';
   }
}else{
   echo 'Incorrect username and/or password';
}
if (password_verify($_POST['password'], $password)){
   if($_POST['password'] === $password){

   }
}
}

?>
</body>
</html>