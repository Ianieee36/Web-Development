<?php

/**
 * File: admin.php
 * Student : Christian Danielle B. Cantos || 23188023
 * Description: returns JSON to admin.js, and return and displays
 * booking requests information. 
 */

// Displays PHP errors while developing/debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Tells the browser that this PHP file returns JSON data
header("Content-Type: application/json");

// Database connection details
$host = "webdev.aut.ac.nz";
$user = "vpk8065";
$pswd = "bipkwbkbrwxrkaideuypiuymaknirpir";
$dbnm = "vpk8065";

// Connects to the MySQL database
$conn = mysqli_connect($host, $user, $pswd, $dbnm);

// Checks if the database connection failed
if (!$conn) {
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

// Gets the action sent from admin.js
// Possible actions: search or assign
$action = $_POST["action"] ?? "";

// SEARCH BOOKING REQUESTS
if ($action === "search") {

    // Gets the booking reference entered by the admin
    $bsearch = $_POST["bsearch"] ?? "";

    // If admin enters a booking reference, search for that specific booking
    if ($bsearch !== "") {
        $sql = "SELECT booking_ref, cname, phone, sbname, dsbname, pickup_date, pickup_time, status
                FROM bookings
                WHERE booking_ref = ?";

        // Prepares SQL statement to prevent SQL injection
        $stmt = mysqli_prepare($conn, $sql);

        // Binds booking reference value to the SQL placeholder
        mysqli_stmt_bind_param($stmt, "s", $bsearch);
    } 
    
    // If search box is empty, show unassigned bookings within 2 hours from current time
    else {
        $sql = "SELECT booking_ref, cname, phone, sbname, dsbname, pickup_date, pickup_time, status
                FROM bookings
                WHERE status = 'unassigned'
                AND TIMESTAMP(pickup_date, pickup_time) BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 2 HOUR)";

        $stmt = mysqli_prepare($conn, $sql);
    }

    // Executes the search query
    mysqli_stmt_execute($stmt);

    // Gets the query result
    $result = mysqli_stmt_get_result($stmt);

    // Stores all booking records
    $bookings = [];

    // Adds each booking row into the bookings array
    while ($row = mysqli_fetch_assoc($result)) {
        $bookings[] = $row;
    }

    // Sends booking data back to admin.js as JSON
    echo json_encode($bookings);
}

// ASSIGN BOOKING REQUEST
if ($action === "assign") {

    // Gets the booking reference selected by the admin
    $reference = $_POST["reference"] ?? "";

    // Updates booking status from unassigned to assigned
    $sql = "UPDATE bookings
            SET status = 'assigned'
            WHERE booking_ref = ?";

    // Prepares SQL statement
    $stmt = mysqli_prepare($conn, $sql);

    // Binds booking reference to the SQL placeholder
    mysqli_stmt_bind_param($stmt, "s", $reference);

    // Executes the update query
    mysqli_stmt_execute($stmt);

    // Sends confirmation message back to admin.js
    echo json_encode([
        "message" => "Congratulations! Booking request $reference has been assigned!"
    ]);
}

// Closes database connection
mysqli_close($conn);
?>