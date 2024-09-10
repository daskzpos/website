<?php
session_start();
require('conn database.php'); // Make sure this file contains the correct database connection setup

if (!isset($_POST['username'], $_POST['password'])) {
    exit('Please complete the login form!');
}

if (empty($_POST['username']) || empty($_POST['password'])) {
    exit('Please complete the login form');
}

// Prepare and execute a statement to fetch the user based on the provided username
if ($stmt = $conn->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($_POST['password'], $hashed_password)) {
            session_regenerate_id(); // Regenerate session ID to prevent session fixation
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['id'] = $id;

            // Redirect to home or profile page
            header('Location: profile.php');
            exit();

        } else {
            header('Location: login.php');
            exit();
        }
    }
    $stmt->close();
} else {
    echo 'Could not prepare statement!';
}

$conn->close();
?>
