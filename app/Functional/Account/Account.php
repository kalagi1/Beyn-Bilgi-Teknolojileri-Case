<?php 

namespace App\Functional\Account;

use App\Functional\Account\Services\Login;
use App\Functional\Account\Services\Register;
use App\Functional\Balance\IBalance;
use App\Functional\Balance\Services\AddBalance;
use App\Functional\Balance\Services\GetBalance;
use App\Functional\Balance\Services\UpdateBalance;
use App\Functional\Cart\Cart;
use Illuminate\Support\Facades\Auth;

Class Account implements IAccount , IBalance{
    use Login,Register,GetBalance,AddBalance,UpdateBalance;
    public $account;
    public $_name;
    public $_email;

    public function __construct(){
        $this->_name = Auth::guard('api')->user()->name;
        $this->_email = Auth::guard('api')->user()->email;
        $this->account = Auth::guard('api')->user();
    }

}
