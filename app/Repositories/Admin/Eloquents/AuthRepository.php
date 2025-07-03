<?php

namespace App\Repositories\Admin\Eloquents;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Repositories\Admin\Contracts\AuthRepositoryInterface;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;

class AuthRepository implements AuthRepositoryInterface
{
    public function register(array $data): void
    {
        DB::transaction(function () use ($data) {
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $user->assignRole(Role::findByName('admin', 'admin'));
        });
    }

    public function login(Request $request): void
    {
        $credentials = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string',
        ])->validate();

        if (!Auth::guard('admin')->attempt($credentials)) {
            throw new AuthenticationException('Invalid credentials.');
        }

        $request->session()->regenerate();
    }

    public function logout(Request $request): void
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
