<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    
    
    public function login( Request $request ) { 
        
        if(Auth::guard("api")->check()){
            return response(["message"=>"you have been logged!"]);
        }
        
        
        $user=$request->validate([
            "email"=>"required|string|email",
            "password"=>"required|string|min:6"
        ]);


        if( !Auth::attempt($user) ){
            return response(["message"=>"Invalid login cridential"]);
        }

        $accessToken=Auth::user()->createToken("mangementVootectSecret")->accessToken;

        return response(["user"=>Auth::user(),"access_token"=>$accessToken]);

    }
}
