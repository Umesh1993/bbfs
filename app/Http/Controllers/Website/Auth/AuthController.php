<?php

namespace App\Http\Controllers\Website\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Throwable;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('website.pages.home');
    }
}

