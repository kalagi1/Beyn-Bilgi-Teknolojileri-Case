<?php 

namespace App\Functional\Balance\Services;

trait UpdateBalance{
    public function updateBalance($balance,$type){
        if($type=="increase"){
            $this->account->balance += $balance;
        }else{
            $this->account->balance -= $balance;
        }

        if($this->account->save()){
            return true;
        } else {
            return false;
        }
    }
}