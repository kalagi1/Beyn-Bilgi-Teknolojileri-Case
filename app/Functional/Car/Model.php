<?php 

namespace App\Functional\Car;

use App\Functional\Car\Services\getModels;
use App\Functional\Car\Services\GetModelsWithFilter;
use App\Functional\Service\IService;
use App\Models\Model as ModelsModel;

Class Model extends Brand implements IModel{
    use getModels;
    public $model;

    public function __construct(string $slug)
    {
        $model = ModelsModel::where('slug',$slug)->first();
        $this->model = $model;
    }
    
}