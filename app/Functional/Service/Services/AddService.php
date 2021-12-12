<?php 

namespace App\Functional\Service\Services;

use App\Models\Service;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use function GuzzleHttp\Promise\all;

trait AddService{
    public static function addService(){
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'price' => 'required',
            'service_completion_time' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        request()->request->add(['slug' => Str::slug(request('name'))]);
        $service = Service::create(request()->all());
        if ($service->save()) {
            return response()->json(['You have successfuly added new service'], 200);
        } else {
            return response()->json('Something went wrong', 400);
        }
    }
}