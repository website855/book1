<?php
// Your booking logic here (e.g., storing data in a database)
// After the booking is successfully saved, redirect to the receipt page
if (isset($_POST['book'])) {
    // Example booking details (replace with actual form data)
    $turfName = "Grand City Futsal";
    $username = $_POST['username']; // Assuming 'username' field in the form
    $mobile = $_POST['mobile']; // Assuming 'mobile' field in the form
    $date = $_POST['date']; // Assuming 'date' field in the form
    $time = $_POST['time']; // Assuming 'time' field in the form
    $ampm = $_POST['ampm']; // Assuming 'ampm' field in the form
    $hours = $_POST['hours']; // Assuming 'hours' field in the form

    // Redirect to the receipt page with parameters
    header("Location: receipt.html?turfName=$turfName&username=$username&mobile=$mobile&date=$date&time=$time&ampm=$ampm&hours=$hours");
    exit();
}
?>
