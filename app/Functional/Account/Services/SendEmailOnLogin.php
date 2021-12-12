<?php 

namespace App\Functional\Account\Services;

trait SendEmailOnLogin{
    public function sendEmailOnLogin(){
        return response()->json("Email başarıyla gönderildi", 200);
    }
}