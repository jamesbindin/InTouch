<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use phpDocumentor\Reflection\Types\Null_;
use Validator;

class UserController extends Controller
{
    // returns all users or one if username present in the url
    public function get(Request $req){
        
        $result = Null;

        if(isset($req->Username)){
            $result = User::where('Username', $req->Username)->first();
        } else {
            $result = User::all();
        }

        if($result){
            return response()->json(['message'=>'success', 'data'=>$result]);
        } 

        return response()->json(['message'=>'user not found', 'data'=>$result], 404);
    }

    // saves a user to the db using a POST request
    public function post(Request $req){

        // check Username is not null
        if(!isset($req->Username)){
            return response()->json(['message'=>'no Username entered', 'data'=>Null], 409);
        }

        // check Email is not null
        if(!isset($req->Username)){
            return response()->json(['message'=>'no Email entered', 'data'=>Null], 409);
        }

        // check record does not exist
        $email_exists =  User::where('Email', $req->Email)->first();
        $username_exists =  User::where('Username', $req->Username)->first();

        // respond if already exists or create new
        if($email_exists || $username_exists){
            return response()->json(['message'=>'user already exists', 'data'=>Null], 409);
        } else {
            $user = new User(); 
            $user->Username = $req->Username;
            $user->Firstname = $req->Firstname;
            $user->Surname = $req->Surname;
            $user->DateOfBirth = $req->DateOfBirth;
            $user->PhoneNumber = $req->PhoneNumber;
            $user->Email = $req->Email;
            $result = $user->save();

            if($result){
                return response()->json(['message'=>'success', 'data'=>$result]);
            }

            return response()->json(['message'=>'failed to add user', 'data'=>$result], 409);

        }
    }

    public function put(Request $req){
        return Null;

    }

}
