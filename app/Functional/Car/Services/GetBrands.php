<?php 

    namespace App\Functional\Car\Services;

use App\Functional\Helper\Helper;
use App\Models\Brand;

trait GetBrands{
    public static function getBrands(){
        $start = Helper::emptyCheck(request('start'), 0);
        $length = Helper::emptyCheck(request('length'), 10);
        $orderBy = Helper::emptyCheck(request('order_by'), 'asc');

        
        $brands = Brand::orderBy('name',$orderBy)
        ->skip($start)
        ->take($length) 
        ->get();

        if(empty($brands)){
            return response()->json("Data is not found", 300);
        }else{
            return response()->json($brands,200);
        }
    }
}