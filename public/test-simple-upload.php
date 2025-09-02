<?php
// Simple file upload test
echo "<h1>Simple File Upload Test</h1>";

// Check if a file was uploaded
if ($_FILES && isset($_FILES['test_file'])) {
    $file = $_FILES['test_file'];

    echo "<h2>Upload Results:</h2>";
    echo "<ul>";
    echo "<li><strong>File Name:</strong> " . htmlspecialchars($file['name']) . "</li>";
    echo "<li><strong>File Size:</strong> " . number_format($file['size'] / 1024 / 1024, 2) . " MB</li>";
    echo "<li><strong>File Type:</strong> " . htmlspecialchars($file['type']) . "</li>";
    echo "<li><strong>Upload Status:</strong> ";

    if ($file['error'] === UPLOAD_ERR_OK) {
        echo '<span style="color: green;">Success</span>';

        // Try to save to a test directory
        $testDir = __DIR__ . '/test-uploads';
        if (!is_dir($testDir)) {
            mkdir($testDir, 0755, true);
        }

        $testPath = $testDir . '/' . time() . '_' . $file['name'];
        if (move_uploaded_file($file['tmp_name'], $testPath)) {
            echo ' - File saved to: ' . $testPath;
            // Clean up
            unlink($testPath);
        } else {
            echo ' - Failed to save file';
        }
    } else {
        $errorMessages = [
            UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize (2M)',
            UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE',
            UPLOAD_ERR_PARTIAL => 'File partially uploaded',
            UPLOAD_ERR_NO_FILE => 'No file uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing temp directory',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file',
            UPLOAD_ERR_EXTENSION => 'PHP extension stopped upload',
        ];

        $errorMessage = $errorMessages[$file['error']] ?? 'Unknown error: ' . $file['error'];
        echo '<span style="color: red;">Error: ' . $errorMessage . '</span>';
    }

    echo "</li>";
    echo "</ul>";
}

// Show current PHP settings
echo "<h2>Current PHP Settings:</h2>";
echo "<ul>";
echo "<li><strong>upload_max_filesize:</strong> " . ini_get('upload_max_filesize') . "</li>";
echo "<li><strong>post_max_size:</strong> " . ini_get('post_max_size') . "</li>";
echo "<li><strong>max_execution_time:</strong> " . ini_get('max_execution_time') . "</li>";
echo "<li><strong>memory_limit:</strong> " . ini_get('memory_limit') . "</li>";
echo "</ul>";

// Upload form
echo "<h2>Test Upload Form:</h2>";
echo '<form method="post" enctype="multipart/form-data">';
echo '<input type="file" name="test_file" required>';
echo '<input type="submit" value="Upload Test File">';
echo '</form>';

echo "<h2>Test Instructions:</h2>";
echo "<ol>";
echo "<li>Select a file (try different sizes: small < 2MB, medium 2-8MB, large > 8MB)</li>";
echo "<li>Click Upload to test</li>";
echo "<li>Check the results above</li>";
echo "</ol>";

echo "<p><strong>Expected Results:</strong></p>";
echo "<ul>";
echo "<li><strong>Files < 2MB:</strong> Should upload successfully</li>";
echo "<li><strong>Files 2-8MB:</strong> May fail due to upload_max_filesize limit</li>";
echo "<li><strong>Files > 8MB:</strong> Will fail due to post_max_size limit</li>";
echo "</ul>";
