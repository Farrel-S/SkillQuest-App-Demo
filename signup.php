<?php
require "db.php";
require "google_config.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"] ?? "";
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";

    if (!$username || !$email || !$password) {
        $error = "All fields are required.";
    } else {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hash);

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header("Location: signin.php?registered=1");
            exit();
        } else {
            $error = "Email or username already exists.";
        }
        $stmt->close();
    }
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
                <div id="googleSignInButton" class="social-icon google-button"></div>
            </div>

            <div class="google-alert" style="margin-top:12px;"></div>
        </div>    
    </div>

    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="Scripts/GoogleSignInManager.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const alertBox = document.querySelector(".google-alert");

            new GoogleSignInManager()
                .ElementID("googleSignInButton")
                .ClientID("<?php echo htmlspecialchars(GOOGLE_CLIENT_ID, ENT_QUOTES, "UTF-8"); ?>")
                .CheckTokenURL("google_token.php")
                .FailURL("signup.php?google=fail", (data) => {
                    if (alertBox) {
                        const message = data?.message || "Google sign-in failed. Please try again.";
                        alertBox.innerHTML = `<p style=\"color:red;\">${message}</p>`;
                    }
                })
                .SuccessURL("home.php", (data) => {
                    if (data?.status === "success") {
                        window.location.href = data.redirect || "home.php";
                        return;
                    }

                    if (alertBox) {
                        const message = data?.message || "Google sign-in failed. Please try again.";
                        alertBox.innerHTML = `<p style=\"color:red;\">${message}</p>`;
                    }
                })
                .ButtonConfig({
                    type: "standard",
                    theme: "ouline",
                    text: "continue_with",
                    logo_alignment: "center",
                    size: "large",
                    width: 313
                });
        });
    </script>
</body>
</html>
