<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model {
	
	protected $table = 'models';

    public function cars() {
	    $cars = $this->hasMany('App\Models\Car', 'model_id')->where('sold_status', 0);
	    return $cars;
	}
}

