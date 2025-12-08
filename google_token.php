<?php
// Verify Google ID token, create/fetch user, and start a session.
header("Content-Type: application/json");

session_start();
require_once __DIR__ . "/db.php";
require_once __DIR__ . "/google_config.php";
require_once __DIR__ . "/class_glogin.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    exit;
}

$token = $_POST['token'] ?? null;
if (!$token) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Token not provided']);
    exit;
}

try {
    $googleLogin = new GoogleLoginStandalone(GOOGLE_CLIENT_ID);
    $userData = $googleLogin->verify($token);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Google verification failed']);
    exit;
}

if (!$userData || empty($userData['email']) || empty($userData['email_verified'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Invalid or unverified Google account']);
    exit;
}

$email = $userData['email'];
$firstName = $userData['first_name'] ?? '';
$lastName = $userData['last_name'] ?? '';
$fullName = trim($firstName . ' ' . $lastName) ?: ($userData['full_name'] ?? '');
$usernameBase = $fullName ?: ($email ? explode('@', $email)[0] : 'google_user');

// Ensure a unique username to satisfy the UNIQUE constraint.
function sq_make_unique_username(mysqli $conn, string $base): string {
    $candidate = $base;
    $suffix = 1;
    $stmt = $conn->prepare('SELECT 1 FROM users WHERE username = ? LIMIT 1');
    
    while (true) {
        $stmt->bind_param('s', $candidate);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 0) {
            $stmt->close();
            return $candidate;
        }
        $candidate = $base . '_' . $suffix++;
    }
}

$username = sq_make_unique_username($conn, $usernameBase);

// Check if user already exists by email.
$existing = $conn->prepare("SELECT id, username FROM users WHERE email = ? LIMIT 1");
if ($existing) {
    $existing->bind_param("s", $email);
    $existing->execute();
    $existing->bind_result($userId, $existingUsername);
    if ($existing->fetch()) {
        $_SESSION["user_id"] = $userId;
        $_SESSION["username"] = $existingUsername;
        echo json_encode(["status" => "success", "redirect" => "home.php"]);
        $existing->close();
        exit;
    }
    $existing->close();
}

// Create a new user with a random password (unused but required by schema).
$randomPassword = bin2hex(random_bytes(12));
$hash = password_hash($randomPassword, PASSWORD_BCRYPT);
$displayName = $fullName ?: $username;

$newUser = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
if (!$newUser) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Database error: prepare failed"]);
    exit;
}

$newUser->bind_param("sss", $username, $email, $hash);
if (!$newUser->execute()) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Database error: save failed"]);
    $newUser->close();
    exit;
}

$userId = $newUser->insert_id;
$newUser->close();

$_SESSION["user_id"] = $userId;
$_SESSION["username"] = $displayName;

echo json_encode(["status" => "success", "redirect" => "home.php"]);
