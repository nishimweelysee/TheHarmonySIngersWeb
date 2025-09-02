<?php
// Test script to verify PHP upload limits
echo "<h1>PHP Upload Limits Test</h1>";
echo "<p>This page shows the current PHP configuration for file uploads.</p>";

echo "<h2>Current PHP Settings:</h2>";
echo "<ul>";
echo "<li><strong>upload_max_filesize:</strong> " . ini_get('upload_max_filesize') . "</li>";
echo "<li><strong>post_max_size:</strong> " . ini_get('post_max_size') . "</li>";
echo "<li><strong>max_execution_time:</strong> " . ini_get('max_execution_time') . "</li>";
echo "<li><strong>max_input_time:</strong> " . ini_get('max_input_time') . "</li>";
echo "<li><strong>memory_limit:</strong> " . ini_get('memory_limit') . "</li>";
echo "<li><strong>max_file_uploads:</strong> " . ini_get('max_file_uploads') . "</li>";
echo "<li><strong>file_uploads:</strong> " . (ini_get('file_uploads') ? 'On' : 'Off') . "</li>";
echo "</ul>";

echo "<h2>Server Information:</h2>";
echo "<ul>";
echo "<li><strong>PHP Version:</strong> " . phpversion() . "</li>";
echo "<li><strong>Server Software:</strong> " . $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' . "</li>";
echo "<li><strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown' . "</li>";
echo "</ul>";

echo "<h2>Test File Upload Form:</h2>";
echo '<form action="test-upload-limits.php" method="post" enctype="multipart/form-data">';
echo '<input type="file" name="test_file" required>';
echo '<input type="submit" value="Test Upload">';
echo '</form>';

if ($_FILES && isset($_FILES['test_file'])) {
    echo "<h2>Upload Test Results:</h2>";
    $file = $_FILES['test_file'];
    echo "<ul>";
    echo "<li><strong>File Name:</strong> " . $file['name'] . "</li>";
    echo "<li><strong>File Size:</strong> " . number_format($file['size'] / 1024 / 1024, 2) . " MB</li>";
    echo "<li><strong>File Type:</strong> " . $file['type'] . "</li>";
    echo "<li><strong>Upload Status:</strong> " . ($file['error'] === UPLOAD_ERR_OK ? 'Success' : 'Error: ' . $file['error']) . "</li>";
    echo "</ul>";
}
