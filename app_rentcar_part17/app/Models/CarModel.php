<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class CarModel extends Model{
    use HasFactory;

    protected $fillable=['brand_id','name','image','doors','seats','air_bag','abs'];
    protected $table="car_models";
    //.......................
    public function refCarBrand(){
        return $this->belongsTo('App\Models\CarBrand','brand_id','id');
    }
    //.......................
    public function refCarBrandII(){
        return $this->belongsTo('App\Models\CarBrand');
    }
    //.......................
    public function rules() {
        return [
            'brand_id' => 'exists:car_brands,id',
            'name' => 'required|unique:car_models,name,'.$this->id.'|min:3',
            'image' => 'required|file|mimes:png,jpeg,jpg,webp',
            'doors' => 'required|integer|digits_between:1,5', //(1,2,3,4,5)
            'seats' => 'required|integer|digits_between:1,20',
            'air_bag' => 'required|boolean',
            'abs' => 'required|boolean' //true, false, 1, 0, "1", "0"
        ];
    }
    //.......................
    public function refBrandValues(){
        $cons="select car_brands.name as brand, car_brands.id as id from car_brands";
        $dest=
        DB::select($cons);
        return $dest;
    }

}
