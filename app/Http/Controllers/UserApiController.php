<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Dotenv\Validator as DotenvValidator;
use Exception;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use phpDocumentor\Reflection\Types\Null_;
use Illuminate\Support\Facades\Validator;

class UserApiController extends Controller
{

    // validates user details entered in the request returns a response with messages, if not met.
    private function validateUser($req){
        $validation_rules = array(
            'Username' => 'required|string|min:3|max:20',
            'Firstname' => 'required|string|min:3|max:20',
            'Surname' => 'required|string|min:3|max:20',
            'DateOfBirth' => 'required|date',
            'PhoneNumber' => 'required|string|min:3|max:20',
            'Email' => 'required|string|min:3|max:30|email',
        );
        $validator = Validator::make($req->all(), $validation_rules);

        if($validator->fails()){
            return response()->json(['success'=>0, 'message'=>$validator->errors(), 'data'=>Null], 409);
        }
        return False;
    }

    // returns all users or one if username present in the url
    public function get(Request $req){
        try{

            $result = Null;
            $message = "retrieved all users";

            if(isset($req->Username)){
                $result = User::where('Username', $req->Username)->first();
            $message = "retrieved user";
            } else {
                $result = User::all();
            }

            if($result){
                return response()->json(['success'=>1, 'message'=>$message, 'data'=>$result]);
            } 

            return response()->json(['success'=>0, 'message'=>'user not found', 'data'=>$result], 404);

        } catch(Exception $e) {
            return response()->json(['success'=>0, 'message'=>$e, 'data'=>Null], 409);
        }
    }


    // saves a user to the db using a POST request
    public function post(Request $req){

        try{
            // check Username is not null
            if(!isset($req->Username)){
                return response()->json(['success'=>0, 'message'=>'no Username entered', 'data'=>Null], 409);
            }

            // check Email is not null
            if(!isset($req->Email)){
                return response()->json(['success'=>0, 'message'=>'no Email entered', 'data'=>Null], 409);
            }

            // check record does not exist
            $username_exists =  User::where('Username', $req->Username)->first();
            $email_exists =  User::where('Email', $req->Email)->first();

            // respond if already exists or create new
            if($email_exists || $username_exists){
                return response()->json(['success'=>0, 'message'=>'user already exists', 'data'=>Null], 409);
            } else {

                // checks details are valid, if not a response is given with an appropriate message
                $validation_res = $this->validateUser($req);
                if($validation_res){
                    return $validation_res;
                }

                // stores to db
                $user = new User(); 
                $user->Username = $req->Username;
                $user->Firstname = $req->Firstname;
                $user->Surname = $req->Surname;
                $user->DateOfBirth = $req->DateOfBirth;
                $user->PhoneNumber = $req->PhoneNumber;
                $user->Email = $req->Email;
                $result = $user->save();

                if($result){
                    return response()->json(['success'=>1, 'message'=>'added new user', 'data'=>$result], 201);
                }

                return response()->json(['success'=>0, 'message'=>'failed to add user', 'data'=>$result], 409);

            }
        } catch(Exception $e) {
            return response()->json(['success'=>0, 'message'=>$e, 'data'=>Null], 409);
        }
    }


    // check record exists and edits on the DB using PUT
    public function put(Request $req){
        try{
            // check Username is not null
            if(!isset($req->Username)){
                return response()->json(['success'=>0, 'message'=>'no Username entered', 'data'=>Null], 409);
            }

            $user =  User::where('Username', $req->Username)->first();

            // check if user exists and change on db
            if($user){

                // checks details are valid, if not a response is given with an appropriate message
                $validation_res = $this->validateUser($req);
                if($validation_res){
                    return $validation_res;
                }
                // stores new values to db
                $user->Firstname = $req->Firstname;
                $user->Surname = $req->Surname;
                $user->DateOfBirth = $req->DateOfBirth;
                $user->PhoneNumber = $req->PhoneNumber;
                $user->Email = $req->Email;
                $result = $user->save();

                if($result){
                    return response()->json(['success'=>1, 'message'=>'edited user details', 'data'=>Null]);
                }

                return response()->json(['success'=>0, 'message'=>'failed to add user', 'data'=>$result], 409);
            }

            return response()->json(['success'=>0, 'message'=>'user doesn\'t exis', 'data'=>Null]);

        } catch(Exception $e) {
            return response()->json(['success'=>0, 'message'=>$e, 'data'=>Null], 409);
        }
    }

    // deletes a user, given that record with the same Username exists
    public function delete(Request $req){
        try{
            // check Username is not null
            if(!isset($req->Username)){
                return response()->json(['success'=>0, 'message'=>'no Username entered', 'data'=>Null], 409);
            }

            $user =  User::where('Username', $req->Username)->first();

            // check if user exists and delete on db
            if($user){
                $result = $user->delete();
                if($result){
                    return response()->json(['success'=>1, 'message'=>'deleted user', 'data'=>Null]);
                }

                return response()->json(['success'=>0, 'message'=>'failed to delete user', 'data'=>$result], 409);
            }

            return response()->json(['success'=>0, 'message'=>'user doesn\'t exis', 'data'=>Null], 409);

        } catch(Exception $e) {
            return response()->json(['success'=>0, 'message'=>$e, 'data'=>Null], 409);
        }
    }


}
