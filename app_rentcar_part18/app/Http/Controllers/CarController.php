<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Car;

class CarController extends Controller{
    public function __construct(Car $carx) {
        $this->car = $carx;
    }
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
// = = = = = = = = = = = = = = = = =
// = = = = = = = = = = = = = = = = =
// = = = = = = = = = = = = = = = = =    
    public function index(Request $request) 
    {
        $cCar=$this->filtrate($request,$this->car,'carModel');
        if ($cCar=="404"){
            return response()->json(['msg'=>'resource not found'],404);
        }

        return response()->json($cCar, 200);
    }
// = = = = = = = = = = = = = = = = =
// = = = = = = = = = = = = = = = = =
// = = = = = = = = = = = = = = = = =
// = = = = = = = = = = = = = = = = =
private function filtrate($request,$objInstance,$ref_method){
    
    $field_like='plate';
    /*
    filter = name=eco@@doors=4@@seats=4@@air_bag=1@@abs=1
    filter=
    bmFtZT1lY29AQGRvb3JzPTRAQHNlYXRzPTRAQGFpcl9iYWc9MUBAYWJzPTE=
    */
    if ($request->has('filter')){ //begin filter
    $objInstance=$objInstance->with($ref_method);
    $myfilter=base64_decode($request->filter);
    $contArroba=substr_count($myfilter,"@@");
        if ($contArroba>0){
            $valys=explode("@@",$myfilter);
            for ($i=0; $i<=count($valys)-1;$i++){
            $vvv=explode("=",$valys[$i]);
            if (($vvv[0]==$field_like) and (isset($vvv[1]) ) ){
                $objInstance=$objInstance->where($vvv[0],"like","%".$vvv[1]."%");
            }
            else{
                if (isset($vvv[1])){
                    $objInstance=$objInstance->where($vvv[0],$vvv[1]);
                }
            }
        }  }
       if ($contArroba<=0){
         $vvv=explode("=",$myfilter);
         if (($vvv[0]==$field_like) and (isset($vvv[1]) ) ){
                $objInstance=$objInstance->where($vvv[0],"like","%".$vvv[1]."%");
            }
            else{
                if (isset($vvv[1])){
                    $objInstance=$objInstance->where($vvv[0],$vvv[1]);
                }
        }  }
    if ($objInstance==null){
        return "404";
    }
    $objInstance=$objInstance->get();
    return $objInstance;
    } // . . . . End Filter 1

    if ($request->has('refmodelvalues')){
        return $objInstance->refModelValues();
    }    

   //..No one filter, return all
    $objInstance=$objInstance->with($ref_method);
    $objInstance=$objInstance->get();
    return $objInstance;
}

//==================================
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->car->rules());

        $cCar = $this->car->create([
            'model_id' => $request->model_id,
            'plate' => $request->plate,
            'available' => $request->available,
            'km' => $request->km
        ]);

        return response()->json($cCar, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($myid)
    {
        $cCar = $this->car->with('carModel')->find($myid);
        if($cCar === null) {
            return response()->json(['error' => 'The resource does not exist'], 404) ;
        } 

        return response()->json($cCar, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function edit(Car $car)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $myid)
    {
        $cCar = $this->car->find($myid);

        if($cCar === null) {
            return response()->json(['error' => 'Update not performed, resource not exists'], 404);
        }

       //.............
       if($request->method() === 'PATCH') {

        $dinrules = array();

        //percorrendo todas as regras definidas no Model
        foreach($cCar->rules() as $input => $rule) {
            
            //coletar apenas as regras aplicáveis aos parâmetros parciais da requisição PATCH
            if(array_key_exists($input, $request->all())) {
                $dinrules[$input] = $rule;
            }
        }
        $request->validate($dinrules);
    } else {
        $request->validate($cCar->rules());
    }
       //.............
        
        $cCar->fill($request->all());
        $cCar->save();
        
        return response()->json($cCar, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($myid)
    {
        $cCar = $this->car->find($myid);

        if($cCar === null) {
            return response()->json(['erro' => 'deletion not performed, the resource does not exists'], 404);
        }

        $cCar->delete();
        return response()->json(['msg' => 'The car was deleted!'], 200);
    }
}
