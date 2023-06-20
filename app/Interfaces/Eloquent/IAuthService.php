<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;
use App\Interfaces\Eloquent\IEloquentService;


interface IAuthService extends IEloquentService
{
    public function login(
        string $email,
        string $password
    ): ServiceResponse;

    public function getByEmail(
        string $email
    ): ServiceResponse;

    public function logout(): ServiceResponse;
}
