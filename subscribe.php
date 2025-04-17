<?php
include('db.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Validate the email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address!";
    } else {
        try {
            // Check if email already exists
            $stmt = $pdo->prepare("SELECT * FROM newsletter_subscribers WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo "You are already subscribed!";
            } else {
                // Insert the email into the database
                $stmt = $pdo->prepare("INSERT INTO newsletter_subscribers (email) VALUES (:email)");
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                echo "Thank you for subscribing!";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

?>
