<?php 
    namespace App\Functional\Car\Services;

use App\Functional\Helper\Helper;
use App\Models\Model;

trait getModels{
        public static function getModels(){
            $name = Helper::emptyCheck(request('brand'),'');
            $model = Helper::emptyCheck(request('model'),'');
            $yearFilterType = Helper::yearFilterTypeCreator(Helper::emptyCheck(request('year_filter_type'),'equal'));
            $columnName = Helper::emptyCheck(request('order_col'),'models.name');
            $columnSortOrder = Helper::emptyCheck(request('column_sort_order'),'asc');
            $start = Helper::emptyCheck(request('start'),0);


            $models = Model::query();

            $models = $models->select("models.*","brands.name")
            ->join('brands','brands.id','=','models.brand_id')
            ->where('brands.name','LIKE','%'.$name.'%')
            ->where('models.name','LIKE','%'.$model.'%')
            ->orderBy($columnName,$columnSortOrder);

            if(!empty(request('year'))){
                $models = $models->where('year',$yearFilterType,request('year'));
            }

            if(!empty(request('length'))){
                $models = $models->skip($start)->take(request('length'));
            }

            $models = $models->get();

            return response()->json($models,200); 
        }
    }