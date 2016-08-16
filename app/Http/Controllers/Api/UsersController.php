<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\Http\Controllers\Auth\JWTAuthController;

use App\Http\Requests;

use App\User;


class UsersController extends Controller
{

    use JWTAuthController;

	public function create(Request $request) {
        
        $data = $request->all();


          
        $password = $request->password;

        $data['password'] = bcrypt($password);

        //return $request->password;
  

        if(!$user = User::where(['email' => $request->email])->first()) {
            if($user = User::create($data)) {

                $request->password = $password;
                $jwtAuth = json_decode($this->authenticate($request)->content());
        
                
               

               if($user->update(['token' => $jwtAuth->token])) {

                    return response()->json([
                        'message' => 'user_created_successfully',
                        'user' => $user
                        ],201);
               }

                
            }
        }
        else {
            //user is already in the database.. 
            return response()->json([
                    'message' => 'user_already_exists',
                    'user' => $user
                    ],500);
        }


        
        
        
	}

    

    
}
