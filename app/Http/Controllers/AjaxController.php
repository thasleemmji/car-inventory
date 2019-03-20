<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AjaxController extends Controller {

    public function checkExist(Request $request){
        $limit = (htmlspecialchars($request->type)=='edit') ? '1' : '0';
    	$value = htmlspecialchars($request->value);
    	$field = htmlspecialchars($request->field);
    	$table = htmlspecialchars($request->table);
    	
        if(DB::table($table)->where($field, $value)->count()>$limit) {
			$exist = 1;
		}else {
            $exist = 0;
        }
    	return response()->json($exist);
   }

   public function uploadImg(Request $request){
        if($request->hasFile('imgInp1')) {
            $img1 = $request->file('imgInp1');
            $ext = $img1->getClientOriginalExtension();
            //server validation
            $allowed_files = ['jpg', 'png', 'jpeg'];
            if($img1 =='' || !in_array($ext, $allowed_files)) {
                return response()->json(0);
            }
            $img1Name = 'car-1-'.time().'.'.$ext;
            $destPath = public_path('\uploads');
            $img1->move($destPath, $img1Name);
        }else{//if no image choosen
            $img1Name = 'default.png';
        }
        if($request->hasFile('imgInp2')) {
            $img2 = $request->file('imgInp2');
            $ext = $img1->getClientOriginalExtension();
            //server validation
            $allowed_files = ['jpg', 'png', 'jpeg'];
            if($img2 =='' || !in_array($ext, $allowed_files)) {
                return response()->json(0);
            }
            $img2Name = 'car-2-'.time().'.'.$ext;
            $destPath = public_path('\uploads');
            $img2->move($destPath, $img2Name);
        }else{//if no image choosen
            $img2Name = 'default.png';
        }
        return response()->json(['image1' => $img1Name, 'image2' => $img2Name]);
   }
}
