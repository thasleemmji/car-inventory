<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manufacturer;
use App\Models\Car;

class InventoryController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data['manufactures'] = Manufacturer::getManufacturers();
        return view('inventory.inventory')->with($data);
    }

    public function sell(Request $request){
    	$car = htmlspecialchars($request->input('car'));
    	//server validation
    	if($car=='' || !is_numeric($car)) {
    		return response()->json(0);
    	}
    	$cdate = date('Y-m-d H:i:s');
    	$car = Car::find($car);

    	$car->sold_status = 1;
        $car->sold_date = $cdate;
        $car->updated_at =  $cdate;
        $car->save();
        if($car->id) {//success
            return response()->json(1);
        }
        return response()->json(0);//updation failed
    }
}
