<?php


header('Content-Type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "webdev.aut.ac.nz";
$user = "vpk8065";
$pswd = "bipkwbkbrwxrkaideuypiuymaknirpir";
$dbnm = "vpk8065";


$conn = new mysqli($host, $user, $pswd, $dbnm);


if ($conn->connect_error) {
    echo json_encode([
        "success" => false,
        "message" => "Database connection failed"
    ]);
    exit;
}


$cname  = $_POST["cname"]  ?? "";
$phone  = $_POST["phone"]  ?? "";
$unumber = $_POST["unumber"] ?? "";
$snumber = $_POST["snumber"] ?? "";
$stname  = $_POST["stname"]  ?? "";
$sbname = $_POST["sbname"] ?? "";
$dsbname = $_POST["dsbname"] ?? "";
$date   = $_POST["date"]   ?? "";
$time   = $_POST["time"]   ?? "";

// Validates required fields
if (
    empty($cname) ||
    empty($phone) ||
    empty($date) ||
    empty($time)
) {
    echo json_encode([
        "success" => false,
        "message" => "Please fill in all required fields."
    ]);
    exit;
}


if (!preg_match("/^[0-9]{10,12}$/", $phone)) {
    echo json_encode([
        "success" => false,
        "message" => "Phone number must be 10 to 12 digits."
    ]);
    exit;
}


$pickupDateTime = DateTime::createFromFormat("d/m/Y H:i", $date . " " . substr($time, 0, 5));


if (!$pickupDateTime) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid date or time format."
    ]);
    exit;
}

// Checks if pickup date/time is earlier than current time
$now = new DateTime();
if ($pickupDateTime < $now) {
    echo json_encode([
        "success" => false,
        "message" => "Pickup date and time must not be earlier than the current date and time."
    ]);
    exit;
}

$mysqlDate     = $pickupDateTime->format("Y-m-d");
$mysqlTime     = $pickupDateTime->format("H:i");
$bookingDateTime = date("Y-m-d H:i:s");
$status        = "unassigned";


$sql = "INSERT INTO bookings
        (cname, phone, unumber, snumber, stname, sbname, dsbname, pickup_date, pickup_time, booking_datetime, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
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

if ($stmt->execute()) {
    $id = $conn->insert_id;

    $bookingReference = "BRN" . str_pad($id, 5, "0", STR_PAD_LEFT);

    $updateStmt = $conn->prepare("UPDATE bookings SET booking_ref = ? WHERE booking_id = ?");
    $updateStmt->bind_param("si", $bookingReference, $id);
    $updateStmt->execute();

    echo json_encode([
        "success"     => true,
        "message"     => "Thank you for your booking!",
        "reference"   => $bookingReference,
        "pickup_time" => $pickupDateTime->format("H:i"),
        "pickup_date" => $pickupDateTime->format("d/m/Y")
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Booking could not be saved."
    ]);
}

$conn->close();
?>
