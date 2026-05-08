<?php

// used for debugging problems in the booking system.
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Tells the browser that this PHP file will return JSON data.
header("Content-Type: application/json");

// Database Server
$host = "webdev.aut.ac.nz"; // hostname
$user = "vpk8065"; // username
$pswd = "bipkwbkbrwxrkaideuypiuymaknirpir"; // password
$dbnm = "vpk8065"; // database name

// Create connection to MySQL database
$conn = new mysqli($host, $user, $pswd, $dbnm);

// check if the database connection failed
if ($conn->connect_error) {

    // return error message in JSON format
    echo json_encode([
        "success" => false,
        "message" => "Database connection failed"
    ]);
    exit;
}

// Gets each form input sent from JavaScript
// If the input does not exist, assign an empty string instead.
$cname = $_POST["cname"] ?? "";
$phone = $_POST["phone"] ?? "";
$unumber = $_POST["unumber"] ?? "";
$snumber = $_POST["snumber"] ?? "";
$stname = $_POST["stname"] ?? "";
$sbname = $_POST["sbname"] ?? "";
$dsbname = $_POST["dsbname"] ?? "";
$date = $_POST["date"] ?? "";
$time = $_POST["time"] ?? "";

// validates each input fields should be filled in.
if (
    empty($cname) ||
    empty($phone) ||
    empty($snumber) ||
    empty($stname) ||
    empty($date) ||
    empty($time)
) {
    echo json_encode([
        "success" => false,
        "message" => "Please fill in all required fields."
    ]);
    exit;
}

// validates phone length is should be 10-12 digits only, throws an error message
if (!preg_match("/^[0-9]{10,12}$/", $phone)) {
    echo json_encode([
        "success" => false,
        "message" => "Phone number must be 10 to 12 digits."
    ]);
    exit;
}

// validate date and time format

// Combines the date and time entered bt the user
// into one DateTime object.
$pickupDateTime = DateTime::createFromFormat("d/m/Y H:i", $date . " " . $time);

// check if the date/time format is invalid
if (!$pickupDateTime) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid date or time format."
    ]);
    exit;
}

// gets the current server date and time
$now = new DateTime();

// checks if pickup date/time is earlier than current time
if ($pickupDateTime < $now) {
    echo json_encode([
        "success" => false,
        "message" => "Pickup date and time must not be earlier than the current date and time."
    ]);
    exit;
}

// converts pickup date int MySQL DATE format
$mysqlDate = $pickupDateTime->format("Y-m-d");

// convers pickup time into MySQL TIME format
$mysqlTime = $pickupDateTime->format("H:i:s");

// stores the current booking creation date/time
$bookingDateTime = date("Y-m-d H:i:s");

// initial booking status
$status = "unassigned";

// sql query to insert booking information into database
$sql = "INSERT INTO bookings 
        (cname, phone, unumber, snumber, stname, sbname, dsbname, pickup_date, pickup_time, booking_datetime, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Prepares SQL statement for secure execution
$stmt = $conn->prepare($sql);

// Bind vairables to SQL placeholders (?)
// "s" means all values are strings.
$stmt->bind_param(
    "sssssssssss",
    $cname,
    $phone,
    $unumber,
    $snumber,
    $stname,
    $sbname,
    $dsbname,
    $mysqlDate,
    $mysqlTime,
    $bookingDateTime,
    $status
);

// execute insert query
if ($stmt->execute()) {

    // gets the auto-generated booking ID
    $id = $conn->insert_id;

    // ==================================================
    // GENERATE BOOKING REFERENCE NUMBER
    // ==================================================

    // Example:
    // booking_id = 1
    // becomes:
    // BRN00001

    $bookingReference = "BRN" . str_pad($id, 5, "0", STR_PAD_LEFT);


    // update booking reference in database
    $updateSql = "UPDATE bookings SET booking_ref = ? WHERE booking_id = ?";

    $updateStmt = $conn->prepare($updateSql);

    // "s" = string
    // "i" = integer
    $updateStmt->bind_param("si", $bookingReference, $id);

    $updateStmt->execute();

    // send success response back to javascript
    echo json_encode([
        "success" => true,
        "message" => "Thank you for your booking!",
        "reference" => $bookingReference,
        "pickup_time" => $pickupDateTime->format("H:i"),
        "pickup_date" => $pickupDateTime->format("d/m/Y")
    ]);
} else {

    // insert failed
    echo json_encode([
        "success" => false,
        "message" => "Booking could not be saved."
    ]);
}

// closes database
$conn->close();
?>