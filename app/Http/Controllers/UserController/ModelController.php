<?php

namespace App\Http\Controllers\UserController;

use App\Functional\Car\Model;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ModelController extends Controller
{
    public function index(){
        $models = Model::getModels();
        return json_encode($models);
    }
}
