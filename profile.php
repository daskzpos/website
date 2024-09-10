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
    <title>profile</title>
</head>
<body>
<method="post" action="http://localhost/php-opdrachten/website/profile.php"></method>
<header>    
    <a href="http://localhost/php-opdrachten/website/website.php">HOME<>
</header>
<body class="loggedin">
   <nav class="navtop"></nav>
   <div class="content">
      <p>Welcom back, <?=htmlspecialchars($_SESSION['name'], ENT_QUOTES)?>!</p>
   </div>
   <div class="content">
			<h2>Profile Page</h2>
			<div>
				<p>Your account details are below:</p>
				<table>
					<tr>
						<td>Username:</td>
						<td><?=htmlspecialchars($_SESSION['name'], ENT_QUOTES)?></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><?=htmlspecialchars($password, ENT_QUOTES)?></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><?=htmlspecialchars($email, ENT_QUOTES)?></td>
					</tr>
				</table>
			</div>
</body>
<br> <br>
<h1>PROFILE</h1>

<?php

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== TRUE) {
    header('Location: login.html');
    exit();
}
if ($stmt = $conn->prepare('SELECT username, email FROM accounts WHERE id = ?')) {
    $stmt->bind_param('i', $_SESSION['id']);
    $stmt->execute();
    $stmt->bind_result($username, $email);
    $stmt->fetch();

    echo '<h1>Welcome, ' . htmlspecialchars($username) . '!</h1>';
    echo '<p>Your email: ' . htmlspecialchars($email) . '</p>';

    $stmt->close();
}
$conn->close();

?>
</body>
</html>