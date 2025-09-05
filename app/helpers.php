<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('image_url')) {
    /**
     * Generate the correct URL for an image based on the environment
     */
    function image_url($imagePath) {
        // Always use asset helper for consistency and proper URL generation
        $url = asset('storage/' . $imagePath);
        
        // Ensure HTTPS in production
        if (config('app.env') === 'production') {
            $url = str_replace('http://', 'https://', $url);
        }
        
        return $url;
    }
}
