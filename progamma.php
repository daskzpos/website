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
    <button onclick="window.location.href = 'profile.php';">PROFILE</button>
    <button onclick="window.location.href = 'createband.php';">CREATE</button>    
    <button onclick="window.location.href = 'website.php';">LOGOUT</button>  
</header>
<h1>LINK</h1>

<?php if (isset($successMessage)): ?>
    <p style="color:green;"><?php echo $successMessage; ?></p>
<?php endif; ?>

<?php if (isset($errorMessage)): ?>
    <p style="color:red;"><?php echo $errorMessage; ?></p>
<?php endif; ?>

<h2 id="tbands">Bands</h2>
<div class="table-container">
<table id="tableband">
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

<h2 id="tevents">Events</h2>
<div class="table-container">
<table id="tableevents">
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



<h2 id="tassbe">Add a band to an event here</h2>
<form action="" method="POST" id="tableassbe">
    <label for="event">Select Event:</label>
    <select name="event_id" id="event">
        <?php foreach ($events as $event): ?>
            <option value="<?php echo $event['id']; ?>"><?php echo htmlspecialchars($event['name']); ?></option>
        <?php endforeach; ?>
    </select>
<br>
<br>
    <label for="band">Select Band:</label>
    <select name="band_id" id="band">
        <?php foreach ($bands as $band): ?>
            <option value="<?php echo $band['id']; ?>"><?php echo htmlspecialchars($band['bandname']); ?></option>
        <?php endforeach; ?>
    </select>
<br>
<br>
    <button type="submit">Assign</button>
</form>

</body>
</html>
