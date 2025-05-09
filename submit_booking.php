<?php
include 'db_connect.php';

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$turfName = $_POST['turfName'];
$username = $_POST['username'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$date = $_POST['date'];
$time = $_POST['time'];
$hours = floatval($_POST['hours']); // make sure hours is float
$totalAmount = floatval($_POST['totalAmount']); // make sure totalAmount is float

// Prepare the SQL query to insert into bookings table (without total_amount)
$sqlBooking = "INSERT INTO bookings (turfname, username, email, mobile, date, time, hours) VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmtBooking = $conn->prepare($sqlBooking);

if (!$stmtBooking) {
    die("Prepare failed: " . $conn->error); // Debug if preparation fails
}

// Bind parameters correctly (ssssss) => all are strings except hours which is integer
$stmtBooking->bind_param("ssssssi", $turfName, $username, $email, $mobile, $date, $time, $hours);

// Execute the booking insertion statement
if ($stmtBooking->execute()) {
    // Now insert the total_amount into the admin table
    $sqlAdmin = "INSERT INTO admin (turfname, username, email, mobile, date, time, hours, device, total_amount) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $device = $_POST['device'] ?? '';  // Device selection, if any
    $stmtAdmin = $conn->prepare($sqlAdmin);

    if (!$stmtAdmin) {
        die("Prepare failed: " . $conn->error); // Debug if preparation fails
    }

    // Bind parameters for admin table (ssssssssd)
    $stmtAdmin->bind_param("ssssssssd", $turfName, $username, $email, $mobile, $date, $time, $hours, $device, $totalAmount);

    // Execute the admin insertion statement
    if ($stmtAdmin->execute()) {
        // Redirect to receipt page with query parameters
        $url = "receipt.html?" . 
               "turfName=" . urlencode($turfName) . 
               "&username=" . urlencode($username) . 
               "&email=" . urlencode($email) . 
               "&mobile=" . urlencode($mobile) . 
               "&date=" . urlencode($date) . 
               "&time=" . urlencode($time) . 
               "&hours=" . urlencode($hours) . 
               "&totalAmount=" . urlencode($totalAmount);

        echo "<script>window.location.href = '$url';</script>";
        exit();
    } else {
        echo "Error: " . $stmtAdmin->error;
    }

    $stmtAdmin->close();
} else {
    echo "Error: " . $stmtBooking->error;
}

// Close resources
$stmtBooking->close();
$conn->close();
?>
