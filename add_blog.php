<?php
session_start();
include('db.php');

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Blog From Submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars(trim($_POST['title']));
    $content = htmlspecialchars(trim($_POST['content']));
    $author = htmlspecialchars(trim($_POST['author']));

    try {
        $stmt = $pdo->prepare("INSERT INTO blogs (title, content, author) VALUES (:title, :content, :author)");
        $stmt->execute([
            ':title' => $title,
            ':content' => $content,
            ':author' => $author
        ]);
        $message = "Blog post added successfully!";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Blog Post</title>
</head>
<body>
    <h1>Add Blog Post</h1>
    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <form action="" method="POST">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" required><br><br>

        <label for="content">Content:</label><br>
        <textarea id="content" name="content" rows="10" required></textarea><br><br>

        <label for="author">Author:</label><br>
        <input type="text" id="author" name="author" required><br><br>

        <button type="submit">Add Blog Post</button>
    </form>
</body>
</html>
