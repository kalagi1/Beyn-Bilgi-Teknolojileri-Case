<?php 

    namespace App\Functional\Account;

    use Illuminate\Http\Request;

interface IAccount{
        public static function Login();
        public static function Register();
    }