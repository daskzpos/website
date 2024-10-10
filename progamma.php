<?php
session_start();
require('conn database.php');

$bandsResult = $conn->query("SELECT bandname, genre FROM Bands");
$bands = [];
while ($row = $bandsResult->fetch_assoc()) {
    $bands[] = $row;
}

$eventsResult = $conn->query("SELECT name, description, date, start_time, end_time FROM Events");
$events = [];
while ($row = $eventsResult->fetch_assoc()) {
    $events[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles.css" rel="stylesheet">
    <title>Progam</title>
</head>
<body>
<header>    
    <button onclick="window.location.href = 'profile.php';">PROFILE</button>
    <button onclick="window.location.href = 'createband.php';">CREATE</button>     
</header>
<h1>PROGAM</h1>

<h2>Bands</h2>
<div class="table-container">
<table id="tbands">
    <thead>
        <tr>
            <th>Band Name</th>
            <th>Genre</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($bands as $band): ?>
        <tr>
            <td><?php echo htmlspecialchars($band['bandname']); ?></td>
            <td><?php echo htmlspecialchars($band['genre']); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>

<h2>Events</h2>
<div class="table-container">
<table id="tevents">
    <thead>
        <tr>
            <th>Event Name</th>
            <th>Description</th>
            <th>Date</th>
            <th>Start Time</th>
            <th>End Time</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($events as $event): ?>
        <tr>
            <td><?php echo htmlspecialchars($event['name']); ?></td>
            <td><?php echo htmlspecialchars($event['description']); ?></td>
            <td><?php echo htmlspecialchars($event['date']); ?></td>
            <td><?php echo htmlspecialchars($event['start_time']); ?></td>
            <td><?php echo htmlspecialchars($event['end_time']); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>


</body>
</html>
