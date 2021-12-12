<?php 

namespace App\Functional\Car;

use App\Functional\Car\Services\CreateBrand;
use App\Functional\Car\Services\GetBrands;
use App\Models\Brand as ModelsBrand;

Class Brand implements IBrand{
    use GetBrands,CreateBrand;

    public $brandName;

    public function __construct(string $slug)
    {
        $brand = ModelsBrand::where('slug',$slug)->first();
        $this->brandName = $brand->name;
    }

    public function getBrand(){

    }

    public function editBrand(){

    }

    public function removeBrand(){

    }
}