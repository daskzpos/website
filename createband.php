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
    <title>Add Bands/Events</title>
</head>
<body class="loggedin">
<header class="header-flex">
    <button onclick="window.location.href = 'progamma.php';">PROGRAM</button>
    <button onclick="window.location.href = 'profile.php';">PROFILE</button>
    <button onclick="window.location.href = 'website.php';">LOG OUT</button>
</header>
<h1>ADD BANDS/EVENTS</h1>

<div class="content flex-container">
        <form action="" method="post" id="createband">
            <p><strong>Voeg hier een band toe</strong></p>
            <input type="text" name="band" placeholder="Band Name">
            <br><br>
            <label><strong>Genre:</strong></label>
            <br><br>
            <input type="radio" name="genre" id="rock" value="Rock" required>
            <label for="rock">Rock</label><br>
            <input type="radio" name="genre" id="pop" value="Pop" required>
            <label for="pop">Pop</label><br>
            <input type="radio" name="genre" id="metal" value="Metal" required>
            <label for="metal">Metal</label><br>
            <input type="radio" name="genre" id="hiphop" value="Hip-Hop" required>
            <label for="hiphop">Hip-Hop</label><br><br>
            <input type="submit" value="ADD">
        </form>

        <form action="" method="post" id="createevent">
            <p><strong>Voeg hier een event toe</strong></p>
            <label for="eventname"><strong>Event Name:</strong></label>
            <input id="eventname" name="eventname" type="text" placeholder="Event Name"><br><br>
            <label for="description"><strong>Description:</strong></label>
            <textarea id="description" name="description" placeholder="Event Description"></textarea><br><br>
            <label for="date"><strong>Date:</strong></label>
            <input id="date" name="date" type="date"><br><br>
            <label for="start"><strong>Start Time:</strong></label>
            <input id="start" name="start" type="time"><br><br>
            <label for="end"><strong>End Time:</strong></label>
            <input id="end" name="end" type="time"><br><br>
            <label for="price"><strong>Price:</strong></label>
            <input id="price" name="price" placeholder="Price" type="number" min="0.00" step="0.01">
            <br><br>
            <input name="add" type="submit" value="ADD">
        </form>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Add band
        if (isset($_POST['band']) && isset($_POST['genre'])) {
            if (empty($_POST['band']) || empty($_POST['genre'])) {
                echo 'Please fill in all fields for the band.';
            } else {
                if ($stmt = $conn->prepare('INSERT INTO Bands (bandname, genre) VALUES (?, ?)')) {
                    $stmt->bind_param('ss', $_POST['band'], $_POST['genre']);
                    if ($stmt->execute()) {
                        echo 'Band added!';
                    } else {
                        echo 'Could not add band: ' . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    echo 'Could not prepare statement: ' . $conn->error;
                }
            }
        }

        // Add event
        if (isset($_POST['eventname']) && isset($_POST['description'])) {
            if (empty($_POST['eventname']) || empty($_POST['description']) || empty($_POST['date']) || empty($_POST['start']) || empty($_POST['end']) || empty($_POST['price'])) {
                echo 'Please fill in all fields for the event.';
            } else {
                if ($stmt = $conn->prepare('INSERT INTO Events (name, description, date, start_time, end_time, price) VALUES (?, ?, ?, ?, ?, ?)')) {
                    $stmt->bind_param('ssssss', $_POST['eventname'], $_POST['description'], $_POST['date'], $_POST['start'], $_POST['end'], $_POST['price']);
                    if ($stmt->execute()) {
                        echo 'Event added!';
                    } else {
                        echo 'Could not add event: ' . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    echo 'Could not prepare statement: ' . $conn->error;
                }
            }
        }
    }
    ?>

</body>
</html>
