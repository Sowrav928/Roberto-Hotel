<?php
session_start();
include('bd.php');
include('font.php');
include('header.php');


$username = '';
$password = '';
$confirm_password = '';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate passwords
    if ($password !== $confirm_password) {
        echo "Passwords do not match!";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if username already exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "Username already taken!";
        } else {
            // Insert new user
            $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            $stmt->execute([$username, $hashed_password, 'user']);
            echo "Registration successful!";
            header('Location: login.php');  // Redirect to login page after successful registration
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rgister - Roberto - Hotel & Resort</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>

    <section>
        <div class="register-form">
            <div class="container register-container">
                <div class="registationTitle">
                    <h3>Rgister Here</h3>
                </div>
                    <form action="register.php" method="POST">
                        <label for="username">Username:</label>
                        <input type="text" name="username" required value="<?php echo htmlspecialchars($username); ?>">  
                        <label for="password">Password:</label>
                        <input type="password" name="password" required value="<?php echo htmlspecialchars($password); ?>"> 
                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" name="confirm_password" required value="<?php echo htmlspecialchars($confirm_password); ?>">

                        <div class="btnGroup" style="gap:20px;">
                            <button type="reset" name="register" class="btn">Clear Data</button>
                            <button type="submit" name="register" class="btn">Register</button>
                        </div>
                    </form>
                
                <div class="registerAndLogin">
                    <p>Already register, then <a href="./login.php">login</a></p>
                </div>
            </div>
        </div>
    </section>

    <script>
        window.onload = function() {
            document.querySelector('button[type="reset"]').click();
            console.log("Clicked");
        };
    </script>

</body>
</html>

<?php include('footer.php') ?>