<?php
include('db.php');
include('header.php');


$blog_id = $_GET['title'] ?? 0;

// Query to fetch blog details
$blog_stmt = $pdo->prepare("SELECT * FROM blogs WHERE title = :title");
$blog_stmt->bindParam(':title', $blog_id, PDO::PARAM_INT);
$blog_stmt->execute();
$blog = $blog_stmt->fetch(PDO::FETCH_ASSOC);

if (!$blog) {
    echo "Blog not found!";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($blog['title']); ?></title>
</head>
<body>
    
    <section class="blogDetails">
        <div class="container">
            <h1 class="singleTitile"><?= htmlspecialchars($blog['title']); ?></h1>
            <p class="singleAurthor"><strong>Author:</strong> <?= htmlspecialchars($blog['author']); ?></p>
            <p class="singleContent"><?= htmlspecialchars($blog['content']); ?></p>
            <a href="blog.php" class="btn" style="display:inline-block;text-align:center;">Back to Blogs</a>
        </div>
    </section>
</body>
</html>

<?php include('footer.php')  ?>