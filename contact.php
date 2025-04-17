<?php
session_start();
include('db.php'); 
include('header.php');
include('font.php');


$message_status = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    $admin_email = "sowrav17sep@gmail.com";

    // Mail headers
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Email to Admin
    $admin_subject = "New Contact Form Submission: $subject";
    $admin_message = "You have received a new message:\n\n" .
                     "Name: $name\n" .
                     "Email: $email\n" .
                     "Subject: $subject\n\n" .
                     "Message:\n$message\n";

    // Email to Sender
    $sender_subject = "Thank you for contacting us!";
    $sender_message = "Hello $name,\n\nThank you for reaching out to us. We have received your message and will respond shortly.\n\n" .
                      "Here is a copy of your message:\n\n" .
                      "Subject: $subject\n" .
                      "Message:\n$message\n\n" .
                      "Best Regards,\nAdmin Team";

    try {
        
        $stmt = $pdo->prepare("INSERT INTO contact_submissions (name, email, subject, message) VALUES (:name, :email, :subject, :message)");
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':subject' => $subject,
            ':message' => $message,
        ]);

        // Send emails
        $admin_mail_status = mail($admin_email, $admin_subject, $admin_message, $headers);
        $sender_mail_status = mail($email, $sender_subject, $sender_message, $headers);

        if ($admin_mail_status && $sender_mail_status) {
            $message_status = "Message sent successfully and saved in the database!";
        } else {
            $message_status = "Message saved in the database, but there was an error sending emails.";
        }
    } catch (PDOException $e) {
        $message_status = "Error saving your message: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    
    <section class="contactTop">
        <div class="container">
            <div class="innerContactTop row">
                <div class="CTInfo">
                    <h3>Contact Us</h3>
                    <p>Need to get in touch with us? Either fill the form or call / mail us from below.</p>
                    <div class="ConInformation">
                        <a href="#"><i class="fa-solid fa-phone"> </i>  +88017777777</a>
                        <a href="#"><i class="fa-solid fa-envelope"> </i> info@roberto.com</a>
                    </div>
                </div>
                <div class="CTForm">
                    <form action="" method="POST">
                        <label for="name">Your Name:</label><br>
                        <input type="text" id="name" name="name" required><br><br>

                        <label for="email">Your Email:</label><br>
                        <input type="email" id="email" name="email" required><br><br>

                        <label for="subject">Subject:</label><br>
                        <input type="text" id="subject" name="subject" required><br><br>

                        <label for="message">Message:</label><br>
                        <textarea id="message" name="message" rows="5" required></textarea><br><br>

                        <button type="submit" class="btn"><i class="fa-solid fa-paper-plane"></i> Send Message</button>
                        <button type="reset" class="btn">Clear Data</button>

                        <?php if (!empty($message_status)): ?>
                            <p><?php echo htmlspecialchars($message_status); ?></p>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2625.090422862554!2d2.3498385769678114!3d48.85648610083989!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e671fdb38f5b8b%3A0xc0345272f10c1f6e!2sH%C3%B4tel%20de%20Ville!5e0!3m2!1sen!2sbd!4v1733135379224!5m2!1sen!2sbd" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>

    



</body>
</html>

<?php include('footer.php') ?>
