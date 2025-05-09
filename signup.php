<?php
include 'db_connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if passwords match
    if ($password != $confirmPassword) {
        echo "Passwords do not match!";
        exit;
    }

    // Hash the password before saving (for security reasons)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if user already exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "User with this email already exists.";
    } else {
        // Insert new user
        $sql = "INSERT INTO users (username, email, mobile, password) VALUES ('$username', '$email', '$mobile', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            echo "Signup successful! You can now login.";
            header("Location: login.html");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
