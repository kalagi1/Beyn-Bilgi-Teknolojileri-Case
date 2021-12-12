<?php 

namespace App\Functional\Service\Services;

use App\Functional\Helper\Helper;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait AvailabilityTimesOnService{
    public function availabilityTimesOnService($date){
        $start = Carbon::createFromFormat('Y-m-d', $date);
        $notAvaibilityTimes = Service::query(); 
        $notAvaibilityTimes =  $notAvaibilityTimes->select(DB::raw('DATE_FORMAT(orders.date, "%H:%i") as time'))

        ->whereDate('orders.date','>=',$start);
        $end = $start->addDay(1);
        $notAvaibilityTimes = $notAvaibilityTimes->join('orders','orders.service_id','=','services.id')
        ->whereDate('orders.date','<',$end)
        ->pluck('time')
        ->toArray();
        $workingHours = Helper::getWorkingHours();
        $workingTime = ($workingHours["end_hour"] - $workingHours["start_hour"])*60;
        $workingTime = $workingTime + $workingHours['end_minute'] - $workingHours['start_minute'];
        $timeCount = $workingTime/$this->service->service_completion_time;
        $avaibilityTimes = array();
        $start = Carbon::createFromTime($workingHours['start_hour'],$workingHours['start_minute']);
        for($i = 0 ; $i <= $timeCount ; $i++){
            if($i == 0)
                $time = $start->format("H:i");
            else
                $time = $start->addMinutes($this->service->service_completion_time)->format("H:i");
                
            if(!in_array($time , $notAvaibilityTimes)){
                array_push($avaibilityTimes,$time);
            }
        }

        return $avaibilityTimes;
    }
}