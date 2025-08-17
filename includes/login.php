<?php
header('Content-Type: application/json');
session_start();
require "./database_connect.php";

$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($email) || empty($password)) {
    echo json_encode(["success" => false, "message" => "Please enter both email and password."]);
    exit;
}

$password_hashed = sha1($password);

$sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password_hashed'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo json_encode(["success" => false, "message" => "Something went wrong. Please try again later."]);
    exit;
}

if (mysqli_num_rows($result) === 0) {
    echo json_encode(["success" => false, "message" => "Invalid email or password. Please try again."]);
    exit;
}

$data = mysqli_fetch_assoc($result);
$_SESSION['user_id'] = $data['id'];
$_SESSION['name'] = $data['name'];
$_SESSION['email'] = $data['email'];

echo json_encode(["success" => true, "message" => "Login successful! Redirecting..."]);
mysqli_close($conn);
?>
