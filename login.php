<?php

session_start();
require('conn database.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Login</button>
    </form>

    <h2>
        <p>Don't have an account? <a href="register.php">REGISTER HERE</a></p>
    </h2>
</body>
</html>

<?php

if (empty($_POST['username']) || empty($_POST['password'])) {
    exit('Please complete the login form');
}

if ($stmt = $conn->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        if (password_verify($_POST['password'], $hashed_password)) {
            session_regenerate_id(); 
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['id'] = $id;
            header('Location: profile.php');
            exit;

        } else {
           echo 'incorrect username or password';
        }
    }
    $stmt->close();
}

?>
