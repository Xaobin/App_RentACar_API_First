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
  //$cModel=$this->filter($request,$this->carmodel,'refCarBrand');
          $cModel=$this->filtrate($request,$this->carmodel,'refCarBrand');
//$cModel=$this->filtrateAval($this->carmodel);
        return response()->json($cModel, 200);
    }
// = = = = = = = = = = = = = = = = =
// = = = = = = = = = = = = = = = = =
// = = = = = = = = = = = = = = = = =
/*
http://localhost:8000/api/v1/model?fields=name,id&filter=name:ford
http://localhost:8000/api/v1/model?fields=name,id&filter=doors:4&fields_brand=name
*/
// = = = = = = = = = = = = = = = = = = = = 
private function filter($request,$objInstance,$ref_method){
        $objInst=$objInstance;
        $objInst2=null;

    //................
    if($request->has('fields')) {

        $fields = $request->fields;
        ///echo "Fields...:".$fields."<br>";
        $e = explode(',', $fields);
        //
       // $objInst = $objInst->select('car_models.'.$e[0],'car_models.'.$e[1]);
        $objInst = $objInst->selectRaw("car_brands.name as brand,car_models.name as model,car_models.image,doors,seats,air_bag,abs");
        //echo "ObjInst Fields:".$objInst."<br>";
       // echo var_dump($objInst);

    }
    else {  $objInst = $objInst->with($ref_method);  }
//................

    //................
        if($request->has('filter')) {
           // $filters = explode(';', $request->filter);
            $filters = $request->filter;
            ///echo "Filters: ".$filters."<br>";
            //foreach($filters as $key => $condition) {
                //$c = explode(':', $condition);
                $d = explode(':', $filters);
                //$objInst = $objInst->where($d[0], $d[1]);
        $objInst=$objInst->join('car_brands','car_brands.id','=','car_models.brand_id');
                //echo "ObjInst Filter:".$objInst."<br>";

          //  }
        }
      //................
      if($request->has('fields_brand')) {

        $fields_brand = $request->fields_brand;
       // echo "<br>".$fields_brand."<br>";
       // $objInst =$objInst->with('refCarBrand'.':id,'.$fields_brand);
        //$objInst = $objInst->with($ref_method);
        //$objInst = $objInst->join('car_brands','brand_id','=','car_models.id');
       // $objInst = $objInst->crossJoin('car_brands');
        //->select('car_brands.name');

    }  else { $objInst = $objInst->with($ref_method); }
    //................
        $objInst=$objInst->get();

        return $objInst;
    }
// = = = = = = = = = = = = = = = = =
private function filtrate($request,$objInstance,$ref_method){
    $objInstance=$objInstance->with($ref_method);
    $field_like='name';
    /*
    filter = name=eco@@doors=4@@seats=4@@air_bag=1@@abs=1
    filter=
    bmFtZT1lY29AQGRvb3JzPTRAQHNlYXRzPTRAQGFpcl9iYWc9MUBAYWJzPTE=
    */
    if ($request->has('filter')){
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
        }
    }
    if ($contArroba<=0){
        $vvv=explode("=",$myfilter);
        if (($vvv[0]==$field_like) and (isset($vvv[1]) ) ){
                $objInstance=$objInstance->where($vvv[0],"like","%".$vvv[1]."%");
            }
            else{
                if (isset($vvv[1])){
                    $objInstance=$objInstance->where($vvv[0],$vvv[1]);
                }
            }
    }


    }
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
        $image_urn = $image->store('images/carmodels', 'public');

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

        //remove o arquivo antigo caso um novo arquivo tenha sido enviado no request
        if($request->file('image')) {
            Storage::disk('public')->delete($cModel->image);
        }

        $image = $request->file('image');
        $image_urn = $image->store('images/carmodels', 'public');

        $cModel->update([
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'image' => $image_urn,
            'doors' => $request->doors,
            'seats' => $request->seats,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs
        ]);

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
