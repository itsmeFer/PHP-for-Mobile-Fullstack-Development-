<?php
header('Content-Type: application/json');

// Connect to database
$conn = new mysqli('localhost', 'root', '', 'tes');

// Check connection
if ($conn->connect_error) {
    die(json_encode(array("success" => false, "message" => "Connection failed: " . $conn->connect_error)));
}

// Check if userId is provided
if(isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    // Fetch username from database
    $sql = "SELECT username FROM users WHERE id='$userId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $username = $user['username'];

        echo json_encode(array("success" => true, "username" => $username));
    } else {
        echo json_encode(array("success" => false, "message" => "User not found"));
    }
} else {
    echo json_encode(array("success" => false, "message" => "userId not provided"));
}

$conn->close();
?>
