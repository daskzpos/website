<?php
session_start();
require ('conn database.php');

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

    $stmt->close();
}
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles.css" rel="stylesheet">
</head>
<body>
<method="post" action="profile.php"></method>
<header>    
    <button onclick="window.location.href = 'createband.php';">CREATE</button>
    <button onclick="window.location.href = 'progamma.php';">PROGAM</button>
    <button onclick="window.location.href = 'website.php';">LOG OUT</button>
</header>
<body class="loggedin">
   <nav class="navtop"></nav>
   <div class="content">
   </div>
<h3>Your account details are below:</h3>
	<table>
		<tr>
			<td>Username:</td>
			<td><?=htmlspecialchars($_SESSION['username'], ENT_QUOTES)?></td>
		</tr>
		<tr>
			<td>Email:</td>
			<td><?=htmlspecialchars($email, ENT_QUOTES)?></td>
		</tr>
	</table>
	</div>
</body>
<br> <br>


</body>
</html>