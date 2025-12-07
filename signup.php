<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillQuest - Sign In</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="Styles/singuppage.css">


</head>
<body>
    <div class="content-wrapper"> 
        <a href="index.php"><img class="back-btn" src="Images/back.png" alt="back button"></a>
        <h1>Create</h1>
        <h1>Account.</h1>
        <p class="subheading">Start your journey.</p>
        <div class="ui-wrapper">  
            <form class="signup-form" action="#" method="post">
                <label for="signup">Full Name</label>
                <input type="text" name="username" placeholder="Username" required>
                <label for="signup">Email</label>
                <input type="email" name="email" placeholder="yourname@email.com" required>
                <label for="signup">Password</label>
                <input type="password" name="password" placeholder="Password" required>
                <label for="signup">Phone Number</label>
                <input type="tel" name="phone" placeholder="eg: 123456789" required>
                <label for="signup">Birthday Date</label>
                <input type="date" name="birthday" required>
                <checkbox-group>
                        <input type="checkbox" name="terms" required>
                        <label>I agree to the Terms and Conditions</label>
                </checkbox-group>
            </form>
            <button type="submit"class ="button">Sign Up</button>
            <div class=" sign-up-container">
                <p>Already have an account?</p>
                <a href="signin.php">Sign In</a>
            </div> 
            <div class="divider">
                <svg width="400" height="11px">
                    <rect x="10" y="10" width="136" height="1px" stroke="White" stroke-width="1px" fill="blue" />
                </svg>
                <p class="other-signup">Sign Up With</p>
                <svg width="400" height="11px">
                    <rect x="10" y="10" width="136" height="1px" stroke="White" stroke-width="1px" fill="blue" />
                </svg>
            </div>
            <div class="social-icons">
                <img class="social-icon-apple" src="Images/apple.png" alt="Apple Sign Up">
                <img class="social-icon" src="Images/facebook.png" alt="Facebook Sign Up">
                <img class="social-icon" src="Images/google.png" alt="Google Sign Up">
                <img class="social-icon" src="Images/twitter.png" alt="Twitter Sign Up">
            </div>
        </div>    
    </div>
</body>
</html>