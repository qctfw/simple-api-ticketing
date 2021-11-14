<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Services\Contracts\UserServiceInterface;

class UserController extends Controller
{
    /**
     * @var UserServiceInterface
     */
    private $user_service;

    public function __construct(UserServiceInterface $user_service)
    {
        $this->user_service = $user_service;
    }

    public function login(UserLoginRequest $request)
    {
        $user = $this->user_service->login($request->email, $request->password);
        if (!$user)
            return response()->json(['message' => 'Unauthorized'], 403);

        $token = $this->user_service->createToken($user->id);

        return response()->json([
            'user' => $user,
            'token' => [
                'type' => 'Bearer',
                'access_token' => $token
            ]
        ]);
    }
}
