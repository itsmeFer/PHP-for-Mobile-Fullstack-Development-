<?php
header('Content-Type: application/json');

// Connect to database
$conn = new mysqli('localhost', 'root', '', 'tes');

// Check connection
if ($conn->connect_error) {
    die(json_encode(array("success" => false, "message" => "Connection failed: " . $conn->connect_error)));
}

if(isset($_POST['username']) && isset($_POST['tanggal_lahir']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['no_hp'])) {
    $username = $_POST['username'];
    $tglLahir = $_POST['tanggal_lahir'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];

    // Insert user into database with current timestamp
    $sql = "INSERT INTO users (username, tanggal_lahir, password, email, no_hp, register_datetime) VALUES ('$username', '$tglLahir', '$password', '$email', '$no_hp', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("success" => true, "message" => "User registered successfully"));
    } else {
        echo json_encode(array("success" => false, "message" => "Error: " . $sql . "<br>" . $conn->error));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Username, password, email, date of birth, or phone number not provided"));
}


$conn->close();
?>
