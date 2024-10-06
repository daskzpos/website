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
</head>
<body>
<method="post" action="website.php"></method>
<header>    
    <button onclick="window.location.href = 'login.php';">LOGIN</button>    
</header>
<br> <br>
<h1>HOME</h1>
<?php

?>
</body>
</html>