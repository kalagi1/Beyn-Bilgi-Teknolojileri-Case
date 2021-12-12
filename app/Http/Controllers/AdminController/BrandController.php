<?php

namespace App\Http\Controllers\AdminController;

use App\Functional\Car\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(){
        $brands = Brand::getBrands();

        return json_encode($brands);
    }
}
