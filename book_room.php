<?php
session_start();
include 'db.php';
include 'header.php';
include('font.php');


$selected_room = $_GET['room_id'] ?? '';
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_id = $_POST['room_id'];
    $user_name = trim($_POST['user_name']);
    $user_email = trim($_POST['user_email']);
    $checkin_date = $_POST['checkin_date'];
    $checkout_date = $_POST['checkout_date'];

    // Validate inputs
    $errors = [];
    
    if (empty($user_name)) $errors[] = "Name is required";
    if (empty($user_email)) $errors[] = "Email is required";
    if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format";
    if (empty($checkin_date)) $errors[] = "Check-in date is required";
    if (empty($checkout_date)) $errors[] = "Check-out date is required";

    // Date validation
    if ($checkin_date && $checkout_date) {
        $today = date('Y-m-d');
        if ($checkin_date < $today) $errors[] = "Check-in date cannot be in the past";
        if ($checkout_date <= $checkin_date) $errors[] = "Check-out date must be after check-in date";
    }

    // Check room availability for dates
    if ($room_id && $checkin_date && $checkout_date) {
        $stmt = $pdo->prepare("
            SELECT * FROM bookings 
            WHERE room_id = ? 
            AND (
                (checkin_date <= ? AND checkout_date >= ?) OR
                (checkin_date <= ? AND checkout_date >= ?)
            )
        ");
        $stmt->execute([
            $room_id,
            $checkout_date, $checkin_date,
            $checkin_date, $checkout_date
        ]);
        
        if ($stmt->fetch()) {
            $errors[] = "This room is already booked for selected dates";
        }
    }

    // Process if no errors
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO bookings 
                (room_id, user_name, user_email, checkin_date, checkout_date) 
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $room_id, 
                $user_name, 
                $user_email, 
                $checkin_date, 
                $checkout_date
            ]);
            
            $_SESSION['message'] = "<p style='color: green;'>Booking successful!</p>";
            header("Location: book_room.php");
            exit();
        } catch(PDOException $e) {
            $message = "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
        }
    } else {
        $message = "<p style='color: red;'>" . implode("<br>", $errors) . "</p>";
    }
}

// Display session message
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
?>

<div class="container roomBooking" >
    <h2>Book a Room</h2>
    <?php if (!empty($message)) echo $message; ?>

    <form method="POST" action="book_room.php">
        <!-- User Info -->
        <label for="user_name">Your Name:</label><br>
        <input type="text" name="user_name" required 
               value="<?= htmlspecialchars($_POST['user_name'] ?? '') ?>"><br><br>

        <label for="user_email">Your Email:</label><br>
        <input type="email" name="user_email" required 
               value="<?= htmlspecialchars($_POST['user_email'] ?? '') ?>"><br><br>

        <!-- Dates -->
        <label for="checkin_date">Check-in Date:</label><br>
        <input type="date" name="checkin_date" required 
               min="<?= date('Y-m-d') ?>" 
               value="<?= $_POST['checkin_date'] ?? '' ?>"><br><br>

        <label for="checkout_date">Check-out Date:</label><br>
        <input type="date" name="checkout_date" required 
               min="<?= date('Y-m-d', strtotime('+1 day')) ?>" 
               value="<?= $_POST['checkout_date'] ?? '' ?>"><br><br>

        <!-- Room Selection -->
        <label for="room_id">Select Room:</label><br>
        <select name="room_id" required>
            <?php
            $stmt = $pdo->query("SELECT room_id, room_number, room_type FROM rooms");
            while ($room = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $selected = ($room['room_id'] == $selected_room) ? 'selected' : '';
                echo "<option value='{$room['room_id']}' $selected>
                        Room {$room['room_number']} - {$room['room_type']}
                      </option>";
            }
            ?>
        </select><br><br>

        <button type="submit">Confirm Booking</button>
    </form>
</div>

<?php include 'footer.php'; ?>