<?php 

    namespace App\Functional\Account\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

trait Register{
        public static function Register(){
            $validator = Validator::make(request()->all(), [
                'name' => 'required|unique:users',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'c_password' => 'required|same:password'
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            $input = request()->all();
            $input['password'] = Hash::make(request('password'));
            $user = User::create($input);
            if ($user->save()) {
                return response()->json('Kullanıcı başarıyla eklendi.', 200);
            } else {
                return response()->json('Kullanıcı kaydı sırasında bir sorun oluştu.', 400);
            }
        }
    }