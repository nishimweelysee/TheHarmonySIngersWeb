<?php
// Test file to check PHP upload limits
echo "<h1>PHP Upload Limits Test</h1>";

echo "<h2>Current PHP Settings:</h2>";
echo "<p>upload_max_filesize: " . ini_get('upload_max_filesize') . "</p>";
echo "<p>post_max_size: " . ini_get('post_max_size') . "</p>";
echo "<p>max_execution_time: " . ini_get('max_execution_time') . "</p>";
echo "<p>max_input_time: " . ini_get('max_input_time') . "</p>";
echo "<p>memory_limit: " . ini_get('memory_limit') . "</p>";
echo "<p>max_file_uploads: " . ini_get('max_file_uploads') . "</p>";

echo "<h2>Setting New Limits:</h2>";
ini_set('upload_max_filesize', '100M');
ini_set('post_max_size', '200M');
ini_set('max_execution_time', 300);
ini_set('max_input_time', 300);
ini_set('memory_limit', '512M');

echo "<p>After setting new limits:</p>";
echo "<p>upload_max_filesize: " . ini_get('upload_max_filesize') . "</p>";
echo "<p>post_max_size: " . ini_get('post_max_size') . "</p>";
echo "<p>max_execution_time: " . ini_get('max_execution_time') . "</p>";
echo "<p>max_input_time: " . ini_get('max_input_time') . "</p>";
echo "<p>memory_limit: " . ini_get('memory_limit') . "</p>";

echo "<h2>Test Upload Form:</h2>";
?>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="test_file" multiple>
    <button type="submit">Test Upload</button>
</form>

<?php
if ($_POST) {
    echo "<h2>Upload Test Results:</h2>";
    echo "<p>POST data size: " . strlen(file_get_contents('php://input')) . " bytes</p>";
    echo "<p>Files uploaded: " . count($_FILES) . "</p>";

    if (isset($_FILES['test_file'])) {
        foreach ($_FILES['test_file']['name'] as $key => $name) {
            echo "<p>File $key: $name (" . $_FILES['test_file']['size'][$key] . " bytes)</p>";
        }
    }
}
?>