<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as LaravelModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends LaravelModel
{
    use HasFactory,SoftDeletes;

    public function getBrand(){
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }
}
