<?php
// Test script specifically for media uploads
echo "<h1>Media Upload Test</h1>";
echo "<p>This page tests the media upload functionality and shows current PHP configuration.</p>";

// Check if we're in a Laravel context
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';

    // Bootstrap Laravel
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

    echo "<h2>Laravel Environment:</h2>";
    echo "<ul>";
    echo "<li><strong>App Environment:</strong> " . config('app.env') . "</li>";
    echo "<li><strong>App Debug:</strong> " . (config('app.debug') ? 'Yes' : 'No') . "</li>";
    echo "<li><strong>Storage Path:</strong> " . storage_path() . "</li>";
    echo "<li><strong>Public Storage:</strong> " . public_path('storage') . "</li>";
    echo "</ul>";
}

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
echo "<li><strong>Server Software:</strong> " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "</li>";
echo "<li><strong>Document Root:</strong> " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Unknown') . "</li>";
echo "<li><strong>Script Name:</strong> " . ($_SERVER['SCRIPT_NAME'] ?? 'Unknown') . "</li>";
echo "</ul>";

echo "<h2>Test Media Upload Form:</h2>";
echo '<form action="test-media-upload.php" method="post" enctype="multipart/form-data">';
echo '<div style="margin-bottom: 15px;">';
echo '<label for="test_file"><strong>Select a file to test upload:</strong></label><br>';
echo '<input type="file" name="test_file" id="test_file" required style="margin-top: 5px;">';
echo '</div>';
echo '<div style="margin-bottom: 15px;">';
echo '<label for="file_type"><strong>File Type:</strong></label><br>';
echo '<select name="file_type" id="file_type" style="margin-top: 5px;">';
echo '<option value="photo">Photo</option>';
echo '<option value="video">Video</option>';
echo '<option value="audio">Audio</option>';
echo '</select>';
echo '</div>';
echo '<input type="submit" value="Test Upload" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">';
echo '</form>';

if ($_FILES && isset($_FILES['test_file'])) {
    echo "<h2>Upload Test Results:</h2>";
    $file = $_FILES['test_file'];
    $fileType = $_POST['file_type'] ?? 'unknown';

    echo "<ul>";
    echo "<li><strong>File Name:</strong> " . htmlspecialchars($file['name']) . "</li>";
    echo "<li><strong>File Size:</strong> " . number_format($file['size'] / 1024 / 1024, 2) . " MB</li>";
    echo "<li><strong>File Type:</strong> " . htmlspecialchars($file['type']) . "</li>";
    echo "<li><strong>Selected Media Type:</strong> " . htmlspecialchars($fileType) . "</li>";
    echo "<li><strong>Upload Status:</strong> ";

    if ($file['error'] === UPLOAD_ERR_OK) {
        echo '<span style="color: green;">Success</span>';

        // Test if we can move the file to a test location
        $testDir = __DIR__ . '/test-uploads';
        if (!is_dir($testDir)) {
            mkdir($testDir, 0755, true);
        }

        $testPath = $testDir . '/' . time() . '_' . $file['name'];
        if (move_uploaded_file($file['tmp_name'], $testPath)) {
            echo ' - File moved successfully to test location';
            // Clean up test file
            unlink($testPath);
        } else {
            echo ' - Failed to move file to test location';
        }
    } else {
        $errorMessages = [
            UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
            UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
            UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
            UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',
        ];

        $errorMessage = $errorMessages[$file['error']] ?? 'Unknown upload error occurred.';
        echo '<span style="color: red;">Error: ' . $errorMessage . '</span>';
    }

    echo "</li>";
    echo "</ul>";

    // Show file validation
    if ($file['error'] === UPLOAD_ERR_OK) {
        echo "<h3>File Validation Test:</h3>";

        $allowedTypes = [
            'photo' => ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'],
            'video' => ['video/mp4', 'video/avi', 'video/mov', 'video/wmv', 'video/flv', 'video/webm'],
            'audio' => ['audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/flac', 'audio/aac', 'audio/ogg'],
        ];

        $fileMimeType = $file['type'];
        $isValid = in_array($fileMimeType, $allowedTypes[$fileType] ?? []);

        echo "<p><strong>Validation Result:</strong> ";
        if ($isValid) {
            echo '<span style="color: green;">Valid</span> - File type matches selected media type';
        } else {
            echo '<span style="color: red;">Invalid</span> - File type ' . htmlspecialchars($fileMimeType) . ' is not allowed for ' . htmlspecialchars($fileType) . ' media';
        }
        echo "</p>";

        echo "<p><strong>Allowed types for {$fileType}:</strong> " . implode(', ', $allowedTypes[$fileType] ?? []) . "</p>";
    }
}

echo "<h2>Recommendations:</h2>";
echo "<ul>";
echo "<li>If upload_max_filesize is less than 100M, check your server configuration</li>";
echo "<li>If post_max_size is less than 200M, check your server configuration</li>";
echo "<li>Make sure the storage/app/public/media directory exists and is writable</li>";
echo "<li>Check that the storage:link command has been run</li>";
echo "</ul>";

echo "<p><a href='../admin/media' style='color: #007bff; text-decoration: none;'>← Back to Media Admin</a></p>";
