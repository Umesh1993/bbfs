<?php

namespace App\Repositories\Admin\Contracts;
use Illuminate\Http\Request;

interface AuthRepositoryInterface
{
    public function login(Request $request);
    public function register(Request $request);
    public function logout(Request $request);
}
