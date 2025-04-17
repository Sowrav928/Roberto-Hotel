<?php
session_start();
include('db.php');
include('font.php');
include('header.php');

// Query to get all rooms data
$stmt = $pdo->query("SELECT * FROM rooms");
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Grid</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <section class="rooms">
        <div class="container">
            <h2 class="pageTitle">Available Rooms</h2>
            <div class="roomWrapper">
                <?php foreach ($rooms as $room): ?>
                    <div class="roomGrid">
                        <img src="uploads/<?php echo $room['room_image']; ?>" alt="Room Image" class="roomImage">
                        <div class="roomContent">
                            <p class="roomNumber">Room Number : <?= htmlspecialchars($room['room_number']); ?></p>
                            <p class="roomType"><?= "Room Type : " . htmlspecialchars(ucwords($room['room_type'])); ?></p>
                            <p class="roomPrice">Price : $<b><?= htmlspecialchars($room['price']); ?></b></p>
                            <p class="roomDescription"><?= htmlspecialchars(substr($room['description'],0,40)) . " ..."; ?></p>
                            <a href="room.php?room_id=<?= $room['room_id']; ?>" class="btn btnsm">View Details</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
    </section>
</body>
</html>

<?php include('footer.php') ?>