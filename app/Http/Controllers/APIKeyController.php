<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\APIKey;
use Illuminate\Support\Str;

class APIKeyController extends Controller
{
    /**
     * Generate a new API key for the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function generate()
    {
        $key = Str::random(40); 

        APIKey::create([
            'user_id' => auth()->id(),
            'key' => $key,
        ]);

        return response()->json(['key' => $key]);
    }

    /**
     * Get all API keys for a specified user.
     *
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getKeys($userId)
    {
        if (auth()->id() !== (int)$userId) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $apiKeys = APIKey::where('user_id', $userId)->get();

        if ($apiKeys->isEmpty()) {
            return response()->json(['error' => 'No API keys found'], 404);
        }

        return response()->json(['keys' => $apiKeys]);
    }

    public function getAllKeys($userId)
{
    $apiKeys = APIKey::where('user_id', $userId)->get();

    if ($apiKeys->isEmpty()) {
        return response()->json(['error' => 'No API keys found'], 404);
    }

    return response()->json(['keys' => $apiKeys]);
}

    /**
     * Validate an API key
     *
     * @param string $key API key to validate
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateKey($key)
    {
        $apiKey = APIKey::where('key', $key)->first();

        if ($apiKey) {
            return response()->json(['valid' => true, 'message' => 'Valid key']);
        } else {
            return response()->json(['valid' => false, 'message' => 'Invalid key'], 400);
        }
    }



    /**
     * Delete a specific API key for the authenticated user.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteKey($id)
    {
        $apiKey = APIKey::where('id', $id)->where('user_id', auth()->id())->first();

        if (!$apiKey) {
            return response()->json(['error' => 'API key not found or unauthorized'], 404);
        }

        $apiKey->delete();

        return response()->json(['message' => 'API key deleted successfully']);
    }
}
