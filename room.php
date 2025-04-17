<?php
include('db.php');
include('header.php');
include('font.php');

if (!isset($_GET['room_id'])) {
    echo "Room not found.";
    exit();
}

$room_id = $_GET['room_id'];
$stmt = $pdo->prepare("SELECT * FROM rooms WHERE room_id = :room_id");
$stmt->bindParam(':room_id', $room_id);
$stmt->execute();
$room = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$room) {
    echo "Room not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($room['room_type']); ?> Room</title>
</head>
<body>

    <section class="singleRoom">
        <div class="container">
            <div class="srWrapper">
                <div class="srImage">
                    <?php echo '<img src="uploads/' . $room['room_image'] . '" alt="Room Image">'; ?>
                </div>
                <div class="srContent">
                    <h3 class="srNumber">Room Number : <?= htmlspecialchars($room['room_number']); ?></h3>
                    <p class="srType">Room Type : <?= htmlspecialchars(ucfirst($room['room_type'])); ?></p>
                    <p class="srPrice">Price : $<?= htmlspecialchars($room['price']); ?></p>
                    <p class="srDes">Description : <?= htmlspecialchars($room['description']); ?></p>
                    <div class="btnGroup">
                        <a href="book_room.php?room_id=<?= $room['room_id'] ?>" class="btn">Book This Room</a>
                        <a href="rooms.php" class="btn">View Another Room</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
</body>
</html>


<?php include('footer.php') ?>