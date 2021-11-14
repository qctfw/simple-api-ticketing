<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserService implements UserServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $user_repository;

    public function __construct(UserRepositoryInterface $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    public function find(string $id)
    {
        return $this->user_repository->find($id);
    }

    public function login(string $email, string $password)
    {
        $user = $this->user_repository->getByEmail($email);
        if (!$user) {
            return null;
        }

        return (Hash::check($password, $user->password)) ? $user : null;
    }

    public function createToken(string $user_id, string $token_name = 'auth-user')
    {
        $user = $this->find($user_id);
        if (!$user) {
            throw new NotFoundHttpException('User yang dicari tidak ada');
        }

        $token = $user->createToken($token_name)->plainTextToken;

        return $token;
    }

    public function removeToken(string $user_id)
    {
        $user = $this->find($user_id);
        if (!$user) {
            throw new NotFoundHttpException('User yang dicari tidak ada');
        }

        $user->tokens()->delete();

        return true;
    }
}
