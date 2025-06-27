<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\Contracts\AuthRepositoryInterface;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Throwable;

class AuthController extends Controller
{
    protected AuthRepositoryInterface $authRepo;

    public function __construct(AuthRepositoryInterface $authRepo)
    {
        $this->authRepo = $authRepo;
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function websiteLogin()
    {
        return view('website.pages.home');
    }

    

    public function login(Request $request)
    {
        try {
            $this->authRepo->login($request);

            return redirect()->route('admin.dashboard')->with('success', 'Logged in successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (AuthenticationException $e) {
            return redirect()->back()
                ->withErrors(['email' => 'Invalid credentials.'])
                ->withInput();
        } catch (Throwable $e) {
            // You can also log the exception: \Log::error($e);
            return redirect()->back()
                ->withErrors(['error' => 'Something went wrong. Please try again.'])
                ->withInput();
        }
    }

    public function showRegistrationForm()
    {
        return view('admin.auth.signup');
    }

    public function register(Request $request)
    {
        try {
            $this->authRepo->register($request);

            return redirect()->route('admin.login')->with('success', 'Registration successful. Please login.');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (Throwable $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Registration failed. Try again later.'])
                ->withInput();
        }
    }

    public function logout(Request $request)
    {
        try {
            $this->authRepo->logout($request);

            return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
        } catch (Throwable $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Logout failed. Please try again.']);
        }
    }
}

