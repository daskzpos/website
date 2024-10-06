<?php
session_start();
require('conn database.php');
$bandsResult = $conn->query("SELECT bandname, genre FROM Bands");
$eventsResult = $conn->query("SELECT name, description, date, start_time, end_time FROM Events");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles.css" rel="stylesheet">
</head>
<body>
<method="post" action="progamma.php"></method>
<header>    
    <button onclick="window.location.href = 'profile.php';">PROFILE</button>
    <button onclick="window.location.href = 'createband.php';">CREATE</button>     
</header>
<table1>
    <tr1>
        <th>band name</th>
        <th>genre</th>
    </tr1>
    <?php while ($row = $bandsResult->fetch_assoc()): ?>
    <tr1>
        <td><?php echo htmlspecialchars($row['bandname']); ?></td>
        <td><?php echo htmlspecialchars($row['genre']); ?></td>
    </tr1>
    <?php endwhile; ?>
</table1>
<table2>
    <tr2>
        <th>event name</th>
        <th>description</th>
        <th>date</th>
        <th>start time</th>
        <th>end time</th>
    </tr2>
    <?php while ($row = $eventsResult->fetch_assoc()): ?>
    <tr2>
        <td><?php echo htmlspecialchars($row['name']); ?></td>
        <td><?php echo htmlspecialchars($row['description']); ?></td>
        <td><?php echo htmlspecialchars($row['date']); ?></td>
        <td><?php echo htmlspecialchars($row['start_time']); ?></td>
        <td><?php echo htmlspecialchars($row['end_time']); ?></td>
    </tr2>
    <?php endwhile; ?>
</table2>

<br> <br>
<h1>PROGAMMA</h1>
<?php



?>
</body>
</html>