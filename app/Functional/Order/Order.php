<?php 

namespace App\Functional\Order;

use App\Functional\Account\Account;
use App\Functional\Car\Model;
use App\Functional\Helper\Helper;
use App\Functional\Service\Service;
use App\Models\Order as ModelsOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Order extends Account{
    public function addOrder(){
        $validator = Validator::make(request()->all(), [
            'date' => 'required',
            'model_slug' => 'required',
            'service_slug' => 'required',
            'payment_type' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        /* Service type check */ 
        $service = new Service(request('service_slug'));
        if(Helper::emptyCheck($service->service,request('service_slug')) == request('service_slug')){
            return response()->json(["status" => false , "message" => "Service not found"],200);  
        }

        /* Model type check */ 
        $model = new Model(request('model_slug'));
        if(Helper::emptyCheck($model->model,request('model_slug')) == request('model_slug')){
            return response()->json(["status" => false , "message" => "Model not found"],400);  
        }

        /* Payment type check */

        if(!in_array(request('payment_type'),Helper::paymentTypes())){
            return response()->json(["status" => false , "message" => "Invalid payment type"],400);  
        }

        /* Availability time check  */
        if(!in_array(Carbon::createFromFormat("Y-m-d H:i",request('date'))->format("H:i"),$service->availabilityTimesOnService(Carbon::createFromFormat("Y-m-d H:i",request('date'))->format("Y-m-d")))){
            return response()->json(["status" => false , "message" => "invalid time"],400);
        }


        /* Balance check */ 

        if(request('payment_type') == 'balance'){
            if($this->account->balance < $service->service->price){
                return response()->json(["status" => false , "message" => "Insufficient balance"],200);  
            }
        }else{
            
        }
    
        /* Balance Update */

        $this->updateBalance($service->service->price,"decrease");

        $order = ModelsOrder::create([
            "user_id" => $this->account->id,
            "service_id" => $service->service->id,
            "model_id" => $model->model->id,
            "date" => request('date'),
            "payment_type" => request('payment_type')
        ]);

        if($order->save()){
            return response()->json(["status" => true],200);  
        }
        
    }

    public function getOrders(){
        $orders = ModelsOrder::query();
        $now = date('Y-m-d H:i',time());
        $orders = $orders->select(DB::raw("models.name as model_name , services.name as service_name , payment_type , date , IF(DATE_FORMAT(orders.date,'%Y-%m-%d %H:%i') < '".$now."',  'done'  ,'pending' )  as order_status"))
        ->join('services','services.id','=','orders.service_id')
        ->join('models','models.id','=','orders.model_id')
        ->where('user_id',$this->account->id);
        if(!empty(request('service_slug'))){
            $service = new Service(request('service_slug'));
            $orders = $orders->where('orders.service_id',$service->id);
        }
        if(!empty(request('model_slug'))){
            $model = new Model(request('model_slug'));
            $orders = $orders->where('orders.model_id',$model->id);
        }
        if(!empty(request('date'))){
            $start = Carbon::createFromFormat('Y-m-d', request('date'));
            $orders = $orders->whereDate('orders.date','>=',$start);
            $end = $start->addDay(1);
            $orders = $orders->whereDate('orders.date','<',$end);
        }

        $orders = $orders->get();

        if(!empty($orders)){
            return response()->json(["status" => true , "data" => $orders],200);  
        }
    }
}