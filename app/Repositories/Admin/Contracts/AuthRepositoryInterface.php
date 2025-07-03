<?php

namespace App\Repositories\Admin\Contracts;
use Illuminate\Http\Request;

interface AuthRepositoryInterface
{
    public function register(array $data): void;
    public function login(Request $request): void;
    public function logout(Request $request): void;
}
