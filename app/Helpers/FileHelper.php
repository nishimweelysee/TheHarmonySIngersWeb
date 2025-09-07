<?php

namespace App\Helpers;

class FileHelper
{
    /**
     * Format bytes to human readable format
     *
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    public static function formatBytes($bytes, $precision = 2)
    {
        if ($bytes === 0) {
            return '0 Bytes';
        }

        $units = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB'];
        $base = log($bytes, 1024);

        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $units[floor($base)];
    }

    /**
     * Get file extension from filename
     *
     * @param string $filename
     * @return string
     */
    public static function getExtension($filename)
    {
        return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    }

    /**
     * Get file type from extension
     *
     * @param string $extension
     * @return string
     */
    public static function getFileType($extension)
    {
        $imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'];
        $videoTypes = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'mkv'];
        $audioTypes = ['mp3', 'wav', 'ogg', 'aac', 'flac', 'm4a'];
        $documentTypes = ['pdf', 'doc', 'docx', 'txt', 'rtf', 'odt'];
        $spreadsheetTypes = ['xls', 'xlsx', 'csv', 'ods'];
        $presentationTypes = ['ppt', 'pptx', 'odp'];

        $extension = strtolower($extension);

        if (in_array($extension, $imageTypes)) {
            return 'image';
        } elseif (in_array($extension, $videoTypes)) {
            return 'video';
        } elseif (in_array($extension, $audioTypes)) {
            return 'audio';
        } elseif (in_array($extension, $documentTypes)) {
            return 'document';
        } elseif (in_array($extension, $spreadsheetTypes)) {
            return 'spreadsheet';
        } elseif (in_array($extension, $presentationTypes)) {
            return 'presentation';
        } else {
            return 'file';
        }
    }

    /**
     * Get MIME type from extension
     *
     * @param string $extension
     * @return string
     */
    public static function getMimeType($extension)
    {
        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'webp' => 'image/webp',
            'svg' => 'image/svg+xml',
            'mp4' => 'video/mp4',
            'avi' => 'video/x-msvideo',
            'mov' => 'video/quicktime',
            'wmv' => 'video/x-ms-wmv',
            'flv' => 'video/x-flv',
            'webm' => 'video/webm',
            'mkv' => 'video/x-matroska',
            'mp3' => 'audio/mpeg',
            'wav' => 'audio/wav',
            'ogg' => 'audio/ogg',
            'aac' => 'audio/aac',
            'flac' => 'audio/flac',
            'm4a' => 'audio/mp4',
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'txt' => 'text/plain',
            'rtf' => 'application/rtf',
            'odt' => 'application/vnd.oasis.opendocument.text',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'csv' => 'text/csv',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'odp' => 'application/vnd.oasis.opendocument.presentation',
        ];

        $extension = strtolower($extension);
        return $mimeTypes[$extension] ?? 'application/octet-stream';
    }

    /**
     * Check if file is an image
     *
     * @param string $extension
     * @return bool
     */
    public static function isImage($extension)
    {
        return self::getFileType($extension) === 'image';
    }

    /**
     * Check if file is a video
     *
     * @param string $extension
     * @return bool
     */
    public static function isVideo($extension)
    {
        return self::getFileType($extension) === 'video';
    }

    /**
     * Check if file is an audio file
     *
     * @param string $extension
     * @return bool
     */
    public static function isAudio($extension)
    {
        return self::getFileType($extension) === 'audio';
    }

    /**
     * Generate a safe filename
     *
     * @param string $filename
     * @return string
     */
    public static function generateSafeFilename($filename)
    {
        $extension = self::getExtension($filename);
        $name = pathinfo($filename, PATHINFO_FILENAME);

        // Remove special characters and replace spaces with underscores
        $name = preg_replace('/[^a-zA-Z0-9_-]/', '_', $name);
        $name = preg_replace('/_+/', '_', $name);
        $name = trim($name, '_');

        // Add timestamp to make it unique
        $timestamp = time();

        return $name . '_' . $timestamp . '.' . $extension;
    }
}
