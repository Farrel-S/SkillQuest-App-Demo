<?php
require "db.php";
session_start();

$login_error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $full_name, $hash);
        $stmt->fetch();

        if (password_verify($password, $hash)) {
            $_SESSION["user_id"] = $id;
            $_SESSION["username"] = $full_name;

            header("Location: home.php");
            exit();
        } else {
            $login_error = "Incorrect password.";
        }
    } else {
        $login_error = "No user found with that email.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SkillQuest - Sign In</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="Styles/signinpage.css">
</head>
<body>
    <div class="content-wrapper"> 
        <a href="index.php"><img class="back-btn" src="Images/back.png" alt="back button"></a>
        <h1>Welcome</h1>
        <h1>Back.</h1>
        <p class="subheading">Continue your adventure.</p>

        <?php if ($login_error): ?>
        <p style="color:red;"><?= $login_error ?></p>
        <?php endif; ?>

        <?php if (isset($_GET["registered"])): ?>
        <p style="color:green;">Account created successfully! Please sign in.</p>
        <?php endif; ?>

        <div class="ui-wrapper">  
            <form class="signin-form" action="signin.php" method="POST">
                <label>Email</label>
                <input type="email" name="email" placeholder="yourname@email.com" required>

                <label>Password</label>
                <input type="password" name="password" placeholder="Password" required>
                
                <checkbox-group>
                    <input type="checkbox" name="remember">
                    <label>Remember Me</label>
                </checkbox-group>

                <button type="submit" class="button">Sign In</button>
            </form>

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
