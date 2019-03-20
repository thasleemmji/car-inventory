<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarModel;
use App\Models\Manufacturer;
use App\Models\Car;

class ModelController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data['manufacturers'] = Manufacturer::getManufacturers();
        return view('models.models')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
  
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $manufacturer = htmlspecialchars($request->input('manufacturer'));
        $modelName = htmlspecialchars($request->input('modelName'));
        // arrays
        $images1 = $request->input('images1');
        $images2 = $request->input('images2');
        $regNos = $request->input('regNos');
        $colors = $request->input('colors');
        $mYears = $request->input('mYears');
        $notes = $request->input('notes');

        //server validation
        if($manufacturer=='' || !is_numeric($manufacturer) || CarModel::where('model', $modelName )->exists() || count($images1)<=0 || count($images2)<=0 || count($regNos)<=0 || count($colors)<=0 || count($mYears)<=0 ) {
            return response()->json(0);
        }
        //now insert into database
        $cdate = date('Y-m-d H:i:s');
        $carmodel = new CarModel;

        $carmodel->model = $modelName;
        $carmodel->manufacturer_id = $manufacturer;
        
        $carmodel->created_at = $cdate;
        $carmodel->updated_at = $cdate;

        $carmodel->save();
        if($carmodel->id) {//insert success
            $model_id = $carmodel->id;
            $carsData = array();
            for ($i=0; $i < count($regNos); $i++) { 
                $carsData[] = array(
                    'model_id' => $model_id,
                    'regNo' => $regNos[$i],
                    'color' => $colors[$i],
                    'manufacture_year' => $mYears[$i],
                    'image1' => $images1[$i],
                    'image2' => $images2[$i],
                    'note' => $notes[$i],
                    'created_at' => $cdate,
                    'updated_at' => $cdate
                );
            }
            if(Car::insert($carsData)) {
                return response()->json(1);
            }
            return response()->json(0);//some insertion failure
        }
        return response()->json(0);//some insertion failure
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $cars = Car::where('model_id',$id)->where('sold_status',0)->get();
        if($cars->count()>0) {
            $i=1;$html='';
            foreach ($cars as $car) {
                $html .= '<tr id="row_'.$car->id.'"><td class="rowNo">'.$i++.'</td><td><img class="avatar" src="'.url('/uploads/'.$car->image1).'" /></td><td>'.strtoupper($car->regNo).'</td><td>'.ucwords($car->color).'</td><td>'.$car->manufacture_year.'</td><td>'.$car->note.'</td><td><button type="button" id="sellBtn_'.$car->id.'" class="btn btn-sm btn-danger sellCar" data-car="'.$car->id.'">Sold</button></td></tr>';
            }
        }else {
            $html = '<tr><td colspan="7" align="center">No Cars found.</td></tr>';
        }
        
        return response()->json($html);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
}
