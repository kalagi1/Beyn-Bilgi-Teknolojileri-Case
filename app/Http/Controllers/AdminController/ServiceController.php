<?php

namespace App\Http\Controllers\AdminController;

use App\Functional\Service\Service;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(){
        return json_encode(Service::getServices());
    }

    public function store(){
        return json_encode(Service::addService());
    }

    public function show($slug){
        $service = new Service($slug);
        return json_encode($service->getService());
    }

    public function update($slug){
        $service = new Service($slug);
        return json_encode($service->editService());
    }

    public function destroy($slug){
        $service = new Service($slug);
        return json_encode($service->removeService());
    }


}
