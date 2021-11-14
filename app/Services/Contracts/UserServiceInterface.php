<?php

namespace App\Services\Contracts;

interface UserServiceInterface
{
    public function find(string $id);
    public function login(string $email, string $password);
    public function createToken(string $user_id, string $token_name = 'auth-user');
    public function removeToken(string $user_id);
}
