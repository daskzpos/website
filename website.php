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
<body>
<method="post" action="http://localhost/php-opdrachten/website/website.php"></method>
<header>    
    <a href="http://localhost/php-opdrachten/website/createband.php">PROGAMMA<>
    <a href="http://localhost/php-opdrachten/website/register.php">REGISTER<>
    <a href="http://localhost/php-opdrachten/website/login.php">LOGIN<>
</header>
<body class="loggedin">
   <nav class="navtop"></nav>
   <div class="content">
      <p>Welcom back, <?=htmlspecialchars($_SESSION['name'], ENT_QUOTES)?>!</p>
   </div>
</body>
<br> <br>
<h1>PROGAMMA</h1>
<?php
if (!isset($_SESSION['loggedin'])){
    header('Location: login.php');
    exit;
}

?>
</body>
</html>