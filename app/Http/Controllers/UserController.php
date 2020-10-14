<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use phpDocumentor\Reflection\Types\Null_;
use Validator;

class UserController extends Controller
{
    public function get(Request $req){
        
        $result = Null;
        
        if(isset($req->id)){
            $result = response()->json(User::find($req->id));
        } else {
            $result = response()->json(User::all());
        }

        if($result){
            return $result;
        } 

        return response()->json($result, 404);
    }

}
