<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

$host = "webdev.aut.ac.nz";
$user = "vpk8065";
$pswd = "bipkwbkbrwxrkaideuypiuymaknirpir";
$dbnm = "vpk8065";

$conn = mysqli_connect($host, $user, $pswd, $dbnm);


if (!$conn) {
    echo json_encode([
        "success" => false,
        "message" => "Database connection failed."
    ]);
    exit;
}


$bookingRef = $_POST["booking_ref"] ?? "";


if (empty($bookingRef)) {
    echo json_encode([
        "success" => false,
        "message" => "Booking reference is required."
    ]);
    exit;
}


$sql = "SELECT booking_ref, cname, phone, sbname, dsbname, pickup_date, pickup_time, status, driver_id
        FROM bookings
        WHERE booking_ref = ?";

$stmt = mysqli_prepare($conn, $sql);


mysqli_stmt_bind_param($stmt, "s", $bookingRef);


mysqli_stmt_execute($stmt);


$result = mysqli_stmt_get_result($stmt);


if ($row = mysqli_fetch_assoc($result)) {
    echo json_encode([
        "success" => true,
        "booking" => $row
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "No booking found with reference number $bookingRef."
    ]);
}

mysqli_close($conn);

?>