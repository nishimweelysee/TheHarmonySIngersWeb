<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleLargeUploads
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Increase PHP limits for file uploads - try multiple approaches
        if ($request->is('admin/media*') && ($request->isMethod('POST') || $request->isMethod('PUT') || $request->isMethod('PATCH'))) {
            // Method 1: Direct ini_set with error suppression
            @ini_set('upload_max_filesize', '100M');
            @ini_set('post_max_size', '200M');
            @ini_set('max_execution_time', 300);
            @ini_set('max_input_time', 300);
            @ini_set('memory_limit', '512M');
            @ini_set('max_file_uploads', 20);

            // Method 2: putenv
            @putenv('upload_max_filesize=100M');
            @putenv('post_max_size=200M');
            @putenv('max_execution_time=300');
            @putenv('max_input_time=300');
            @putenv('memory_limit=512M');
            @putenv('max_file_uploads=20');

            // Method 3: Set custom headers to hint at large upload
            if ($request->hasFile('file') || $request->hasFile('files')) {
                $request->headers->set('X-Upload-Size', 'large');
            }

            // Method 4: Try to set via .htaccess equivalent
            if (function_exists('apache_setenv')) {
                @apache_setenv('upload_max_filesize', '100M');
                @apache_setenv('post_max_size', '200M');
            }

            // Log the current limits for debugging
            \Illuminate\Support\Facades\Log::info('PHP limits set for media upload', [
                'upload_max_filesize' => ini_get('upload_max_filesize'),
                'post_max_size' => ini_get('post_max_size'),
                'max_execution_time' => ini_get('max_execution_time'),
                'memory_limit' => ini_get('memory_limit'),
                'max_file_uploads' => ini_get('max_file_uploads')
            ]);
        }

        return $next($request);
    }
}
