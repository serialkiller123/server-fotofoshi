<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    /**
     * Handle user registration.
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        // Create the user
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        // Fire the Registered event
        event(new Registered($user));

        // Create a token for the user
        $token = $user->createToken('auth_token')->plainTextToken;

        // Log in the user
        Auth::login($user);

        // Return a response with the token and user
        return response()->json([
            'message' => 'Registration successful',
            'token' => $token,
            'user' => $user
        ]);
    }
}
