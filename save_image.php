<?php
// save-image.php
header('Content-Type: application/json');

// Get the JSON data from the request
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

// Check if image data is present
if (!isset($data['image']) || empty($data['image'])) {
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

// Decode the base64 image data
$image_data = base64_decode($data['image']);

// Save the image
if (file_put_contents($filepath, $image_data)) {
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