<?php
// save-image.php
header('Content-Type: application/json');

// Get the JSON data from the request
$imageData = file_get_contents('php://input');
$imageData = base64_decode($imageData);

// Check if image data is present
if (!isset($imageData) || empty($imageData)) {
    echo json_encode([
        'success' => false,
        'error' => 'No image data received'
    ]);
    exit;
}

// Folder to save images
$upload_dir = 'uploads/';

// Create the directory if it doesn't exist
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Generate a unique filename
$filename = 'image_' . date('Ymd_His') . '_' . uniqid() . '.jpg';
$filepath = $upload_dir . $filename;

// Save the image
if (file_put_contents($filepath, $imageData)) {
    echo json_encode([
        'success' => true,
        'filename' => $filename,
        'path' => $filepath
    ]);
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Failed to save image'
    ]);
}
?>