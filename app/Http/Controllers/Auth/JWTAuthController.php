<?php
namespace App\Http\Controllers\Auth;


use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
//use Illuminate\Http\Request;

trait JWTAuthController
{
    public function authenticate($request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                	'message' => 'invalid_credentials',
                	'token' => false
                	], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json([
            	'message' => 'could_not_create_token',
            	'token' => false
            	], 500);
        }

        // all good so return the token
        return response()->json([
        		'message' => 'token_created',
        		'token' => $token
        	]);
    }
}