<?php
session_start();
require('conn database.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        if ($stmt = $conn->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
            $stmt->bind_param('s', $_POST['username']);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $hashed_password);
                $stmt->fetch();

                if (password_verify($_POST['password'], $hashed_password)) {
                    $_SESSION['loggedin'] = TRUE;
                    $_SESSION['username'] = $_POST['username'];
                    $_SESSION['id'] = $id;
                    header('Location: profile.php');
                    exit;
                } else {
                    $error = 'Incorrect username or password';
                }
            }
            $stmt->close();
        }
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles.css" rel="stylesheet">
    <title>LOGIN</title>
</head>
<header>
    <button onclick="window.location.href = 'website.php';">HOME</button>
</header>
<body>
    <h1>Login</h1>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <br>
        <button type="submit">Login</button>
    </form>

    <?php
    if (isset($error)) {
        echo '<p style="color: red;">' . $error . '</p>';
    }
    ?>
</body>
</html>
