<?php
session_start();

// Check if the form is submitted
if (isset($_POST['login'])) {
    include 'db_connect.php';

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $email = $_POST['email']; // Email from form
    $password = $_POST['password']; // Password from form

    // Use prepared statement to prevent SQL injection
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email); // 's' specifies the type (string)
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username']; // Store session data for username
            $_SESSION['email'] = $user['email']; // Store session data for email
            header("Location: profile.php"); // Redirect to profile page after successful login
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "User not found. Please sign up first.";
    }

    $stmt->close();
    $conn->close();
}
?>
