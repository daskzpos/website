<?php
session_start();
require('conn database.php');

$bandsResult = $conn->query("SELECT bandname, genre, id FROM Bands");
$bands = [];
while ($row = $bandsResult->fetch_assoc()) {
    $bands[] = $row;
}

$eventsResult = $conn->query("SELECT name, description, date, start_time, end_time, id FROM Events");
$events = [];
while ($row = $eventsResult->fetch_assoc()) {
    $events[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = $_POST['event_id'];
    $band_id = $_POST['band_id'];

    $checkQuery = $conn->prepare("SELECT * FROM BandEvents WHERE event_id = ? AND band_id = ?");
    $checkQuery->bind_param("ii", $event_id, $band_id);
    $checkQuery->execute();
    $checkResult = $checkQuery->get_result();

    if ($checkResult->num_rows === 0) {
        $stmt = $conn->prepare("INSERT INTO BandEvents (event_id, band_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $event_id, $band_id);

        if ($stmt->execute()) {
            $successMessage = "Band successfully assigned to event!";
        } else {
            $errorMessage = "Error assigning band: " . $conn->error;
        }
    } else {
        $errorMessage = "This band is already assigned to the event!";
    }
}

$bandEventsResult = $conn->query("
    SELECT 
        Events.name AS event_name, 
        Events.description AS event_description, 
        Events.date AS event_date, 
        Events.start_time AS event_start, 
        Events.end_time AS event_end,
        Bands.bandname AS band_name, 
        Bands.genre AS band_genre
    FROM BandEvents
    JOIN Events ON BandEvents.event_id = Events.id
    JOIN Bands ON BandEvents.band_id = Bands.id
");
$bandEvents = [];
while ($row = $bandEventsResult->fetch_assoc()) {
    $bandEvents[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles.css" rel="stylesheet">
</head>
<body>
<header>    
    <button onclick="window.location.href = 'login.php';">LOGIN</button>  
</header>
<h1>HOME</h1>

<h2 id="tprogram">Program</h2>
<div class="table-container">
    <table id="tableprogram">
        <tbody>
            <?php foreach ($bandEvents as $assignment): ?>
                <tr>
                    <td>
                        <div style="text-align: center;">
                            <strong><?php echo htmlspecialchars($assignment['event_name']); ?></strong>
                            <br>
                            <em><?php echo htmlspecialchars($assignment['event_description']); ?></em>
                        </div>
                        <br>
                        <strong>Date:</strong> <?php echo htmlspecialchars($assignment['event_date']); ?>
                        <br>
                        <strong>Start Time:</strong> <?php echo htmlspecialchars($assignment['event_start']); ?>
                        <br>
                        <strong>End Time:</strong> <?php echo htmlspecialchars($assignment['event_end']); ?>
                        <br><br>
                        <div style="text-align: center;">
                            <strong>Featuring:</strong> <?php echo htmlspecialchars($assignment['band_name']); ?>
                            <br>
                            <strong>Genre:</strong> <?php echo htmlspecialchars($assignment['band_genre']); ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
