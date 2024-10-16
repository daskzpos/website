<?php
session_start();
require('conn database.php');

// Fetch bands from the database
$bandsResult = $conn->query("SELECT bandname, genre, id FROM Bands");
$bands = [];
while ($row = $bandsResult->fetch_assoc()) {
    $bands[] = $row;
}

// Fetch events from the database 
$eventsResult = $conn->query("SELECT name, description, date, start_time, end_time, id, price FROM Events");
$events = [];
while ($row = $eventsResult->fetch_assoc()) {
    $events[] = $row;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = $_POST['event_id'];
    $band_id = $_POST['band_id'];

    // Check if the band is already assigned to the event
    $checkQuery = $conn->prepare("SELECT * FROM BandEvents WHERE event_id = ? AND band_id = ?");
    $checkQuery->bind_param("ii", $event_id, $band_id);
    $checkQuery->execute();
    $checkResult = $checkQuery->get_result();

    if ($checkResult->num_rows === 0) {
        // Assign the band to the event if not already assigned
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
        Events.price AS event_price,
        GROUP_CONCAT(Bands.bandname SEPARATOR ', ') AS band_names,
        GROUP_CONCAT(Bands.genre SEPARATOR ', ') AS band_genres
    FROM BandEvents
    JOIN Events ON BandEvents.event_id = Events.id
    JOIN Bands ON BandEvents.band_id = Bands.id
    GROUP BY Events.id
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

<?php if (isset($successMessage)): ?>
    <p style="color:green;"><?php echo $successMessage; ?></p>
<?php endif; ?>

<?php if (isset($errorMessage)): ?>
    <p style="color:red;"><?php echo $errorMessage; ?></p>
<?php endif; ?>

<div id="tprogram">
    <h2>Program</h2>
    <div class="table-container">
        <table id="tableprogram">
            <tbody>
                <?php foreach ($bandEvents as $assignment): ?>
                    <tr>
                        <td>
                            <div style="text-align: center;">
                                <strong><?php echo htmlspecialchars($assignment['event_name'] ?? ''); ?></strong>
                                <br>
                                <em><?php echo htmlspecialchars($assignment['event_description'] ?? ''); ?></em>
                            </div>
                            <br>
                            <strong>Date:</strong> <?php echo htmlspecialchars($assignment['event_date'] ?? ''); ?>
                            <br>
                            <strong>Start Time:</strong> <?php echo htmlspecialchars($assignment['event_start'] ?? ''); ?>
                            <br>
                            <strong>End Time:</strong> <?php echo htmlspecialchars($assignment['event_end'] ?? ''); ?>
                            <br>
                            <strong>Price:</strong> <?php echo htmlspecialchars($assignment['event_price'] ?? '0.00'); ?>
                            <br><br>
                            <div style="text-align: center;">
                                <strong>Featuring:</strong> <?php echo htmlspecialchars($assignment['band_names'] ?? ''); ?>
                                <br>
                                <strong>Genres:</strong> <?php echo htmlspecialchars($assignment['band_genres'] ?? ''); ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
