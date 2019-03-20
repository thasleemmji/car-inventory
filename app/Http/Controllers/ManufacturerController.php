<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manufacturer;
use App\Models\CarModel;
use App\Models\Car;
use Datatables;
use Illuminate\Support\Collection;

class ManufacturerController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
         return view('manufacturers.manufacturers');
    }

    public function getAll() {
        $mans = Manufacturer::getManufacturers();
        $manArr = new Collection;
        if($mans!=FALSE) {
            $i=1;
            foreach ($mans as $man) {
                $action = '<div class="btn-group"><a href="#" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a><button type="button" class="btn btn-danger btn-sm" id="dltBtn_'.$man->id.'" onclick="deleteFn('.$man->id.')"><i class="fa fa-trash-o"></i></button></div>';
                $status = ($man->status==1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
                $manArr->push([
                    'index' => $i++,
                    'manufacturer' => ucwords($man->manufacturer),
                    'status' => $status,
                    'action' => $action
                ]);
            }
        }
        return Datatables::of($manArr)->make(true);
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
        $status = htmlspecialchars($request->input('status'));

        //server validation
        if($manufacturer=='' || ($status!=0 && $status!=1) || Manufacturer::where('manufacturer', $manufacturer )->exists() ) {
            return response()->json(0);
        }
        //now insert into database
        $cdate = date('Y-m-d H:i:s');
        $insert = new Manufacturer;

        $insert->manufacturer = $manufacturer;
        $insert->status = $status;
        $insert->created_at = $cdate;
        $insert->updated_at = $cdate;

        $insert->save();
        if($insert->id) {//insert success
            return response()->json(1);
        }
        return response()->json(0);//some insertion failure
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

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
	public function show($id) {

	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $man = Manufacturer::find($id);
        if(count($man->models)>0) {
        	foreach ($man->models as $model) {
        		Car::where('model_id',$model->id)->delete();
	        }
	        CarModel::where('manufacturer_id',$man->id)->delete();
        }
        if($man->delete()) {
        	return response()->json(1);
        }
        return response()->json(0);
    }
}
