<?php
require "../includes/database_connect.php";

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$re_password = $_POST['confirm-password'];

if($password != $re_password){
echo json_encode(array("success"=> false, "message"=> "Password not matched!"));
exit;
}
else {
    $password = sha1($password);
    $sql = "SELECT * FROM users where email = '$email'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $response = array("success" => false, "message" => "Something went wrong!");
        echo json_encode($response);
        return;
    }
    $row_count = mysqli_num_rows($result);
    if ($row_count != 0) {
        $response = array("success" => false, "message" => "This email is already registered with us!");
        echo json_encode($response);
        return;
    }
    $sql_2 = "INSERT INTO users (name, email, password) values ('$name', '$email', '$password')";
    $result_2 = mysqli_query($conn, $sql_2);
    if (!$result_2) {
        $response = array("success" => false, "message" => "Something went wrong!");
        echo json_encode($response);
        return;
    }
    $response = array("success" => true, "message" => "Your account has been created successfully! You can now log in to get started.");
    echo json_encode($response);
}

mysqli_close($conn);

?>
