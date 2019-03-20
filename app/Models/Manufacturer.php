<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model {
    static function getManufacturers() {
    	$manufacturers = self::where('status',1)->orderBy('id', 'DESC')->get();
        if($manufacturers->count()>0) {
        	return $manufacturers;
        }
        return FALSE;
    }

    public function models() {
        return $this->hasMany('App\Models\CarModel');
    }

}
