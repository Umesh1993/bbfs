<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\Contracts\AuthRepositoryInterface;
use App\Http\Requests\Admin\AdminRegisterRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Throwable;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    protected AuthRepositoryInterface $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function showLoginForm(): \Illuminate\View\View
    {
        return view('admin.auth.login');
    }

    public function showRegistrationForm(): \Illuminate\View\View
    {
        return view('admin.auth.signup');
    }

    public function websiteLogin(): \Illuminate\View\View
    {
        return view('website.pages.home');
    }

    public function login(Request $request): RedirectResponse
    {
        try {
            $this->authRepository->login($request);
            return redirect()->route('admin.dashboard')->with('success', 'Logged in successfully.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (AuthenticationException $e) {
            return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
        } catch (Throwable $e) {
            return back()->withErrors(['error' => 'Something went wrong. Please try again.'])->withInput();
        }
    }

    public function register(AdminRegisterRequest $request): RedirectResponse
    {
        try {
            $this->authRepository->register($request->validated());
            return redirect()->route('admin.login')->with('success', 'Registration successful. Please login.');
        } catch (Throwable $e) {
            return back()->withErrors(['error' => 'Registration failed. Try again later.'])->withInput();
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        try {
            $this->authRepository->logout($request);
            return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
        } catch (Throwable $e) {
            return back()->withErrors(['error' => 'Logout failed. Please try again.']);
        }
    }
}
