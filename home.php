<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    die("Access denied. Please <a href='signin.php'>sign in</a>.");
}

require 'db.php';

$stmt = $conn->prepare("SELECT id, username, email, created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    ?>
    <div class="user-info">
        <p>>User ID: <?php echo htmlspecialchars($user['id']); ?></p>
        <p>Username: <?php echo htmlspecialchars($user['username']); ?></p>
        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
        <p>Account Created: <?php echo htmlspecialchars($user['created_at']); ?></p>
    </div>
    <?php
} else {
    ?>
    <div class="error-message">
        <p>User not found.</p>
    </div>
    <?php
}

$stmt->close();
$conn->close();
?>
