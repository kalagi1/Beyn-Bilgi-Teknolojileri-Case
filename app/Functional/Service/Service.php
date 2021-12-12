<?php 
    namespace App\Functional\Service;

use App\Functional\Service\Services\AddService;
use App\Functional\Service\Services\AvailabilityTimesOnService;
use App\Functional\Service\Services\GetServices;
use App\Models\Service as ModelsService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class Service implements IService{
    use AddService,GetServices,AvailabilityTimesOnService;
    
    public $service;
    
  

    public function __construct($slug)
    {
        $service = ModelsService::where('slug',$slug)->first();
        $this->service = $service;
    }


    public function getService(){
        if(empty($this->service)){
            return response()->json("Data is not found", 200);
        }

        $service = $this->service->makeHidden(["id","created_at","updated_at"]);
        return response()->json($service, 200);
        
    }

    public function editService(){
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'price' => 'required',
            'service_completion_time' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if(empty($this->service)){
            return response()->json("Data is not found", 200);
        }

        $this->service->name = request('name');
        $this->service->slug = request('name');
        $this->service->price = request('price');
        $this->service->service_completion_time = request('service_completion_time');

        if ($this->service->save()) {
            return response()->json('You have successfuly updated the '.$this->service->name, 200);
        } else {
            return response()->json('Something went wrong', 400);
        }
    }

    public function removeService(){
        if(!empty($this->service)){
            $this->service->delete();
            return response()->json('You have successfuly deleted the'.$this->service->name, 200);
        }else{
            return response()->json('Data is not found', 400);
        }
    }
    
}