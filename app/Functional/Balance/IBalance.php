<?php 
namespace App\Functional\Balance;

interface IBalance{
    public function addBalance();
    public function getBalance();
    public function updateBalance($balance,$type);
}