<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use App\Models\User;
use App\Models\UsersVerify;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Str;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(
            'auth:api',
            [
                'except' => [
                    'login', 'register', 'registerClient',
                ],
            ]
        );
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(): JsonResponse
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth()->user()->refresh());
    }

    /**
     * Respond with a token.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $data = $request->only('name', 'email', 'password');
        $validator = Validator::make(
            $data,
            [
                'name'     => 'required|string',
                'email'    => 'required|email|unique:users',
                'password' => 'required|string|min:6|max:50',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        return $this->createUser($request);
    }

    /**
     * Respond with a token.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerClient(Request $request): JsonResponse
    {
        $data = $request->only('name', 'email', 'password');
        $validator = Validator::make(
            $data,
            [
                'name'     => 'required|string',
                'email'    => 'required|email|unique:users',
                'password' => 'required|string|min:6|max:50',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], Response::HTTP_BAD_REQUEST);
        }

        return $this->createUser($request);
    }


    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyAccount(Request $request): JsonResponse
    {
        $data = $request->only('tokenToVerify');
        $validator = Validator::make(
            $data,
            [
                'tokenToVerify' => 'required|string',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], Response::HTTP_BAD_REQUEST);
        }
        $usersVerify = UsersVerify::query()->where('token', $data['tokenToVerify'])->first();
        $user = User::where('id', $usersVerify)->first();
        if (!$user) {
            return response()->json(['error' => 'Invalid token'], Response::HTTP_BAD_REQUEST);
        }
        if ($user->isVerified()) {
            return response()->json(['error' => 'User already verified'], Response::HTTP_BAD_REQUEST);
        }
        $user->verify();
        return response()->json(['message' => 'User verified!'], Response::HTTP_OK);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json(
            [
                'access_token' => $token,
                'token_type'   => 'bearer',
                'expires_in'   => auth()->factory()->getTTL() * 60,
            ]
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function createUser(Request $request): JsonResponse
    {

        $user = User::create(
            [
                'name'           => $request['name'],
                'email'          => $request['email'],
                'password'       => bcrypt($request['password'])
            ]
        );

        $token = Str::random(64);
        UsersVerify::create(
            [
                'user_id' => $user->id,
                'token'   => $token,
            ]
        );

        $email = $user['email'];
        $data = ([
            'name'              => $user['name'],
            'email'             => $email,
            'verification_link' => 'http://localhost:3000/user/verify-account?q=' . $token,
            'company'           => env('APP_NAME'),
        ]);
        Mail::to($email)->send(new WelcomeMail($data));

        return response()->json(
            [
                'message' => 'User created',
                'token'   => $token,
                'user'    => $user,
            ],
            Response::HTTP_OK
        );
    }

}
