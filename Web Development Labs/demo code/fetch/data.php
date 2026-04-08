<?php
/**
 * Server-side handler for Modern Fetch Example
 * Matches the 'application/json' POST request from simpleajax.js
 */

// 1. Set the response header to JSON
header('Content-Type: application/json; charset=utf-8');

// 2. Get the raw POST data (since fetch sent JSON)
$json = file_get_contents('php://input');

// 3. Decode the JSON into a PHP object
$data = json_decode($json);

// Check if decoding failed
if ($json && !$data) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid JSON provided.']);
    exit;
}

// 4. Extract credentials
$user = $data->name ?? null;
$pass = $data->pwd ?? null;

// 5. Basic Validation & Logic
if (!$user || !$pass) {
    http_response_code(400); // Bad Request
    echo json_encode(['message' => 'Missing username or password.']);
    exit;
}

// --- MOCK AUTHENTICATION LOGIC ---
// In a real app, you would check a database here (e.g., password_verify)
if ($user === 'admin' && $pass === 'password123') {
    
    // Success response
    echo json_encode([
        'status' => 'success',
        'message' => 'Login successful!',
        'user' => [
            'id' => 101,
            'name' => 'admin',
            'role' => 'Administrator',
            'last_login' => date('Y-m-d H:i:s')
        ]
    ]);

} else {
    // 6. Error handling (Unauthorized)
    http_response_code(401);
    echo json_encode(['message' => 'Invalid username or password.']);
}