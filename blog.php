<?php
include('db.php');
include('header.php');
include('font.php');


// Query to get all blogs
$blogs_stmt = $pdo->prepare("SELECT * FROM blogs ORDER BY id DESC");
$blogs_stmt->execute();
$blogs = $blogs_stmt->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs</title>

</head>
<body>
    <section class="blogSec">
        <div class="container">
            <h2>Our Blogs</h2>
            <div class="blog-container">
                <?php foreach ($blogs as $blog): ?>
                    <div class="blog-card">

                        <h4 class="blog-title"><?= htmlspecialchars($blog['title']); ?></h4>
                        <p class="blog-content"><?= htmlspecialchars(substr($blog['content'], 0, 150)) . '...'; ?></p>
                        <p class="blog-author">by <?= htmlspecialchars($blog['author']); ?></p>
                        <br>
                        <a class="btn btnsm" href="blog_details.php?title=<?= $blog['title']; ?>">Read More</a>
                        <br>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</body>
</html>


<?php include('footer.php') ?>
