<?php
session_start();
include('db.php');

// Ensure the user is logged in as an admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Check if ID is provided
if (isset($_GET['email'])) {
    $subscriber_email = $_GET['email'];

    // Delete subscriber from the database
    $stmt = $pdo->prepare("DELETE FROM newsletter_subscribers WHERE email = :email");
    $stmt->bindParam(':email', $subscriber_email);
    if ($stmt->execute()) {
        echo "Subscriber deleted successfully.";
    } else {
        echo "Error deleting subscriber.";
    }
} else {
    echo "Invalid request.";
}
?>
