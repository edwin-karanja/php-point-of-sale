<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateUserRequest;
use App\Http\Requests\Api\LoginUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    private $auth;

    public function __construct()
    {
        $this->auth = auth('api');

        $this->middleware('auth:api')->except(['register', 'login']);
    }

    public function user()
    {
        return (new UserResource( $this->auth->user() ))
            ->additional([
                'success' => true
            ]);
    }

    public function register(CreateUserRequest $request)
    {
        $user = User::create($request->toBag()->attributes());

        try {
            $token = $this->auth->login( $user );
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], $e->getCode());
        }

        if ($token) {
            return (new UserResource( $user ))
                ->additional([
                    'success' => true,
                    'token_type' => 'bearer',
                    'token' => $token,
                    'token_expires' => $this->auth->factory()->getTTL() * 60
                ]);
        }

    }

    public function login(LoginUserRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if ( !$token = $this->auth->attempt( $credentials ) ) {
            return response()
                ->json([
                    'success' => false,
                    'errors' => [
                        'root' => 'We do not recognize those credentials!!'
                    ]
                ], 401);
        }

        return (new UserResource( $this->auth->user() ))
            ->additional([
                'success' => true,
                'token_type' => 'bearer',
                'token' => $token,
                'token_expires' => $this->auth->factory()->getTTL() * 60
            ]);
    }
}
