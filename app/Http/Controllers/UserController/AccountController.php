<?php

namespace App\Http\Controllers\UserController;

use App\Functional\Account\Account;
use App\Functional\Account\IAccount;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\New_;

class AccountController extends Controller
{

    public function loginV(){
        return json_encode(["status" => false , "message" => "unauthorized"]);
    }

    public function login(){
        $response = Account::login();
        return json_encode($response);
    }

    public function register(){
        $response = Account::register();
        
        return json_encode($response);
    }

    public function getDetail(){
        
    }

    public function addBalance(){
        $account = new Account();

        return json_encode($account->addBalance());
    }

    public function getBalance(){
        $account = new Account();
        $response = $account->getBalance();

        return json_encode($response);
    }
}
