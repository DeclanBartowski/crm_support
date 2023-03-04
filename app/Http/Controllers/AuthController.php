<?php

namespace App\Http\Controllers;


use App\Http\Requests\LoginRequest;

use App\Services\UserAuth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    public function login()
    {
        Session::forget('checking_phone');
        return view('admin.auth.login');
    }

    public function authUser(UserAuth $userAuthService, LoginRequest $request)
    {
        return $userAuthService->authUser($request->validated());
    }



}
