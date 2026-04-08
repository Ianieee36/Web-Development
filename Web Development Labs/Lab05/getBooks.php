<?php
// Show errors in development only — disable in production
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
session_start();

$host = "webdev.aut.ac.nz";
$user = "vpk8065";
$pswd = "bipkwbkbrwxrkaideuypiuymaknirpir";
$dbnm = "vpk8065";

$conn = new mysqli($host, $user, $pswd, $dbnm);

if ($conn->connect_error) {
    http_response_code(500);
    die(json_encode(["error" => "Database connection failed"]));
}

// Select only the columns you need — avoid SELECT *
$sql = "SELECT id, title, authors, isbn, price, cover FROM books";
$result = $conn->query($sql);

if ($result === false) {
    http_response_code(500);
    die(json_encode(["error" => "Query failed"]));
}

$books = [];
while ($row = $result->fetch_assoc()) {
    $books[] = $row;
}

echo json_encode($books);
$conn->close();
?>