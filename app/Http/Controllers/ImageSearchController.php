<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageSearchController extends Controller
{
    /**
     * Search images via Pixabay API
     */
    public function searchPixabay(Request $request)
    {
        $query = $request->input('query');
        
        if (!$query || strlen(trim($query)) === 0) {
            return response()->json([
                'error' => 'Query is required',
                'hits' => []
            ], 400);
        }

        try {
            $apiKey = config('services.pixabay.key', '47340408-fa7adf893d0ccc108f99b0fbc');
            
            $url = 'https://pixabay.com/api/';
            $params = [
                'key' => $apiKey,
                'q' => $query,
                'image_type' => 'photo',
                'per_page' => 12,
                'orientation' => 'horizontal'
            ];

            $response = \Http::timeout(10)->get($url, $params);

            if ($response->failed()) {
                return response()->json([
                    'error' => 'API request failed',
                    'hits' => []
                ], $response->status());
            }

            return response()->json($response->json());

        } catch (\Exception $e) {
            \Log::error('Image search error: ' . $e->getMessage());
            
            return response()->json([
                'error' => $e->getMessage(),
                'hits' => []
            ], 500);
        }
    }
}
