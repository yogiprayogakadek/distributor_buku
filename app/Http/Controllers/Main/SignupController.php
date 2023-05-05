<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;

class SignupController extends Controller
{
    public function index()
    {
        return view('auth.signup');
    }

    public function signup(AuthRequest $request)
    {
        //
    }
}
