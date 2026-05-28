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


$reference = $_POST["reference"] ?? "";


$driverId = $_POST["driver_id"] ?? "";


if (empty($reference) || empty($driverId)) {
    echo json_encode([
        "success" => false,
        "message" => "Booking reference and driver are required."
    ]);
    exit;
}


$sql = "UPDATE bookings
        SET status = 'assigned',
            driver_id = ?
        WHERE booking_ref = ?";


$stmt = mysqli_prepare($conn, $sql);


mysqli_stmt_bind_param($stmt, "ss", $driverId, $reference);


if (mysqli_stmt_execute($stmt)) {

    
    echo json_encode([
        "success" => true,
        "message" => "Booking request $reference has been assigned to driver $driverId."
    ]);
} else {

   
    echo json_encode([
        "success" => false,
        "message" => "Failed to assign booking."
    ]);
}


mysqli_close($conn);

?>