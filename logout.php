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

    // Update logout datetime and statuslogin
    $sql = "UPDATE users SET logoutdatetime = NOW(), statuslogin = FALSE WHERE id='$userId'";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("success" => true, "message" => "Logout successful"));
    } else {
        echo json_encode(array("success" => false, "message" => "Error updating record: " . $conn->error));
    }
} else {
    echo json_encode(array("success" => false, "message" => "userId not provided"));
}

$conn->close();
?>
