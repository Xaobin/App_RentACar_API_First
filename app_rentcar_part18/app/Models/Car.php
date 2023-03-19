<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Car extends Model
{
    use HasFactory; 
    
    protected $fillable = ['model_id', 'plate', 'available', 'km'];

    public function rules() {
        return [
            'model_id' => 'exists:car_models,id',
            'plate' => 'required',
            'available' => 'required',
            'km' => 'required'
        ];
    }
// = = = = = = = = = = = = = = = = =
    public function carModel() {
        return $this->belongsTo('App\Models\CarModel','model_id','id');
    }
// = = = = = = = = = = = = = = = = = 
public function refModelValues(){
    $cons="select car_models.name as model, car_models.id as id from car_models";
    $dest=
    DB::select($cons);
    return $dest;
}
// = = = = = = = = = = = = = = = = =
}
