<?php 

namespace App\Functional\Balance\Services;

use App\Models\Balance;
use Illuminate\Support\Facades\Validator;

trait AddBalance{
    public function addBalance(){
        $validator = Validator::make(request()->all(), [
            'name_on_the_card' => 'required',
            'card_number' => 'required|max:16|min:16',
            'expiry_month' => 'required|max:2',
            'expiry_year' => 'required|max:4',
            'cvc' => 'required',
            'balance' => "required"
        ]);

        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        
        $updateBalanceRes = $this->updateBalance(request('balance'),"increase");

        if($updateBalanceRes){
            return response()->json(array('status' => true,'success_message'=>'You have successfuly added the '.request('balance').' balance'  , 'current_balance' => $this->account->balance), 200);
        } else {
            return response()->json('Something went wrong', 400);
        }
    }
}