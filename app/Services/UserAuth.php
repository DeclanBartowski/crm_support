<?php


namespace App\Services;

use App\Mail\Password;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class UserAuth
{
    public function authUser($arData)
    {

        $user = User::where('name', $arData['login'])->first();
        if ($user) {
            if ($res = Auth::attempt(['id' => $user->id, 'password' => $arData['password']], true)) {
                return redirect()->intended(route('login'));
            } else {
                return back()->withErrors(__('auth/login.error'))->withInput($arData);
            }
        } else {
            return back()->withErrors(__('auth/login.not_found'))->withInput($arData);
        }
    }



}
