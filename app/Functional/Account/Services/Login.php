<?php 

    namespace App\Functional\Account\Services;

use Illuminate\Support\Facades\Auth;

trait Login{
        use SendEmailOnLogin;
        public static function Login(){
            if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
                $user = Auth::user();
                $success['token'] = $user->createToken('MyApp')->accessToken;
                $success['email'] = $user->email;
                $success['name'] = $user->name;
                return response()->json($success, 200);
            } else {
                return response()->json('Email veya şifre yanlış.', 401);
            }
        }
    }