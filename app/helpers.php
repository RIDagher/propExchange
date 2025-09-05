<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('image_url')) {
    /**
     * Generate the correct URL for an image based on the environment
     */
    function image_url($imagePath) {
        // For production deployments (like Render),  the app URL + storage path
        if (config('app.env') === 'production') {
            return config('app.url') . '/storage/' . $imagePath;
        }
        
        // For local development,  asset helper
        return asset('storage/' . $imagePath);
    }
}
