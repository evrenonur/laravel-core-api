<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Interfaces\Eloquent\IAuthService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService implements IAuthService
{
    //
    public function login(string $email, string $password): ServiceResponse
    {
        if(!Auth::attempt(array('email' => $email, 'password' => $password))){
            return new ServiceResponse(false, 'Invalid credentials', null, 401);
        }
        $user = $this->getByEmail($email);
        $token = $user->getData()->createToken($email)->plainTextToken;
        return new ServiceResponse(true, 'User logged in', [
            'user' => $user->getData(),
            'token' => $token
        ], 200);
    }

    public function getAll(): ServiceResponse
    {

    }

    public function getById(int $id): ServiceResponse
    {
        // TODO: Implement getById() method.
    }

    public function delete(int $id): ServiceResponse
    {
        // TODO: Implement delete() method.
    }

    public function getByEmail(string $email): ServiceResponse
    {
        $user = User::where('email', $email)->first();
        if ($user) {
            return new ServiceResponse(true, 'User found', $user, 200);
        }
        return new ServiceResponse(false, 'User not found', null, 404);
    }

    public function logout(): ServiceResponse
    {
        $user = \auth()->user()->currentAccessToken()->delete();
        if ($user) {
            return new ServiceResponse(true, 'User logged out', null, 200);
        }
        return new ServiceResponse(false, 'User not found', null, 404);
    }
}
