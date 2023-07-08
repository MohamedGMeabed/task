<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {

            $user->login_attempts = 0;
            $user->blocked_time = null;
            $user->save();

            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        if ($user && $user->login_attempts < 3) {
            $user->login_attempts++;
            $user->save();
            if ($user->login_attempts = 3) {
                $user->blocked_time = Carbon::now()->addSeconds(30);
                $user->save();
                $cookie = Cookie::make('blocked_time', 'you have to wait for 30 seconds', 0.5);
                $cookie = Cookie::make('blocked_time', $request->email, 0.5);
                return redirect()->back()->withCookie($cookie);
            }

            return $this->sendFailedLoginResponse($request);
        } elseif ($user  && $user->login_attempts >= 3) {
            $user->blocked_time = Carbon::now()->addYear();
            $user->save();

            $cookie = cookie()->forever('blocked_time', 'you have to Contact with admin');

            return redirect()->back()->withCookie($cookie);
        }
        return $this->sendFailedLoginResponse($request);
    }

}
