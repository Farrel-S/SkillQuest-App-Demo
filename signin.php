<?php
require "db.php";
require "google_config.php";
session_start();

$login_error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $stmt->close();
            $conn->close();
            header("Location: home.php");
            exit();
        } else {
            $login_error = "Incorrect password.";
        }
    } else {
        $login_error = "No user found with that email.";
    }
    $stmt->close();
}
$conn->close();
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
        <p style="color:red;"><?= htmlspecialchars($login_error, ENT_QUOTES, "UTF-8") ?></p>
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

                <button id="signin-submit" type="submit" class="button">Sign In</button>
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
                .FailURL("signin.php?google=fail", (data) => {
                    if (alertBox) {
                        const message = data?.message || "Google sign-in failed. Please try again.";
                        alertBox.innerHTML = `<p style="color:red;">${message}</p>`;
                    }
                })
                .SuccessURL("home.php", (data) => {
                    if (data?.status === "success") {
                        window.location.href = data.redirect || "home.php";
                        return;
                    }

                    if (alertBox) {
                        const message = data?.message || "Google sign-in failed. Please try again.";
                        alertBox.innerHTML = `<p style="color:red;">${message}</p>`;
                    }
                })
                .ButtonConfig({
                    type: "standard",
                    theme: "outline",
                    text: "sign_in_with",
                    logo_alignment: "center",
                    size: "large",
                    width: 313,
                });
        });
    </script>
    <script src="Scripts/audiomanager.js"></script>
</body>
</html>
