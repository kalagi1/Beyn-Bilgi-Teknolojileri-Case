<?php

namespace App\Http\Controllers\UserController;

use App\Functional\Order\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $order = new Order();
        return json_encode($order->getOrders());
    }

    public function store(){
        $order = new Order();
        return json_encode($order->addOrder());
    }
}
