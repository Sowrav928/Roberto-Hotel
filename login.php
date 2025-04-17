<?php
session_start();  

include('db.php'); 
include('header.php'); 



// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];  
    $password = $_POST['password'];  

    // Query the database to check if the username exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);



    // If user exists and password matches
    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];  
        $_SESSION['username'] = $user['username'];  
        $_SESSION['role'] = $user['role'];  

        // Redirect to dashboard (no output before this)
        header('Location: dashboard.php');
        exit();  
    } else {
        $error_message = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>

<section>
        <div class="login-form">
            <div class="container login-container">
                <div class="loginTitle">
                    <h3>Rgister Here</h3>
                </div>
                    <form action="login.php" method="POST">
                        <label for="username">Username:</label>
                        <input type="text" name="username" placeholder="Username" required>  
                        <label for="password">Password:</label>
                        <input type="password" name="password" placeholder="Password" required>
                        
                        <div class="btnGroup" style="gap:20px;">
                            <button type="reset" name="login" class="btn">Clear Data</button>
                            <button type="submit" name="login" class="btn">login</button>
                        </div>
                    </form>
                
                <div class="registerAndLogin">
                    <p>Already have an account, then <a href="./login.php">login</a></p>
                </div>
            </div>
        </div>
    </section>


<?php
// Display error message if login fails
if (isset($error_message)) {
    echo "<p style='color: red;'>$error_message</p>";
}
?>

<!-- <form method="POST" action="login.php">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form> -->

</body>
</html>



<?php include('footer.php'); ?>