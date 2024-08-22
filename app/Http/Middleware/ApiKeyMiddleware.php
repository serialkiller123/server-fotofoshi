<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\APIKey; 

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('x-api-key');

        if (!$apiKey) {
            return response()->json(['message' => 'API key is missing'], 401);
        }

        $apiKeyRecord = APIKey::where('key', $apiKey)->first();

        if (!$apiKeyRecord) {
            return response()->json(['message' => 'Invalid API key'], 401);
        }

        $request->user = $apiKeyRecord->user;

        return $next($request);
    }
}
