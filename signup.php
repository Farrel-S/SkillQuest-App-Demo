<?php
require "db.php";

$error = "";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }

    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        header("Location: signin.php?registered=1");
        exit();
    } else {
        $error = "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SkillQuest - Sign Up</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="Styles/signuppage.css">
</head>
<body>
    <div class="content-wrapper"> 
        <a href="index.php"><img class="back-btn" src="Images/back.png" alt="back button"></a>
        <h1>Create</h1>
        <h1>Account.</h1>
        <p class="subheading">Start your journey.</p>

        <?php if ($error): ?>
        <p style="color:red;"><?= $error ?></p>
        <?php endif; ?>

        <div class="ui-wrapper">  
            <form class="signup-form" action="signup.php" method="POST">
                <label>Full Name</label>
                <input type="text" name="username" placeholder="Username" required>

                <label>Email</label>
                <input type="email" name="email" placeholder="yourname@email.com" required>

                <label>Password</label>
                <input type="password" name="password" placeholder="Password" required>

                <label>Phone Number</label>
                <input type="number" name="phone" placeholder="eg: 123456789" required>

                <label>Birthday</label>
                <input type="date" name="birthday" required>

                <checkbox-group>
                    <input type="checkbox" name="terms" required>
                    <label>I agree to the Terms and Conditions</label>
                </checkbox-group>

                <button type="submit" class="submit-btn">Sign Up</button>
            </form>

            <div class="sign-up-container">
                <p>Already have an account?</p>
                <a href="signin.php">Sign In</a>
            </div>

            <div class="divider">
                <svg width="400" height="11px">
                    <rect x="10" y="10" width="136" height="1px" stroke="White" stroke-width="1px" fill="blue" />
                </svg>

                <p class="other-signin">Sign In With</p>

                <svg width="400" height="11px">
                    <rect x="10" y="10" width="136" height="1px" stroke="White" stroke-width="1px" fill="blue" />
                </svg>
            </div>
            
            <div class="social-icons">
                <img class="social-icon-apple" src="Images/apple.png" alt="Apple Sign In">
                <img class="social-icon" src="Images/facebook.png" alt="Facebook Sign In">
                <img class="social-icon" src="Images/google.png" alt="Google Sign In">
                <img class="social-icon" src="Images/twitter.png" alt="Twitter Sign In">
            </div>
        </div>    
    </div>
</body>
</html>
