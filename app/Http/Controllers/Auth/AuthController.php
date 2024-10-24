<?php
namespace App\Http\Controllers\auth;

use App\Http\Resources\v1\AuthorResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', 'min:4']
        ]);
        $validated['password'] = Hash::make($validated['password']);
        /**
         * @var User $user
         */
        $user = User::create($validated);
        $token = $user->createToken('access_token')->plainTextToken;
        // Auth::attempt($validated);
        return response()->json([
            (new AuthorResource($user)),
            'token' => $token
        ], Response::HTTP_CREATED);
    }

    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'password' => ['required', 'min:4'],
            'email' => ['email', 'required']
        ]);
        if (!Auth::attempt($validated)) {
            return response()->json([
                'status' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Invalid credentials',
                'data_user' => $request->user()
            ], Response::HTTP_UNAUTHORIZED);
        }

        /**
         * @var User $user
         */
        $user = Auth::user();
        $token = $user->createToken('access_token')->plainTextToken;
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Login successfully',
            'access_token' => $token
        ], Response::HTTP_OK);
    }

    public function logout(Request $request)
    {
        /**
         * @var User $user
         */

        $user = Auth::user();
        $user->tokens()->delete();
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'logged out successfully'
        ], Response::HTTP_OK);
    }

}

