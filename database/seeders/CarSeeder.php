<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/seeders/automobile.json");
        $automobiles = json_decode($json);
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Brand::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $tempSlug = null;
        $tempId = null;
        foreach ($automobiles->RECORDS as $key => $value) {
            $name = $value->brand;
            $slug = Str::slug($value->brand);
            if($tempSlug != $slug){
                $brand = Brand::where('slug',$slug)->first();
                if(empty($brand)){
                    $brand = Brand::create([
                        "name" => $name,
                        "slug" => $slug
                    ]);
                    
                    $year = explode('-',$value->year);
                    $year = trim($year[0]);

                    Model::create([
                        "brand_id" => $brand->id,
                        "name" => $value->model,
                        "slug" => Str::slug($value->model),
                        "year" => $year
                    ]);
                    $tempId = $brand->id;
                }
            }else{
                $year = explode('-',$value->year);
                $year = trim($year[0]);
                Model::create([
                    "brand_id" => $tempId,
                    "name" => $value->model,
                    "slug" => Str::slug($value->model),
                    "year" => $year
                ]);
            }
            $tempSlug = $slug;
            
            
        }
    }
}
