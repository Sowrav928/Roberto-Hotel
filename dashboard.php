<?php
session_start();  

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include('db.php');
include('font.php');  

// Query to get all user data
$user_stmt = $pdo->prepare("SELECT * FROM users");
$user_stmt->execute();
$users = $user_stmt->fetchAll(PDO::FETCH_ASSOC);

// Query to get all subscriber data
$subscriber_stmt = $pdo->prepare("SELECT * FROM newsletter_subscribers");
$subscriber_stmt->execute();
$subscribers = $subscriber_stmt->fetchAll(PDO::FETCH_ASSOC);

// Query to get all contact data
$contact_stmt = $pdo->prepare("SELECT * FROM contact_submissions ORDER BY created_at DESC");
$contact_stmt->execute();
$contacts = $contact_stmt->fetchAll(PDO::FETCH_ASSOC);

// Query to get all blogs data
$blog_stmt = $pdo->prepare("SELECT * FROM blogs ORDER BY created_at DESC");
$blog_stmt->execute();
$blogs = $blog_stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle add a new room

if (isset($_POST['add_room'])) {
    $room_number = $_POST['room_number'];
    $room_type = $_POST['room_type'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Handle image upload
    $image = $_FILES['room_image']['name']; // Get the image file name
    $image_temp = $_FILES['room_image']['tmp_name']; // Get the temporary file path

    // Set the target path in the 'uploads' folder
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);

    // Move the uploaded file to the target directory
    if (move_uploaded_file($image_temp, $target_file)) {
        // Insert the room details into the database (including the image file name)
        $stmt = $pdo->prepare("INSERT INTO rooms (room_number, room_type, price, description, room_image) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$room_number, $room_type, $price, $description, $image]);

        echo "Room added successfully.";
    } else {
        echo "Error uploading image.";
    }
}


//Check upload directory
if (!is_writable('uploads')) {
    echo "Uploads directory is not writable.";
    exit();
}


// Fetch all rooms data
$room_stmt = $pdo->query("SELECT * FROM rooms ORDER BY created_at DESC");
$rooms = $room_stmt->fetchAll(PDO::FETCH_ASSOC);


// Handle blog form submission
$blog_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_blog'])) {
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
        $blog_message = "Blog added successfully!";
    } catch (PDOException $e) {
        $blog_message = "Error: " . $e->getMessage();
    }
}

// Delete a room
if (isset($_POST['delete_room'])) {
    $room_id = $_POST['room_id'];

    $stmt = $pdo->prepare("DELETE FROM rooms WHERE room_id = :room_id");
    $stmt->bindParam(':room_id', $room_id);
    if ($stmt->execute()) {
        echo "Room deleted successfully!";
    } else {
        echo "Error deleting room.";
    }
}

// Handle Subscribtion deletion request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $subscriber_email = $_POST['email'];

    if (filter_var($subscriber_email, FILTER_VALIDATE_EMAIL)) {
        try {
            // Delete subscriber from the database
            $delete_stmt = $pdo->prepare("DELETE FROM newsletter_subscribers WHERE email = :email");
            $delete_stmt->bindParam(':email', $subscriber_email);
            $delete_stmt->execute();
            $message = "Subscriber with email {$subscriber_email} deleted successfully.";
        } catch (PDOException $e) {
            $message = "Error deleting subscriber: " . $e->getMessage();
        }
    } else {
        $message = "Invalid email address.";
    }
}

// Handle Blog Deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_blog'])) {
    $blog_id = $_POST['delete_blog_id'];

    // Prepare and execute the delete query
    $delete_stmt = $pdo->prepare("DELETE FROM blogs WHERE id = :id");
    $delete_stmt->bindParam(':id', $blog_id, PDO::PARAM_INT);

    if ($delete_stmt->execute()) {
        echo "<script>alert('Blog deleted successfully.'); window.location.href = 'dashboard.php';</script>";
    } else {
        echo "<script>alert('Failed to delete blog.');</script>";
    }
}



// Get the logged-in user's session info
$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./dashboardStyle.css">
    <title>Dashboard : Robetro - Hotel & Resort</title>
    <link rel="icon" href="./img/favicon.ico" type="image/x-icon">
</head>
<body>

    
    
    <section class="dashbody">
            <div class="dashNav">
                <a href="./index.php" target="_blank" class="logoImg"><img src="./img/footerlogo.webp" alt="Robetro"></a>
                <ul>
                    <li><a href="#" data-section="userCon" class="menu-item active">User Details</a></li>
                    <li><a href="#" data-section="subscriberCon" class="menu-item">Subscriber Details</a></li>
                    <li><a href="#" data-section="contactCon" class="menu-item">Contact Details</a></li>
                    <li><a href="#" data-section="blogCon" class="menu-item">Add Blog</a></li>
                    <li><a href="#" data-section="blogDelCon" class="menu-item">Manage Blog</a></li>
                    <li><a href="#" data-section="addRoomCon" class="menu-item">Add Room</a></li>
                    <li><a href="#" data-section="listRoomCon" class="menu-item">Room Management</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
            <div class="dashContent" >
                <div class="welcomeMassage">
                    <div class="container-fluid">
                        <h1>Welcome to the Dashboard</h1>
                        <p>Hello, <span><?php echo htmlspecialchars($username); ?>!</span> You are logged in as an <?php echo htmlspecialchars($role); ?>.</p>
                        <?php if ($blog_message): ?>
                        <p><?php echo htmlspecialchars($blog_message); ?></p>
                    <?php endif; ?>
                    </div>
                </div>
                <div class="userCon dashConSection" id="userCon" style="display: block;">
                    <h3>All available user</h3>
                    <table border="1">
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Created At</th>
                        </tr>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['id']); ?></td>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td><?php echo htmlspecialchars($user['role']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <div class="subscriberCon dashConSection" id="subscriberCon">
                    <h3>All available subscribers</h3>
                    <table border="1" name="Showing Subscriber Data">
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Subscribed At</th>
                        </tr>
                        <?php foreach ($subscribers as $subscriber): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($subscriber['id']); ?></td>
                            <td><?php echo htmlspecialchars($subscriber['email']); ?></td>
                            <td><?php echo htmlspecialchars($subscriber['subscribed_at']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                    <br>
                    <br>
                    <h3>You can delete subscriber from here</h3>
                    <table border="1" name="Delete Data">
                            <tr>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                            <?php if (!empty($subscribers)) : ?>
                                <?php foreach ($subscribers as $subscriber) : ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($subscriber['email']); ?></td>
                                        <td>
                                            <!-- Delete Form -->
                                            <form action="dashboard.php" method="POST" style="display:inline;">
                                                <input type="hidden" name="email" value="<?php echo htmlspecialchars($subscriber['email']); ?>">
                                                <button type="submit">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="2">No subscribers found.</td>
                                </tr>
                            <?php endif; ?>
                    </table>
                </div>
                <div class="subscriberCon dashConSection" id="contactCon">
                    <h3>All available subscribers</h3>
                    <table border="1" name="Showing Subscriber Data">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Contact Time</th>
                        </tr>
                        <?php foreach ($contacts as $contact): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($contact['id']); ?></td>
                            <td><?php echo htmlspecialchars($contact['name']); ?></td>
                            <td><?php echo htmlspecialchars($contact['email']); ?></td>
                            <td><?php echo htmlspecialchars($contact['subject']); ?></td>
                            <td><?php echo htmlspecialchars($contact['message']); ?></td>
                            <td><?php echo htmlspecialchars($contact['created_at']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <div class="blogCon dashConSection" id="blogCon">
                    <h3>Add New Blog</h3>
                    <form method="POST" action="">
                        <label for="title">Title:</label><br>
                        <input type="text" id="title" name="title" required><br><br>

                        <label for="content">Content:</label><br>
                        <textarea id="content" name="content" rows="5" required></textarea><br><br>

                        <label for="author">Author:</label><br>
                        <input type="text" id="author" name="author" required><br><br>

                        <button type="submit" name="add_blog">Add Blog</button>
                    </form>
                </div>
                <div class="blogDelCon dashConSection" id="blogDelCon">
                    <h3>Manage Blogs</h3>
                    <table border="1" cellspacing="0" cellpadding="5">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Author</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($blogs as $blog): ?>
                                <tr>
                                    <td><?= htmlspecialchars($blog['id']); ?></td>
                                    <td><?= htmlspecialchars(substr($blog['title'],0,20)); ?></td>
                                    <td><?= htmlspecialchars(substr($blog['content'], 0, 50)) . "..."; ?></td>
                                    <td><?= htmlspecialchars($blog['author']); ?></td>
                                    <td>
                                        <!-- Delete Button -->
                                        <form method="POST" action="" onsubmit="return confirm('Are you sure you want to delete this blog?');">
                                            <input type="hidden" name="delete_blog_id" value="<?= $blog['id']; ?>">
                                            <button type="submit" name="delete_blog">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="addRoomCon dashConSection" id="addRoomCon">
                    <h3>Add Room</h3>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <label for="room_number">Room Number:</label><br>
                        <input type="text" name="room_number" id="room_number" required><br><br>

                        <label for="room_type">Room Type:</label>
                        <select name="room_type" id="room_type" required>
                            <option value="single">Single</option>
                            <option value="double">Double</option>
                            <option value="suite">Suite</option>
                        </select><br><br>

                        <label for="price">Price:</label><br>
                        <input type="number" name="price" id="price" required><br><br>

                        <label for="room_image">Room Image:</label><br>
                        <input type="file" name="room_image" id="room_image" accept="image/*" required><br><br>

                        <label for="description">Description:</label><br>
                        <textarea name="description" id="description" rows="5"></textarea><br><br>

                        <button type="submit" name="add_room" class="btn">Add Room</button>
                    </form>
                </div>
                <div class="listRoomCon dashConSection" id="listRoomCon">
                    <h3>All Rooms</h3>
                    <table border="1">
                        <thead>
                            <tr>
                                <th>Room Number</th>
                                <th>Type</th>
                                <th>Price</th>
                                <th>Availability</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rooms as $room): ?>
                            <tr>
                                <td><?= htmlspecialchars($room['room_number']); ?></td>
                                <td><?= htmlspecialchars($room['room_type']); ?></td>
                                <td>$<?= htmlspecialchars($room['price']); ?></td>
                                <td><?= $room['availability'] ? 'Available' : 'Booked'; ?></td>
                                <td>
                                    <form method="POST" action="">
                                        <input type="hidden" name="room_id" value="<?= $room['room_id']; ?>">
                                        <button type="submit" name="delete_room">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </section>

    <script src="./dashboardScript.js"></script>
</body>
</html>
