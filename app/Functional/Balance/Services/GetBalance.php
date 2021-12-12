<?php 

namespace App\Functional\Balance\Services;

trait GetBalance{
    public function getBalance(){
        if(isset($this->account->balance)){
            return response()->json(array('status' => true, 'current_balance' => $this->account->balance), 200);
        } else {
            return response()->json('Something went wrong', 400);
        }
    }
}