<?php 

namespace App\Functional\Service\Services;
use App\Models\Service;

trait GetServices{
    public static function getServices(){
        $services = Service::get();
        $services = $services->makeHidden(["id","created_at","updated_at"]);
        
        return response()->json($services,200);
    }
}