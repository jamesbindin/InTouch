<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Exception;

class CheckApiKey
{
    private $apiKey = "Bearer 62ac546c-1eb6-477c-8d7c-ad676b6609cf";
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    // checks if the request contains an authorisation key in the header. If it matches,
    // the request is handled by the correct route, if not an response is given. 
    public function handle(Request $request, Closure $next)
    {
        try{

            // check autharisation header exists, if so store key
            if(!array_key_exists('authorization', $request->header())){
                return response()->json(['message'=>'no authorization header', 'data'=>Null], 403);
            }
            $apiKey = $request->header()['authorization'][0];

            //check key matches
            if($apiKey){
                if($apiKey == $this->apiKey){
                    return $next($request);
                }
                return response()->json(['message'=>'api key does not match', 'data'=>Null], 403);
            } 
            return response()->json(['message'=>'no authorization key entered', 'data'=>Null], 403);

        } catch(Exception $e) {
            return response()->json(['message'=>$e, 'data'=>Null], 409);
        }
        
    }
}
