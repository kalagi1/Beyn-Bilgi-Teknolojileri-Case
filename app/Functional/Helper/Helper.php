<?php 
namespace App\Functional\Helper;

Class Helper{
    public static function yearFilterTypeCreator(string $filterType){
        if($filterType == 'equal'){
            return '=';
        }elseif($filterType == 'equal_and_greater'){
            return '>=';
        }elseif($filterType == 'equal_and_smaller'){
            return '<=';
        }elseif($filterType == 'not_equal'){
            return '!=';
        }elseif($filterType == 'greater'){
            return '>';
        }elseif($filterType == 'smaller'){
            return false;
        }
    }

    public static function emptyCheck($value , $default = null){
        if(empty($value)){
            return $default;
        }else{
            return $value;
        }
    }

    public static function paymentTypes(){
        return array('balance','card');
    }
    

    public static function getWorkingHours(){
        $workingHours = ["start_hour" => 8 , "start_minute" => 30 , "end_hour" => 18 , "end_minute" => 30];
        return $workingHours;
    }


}