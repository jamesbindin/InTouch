<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use phpDocumentor\Reflection\Types\Null_;
use Validator;

class UserController extends Controller
{
    // returns all users or one if username present in the url
    public function get(Request $req){
        try{

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

        } catch(Exception $e) {
            return response()->json(['message'=>$e, 'data'=>Null], 409);
        }
    }

    // saves a user to the db using a POST request
    public function post(Request $req){
        try{
            // check Username is not null
            if(!isset($req->Username)){
                return response()->json(['message'=>'no Username entered', 'data'=>Null], 409);
            }

            // check Email is not null
            if(!isset($req->Email)){
                return response()->json(['message'=>'no Email entered', 'data'=>Null], 409);
            }

            // check record does not exist
            $username_exists =  User::where('Username', $req->Username)->first();
            $email_exists =  User::where('Email', $req->Email)->first();

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
        } catch(Exception $e) {
            return response()->json(['message'=>$e, 'data'=>Null], 409);
        }
    }

    // check record exists and edits on the DB using PUT
    public function put(Request $req){
        try{
            // check Username is not null
            if(!isset($req->Username)){
                return response()->json(['message'=>'no Username entered', 'data'=>Null], 409);
            }

            $user =  User::where('Username', $req->Username)->first();

            // check if user exists and change on db
            if($user){
                $user->Firstname = $req->Firstname;
                $user->Surname = $req->Surname;
                $user->DateOfBirth = $req->DateOfBirth;
                $user->PhoneNumber = $req->PhoneNumber;
                $user->Email = $req->Email;
                $result = $user->save();

                if($result){
                    return response()->json(['message'=>'success', 'data'=>Null]);
                }

                return response()->json(['message'=>'failed to add user', 'data'=>$result], 409);
            }

            return response()->json(['message'=>'user doesn\'t exis', 'data'=>Null]);

        } catch(Exception $e) {
            return response()->json(['message'=>$e, 'data'=>Null], 409);
        }
    }


    // deletes a user, given that record with the same Username exists
    public function delete(Request $req){
        try{
            // check Username is not null
            if(!isset($req->Username)){
                return response()->json(['message'=>'no Username entered', 'data'=>Null], 409);
            }

            $user =  User::where('Username', $req->Username)->first();

            // check if user exists and delete on db
            if($user){
                $result = $user->delete();
                if($result){
                    return response()->json(['message'=>'success', 'data'=>Null]);
                }

                return response()->json(['message'=>'failed to delete user', 'data'=>$result], 409);
            }

            return response()->json(['message'=>'user doesn\'t exis', 'data'=>Null]);

        } catch(Exception $e) {
            return response()->json(['message'=>$e, 'data'=>Null], 409);
        }
    }

}
