<?php
header('Content-Type: application/json');

// Connect to database
$conn = new mysqli('localhost', 'root', '', 'tes');

// Check connection
if ($conn->connect_error) {
    die(json_encode(array("success" => false, "message" => "Connection failed: " . $conn->connect_error)));
}

// Check if email and password are provided
if(isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Log the received data for debugging
    file_put_contents('debug_log.txt', "Received email: $email\nReceived Password: $password\n", FILE_APPEND);

    // Fetch user from database
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $userId = $user['id'];

        // Update login datetime and statuslogin
        $update_login_sql = "UPDATE users SET logindatetime = NOW(), statuslogin = TRUE WHERE id='$userId'";
        $conn->query($update_login_sql);

        echo json_encode(array("success" => true, "message" => "Login successful", "userId" => $userId));
    } else {
        echo json_encode(array("success" => false, "message" => "Incorrect email or password"));
    }
} else {
    echo json_encode(array("success" => false, "message" => "email or password not provided"));
}

$conn->close();
?>
