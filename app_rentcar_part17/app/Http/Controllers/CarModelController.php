<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\CarModel;
use Illuminate\Http\Request;


use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\DB;

class CarModelController extends Controller{
    public function __construct(CarModel $carmodelx) {
        $this->carmodel = $carmodelx;
    }
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
// = = = = = = = = = = = = = = = = =
// = = = = = = = = = = = = = = = = =    
// = = = = = = = = = = = = = = = = =
public function index(Request $request){
  
          $cModel=$this->filtrate($request,$this->carmodel,'refCarBrand');

        if ($cModel=="404"){
            return response()->json(['msg'=>'resource not found'],404);
        }
        return response()->json($cModel, 200);
}
// = = = = = = = = = = = = = = = = =
// = = = = = = = = = = = = = = = = =
// = = = = = = = = = = = = = = = = =
// = = = = = = = = = = = = = = = = = 

// = = = = = = = = = = = = = = = = =
private function filtrate($request,$objInstance,$ref_method){
    
    $field_like='name';
    /*
    filter = name=eco@@doors=4@@seats=4@@air_bag=1@@abs=1
    filter=
    bmFtZT1lY29AQGRvb3JzPTRAQHNlYXRzPTRAQGFpcl9iYWc9MUBAYWJzPTE=
    */
    if ($request->has('filter')){
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

    if ($request->has('refbrandvalues')){
        return $objInstance->refBrandValues();
    }    

   //..No one filter, return all
    $objInstance=$objInstance->with($ref_method);
    $objInstance=$objInstance->get();
    return $objInstance;
}
    // = = = = = = = = = = = = = = = = =
private function filtrateAval($objInstance){
    $objInstance=$objInstance->with('refCarBrand');
    $objInstance= $objInstance->where('name','like','%eco%');

    $objInstance=$objInstance->get();

    return $objInstance;

}

    // = = = = = = = = = = = = = = = = =
       /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     // = = = = = = = = = = = = = = = = =
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $request->validate($this->carmodel->rules());

        $image = $request->file('image');
        $image_urn = $image->store('images/carmodels', 'public2');

        $cModel = $this->carmodel->create([
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'image' => $image_urn,
            'doors' => $request->doors,
            'seats' => $request->seats,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs
        ]);

        return response()->json($cModel, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
  // = = = = = = = = = = = = = = = = =
    public function show($myid){
        $cModel = $this->carmodel->with('refCarBrand')->find($myid);
        if($cModel === null) {
            return response()->json(['error' => 'Resource not found'], 404) ;
        }

        return response()->json($cModel, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CarModel  $carModel
     * @return \Illuminate\Http\Response
     */
  // = = = = = = = = = = = = = = = = =
    public function edit(CarModel $carModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
  // = = = = = = = = = = = = = = = = =
    public function update(Request $request, $myid){
        $cModel = $this->carmodel->find($myid);

        if($cModel === null) {
            return response()->json(['error' => 'Update not performed, resource not exists'], 404);
        }

        if($request->method() === 'PATCH') {

            $dinrules = array();

            //percorrendo todas as regras definidas no Model
            foreach($cModel->rules() as $input => $rule) {

                //coletar apenas as regras aplicáveis aos parâmetros parciais da requisição PATCH
                if(array_key_exists($input, $request->all())) {
                    $dinrules[$input] = $rule;
                }
            }

            $request->validate($dinrules);

        } else {
            $request->validate($cModel->rules());
        }

       //................
        if($request->file('image')) {
            Storage::disk('public2')->delete($cModel->image);
            $image = $request->file('image');
            $image_urn = $image->store('images/carmodels', 'public2');

            $cModel->fill($request->all());
            $cModel->name=$request->name;
            $cModel->brand_id=$request->brand_id;
            $cModel->doors=$request->doors;
            $cModel->seats=$request->seats;
            $cModel->air_bag=$request->air_bag;
            $cModel->abs=$request->abs;
            //$cModel->

            $cModel->save();

        //................    
        } else{
            $cModel->fill($request->all());
            $cModel->save();
        }

        
        //................
      /*  
        $cModel->update([
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'image' => $image_urn,
            'doors' => $request->doors,
            'seats' => $request->seats,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs
        ]);
       */ 
        return response()->json($cModel, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $integer
     * @return \Illuminate\Http\Response
     */
  // = = = = = = = = = = = = = = = = =
    public function destroy($myid){
        $cModel = $this->carmodel->find($myid);

        if($cModel === null) {
            return response()->json(['error' => 'deletion not performed, the resource does not exists'], 404);
        }

        //remove o arquivo antigo
        Storage::disk('public')->delete($cModel->image);

        $cModel->delete();
        return response()->json(['msg' => 'The car model was deleted!'], 200);
    }
}
