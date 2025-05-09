<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "turfmaster";

// Establish database connection
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all booking records
$sql = "SELECT * FROM bookings";
$result = $conn->query($sql);

// Check if query was successful
if (!$result) {
    echo json_encode(['error' => 'Query failed: ' . $conn->error]);
    exit();
}

if ($result->num_rows > 0) {
    $bookings = [];
    while($row = $result->fetch_assoc()) {
        $bookings[] = $row; // Store each row in an array
    }
    // Return the result as a JSON object
    echo json_encode($bookings);
} else {
    // No bookings found
    echo json_encode([]);
}

$conn->close();
?>
