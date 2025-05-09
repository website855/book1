<?php
include 'db_connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch admin booking data
$sql = "SELECT * FROM admin";
$result = $conn->query($sql);

$adminBookings = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $adminBookings[] = $row;
    }
}

// Return admin bookings as JSON
echo json_encode($adminBookings);

// Close connection
$conn->close();
?>
