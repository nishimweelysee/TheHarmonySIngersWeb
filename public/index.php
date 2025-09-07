<?php

// Force PHP limits for large file uploads - MUST be set before any other code
@ini_set('upload_max_filesize', '100M');
@ini_set('post_max_size', '200M');
@ini_set('max_execution_time', 300);
@ini_set('max_input_time', 300);
@ini_set('memory_limit', '512M');
@ini_set('max_file_uploads', 20);

// Check PHP upload limits and provide helpful error messages
$uploadMax = ini_get('upload_max_filesize');
$postMax = ini_get('post_max_size');
$memoryLimit = ini_get('memory_limit');

// Convert to bytes for comparison
function sizeToBytes($size)
{
    $unit = strtolower(substr($size, -1));
    $value = (int)substr($size, 0, -1);
    switch ($unit) {
        case 'g':
            return $value * 1024 * 1024 * 1024;
        case 'm':
            return $value * 1024 * 1024;
        case 'k':
            return $value * 1024;
        default:
            return $value;
    }
}

$uploadMaxBytes = sizeToBytes($uploadMax);
$postMaxBytes = sizeToBytes($postMax);

// Log current limits for debugging
if (isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'local') {
    error_log("Current PHP Limits - Upload: {$uploadMax}, Post: {$postMax}, Memory: {$memoryLimit}");
    error_log("Upload max bytes: {$uploadMaxBytes}, Post max bytes: {$postMaxBytes}");
}

// Check if limits are sufficient for large uploads
if ($uploadMaxBytes < 50 * 1024 * 1024 || $postMaxBytes < 100 * 1024 * 1024) {
    error_log("WARNING: PHP upload limits are too low for large file uploads!");
    error_log("Current limits: upload_max_filesize={$uploadMax}, post_max_size={$postMax}");
    error_log("Required: upload_max_filesize>=50M, post_max_size>=100M");
    error_log("Please update your server configuration (.htaccess, php.ini, or server config)");
}

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__ . '/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__ . '/../bootstrap/app.php';

$app->handleRequest(Request::capture());
