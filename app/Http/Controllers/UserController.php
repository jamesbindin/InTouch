<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use phpDocumentor\Reflection\Types\Null_;
use Validator;

class UserController extends Controller
{
    // return one or many users from db, depending if id is passed or not
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

    // saves a user to the db using a POST request
    public function post(Request $req){

        $exists =  User::where('Email', $req->Email)->first();
        if($exists){
            return ['Result' => 'record already exists'];
        } else {
            $user = new User(); 
            $user->Firstname = $req->Firstname;
            $user->Surname = $req->Surname;
            $user->DateOfBirth = $req->DateOfBirth;
            $user->PhoneNumber = $req->PhoneNumber;
            $user->Email = $req->Email;
            $result = $user->save();
            if($result){
                return ['Result' => 'data has been saved'];
            } else {
                return ['Result' => 'failed'];
            }
            return "test";
        }
    }

}
