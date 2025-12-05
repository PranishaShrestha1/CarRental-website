<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin'])==0) {    
    header('location:index.php');
    exit();
}

if(isset($_GET['file'])) {
    $filePath = urldecode($_GET['file']);
    
    // Security check - prevent directory traversal
    $realBase = realpath('admin/uploads/documents/');
    $realPath = realpath($filePath);
    
    if($realPath === false || strpos($realPath, $realBase) !== 0) {
        die('Invalid file path');
    }
    
    // Check if file exists
    if(file_exists($filePath)) {
        $filename = basename($filePath);
        $filetype = mime_content_type($filePath);
        $filesize = filesize($filePath);
        
        // Set headers
        header("Content-Type: $filetype");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Length: $filesize");
        
        // Clear output buffer
        ob_clean();
        flush();
        
        // Read the file
        readfile($filePath);
        exit;
    } else {
        header("HTTP/1.0 404 Not Found");
        echo "File not found.";
    }
} else {
    header("HTTP/1.0 400 Bad Request");
    echo "No file specified.";
}
?>