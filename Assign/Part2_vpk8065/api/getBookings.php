<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$host = "webdev.aut.ac.nz";
$user = "vpk8065";
$pswd = "bipkwbkbrwxrkaideuypiuymaknirpir";
$dbnm = "vpk8065";

$conn = mysqli_connect($host, $user, $pswd, $dbnm);

if (!$conn) {
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

$bsearch = $_POST["bsearch"] ?? "";

if ($bsearch !== "") {
    $sql = "SELECT booking_ref, cname, phone, sbname, dsbname, pickup_date, pickup_time, status
            FROM bookings WHERE booking_ref = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $bsearch);
} 
else {
        $sql = "SELECT booking_ref, cname, phone, sbname, dsbname, pickup_date, pickup_time, status
                FROM bookings
                WHERE status = 'unassigned'
                AND TIMESTAMP(pickup_date, pickup_time) BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 2 HOUR)";

        $stmt = mysqli_prepare($conn, $sql);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$bookings = [];
while ($row = mysqli_fetch_assoc($result)) {
    $bookings[] = $row;
}

echo json_encode($bookings);

mysqli_close($conn);
?>