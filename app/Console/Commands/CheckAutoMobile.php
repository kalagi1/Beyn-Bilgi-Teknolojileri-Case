<?php

namespace App\Console\Commands;

use App\Models\Brand;
use App\Models\Model;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CheckAutoMobile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:automobile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check automobile';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = Http::get("https://static.novassets.com/automobile.json");
        $resposeData = json_decode($client);
        $automobiles = Cache::rememberForever("automobile",function(){
            return Model::select(DB::raw("models.* , brands.name as brand_name"))->join('brands','brands.id','=','models.brand_id')->get();
        });
        $temp = 0;
        foreach($resposeData->RECORDS as $key=>$data){
            if(trim(Str::slug($data->model)) != $automobiles[$key-$temp]->slug){
                $brand = Brand::create([
                    "name" => $data->brand,
                    "slug" => Str::slug($data->brand)
                ]);
                $year = explode('-',$data->year);
                $year = trim($year[0]);
                Model::create([
                    "brand_id" => $brand->id,
                    "name" => $data->model,
                    "slug" => Str::slug($data->model),
                    "year" => $year
                ]);
                print_r($data);
                $temp++;
            }
        }
    }
}
